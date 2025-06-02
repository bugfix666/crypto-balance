<?php

declare(strict_types=1);

namespace App\Enums;

use App\Enums\Traits\TEnumToArray;

/**
 * OpStateEnum
 * php version 8.3
 *
 * @category enums
 * @package  CryptoBalance
 * @author   Constantine Bragin <appscenter@proton.me>
 * @license  GPLv3 License
 * @link     https://github.com/appsinvest/crypto-balance
 */
enum OpStateEnum: int
{
    use TEnumToArray;

    case OS_INPROCESS = 1;
    case OS_COMPLETE = 2;
    case OS_FAIL = 3;
    case OS_CANCELED = 4;
    case OS_HOLD = 5;
}
