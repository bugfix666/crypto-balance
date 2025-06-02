<?php

declare(strict_types=1);

namespace App\Enums;

/**
 * OpTypeEnum
 * php version 8.3
 *
 * @category enums
 * @package  CryptoBalance
 * @author   Constantine Bragin <appscenter@proton.me>
 * @license  GPLv3 License
 * @link     https://github.com/appsinvest/crypto-balance
 */
enum OpTypeEnum: int
{
    case OP_TYPE_CREDIT = 1;
    case OP_TYPE_DEBIT = 2;
}
