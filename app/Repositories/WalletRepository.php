<?php

declare(strict_types=1);

namespace App\Repositories;

use App\DTO\OperationDTO;
use App\Enums\OpStateEnum;
use App\Enums\OpTypeEnum;
use App\Exceptions\Wallet\InvalidTransactionException;
use App\Exceptions\Wallet\InvalidWalletIdException;
use App\Exceptions\Wallet\NotEnoughFundsException;
use App\Exceptions\Wallet\WalletCurrencyPrecisionNotSetException;
use App\Models\Operation;
use App\Models\Wallet;
use App\Repositories\Interfaces\OperationRepositoryInterface;
use App\Repositories\Interfaces\PrecisionRepositoryInterface;
use App\Repositories\Interfaces\WalletRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Throwable;

/**
 * WalletRepository
 * php version 8.3
 *
 * @category repositories
 * @package  CryptoBalance
 * @author   Constantine Bragin <appscenter@proton.me>
 * @license  GPLv3 License
 * @link     https://github.com/appsinvest/crypto-balance
 */
final readonly class WalletRepository implements WalletRepositoryInterface
{
    public function __construct(
        private OperationRepositoryInterface $operationRepository,
        private PrecisionRepositoryInterface $precisionRepository
    ) {
    }

    public function findById(int $walletId, bool $lockForUpdate = false): ?Wallet
    {
        $builder = Wallet::query()->where('id', $walletId);

        return $lockForUpdate ? $builder->lockForUpdate()->first() : $builder->first();
    }

    public function findByUuid(string $walletUuid, bool $lockForUpdate = false): ?Wallet
    {
        $builder = Wallet::query()->where('uuid', $walletUuid);

        return $lockForUpdate ? $builder->lockForUpdate()->first() : $builder->first();
    }

    /**
     * @param string $amount
     * @param string $walletUuid
     * @param OpStateEnum $opState
     * @param Operation|null $operation
     * @param array|null $data
     *
     * @return Operation|null
     * @throws InvalidTransactionException
     * @throws Throwable
     */
    public function credit(
        string $amount,
        string $walletUuid,
        OpStateEnum $opState,
        ?Operation $operation,
        ?array $data = null,
    ): ?Operation {
        if (!in_array($opState->value, OpStateEnum::toArray())) {
            throw new InvalidTransactionException();
        }

        return DB::transaction(function () use ($walletUuid, $amount, $opState, $operation) {
            $wallet = $this->findByUuid(
                walletUuid: $walletUuid,
                lockForUpdate: true
            );

            if (!$wallet) {
                throw new InvalidWalletIdException();
            }

            $precisionDTO = $this->precisionRepository->getPrecisionByWallet($wallet);
            if (null === $precisionDTO) {
                throw new WalletCurrencyPrecisionNotSetException();
            }

            if (
                $this->operationRepository->isHoldState(
                    opType: OpTypeEnum::OP_TYPE_CREDIT,
                    opState: $opState
                )
            ) {
                $result = $wallet
                    ->whereRaw(sprintf('id = %s AND amount + %s >= 0', $wallet->id, $amount))
                    ->increment('amount', $amount)
                ;
                if (!$result) {
                    throw new NotEnoughFundsException();
                }
            }

            if (null === $operation) {
                return $this->operationRepository->add(new OperationDTO(
                    uuid: Str::uuid()->toString(),
                    amount: $amount,
                    precision: $precisionDTO,
                    walletId: $wallet->id,
                    opType: OpTypeEnum::OP_TYPE_CREDIT,
                    opState: $opState,
                    createdAt: now()
                ));
            }

            return $this->operationRepository->updateState(
                operationUuid: $operation->uuid,
                opState: $opState,
            );
        });
    }

    /**
     * @param string $amount
     * @param string $walletUuid
     * @param OpStateEnum $opState
     * @param Operation|null $operation
     * @param array|null $data
     *
     * @return Operation|null
     * @throws InvalidTransactionException
     * @throws Throwable
     */
    public function debit(
        string $amount,
        string $walletUuid,
        OpStateEnum $opState,
        ?Operation $operation,
        ?array $data = null
    ): ?Operation {
        if (!in_array($opState->value, OpStateEnum::toArray())) {
            throw new InvalidTransactionException();
        }

        return DB::transaction(function () use ($walletUuid, $amount, $opState, $operation) {
            $wallet = $this->findByUuid(
                walletUuid: $walletUuid,
                lockForUpdate: true
            );

            if (!$wallet) {
                throw new InvalidWalletIdException();
            }

            $precisionDTO = $this->precisionRepository->getPrecisionByWallet($wallet);
            if (null === $precisionDTO) {
                throw new WalletCurrencyPrecisionNotSetException();
            }

            if (
                $this->operationRepository->isNotEnoughFunds(
                    walletAmount: $wallet->amount,
                    amount: $amount,
                    precision: $precisionDTO->getPrecision()
                )
            ) {
                throw new NotEnoughFundsException();
            }

            if (
                $this->operationRepository->isHoldState(
                    opType: OpTypeEnum::OP_TYPE_DEBIT,
                    opState: $opState
                )
            ) {
                $result = $wallet
                    ->whereRaw(sprintf('id = %s AND amount - %s >= 0', $wallet->id, $amount))
                    ->decrement('amount', $amount)
                ;

                if (!$result) {
                    throw new NotEnoughFundsException();
                }
            }

            if (null === $operation) {
                return $this->operationRepository->add(new OperationDTO(
                    uuid: Str::uuid()->toString(),
                    amount: '-' . $amount,
                    precision: $precisionDTO,
                    walletId: $wallet->id,
                    opType: OpTypeEnum::OP_TYPE_DEBIT,
                    opState: $opState,
                    createdAt: now()
                ));
            }
            return $this->operationRepository->updateState(
                operationUuid: $operation->uuid,
                opState: $opState,
            );
        });
    }
}
