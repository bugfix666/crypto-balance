<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\DTO\BalanceProcessCallbackDTO;
use App\Enums\OpStateEnum;
use App\Exceptions\Wallet\InvalidUuidStringException;
use App\Exceptions\Wallet\ProcessingAmountIsInvalidException;
use App\Exceptions\Wallet\UnsupportedBlockchainOrCurrencyException;
use App\Exceptions\Wallet\WalletCurrencyPrecisionNotSetException;
use App\Exceptions\Wallet\WalletNotFoundException;
use App\Jobs\BalanceProcessCallbackJob;
use App\Services\WalletService;
use Illuminate\Console\Command;

/**
 * WithdrawCommand
 * php version 8.3
 *
 * @category commands
 * @package  CryptoBalance
 * @author   Constantine Bragin <appscenter@proton.me>
 * @license  GPLv3 License
 * @link     https://github.com/appsinvest/crypto-balance
 */
class WithdrawCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wallet:withdraw {amount : amount to withdraw}
    {wallet : uuid of wallet to withdraw}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * @param WalletService $walletService
     *
     * @return void
     * @throws InvalidUuidStringException
     * @throws ProcessingAmountIsInvalidException
     * @throws UnsupportedBlockchainOrCurrencyException
     * @throws WalletCurrencyPrecisionNotSetException
     * @throws WalletNotFoundException
     */
    public function handle(
        WalletService $walletService
    ) {
        $amount = $this->argument('amount');
        $walletUuid = $this->argument('wallet');

        for ($i = 0; $i < 100; $i++) {
            // add new
            $operation = $walletService->subBalance(
                amount: $amount,
                walletUuid: $walletUuid,
                opState: OpStateEnum::OS_INPROCESS
            );

            BalanceProcessCallbackJob::dispatch(new BalanceProcessCallbackDTO(
                opState: OpStateEnum::OS_COMPLETE,
                operationUuid: $operation->uuid
            ));
        }
    }
}
