<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Http\Resources\UserResource;
use App\Services\UserService;
use Illuminate\Console\Command;

/**
 * ListWalletsCommand
 * php version 8.3
 *
 * @category commands
 * @package  CryptoBalance
 * @author   Constantine Bragin <appscenter@proton.me>
 * @license  GPLv3 License
 * @link     https://github.com/appsinvest/crypto-balance
 */
class ListWalletsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wallet:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * @param UserService $userService
     * @return void
     */
    public function handle(
        UserService $userService
    ) {
        echo "User UUID | User name | Email | Wallet UUID", PHP_EOL;

        foreach (UserResource::collection($userService->getList()) as $item) {
            echo $item->resource->uuid, " | ",
            $item->resource->name, " | ",
            $item->resource->email, " | ",
            $item->resource->wallets->first()->uuid,
            PHP_EOL;
        }
    }
}
