<?php

declare(strict_types=1);

namespace Database\Seeders;

use Bugfix666\CryptoBalanceWallet\Enums\BlockchainEnum;
use Bugfix666\CryptoBalanceWallet\Enums\WalletCurrencyEnum;
use Bugfix666\CryptoBalanceWallet\Exceptions\Wallet\InvalidUuidStringException;
use Bugfix666\CryptoBalanceWallet\Exceptions\Wallet\ProcessingAmountIsInvalidException;
use Bugfix666\CryptoBalanceWallet\Exceptions\Wallet\UnsupportedBlockchainOrCurrencyException;
use Bugfix666\CryptoBalanceWallet\Exceptions\Wallet\WalletCurrencyPrecisionNotSetException;
use Bugfix666\CryptoBalanceWallet\Exceptions\Wallet\WalletNotFoundException;
use App\Models\User;
use Bugfix666\CryptoBalanceWallet\Models\Wallet;
use Bugfix666\CryptoBalanceWallet\Repositories\Interfaces\PrecisionRepositoryInterface;
use Bugfix666\CryptoBalanceWallet\Services\WalletService;
use Illuminate\Database\Seeder;

/**
 * DatabaseSeeder
 * php version 8.3
 *
 * @category seeders
 * @package  CryptoBalance
 * @author   Constantine Bragin <appscenter@proton.me>
 * @license  GPLv3 License
 * @link     https://github.com/appsinvest/crypto-balance
 */
class DatabaseSeeder extends Seeder
{
    public function __construct(
        private readonly WalletService $walletService,
        private readonly PrecisionRepositoryInterface $precisionRepository,
    ) {
    }

    /**
     * @return void
     * @throws InvalidUuidStringException
     * @throws ProcessingAmountIsInvalidException
     * @throws WalletCurrencyPrecisionNotSetException
     * @throws WalletNotFoundException
     * @throws UnsupportedBlockchainOrCurrencyException
     */
    public function run(): void
    {
        for ($j = 0; $j < 10; $j++) {
            $user = User::factory()->create();
            /** @var User $user */

            $uuid = fake()->unique()->uuid();
            $wallet = Wallet::query()->create([
                'user_id' => $user->id,
                'uuid' => $uuid,
                'currency' => WalletCurrencyEnum::BTC,
                'blockchain_id' => BlockchainEnum::BTC
            ])->refresh();
            /** @var Wallet $wallet */

            $precisionDTO = $this->precisionRepository->getPrecisionByWallet($wallet);
            $minimum = $this->precisionRepository->buildMinimumAmount(
                $precisionDTO->getPrecision()
            );

            for ($i = 0; $i < 10; $i++) {
                $amount = $this->bcrand($minimum,'3', $precisionDTO->getPrecision());
                $this->walletService->addBalance(
                    amount: $amount,
                    walletUuid: $uuid,
                );
            }
        }
    }

    /**
     * @param string $min
     * @param string $max
     * @param int $precision
     *
     * @return string
     */
    private function bcrand(string $min, string $max, int $precision): string
    {
        $difference   = bcadd(bcsub($max, $min),'1');
        $rand_percent = bcdiv((string)mt_rand(), (string)mt_getrandmax(), $precision);

        return bcadd($min, bcmul($difference, $rand_percent, $precision), $precision);
    }
}
