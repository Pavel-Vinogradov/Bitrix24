<?php

namespace Tizix\Bitrix24Laravel\Model\User;

use Barryvdh\LaravelIdeHelper\Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;
use Tizix\Bitrix24Laravel\Model\RBAC\Role;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property string $work_position
 * @property bool $is_active
 * @property string $created_at
 * @property string $updated_at
 *
 * @mixin Eloquent
 */
final class User extends Model
{
    protected $table = 'user.users';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'is_active',
        'work_position',
    ];

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function getWorkPosition(): string
    {
        return $this->work_position;
    }

    public function getIsActive(): bool
    {
        return $this->is_active;
    }

    public function getCreatedAt(): string
    {
        return $this->created_at;
    }

    public function getUpdatedAt(): string
    {
        return $this->updated_at;
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'rbac.user_role', 'user_id', 'role_id');
    }

    public function getAllPermissions(): Collection
    {
        return $this->roles->map(function ($role) {
            return $role->permissions;
        })->flatten();
    }
}
