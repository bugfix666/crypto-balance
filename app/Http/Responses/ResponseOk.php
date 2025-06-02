<?php

declare(strict_types=1);

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

/**
 * ResponseOk
 * php version 8.3
 *
 * @category responses
 * @package  CryptoBalance
 * @author   Constantine Bragin <appscenter@proton.me>
 * @license  GPLv3 License
 * @link     https://github.com/appsinvest/crypto-balance
 */
class ResponseOk extends AbstractResponse
{
    protected ?bool $success = true;
    protected $status = HttpFoundationResponse::HTTP_OK;

    /**
     * @return JsonResponse
     */
    public function asJSON(): JsonResponse
    {
        return new JsonResponse(
            ['status' => 'ok'],
            $this->status
        );
    }
}
