<?php

declare(strict_types=1);

namespace Tizix\Bitrix24Laravel\Model\RBAC;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Tizix\Bitrix24Laravel\Model\RBAC\Queries\PermissionQuery;

/**
 * @property int $id
 * @property string $key
 * @property string $name
 */
final class Permission extends Model
{
    protected $table = 'rbac.permissions';

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

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'rbac.role_permission', 'permission_id', 'role_id');
    }

    public function newEloquentBuilder($query): PermissionQuery
    {
        return new PermissionQuery($query);
    }
}
