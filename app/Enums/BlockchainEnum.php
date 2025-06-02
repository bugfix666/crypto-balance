<?php

declare(strict_types=1);

namespace App\Enums;

/**
 * BlockchainEnum
 * php version 8.3
 *
 * @category enums
 * @package  CryptoBalance
 * @author   Constantine Bragin <appscenter@proton.me>
 * @license  GPLv3 License
 * @link     https://github.com/appsinvest/crypto-balance
 */
enum BlockchainEnum: int
{
    case FIAT = 0;
    case BTC = 1;
    case TRC20 = 2;
}
