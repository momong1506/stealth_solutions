<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;

class Products extends CoreModel
{
    protected $table = "products";
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'product_name',
        'price',
        'quantity',
    ];

    /**
     * Model to create product
     *
     * @param array $payload
     * @return Products
     */
    public function createProduct(array $payload): Products
    {
        $this->setFillableFields($this, $payload);

        $this->save();

        return $this->refresh();
    }

    /**
     * Model to update product
     *
     * @param string $id
     * @param array $payload
     * @return boolean
     */
    public function updateProduct(string $id, array $payload): bool
    {
        $record = $this->find($id);
        $this->setFillableFields($record, $payload);

        return $record->save();
    }

    /**
     * Model to delet product
     *
     * @param string $id
     * @return boolean
     */
    public function deleteProduct(string $id): bool
    {
        $record = $this->find($id);

        return $record->delete();
    }

    /**
     * Model to get relationship between products and categories
     *
     * @return HasMany
     */
    public function productCategories(): HasMany
    {
        return $this->hasMany(ProductCategories::class);
    }
}