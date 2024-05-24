<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RolePermissions extends CoreModel
{
    protected $table = "role_permissions";
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_roles_id',
        'permissions_id',
    ];

    /**
     * Model to create role permission
     *
     * @param array $payload
     * @return void
     */
    public function createRolePermission(array $payload)
    {
        $this->setFillableFields($this, $payload);

        $this->save();
    }

    /**
     * Model to delete role permission
     *
     * @param string $id
     * @return boolean
     */
    public function deleteRolePermission(string $id): bool
    {
        return $this->where('user_roles_id', $id)->delete();
    }
}
