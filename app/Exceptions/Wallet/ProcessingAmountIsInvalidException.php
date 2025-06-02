<?php

declare(strict_types=1);

namespace App\Exceptions\Wallet;

use App\Exceptions\BadHttpRequestException;

/**
 * ProcessingAmountIsInvalidException
 * php version 8.3
 *
 * @category exceptions
 * @package  CryptoBalance
 * @author   Constantine Bragin <appscenter@proton.me>
 * @license  GPLv3 License
 * @link     https://github.com/appsinvest/crypto-balance
 */
final class ProcessingAmountIsInvalidException extends BadHttpRequestException
{
    protected $message = 'Processing amount "%s" is invalid.';
    public function __construct(string $amount)
    {
        parent::__construct(sprintf($this->message, $amount), $this->code, $this->getPrevious());
    }
}
