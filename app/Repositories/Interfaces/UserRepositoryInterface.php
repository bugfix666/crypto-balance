<?php

declare(strict_types=1);

namespace App\Repositories\Interfaces;

use App\Models\User;
use Illuminate\Support\Collection;

/**
 * UserRepositoryInterface
 * php version 8.3
 *
 * @category interfaces
 * @package  CryptoBalance
 * @author   Constantine Bragin <appscenter@proton.me>
 * @license  GPLv3 License
 * @link     https://github.com/appsinvest/crypto-balance
 */
interface UserRepositoryInterface
{
    public function findById(int $userId): ?User;
    public function findByUuid(string $userUuid): ?User;
    public function getList(): Collection;
}
