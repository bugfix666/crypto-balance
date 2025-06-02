<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Collection;

/**
 * UserRepository
 * php version 8.3
 *
 * @category repositories
 * @package  CryptoBalance
 * @author   Constantine Bragin <appscenter@proton.me>
 * @license  GPLv3 License
 * @link     https://github.com/appsinvest/crypto-balance
 */
final readonly class UserRepository implements UserRepositoryInterface
{
    public function findById(int $userId): ?User
    {
        return User::query()->where('id', $userId)->first();
    }

    /**
     * @return Collection<int, User>
     */
    public function getList(): Collection
    {
        return User::with(['wallets'])->get();
    }

    public function findByUuid(string $userUuid): ?User
    {
        return User::query()->where('uuid', $userUuid)->first();
    }
}
