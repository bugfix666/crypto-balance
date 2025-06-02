<?php

declare(strict_types=1);

namespace App\DTO;

use App\Enums\OpStateEnum;

/**
 * BalanceProcessCallbackDTO
 * php version 8.3
 *
 * @category DTO
 * @package  CryptoBalance
 * @author   Constantine Bragin <appscenter@proton.me>
 * @license  GPLv3 License
 * @link     https://github.com/appsinvest/crypto-balance
 */
readonly final class BalanceProcessCallbackDTO
{
    public function __construct(
        private OpStateEnum $opState,
        private string $operationUuid,
    ) {
    }

    public function getOpState(): OpStateEnum
    {
        return $this->opState;
    }

    public function getOperationUuid(): string
    {
        return $this->operationUuid;
    }
}
