<?php

declare(strict_types=1);

namespace App\Exceptions\Wallet;

use App\Exceptions\BadHttpRequestException;

/**
 * UnsupportedBlockchainOrCurrencyException
 * php version 8.3
 *
 * @category exceptions
 * @package  CryptoBalance
 * @author   Constantine Bragin <appscenter@proton.me>
 * @license  GPLv3 License
 * @link     https://github.com/appsinvest/crypto-balance
 */
final class UnsupportedBlockchainOrCurrencyException extends BadHttpRequestException
{
    protected $message = 'Unsupported blockchain or currency provided.';
}
