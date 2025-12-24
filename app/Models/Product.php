<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 
        'price', 
        'description',
        'category_id' // ! new from Task 05
    ];
    protected $casts = [    
        'price' => 'decimal:2'
    ];

    // ! From Task 05: Create RelationShip between Products-Category
    /**
     * Get the category that owns the product.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}