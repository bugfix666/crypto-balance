<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\OpStateEnum;
use App\Exceptions\Wallet\InvalidUuidStringException;
use App\Exceptions\Wallet\ProcessingAmountIsInvalidException;
use App\Exceptions\Wallet\UnsupportedBlockchainOrCurrencyException;
use App\Exceptions\Wallet\WalletCurrencyPrecisionNotSetException;
use App\Exceptions\Wallet\WalletNotFoundException;
use App\Models\Operation;
use App\Models\Wallet;
use App\Repositories\Interfaces\OperationRepositoryInterface;
use App\Repositories\Interfaces\PrecisionRepositoryInterface;
use App\Repositories\Interfaces\WalletRepositoryInterface;

/**
 * WalletService
 * php version 8.3
 *
 * @category services
 * @package  CryptoBalance
 * @author   Constantine Bragin <appscenter@proton.me>
 * @license  GPLv3 License
 * @link     https://github.com/appsinvest/crypto-balance
 */
readonly class WalletService
{
    public function __construct(
        private WalletRepositoryInterface $walletRepository,
        private PrecisionRepositoryInterface $precisionRepository,
        private OperationRepositoryInterface $operationRepository,
    ) {
    }

    /**
     * @param string $uuid
     * @return Wallet|null
     */
    public function findByUuid(string $uuid): ?Wallet
    {
        return $this->walletRepository->findByUuid($uuid);
    }

    /**
     * @param string $amount
     * @param string $walletUuid
     * @param OpStateEnum $opState
     * @param Operation|null $operation
     *
     * @return Operation|null
     * @throws InvalidUuidStringException
     * @throws ProcessingAmountIsInvalidException
     * @throws UnsupportedBlockchainOrCurrencyException
     * @throws WalletCurrencyPrecisionNotSetException
     * @throws WalletNotFoundException
     */
    public function addBalance(
        string $amount,
        string $walletUuid,
        OpStateEnum $opState = OpStateEnum::OS_COMPLETE,
        ?Operation $operation = null
    ): ?Operation {
        $amount = $this->validate(
            amount: $amount,
            walletUuid: $walletUuid,
        );

        $operation = $this->walletRepository->credit(
            amount: $amount,
            walletUuid: $walletUuid,
            opState: $opState,
            operation : $operation
        );

        return null !== $operation ? $operation : null;
    }

    /**
     * @param string $amount
     * @param string $walletUuid
     * @param OpStateEnum $opState
     * @param Operation|null $operation
     *
     * @return Operation|null
     * @throws InvalidUuidStringException
     * @throws ProcessingAmountIsInvalidException
     * @throws UnsupportedBlockchainOrCurrencyException
     * @throws WalletCurrencyPrecisionNotSetException
     * @throws WalletNotFoundException
     */
    public function subBalance(
        string $amount,
        string $walletUuid,
        OpStateEnum $opState = OpStateEnum::OS_COMPLETE,
        ?Operation $operation = null
    ): ?Operation {
        $amount = $this->validate(
            amount: $amount,
            walletUuid: $walletUuid
        );

        $operation = $this->walletRepository->debit(
            amount: $amount,
            walletUuid: $walletUuid,
            opState: $opState,
            operation: $operation
        );

        return null !== $operation ? $operation : null;
    }

    /**
     * @param string $amount
     * @param string $walletUuid
     *
     * @return string
     * @throws InvalidUuidStringException
     * @throws ProcessingAmountIsInvalidException
     * @throws WalletCurrencyPrecisionNotSetException
     * @throws WalletNotFoundException
     * @throws UnsupportedBlockchainOrCurrencyException
     */
    private function validate(
        string $amount,
        string $walletUuid
    ): string {
        // check if wallet's UUID is valid UUID
        if (false === $this->operationRepository->isValidUuid(uuid: $walletUuid)) {
            throw new InvalidUuidStringException();
        }

        // check if wallet exists
        $wallet = $this->walletRepository->findByUuid($walletUuid);
        if (null === $wallet) {
            throw new WalletNotFoundException();
        }

        // check precision is set and blockchain with currency is supported
        $precisionDTO = $this->precisionRepository->getPrecisionByWallet($wallet);
        if (null === $precisionDTO) {
            throw new WalletCurrencyPrecisionNotSetException();
        }

        // check amount value
        $value = $this->operationRepository->prepareValue(
            amount: $amount,
            precision: $precisionDTO->getPrecision()
        );

        if (
            $this->precisionRepository->lessThanMinimumAmount(
                amount: $value,
                precision: $precisionDTO->getPrecision()
            )
        ) {
            throw new ProcessingAmountIsInvalidException($value);
        }

        return $amount;
    }
}
