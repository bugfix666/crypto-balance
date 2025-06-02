<?php

declare(strict_types=1);

namespace App\Repositories\Interfaces;

use App\Enums\OpStateEnum;
use App\Enums\OpTypeEnum;
use App\Models\Operation;
use Illuminate\Support\Collection;

/**
 * OperationRepositoryInterface
 * php version 8.3
 *
 * @category interfaces
 * @package  CryptoBalance
 * @author   Constantine Bragin <appscenter@proton.me>
 * @license  GPLv3 License
 * @link     https://github.com/appsinvest/crypto-balance
 */
interface OperationRepositoryInterface
{
    public function getList(int $walletId): Collection;
    public function findByUserWalletsIds(array $walletIds): Collection;
    public function findById(int $walletId): ?Operation;
    public function absAmount(string $amount): string;
    public function prepareValue(string $amount, int $precision): string;
    public function isNotEnoughFunds(string $walletAmount, string $amount, int $precision): bool;
    public function isHoldState(OpTypeEnum $opType, OpStateEnum $opState): bool;
    public function formatAmount(string $amount, int $precision): string;
}
