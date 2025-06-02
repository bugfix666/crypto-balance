<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Exceptions\User\UserNotFoundException;
use App\Exceptions\Wallet\InvalidUuidStringException;
use App\Http\Resources\OperationResource;
use App\Services\OperationService;
use App\Services\UserService;
use Illuminate\Console\Command;

/**
 * ListOperationsCommand
 * php version 8.3
 *
 * @category commands
 * @package  CryptoBalance
 * @author   Constantine Bragin <appscenter@proton.me>
 * @license  GPLv3 License
 * @link     https://github.com/appsinvest/crypto-balance
 */
class ListOperationsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wallet:operations {user : uuid of user}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * @param OperationService $operationService
     * @param UserService $userService
     * @return void
     * @throws InvalidUuidStringException
     * @throws UserNotFoundException
     */
    public function handle(
        OperationService $operationService,
        UserService $userService,
    ) {
        $userUuid = $this->argument('user');

        if (false === $operationService->isValidUuid($userUuid)) {
            throw new InvalidUuidStringException();
        }

        $user = $userService->findByUuid($userUuid);
        if (null === $user) {
            throw new UserNotFoundException();
        }

        $operations = OperationResource::collection(
            $operationService->findByUserUuid($userUuid)
        );

        foreach ($operations as $item) {
            echo $item->resource->uuid, " | ",
            $item->resource->op_type, " | ",
            $item->resource->amount, " | ",
            $item->resource->currency, " | ",
            $item->resource->created_at->format('d.m.Y H:i:s'),
            PHP_EOL;
        }
    }
}
