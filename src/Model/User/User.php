<?php

declare(strict_types=1);

namespace Tizix\Bitrix24Laravel\Model\User;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Tizix\Bitrix24Laravel\Model\RBAC\Role;
use Tizix\Bitrix24Laravel\Model\User\Queries\UserQuery;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property string $work_position
 * @property bool $is_active
 * @property string|null $login
 * @property string|null $password
 * @property int|null $bitrix_id
 * @property boolean $is_bitrix24_user
 * @property Carbon|string $created_at
 * @property Carbon|string $updated_at
 */
class User extends Authenticatable
{
    use SoftDeletes;

    protected $table = 'user.users';
    protected $dateFormat = 'Y-m-d H:i:s';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'is_active',
        'work_position',
        'login',
        'password',
        'bitrix_id',
        'is_bitrix24_user'
    ];
    protected $hidden = [
        'password',
    ];
    protected $primaryKey = 'id';

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

    public function getLogin(): ?string
    {
        return $this->login;
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

    public function permissions(): Collection
    {
        return $this->roles->map(fn($role) => $role->permissions)->flatten();
    }

    public function newEloquentBuilder($query): UserQuery
    {
        return new UserQuery($query);
    }

    public function hasRole($role): bool
    {
        return $this->roles->contains('key', $role);
    }

    public function hasPermission($permission): bool
    {
        foreach ($this->roles as $role) {
            if ($role->permissions->contains('key', $permission)) {
                return true;
            }
        }

        return false;
    }

    public function setPasswordAttribute($value): void
    {
        $this->attributes['password'] = HASH::make($value);
    }


    public function getIsBitrix24User(): bool
    {
        return $this->is_bitrix24_user;
    }
}
