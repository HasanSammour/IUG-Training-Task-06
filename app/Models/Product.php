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

    // ! From Task 06: Create Many to Many Relationship between Products-Suppliers
    /**
     * Get the suppliers for the product.
     */
    public function suppliers()
    {
        return $this->belongsToMany(Supplier::class)
                    ->withPivot(['cost_price', 'lead_time_days'])
                    ->withTimestamps();
    }
}