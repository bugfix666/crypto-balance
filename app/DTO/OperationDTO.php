<?php

declare(strict_types=1);

namespace App\DTO;

use App\Enums\OpStateEnum;
use App\Enums\OpTypeEnum;
use Illuminate\Support\Carbon;

/**
 * OperationDTO
 * php version 8.3
 *
 * @category DTO
 * @package  CryptoBalance
 * @author   Constantine Bragin <appscenter@proton.me>
 * @license  GPLv3 License
 * @link     https://github.com/appsinvest/crypto-balance
 */
readonly final class OperationDTO
{
    public function __construct(
        private string $uuid,
        private string $amount,
        private PrecisionDTO $precision,
        private int $walletId,
        private OpTypeEnum $opType,
        private OpStateEnum $opState,
        private Carbon $createdAt,
    ) {
    }

    public function toArray(): array
    {
        return [
            'uuid' => $this->uuid,
            'amount' => $this->amount,
            'currency' => $this->precision->getCurrency()->value,
            'blockchain_id' => $this->precision->getBlockchain()->value,
            'wallet_id' => $this->walletId,
            'op_type' => $this->opType->value,
            'op_state' => $this->opState->value,
            'created_at' => $this->createdAt
        ];
    }
}
