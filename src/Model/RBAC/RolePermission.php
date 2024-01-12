<?php

declare(strict_types=1);

namespace Tizix\Bitrix24Laravel\Model\RBAC;

use Illuminate\Database\Eloquent\Model;
use Tizix\Bitrix24Laravel\Model\RBAC\Queries\RolePermissionQuery;

/**
 * @property int $id
 * @property int $role_id
 * @property int $permission_id
 */
final class RolePermission extends Model
{
    protected $table = 'rbac.role_permission';

    public $timestamps = false;

    protected $fillable = [
        'role_id',
        'permission_id',
    ];

    public function getRole(): Role
    {
        return Role::find($this->getRoleId());
    }

    public function getPermission(): Permission
    {
        return Permission::find($this->getPermissionId());
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

    public function newEloquentBuilder($query): RolePermissionQuery
    {
        return new RolePermissionQuery($query);
    }
}
