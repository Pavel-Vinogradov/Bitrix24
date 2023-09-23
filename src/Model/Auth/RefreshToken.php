<?php

namespace Tizix\Bitrix24Laravel\Model\Auth;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Tizix\Bitrix24Laravel\Model\Auth\Queries\RefreshTokenQuery;
use Tizix\Bitrix24Laravel\Model\User\User;

/**
 * @property int $id
 * @property int $user_id
 * @property string $value
 * @property string $access_token_id
 * @property string $expires_at
 * @property string $created_at
 */
final class RefreshToken extends Model
{
    protected $table = 'auth.refresh_token';

    protected $fillable = [
        'user_id',
        'access_token_id',
        'value',
        'expires_at',
        'created_at',
    ];

    public function users(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
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

    public function getAccessTokenId(): string
    {
        return $this->access_token_id;
    }

    public function getExpiresAt(): string
    {
        return $this->expires_at;
    }

    public function getCreatedAt(): string
    {
        return $this->created_at;
    }

    public function newEloquentBuilder($query): RefreshTokenQuery
    {
        return new RefreshTokenQuery($query);
    }
}
