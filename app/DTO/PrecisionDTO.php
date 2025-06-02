<?php

declare(strict_types=1);

namespace App\DTO;

use App\Enums\BlockchainEnum;
use App\Enums\WalletCurrencyEnum;

class PrecisionDTO
{
    public function __construct(
        private readonly WalletCurrencyEnum $currency,
        private readonly BlockchainEnum $blockchain,
        private readonly int $precision,
    ) {
    }

    public function getCurrency(): WalletCurrencyEnum
    {
        return $this->currency;
    }

    public function getBlockchain(): BlockchainEnum
    {
        return $this->blockchain;
    }

    public function getPrecision(): int
    {
        return $this->precision;
    }
}
