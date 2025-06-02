<?php

declare(strict_types=1);

namespace App\Services;

use App\Exceptions\User\UserNotFoundException;
use App\Models\Operation;
use App\Repositories\Interfaces\OperationRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Collection;

/**
 * OperationService
 * php version 8.3
 *
 * @category services
 * @package  CryptoBalance
 * @author   Constantine Bragin <appscenter@proton.me>
 * @license  GPLv3 License
 * @link     https://github.com/appsinvest/crypto-balance
 */
readonly class OperationService
{
    public function __construct(
        private OperationRepositoryInterface $operationRepository,
        private UserRepositoryInterface $userRepository,
    ) {
    }

    /**
     * @throws UserNotFoundException
     */
    public function findByUserUuid(string $uuid): Collection
    {
        $user = $this->userRepository->findByUuid($uuid);
        if (null === $user) {
            throw new UserNotFoundException();
        }

        return $this->operationRepository->findByUserWalletsIds($user->wallets->pluck('id')->toArray());
    }

    public function findByUuid(string $uuid): ?Operation
    {
        return Operation::query()->whereUuid($uuid)->first();
    }

    public function isValidUuid(string $uuid): bool
    {
        return $this->operationRepository->isValidUuid($uuid);
    }
}
