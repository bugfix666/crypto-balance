<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\BlockchainEnum;
use App\Enums\WalletCurrencyEnum;
use App\Exceptions\Wallet\InvalidUuidStringException;
use App\Exceptions\Wallet\ProcessingAmountIsInvalidException;
use App\Exceptions\Wallet\UnsupportedBlockchainOrCurrencyException;
use App\Exceptions\Wallet\WalletCurrencyPrecisionNotSetException;
use App\Exceptions\Wallet\WalletNotFoundException;
use App\Models\User;
use App\Models\Wallet;
use App\Repositories\Interfaces\PrecisionRepositoryInterface;
use App\Services\WalletService;
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
            $wallet = Wallet::factory()->create([
                'user_id' => $user->id,
                'uuid' => $uuid,
                'currency' => WalletCurrencyEnum::BTC->value,
                'blockchain_id' => BlockchainEnum::BTC->value
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
