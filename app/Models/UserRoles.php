<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;

class UserRoles extends CoreModel
{
    protected $table = "user_roles";
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'role_name',
    ];

    /**
     * Model to create role
     *
     * @param array $payload
     * @return UserRoles
     */
    public function createRole(array $payload): UserRoles
    {
        $this->setFillableFields($this, $payload);

        $this->save();

        return $this->refresh();
    }

    /**
     * Model to update role
     *
     * @param string $id
     * @param array $payload
     * @return boolean
     */
    public function updateRole(string $id, array $payload): bool
    {
        $record = $this->find($id);
        $this->setFillableFields($record, $payload);

        return $record->save();
    }

    /**
     * Model to delete role
     *
     * @param string $id
     * @return boolean
     */
    public function deleteRole(string $id): bool
    {
        $record = $this->find($id);

        return $record->delete();
    }

    /**
     * Relationship between user roles and role permissions
     *
     * @return HasMany
     */
    public function rolePermissions(): HasMany
    {
        return $this->hasMany(RolePermissions::class);
    }
}
