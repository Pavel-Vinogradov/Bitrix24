<?php

declare(strict_types=1);

namespace Tizix\Bitrix24Laravel\Model\RBAC;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Tizix\Bitrix24Laravel\Model\RBAC\Queries\RoleQuery;
use Tizix\Bitrix24Laravel\Model\User\User;

/**
 * @property int $id
 * @property string $key
 * @property string $name
 */
final class Role extends Model
{
    protected $table = 'rbac.roles';

    public $timestamps = false;

    protected $fillable = [
        'key',
        'name',
    ];

    public function getId(): int
    {
        return $this->id;
    }

    public function getKey(): string
    {
        return $this->key;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'rbac.user_role', 'role_id', 'user_id');
    }

    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'rbac.role_permission', 'role_id', 'permission_id');
    }

    public function newEloquentBuilder($query): RoleQuery
    {
        return new RoleQuery($query);
    }
}
