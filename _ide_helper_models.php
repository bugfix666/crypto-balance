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
 * 
 *
 * @property int $id
 * @property string $uuid
 * @property string $amount
 * @property string $currency
 * @property int $wallet_id
 * @property int $op_type
 * @property int $op_state
 * @property array<array-key, mixed>|null $data
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\User|null $user
 * @property-read \App\Models\Wallet $wallet
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Operation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Operation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Operation onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Operation query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Operation whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Operation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Operation whereCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Operation whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Operation whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Operation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Operation whereOpState($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Operation whereOpType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Operation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Operation whereUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Operation whereWalletId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Operation withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Operation withoutTrashed()
 */
	class Operation extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $uuid
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Wallet> $wallets
 * @property-read int|null $wallets_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUuid($value)
 */
	class User extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Wallet
 *
 * @property int $id
 * @property int $user_id
 * @property string $amount
 * @property string $currency
 * @method static Builder|Wallet newModelQuery()
 * @method static Builder|Wallet newQuery()
 * @method static Builder|Wallet query()
 * @method static Builder|Wallet whereAmount($value)
 * @method static Builder|Wallet whereId($value)
 * @method static Builder|Wallet whereSymbol($value)
 * @method static Builder|Wallet whereUserId($value)
 * @mixin \Eloquent
 * @property string $uuid
 * @property-read \App\Models\User $user
 * @method static \Database\Factories\WalletFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wallet whereCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wallet whereUuid($value)
 */
	class Wallet extends \Eloquent {}
}

