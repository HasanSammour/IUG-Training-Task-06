<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name'];

    /**
     * Get all products for the category {RelationShip 1-many}.
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}