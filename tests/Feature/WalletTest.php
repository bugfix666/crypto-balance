<?php

declare(strict_types=1);

namespace Feature;

use App\Enums\BlockchainEnum;
use App\Enums\WalletCurrencyEnum;
use App\Models\Operation;
use App\Models\User;
use App\Models\Wallet;
use App\Services\WalletService;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

/**
 * WalletTest
 * php version 8.3
 *
 * @category tests
 * @package  CryptoBalance
 * @author   Constantine Bragin <appscenter@proton.me>
 * @license  GPLv3 License
 * @link     https://github.com/appsinvest/crypto-balance
 */
class WalletTest extends TestCase
{
    public function testWalletAddBalance(): void
    {
        Artisan::call('migrate');
        $user = User::factory()->create();

        $walletService = app(WalletService::class);
        $walletUuid = fake()->unique()->uuid();
        Wallet::factory()->create([
            'user_id' => $user->id,
            'uuid' => $walletUuid,
            'currency' => WalletCurrencyEnum::BTC->value,
            'blockchain_id' => BlockchainEnum::BTC->value
        ]);

        $amount = '12.345678';
        $operation = $walletService->addBalance(
            amount: $amount,
            walletUuid: $walletUuid,
        );

        $this->assertNotNull($operation);
        $this->assertTrue($operation instanceof Operation);
        $this->assertTrue(bccomp($operation->amount, $amount) === 0);

        $wallet = $walletService->findByUuid($walletUuid);
        $this->assertTrue(bccomp($wallet->amount, $amount) === 0);

        $operation = $walletService->subBalance(
            amount: $amount,
            walletUuid: $walletUuid,
        );
        $this->assertNotNull($operation);
        $this->assertTrue($operation instanceof Operation);
        $this->assertTrue(bccomp($operation->amount, '-' . $amount) === 0);
        $wallet = $walletService->findByUuid($walletUuid);
        $this->assertTrue(bccomp($wallet->amount, '0') === 0);
    }

    public function testWalletFails(): void
    {
        Artisan::call('migrate');
        $user = User::factory()->create();

        $walletService = app(WalletService::class);
        $walletUuid = fake()->unique()->uuid();
        Wallet::factory()->create([
            'user_id' => $user->id,
            'uuid' => $walletUuid,
            'currency' => WalletCurrencyEnum::BTC->value,
            'blockchain_id' => BlockchainEnum::BTC->value
        ]);

        $amount = '12.345678';

        $exceptionOnNotEnoughFunds = false;
        try{
            $walletService->subBalance(
                amount: $amount,
                walletUuid: $walletUuid
            );
        } catch (\Throwable) {
            $exceptionOnNotEnoughFunds = true;
        }
        $this->assertTrue($exceptionOnNotEnoughFunds);

        $wallet = $walletService->findByUuid($walletUuid);
        $this->assertTrue(bccomp($wallet->amount, '0') === 0);
    }

    public function test_user_successful_response(): void
    {
        Artisan::call('migrate');
        Artisan::call('db:seed');

        $response = $this->get('/api/v1/users');

        $response->assertStatus(200);
        $json = $response->json();

        $response->assertJsonStructure([
            "wallet" => [
                "uuid",
                "amount",
                "currency",
            ],
            "email",
            "name",
            'user_uuid',
            ], $json['data'][0]
        );
    }

    public function test_operation_successful_response(): void
    {
        Artisan::call('migrate');
        Artisan::call('db:seed');

        $response = $this->get('/api/v1/users');

        $response->assertStatus(200);
        $json = $response->json();

        $response = $this->post('/api/v1/operations', [
            'user_uuid' => $json['data'][0]['user_uuid']
        ]);

        $response->assertStatus(200);
        $json = $response->json();

        $response->assertJsonStructure([
            "amount",
            "created_at",
            "currency",
            "op_type",
            "uuid",
        ], $json['data'][0]
        );

    }
    public function test_operation_unsuccessful_response(): void
    {
        $response = $this->post('/api/v1/operations', [
            'user_uuid' => 'ba644bb1-1111-3333-2222-d13c49695dc7'
        ]);

        $response->assertStatus(400);
    }

    public function test_wallet_successful_response(): void
    {
        Artisan::call('migrate');
        Artisan::call('db:seed');

        $response = $this->get('/api/v1/users');

        $response->assertStatus(200);
        $json = $response->json();

        $response = $this->post('/api/v1/wallet/add-balance', [
            'wallet_uuid' => $json['data'][0]['wallet']['uuid'],
            'amount' => '123.456'
        ]);
        $json = $response->json();

        $response->assertStatus(200);

        $this->assertTrue($json['success']);
        $this->assertTrue(isset($json['data']['id']));
    }
}
