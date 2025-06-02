<?php

declare(strict_types=1);

namespace App\Repositories\Interfaces;

use App\Enums\OpStateEnum;
use App\Models\Operation;
use App\Models\Wallet;

/**
 * WalletRepositoryInterface
 * php version 8.3
 *
 * @category interfaces
 * @package  CryptoBalance
 * @author   Constantine Bragin <appscenter@proton.me>
 * @license  GPLv3 License
 * @link     https://github.com/appsinvest/crypto-balance
 */
interface WalletRepositoryInterface
{
    public function findById(int $walletId, bool $lockForUpdate = false): ?Wallet;
    public function findByUuid(string $walletUuid, bool $lockForUpdate = false): ?Wallet;
    public function debit(
        string $amount,
        string $walletUuid,
        OpStateEnum $opState,
        ?Operation $operation,
        ?array $data = null
    ): ?Operation;

    public function credit(
        string $amount,
        string $walletUuid,
        OpStateEnum $opState,
        ?Operation $operation,
        ?array $data = null
    ): ?Operation;
}
