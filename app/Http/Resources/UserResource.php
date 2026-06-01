<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Bugfix666\CryptoBalanceWallet\Enums\WalletCurrencyEnum;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * UserResource
 * php version 8.3
 *
 * @category resources
 * @package  CryptoBalance
 * @author   Constantine Bragin <appscenter@proton.me>
 * @license  GPLv3 License
 * @link     https://github.com/appsinvest/crypto-balance
 */
class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'user_uuid' => $this->resource->uuid,
            'name' => $this->resource->name,
            'email' => $this->resource->email,
            'wallet' => $this->filterWallet(),
        ];
    }

    private function filterWallet(): WalletResource
    {
        return WalletResource::collection($this->resource->wallets->filter(function ($wallet) {
            if ($wallet->currency === WalletCurrencyEnum::BTC) {
                return $wallet;
            } else {
                var_dump($wallet->currency);
                die;
            }
        }))->first();
    }
}
