<?php

namespace App\Models;

class Permissions extends CoreModel
{
    protected $table = "permissions";

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'module_name',
        'can_view',
        'can_create',
        'can_update',
        'can_delete',
    ];

    /**
     * Model to create permission
     *
     * @param array $payload
     * @return boolean
     */
    public function createPermission(array $payload): bool
    {
        $this->setFillableFields($this, $payload);

        return $this->save();
    }

    /**
     * Model to update permission
     *
     * @param string $id
     * @param array $payload
     * @return boolean
     */
    public function updatePermission(string $id, array $payload): bool
    {
        $record = $this->find($id);
        $this->setFillableFields($record, $payload);

        return $record->save();
    }

    /**
     * Model to delete permission
     *
     * @param string $id
     * @return boolean
     */
    public function deletePermission(string $id): bool
    {
        $record = $this->find($id);

        return $record->delete();
    }
}
