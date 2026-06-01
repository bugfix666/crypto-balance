<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\Operation
 * php version 8.3
 *
 * @category models
 * @package CryptoBalance
 * @author Constantine Bragin <appscenter@proton.me>
 * @license GPLv3 License
 * @link https://github.com/appsinvest/crypto-balance
 * @property int $id
 * @property string $uuid
 * @property string $amount
 * @property string $currency
 * @property int|null $blockchain_id
 * @property int $wallet_id
 * @property int $op_type
 * @property int $op_state
 * @property array<array-key, mixed>|null $data
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read User|null $user
 * @property-read Wallet $wallet
 * @method static Builder<static>|Operation newModelQuery()
 * @method static Builder<static>|Operation newQuery()
 * @method static Builder<static>|Operation onlyTrashed()
 * @method static Builder<static>|Operation query()
 * @method static Builder<static>|Operation whereAmount($value)
 * @method static Builder<static>|Operation whereBlockchainId($value)
 * @method static Builder<static>|Operation whereCreatedAt($value)
 * @method static Builder<static>|Operation whereCurrency($value)
 * @method static Builder<static>|Operation whereData($value)
 * @method static Builder<static>|Operation whereDeletedAt($value)
 * @method static Builder<static>|Operation whereId($value)
 * @method static Builder<static>|Operation whereOpState($value)
 * @method static Builder<static>|Operation whereOpType($value)
 * @method static Builder<static>|Operation whereUpdatedAt($value)
 * @method static Builder<static>|Operation whereUuid($value)
 * @method static Builder<static>|Operation whereWalletId($value)
 * @method static Builder<static>|Operation withTrashed()
 * @method static Builder<static>|Operation withoutTrashed()
 * @mixin Eloquent
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperOperation {}
}

namespace App\Models{
/**
 * App\Models\User
 * php version 8.3
 *
 * @category models
 * @package CryptoBalance
 * @author Constantine Bragin <appscenter@proton.me>
 * @license GPLv3 License
 * @link https://github.com/appsinvest/crypto-balance
 * @property int $id
 * @property string $uuid
 * @property string $name
 * @property string $email
 * @property Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read DatabaseNotificationCollection<int, DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read Collection<int, \App\Models\Wallet> $wallets
 * @property-read int|null $wallets_count
 * @method static UserFactory factory($count = null, $state = [])
 * @method static Builder<static>|User newModelQuery()
 * @method static Builder<static>|User newQuery()
 * @method static Builder<static>|User query()
 * @method static Builder<static>|User whereCreatedAt($value)
 * @method static Builder<static>|User whereEmail($value)
 * @method static Builder<static>|User whereEmailVerifiedAt($value)
 * @method static Builder<static>|User whereId($value)
 * @method static Builder<static>|User whereName($value)
 * @method static Builder<static>|User wherePassword($value)
 * @method static Builder<static>|User whereRememberToken($value)
 * @method static Builder<static>|User whereUpdatedAt($value)
 * @method static Builder<static>|User whereUuid($value)
 * @mixin Eloquent
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperUser {}
}

namespace App\Models{
/**
 * App\Models\Wallet
 * php version 8.3
 *
 * @category models
 * @package CryptoBalance
 * @author Constantine Bragin <appscenter@proton.me>
 * @license GPLv3 License
 * @link https://github.com/appsinvest/crypto-balance
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
	#[\AllowDynamicProperties]
	class IdeHelperWallet {}
}

