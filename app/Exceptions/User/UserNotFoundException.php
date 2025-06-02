<?php

declare(strict_types=1);

namespace App\Exceptions\User;

use App\Exceptions\BadHttpRequestException;

/**
 * UserNotFoundException
 * php version 8.3
 *
 * @category exceptions
 * @package  CryptoBalance
 * @author   Constantine Bragin <appscenter@proton.me>
 * @license  GPLv3 License
 * @link     https://github.com/appsinvest/crypto-balance
 */
final class UserNotFoundException extends BadHttpRequestException
{
    protected $message = 'User not found';
}
