<?php

declare(strict_types=1);

namespace App\Repositories\Interfaces;

use App\DTO\PrecisionDTO;
use App\Enums\BlockchainEnum;
use App\Enums\WalletCurrencyEnum;
use App\Models\Wallet;

/**
 * PrecisionRepositoryInterface
 * php version 8.3
 *
 * @category interfaces
 * @package  CryptoBalance
 * @author   Constantine Bragin <appscenter@proton.me>
 * @license  GPLv3 License
 * @link     https://github.com/appsinvest/crypto-balance
 */
interface PrecisionRepositoryInterface
{
    public function getPrecisionByWallet(Wallet $wallet): ?PrecisionDTO;
    public function getPrecision(
        WalletCurrencyEnum $currency,
        BlockchainEnum $blockchain
    ): ?int;
    public function buildMinimumAmount(int $precision): string;
    public function lessThanMinimumAmount(string $amount, int $precision): bool;
}
