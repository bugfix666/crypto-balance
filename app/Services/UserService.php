<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Collection;

/**
 * UserService
 * php version 8.3
 *
 * @category services
 * @package  CryptoBalance
 * @author   Constantine Bragin <appscenter@proton.me>
 * @license  GPLv3 License
 * @link     https://github.com/appsinvest/crypto-balance
 */
readonly class UserService
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
    ) {
    }

    public function getList(): Collection
    {
        return $this->userRepository->getList();
    }

    public function findByUuid(string $uuid): ?User
    {
        return $this->userRepository->findByUuid($uuid);
    }
}
