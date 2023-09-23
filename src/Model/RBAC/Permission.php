<?php

namespace Tizix\Bitrix24Laravel\Model\RBAC;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property int $id
 * @property string $key
 * @property string $name
 */
final class Permission extends Model
{
    protected $table = 'rbac.permissions';

    protected $fillable = [
        'key',
        'name',
    ];

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'rbac.role_permission', 'permission_id', 'role_id');
    }
}
