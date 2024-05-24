<?php

namespace App\Models;

class Categories extends CoreModel
{
    protected $table = "categories";
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'category_name',
    ];

    /**
     * Model to save data in category table
     *
     * @param array $payload
     * @return Categories
     */
    public function createCategory(array $payload): Categories
    {
        $this->setFillableFields($this, $payload);

        $this->save();

        return $this->refresh();
    }

    /**
     * Model to update category
     *
     * @param string $id
     * @param array $payload
     * @return boolean
     */
    public function updateCategory(string $id, array $payload): bool
    {
        $record = $this->find($id);
        $this->setFillableFields($record, $payload);

        return $record->save();
    }

    /**
     * Model to delete category
     *
     * @param string $id
     * @return boolean
     */
    public function deleteCategory(string $id): bool
    {
        $record = $this->find($id);

        return $record->delete();
    }
}