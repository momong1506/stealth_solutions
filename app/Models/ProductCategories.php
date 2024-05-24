<?php

namespace App\Models;

class ProductCategories extends CoreModel
{
    protected $table = "product_categories";
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'products_id',
        'categories_id',
    ];

    /**
     * Model to create product categories
     *
     * @param array $payload
     * @return void
     */
    public function createProductCategories(array $payload)
    {
        $this->setFillableFields($this, $payload);

        $this->save();
    }

    /**
     * Model to delete product categories
     *
     * @param string $id
     * @return boolean
     */
    public function deleteProductCategories(string $id): bool
    {
        return $this->where('products_id', $id)->delete();
    }
}
