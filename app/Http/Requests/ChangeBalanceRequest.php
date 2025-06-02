<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * ChangeBalanceRequest
 * php version 8.3
 *
 * @category requests
 * @package  CryptoBalance
 * @author   Constantine Bragin <appscenter@proton.me>
 * @license  GPLv3 License
 * @link     https://github.com/appsinvest/crypto-balance
 */
class ChangeBalanceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'wallet_uuid' => [
                'required',
                'uuid'
            ],
            'amount' => [
                'numeric',
                'min:0.00000001',
                'max:10000'
            ],
        ];
    }
}
