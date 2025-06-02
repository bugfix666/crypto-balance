<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\WalletFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Wallet
 * php version 8.3
 *
 * @category models
 * @package  CryptoBalance
 * @author   Constantine Bragin <appscenter@proton.me>
 * @license  GPLv3 License
 * @link     https://github.com/appsinvest/crypto-balance
 * @property int $id
 * @property string $uuid
 * @property string $amount
 * @property string $currency
 * @property int|null $blockchain_id
 * @property int $user_id
 * @property-read User $user
 * @method static WalletFactory factory($count = null, $state = [])
 * @method static Builder<static>|Wallet newModelQuery()
 * @method static Builder<static>|Wallet newQuery()
 * @method static Builder<static>|Wallet query()
 * @method static Builder<static>|Wallet whereAmount($value)
 * @method static Builder<static>|Wallet whereBlockchainId($value)
 * @method static Builder<static>|Wallet whereCurrency($value)
 * @method static Builder<static>|Wallet whereId($value)
 * @method static Builder<static>|Wallet whereUserId($value)
 * @method static Builder<static>|Wallet whereUuid($value)
 * @mixin \Eloquent
 */
class Wallet extends Eloquent
{
    /** @use HasFactory<WalletFactory> */
    use HasFactory;

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var string[]
     */
    protected $fillable = [
        'amount',
        'currency',
        'blockchain_id',
        'user_id',
        'uuid',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
