<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Bugfix666\CryptoBalanceWallet\DTO\BalanceProcessCallbackDTO;
use Bugfix666\CryptoBalanceWallet\Enums\OpStateEnum;
use Bugfix666\CryptoBalanceWallet\Exceptions\Wallet\InvalidUuidStringException;
use Bugfix666\CryptoBalanceWallet\Exceptions\Wallet\ProcessingAmountIsInvalidException;
use Bugfix666\CryptoBalanceWallet\Exceptions\Wallet\UnsupportedBlockchainOrCurrencyException;
use Bugfix666\CryptoBalanceWallet\Exceptions\Wallet\WalletCurrencyPrecisionNotSetException;
use Bugfix666\CryptoBalanceWallet\Exceptions\Wallet\WalletNotFoundException;
use Bugfix666\CryptoBalanceWallet\Jobs\BalanceProcessCallbackJob;
use Bugfix666\CryptoBalanceWallet\Services\WalletService;
use Illuminate\Console\Command;

/**
 * DepositCommand
 * php version 8.3
 *
 * @category commands
 * @package  CryptoBalance
 * @author   Constantine Bragin <appscenter@proton.me>
 * @license  GPLv3 License
 * @link     https://github.com/appsinvest/crypto-balance
 */
class DepositCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wallet:deposit {amount : amount to deposit}
    {wallet : uuid of wallet to deposit}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * @param WalletService $walletService
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
            $operation = $walletService->addBalance(
                amount: (string)$amount,
                walletUuid: (string)$walletUuid,
                opState: OpStateEnum::OS_INPROCESS
            );

            BalanceProcessCallbackJob::dispatch(new BalanceProcessCallbackDTO(
                opState: OpStateEnum::OS_COMPLETE,
                operationUuid: $operation->uuid
            ));
        }
    }
}
