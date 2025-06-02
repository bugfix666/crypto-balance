<?php

declare(strict_types=1);

namespace App\Repositories;

use App\DTO\PrecisionDTO;
use App\Enums\BlockchainEnum;
use App\Enums\WalletCurrencyEnum;
use App\Exceptions\Wallet\UnsupportedBlockchainOrCurrencyException;
use App\Models\Wallet;
use App\Repositories\Interfaces\PrecisionRepositoryInterface;
use ValueError;

/**
 * PrecisionRepository
 * php version 8.3
 *
 * @category repositories
 * @package  CryptoBalance
 * @author   Constantine Bragin <appscenter@proton.me>
 * @license  GPLv3 License
 * @link     https://github.com/appsinvest/crypto-balance
 */
final readonly class PrecisionRepository implements PrecisionRepositoryInterface
{
    private const array PRECISION = [
        BlockchainEnum::FIAT->value => [
            WalletCurrencyEnum::USD->value => 2,
        ],
        BlockchainEnum::BTC->value => [
            WalletCurrencyEnum::BTC->value => 8,
        ],
        BlockchainEnum::TRC20->value => [
            WalletCurrencyEnum::USDT->value => 6,
        ],
    ];

    /**
     * @param Wallet $wallet
     *
     * @return ?PrecisionDTO
     * @throws UnsupportedBlockchainOrCurrencyException
     */
    public function getPrecisionByWallet(Wallet $wallet): ?PrecisionDTO
    {
        try {
            $currency = WalletCurrencyEnum::from($wallet->currency);
            $blockchain = BlockchainEnum::from($wallet->blockchain_id);
        } catch (ValueError) {
            throw new UnsupportedBlockchainOrCurrencyException();
        }
        $precision = $this->getPrecision(
            currency: $currency,
            blockchain: $blockchain
        );

        return null !== $precision ? new PrecisionDTO(
            currency: $currency,
            blockchain: $blockchain,
            precision: $precision
        ) : null;
    }

    public function getPrecision(
        WalletCurrencyEnum $currency,
        BlockchainEnum $blockchain
    ): ?int {
        return self::PRECISION[$blockchain->value][$currency->value] ?? null;
    }

    public function buildMinimumAmount(int $precision): string
    {
        return '0.' . str_pad('', $precision - 1, '0') . '1';
    }

    public function lessThanMinimumAmount(string $amount, int $precision): bool
    {
        return bccomp(
            $amount,
            $this->buildMinimumAmount($precision),
            $precision
        ) < 0;
    }
}
