<?php

declare(strict_types=1);

namespace Tizix\Bitrix24Laravel\Model\RBAC;

use Illuminate\Database\Eloquent\Model;
use Tizix\Bitrix24Laravel\Model\RBAC\Queries\UserRoleQuery;
use Tizix\Bitrix24Laravel\Model\User\User;

/**
 * @property int $id
 * @property int $user_id
 * @property int $role_id
 */
final class UserRole extends Model
{
    protected $table = 'rbac.user_role';

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'role_id',
    ];

    public function getUser(): User
    {
        return User::find($this->user_id);
    }

    public function getRole(): Role
    {
        return Role::find($this->role_id);
    }

    public function getRoleId(): int
    {
        return $this->role_id;
    }

    public function getUserId(): int
    {
        return $this->user_id;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function newEloquentBuilder($query): UserRoleQuery
    {
        return new UserRoleQuery($query);

    }
}
