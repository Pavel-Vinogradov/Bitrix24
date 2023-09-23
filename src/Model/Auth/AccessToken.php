<?php

namespace Tizix\Bitrix24Laravel\Model\Auth;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Tizix\Bitrix24Laravel\Model\Auth\Queries\AccessTokenQuery;
use Tizix\Bitrix24Laravel\Model\User\User;

/**
 * @property int $id
 * @property int $user_id
 * @property string $value
 * @property string $expires_at
 * @property string $created_at
 */
final class AccessToken extends Model
{
    protected $table = 'auth.access_tokens';

    protected $fillable = [
        'user_id',
        'value',
        'expires_at',
    ];

    public function users(): HasOne
    {
        return $this->hasOne(User::class);
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUserId(): int
    {
        return $this->user_id;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function getExpiresAt(): string
    {
        return $this->expires_at;
    }

    public function getCreatedAt(): string
    {
        return $this->created_at;
    }

    public function newEloquentBuilder($query): AccessTokenQuery
    {
        return new AccessTokenQuery($query);
    }
}
