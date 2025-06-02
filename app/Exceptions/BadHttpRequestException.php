<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

/**
 * BadHttpRequestException
 * php version 8.3
 *
 * @category exceptions
 * @package  CryptoBalance
 * @author   Constantine Bragin <appscenter@proton.me>
 * @license  GPLv3 License
 * @link     https://github.com/appsinvest/crypto-balance
 */
class BadHttpRequestException extends Exception
{
    protected $code = HttpFoundationResponse::HTTP_BAD_REQUEST;
}
