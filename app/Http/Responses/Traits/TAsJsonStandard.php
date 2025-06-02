<?php

namespace App\Http\Responses\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * TAsJsonStandard
 * php version 8.3
 *
 * @category traits
 * @package  CryptoBalance
 * @author   Constantine Bragin <appscenter@proton.me>
 * @license  GPLv3 License
 * @link     https://github.com/appsinvest/crypto-balance
 */
trait TAsJsonStandard
{
    /**
     * @return JsonResponse
     */
    public function asJSON(): JsonResponse
    {
        return new JsonResponse(
            [
                'error' => $this->error,
                'success' => $this->success,
                'data' => (is_object($this->data) && method_exists($this->data, 'toArray'))
                    ?
                    $this->data->toArray(Request::capture())
                    : $this->data
            ],
            $this->status
        );
    }
}
