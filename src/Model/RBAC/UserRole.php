<?php

namespace Tizix\Bitrix24Laravel\Model\RBAC;

use Illuminate\Database\Eloquent\Model;
use Tizix\Bitrix24Laravel\Model\User\User;

/**
 * @property int $id
 * @property int $user_id
 * @property int $role_id
 */
final class UserRole extends Model
{
    protected $table = 'rbac.user_role';

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
}
