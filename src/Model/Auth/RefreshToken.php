<?php

declare(strict_types=1);

namespace Tizix\Bitrix24Laravel\Model\Auth;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Tizix\Bitrix24Laravel\Model\Auth\Queries\RefreshTokenQuery;
use Tizix\Bitrix24Laravel\Model\User\User;

/**
 * @property int $id
 * @property int $user_id
 * @property string $refresh_token
 * @property int $access_token_id
 * @property Carbon|string $expires_at
 * @property Carbon|string $created_at
 */
class RefreshToken extends Model
{
    protected $table = 'auth.refresh_tokens';
    public $timestamps = false;

    protected function serializeDate($date): bool|int|string
    {
        return $date->format('Y-m-d H:i:s');
    }

    protected $fillable = [
        'user_id',
        'access_token_id',
        'refresh_token',
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

    public function getAccessTokenId(): int
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

    public function getAccessToken(): AccessToken
    {
        return (new AccessToken())->find($this->getAccessTokenId());
    }

    public function accessToken(): HasOne
    {
        return $this->hasOne(AccessToken::class, 'id', 'access_token_id');
    }

    public function kill(): bool
    {
        $this->fill([
            'expires_at' => Carbon::createFromTimestamp(0),
        ]);
        return $this->save() && $this->getAccessToken()->kill();
    }
}
