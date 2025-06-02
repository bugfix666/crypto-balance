<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * OperationResource
 * php version 8.3
 *
 * @category resources
 * @package  CryptoBalance
 * @author   Constantine Bragin <appscenter@proton.me>
 * @license  GPLv3 License
 * @link     https://github.com/appsinvest/crypto-balance
 */
class OperationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'uuid' => $this->resource->uuid,
            'op_type' => $this->resource->op_type,
            'amount' => $this->resource->amount,
            'currency' => $this->resource->currency,
            'created_at' => $this->resource->created_at->format('d.m.Y H:i:s'),
        ];
    }
}
