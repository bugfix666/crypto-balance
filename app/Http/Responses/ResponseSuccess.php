<?php

declare(strict_types=1);

namespace App\Http\Responses;

use App\Http\Responses\Traits\TAsJsonStandard;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

/**
 * ResponseSuccess
 * php version 8.3
 *
 * @category responses
 * @package  CryptoBalance
 * @author   Constantine Bragin <appscenter@proton.me>
 * @license  GPLv3 License
 * @link     https://github.com/appsinvest/crypto-balance
 */
class ResponseSuccess extends AbstractResponse
{
    use TAsJsonStandard;

    protected ?bool $success = true;
    protected $status = HttpFoundationResponse::HTTP_OK;
}
