<?php

declare(strict_types=1);

namespace Tizix\Bitrix24Laravel\Model\Auth;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Tizix\Bitrix24Laravel\Model\Auth\Queries\AccessTokenQuery;
use Tizix\Bitrix24Laravel\Model\User\User;

/**
 * @property int $id
 * @property int $user_id
 * @property string $access_token
 * @property Carbon|string $expires_at
 * @property Carbon|string $created_at
 * @property User $users
 */
class AccessToken extends Model
{
    protected $table = 'auth.access_tokens';

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'access_token',
        'expires_at',
        'created_at'
    ];

    public function getUser(): User
    {
        return User::find($this->getUserId());
    }

    protected function serializeDate($date): bool|int|string
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function users(): HasOne
    {
        return $this->hasOne(User::class,'id','user_id');
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUserId(): int
    {
        return $this->user_id;
    }

    public function getAccessToken(): string
    {
        return $this->access_token;
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

    public function kill(): bool
    {
        return $this->fill([
            'expires_at' => Carbon::createFromTimestamp(0),
        ])->save();
    }
}
