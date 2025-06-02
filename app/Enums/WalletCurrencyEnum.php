<?php

declare(strict_types=1);

namespace App\Enums;

use App\Enums\Traits\TEnumToArray;

/**
 * WalletCurrencyEnum
 * php version 8.3
 *
 * @category enums
 * @package  CryptoBalance
 * @author   Constantine Bragin <appscenter@proton.me>
 * @license  GPLv3 License
 * @link     https://github.com/appsinvest/crypto-balance
 */
enum WalletCurrencyEnum: string
{
    use TEnumToArray;

    case BTC = 'BTC';
    case USDT = 'USDT';
    case USD = 'USD';
}
