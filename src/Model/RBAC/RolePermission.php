<?php

namespace Tizix\Bitrix24Laravel\Model\RBAC;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $role_id
 * @property int $permission_id
 */
final class RolePermission extends Model
{
    protected $table = 'rbac.role_permission';

    protected $fillable = [
        'role_id',
        'permission_id',
    ];

    public function getRole(): Role
    {
        return Role::find($this->role_id);
    }

    public function getPermission(): Permission
    {
        return Permission::find($this->permission_id);
    }

    public function getRoleId(): int
    {
        return $this->role_id;
    }

    public function getPermissionId(): int
    {
        return $this->permission_id;
    }

    public function getId(): int
    {
        return $this->id;
    }
}
