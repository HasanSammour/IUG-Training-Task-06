<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // ! From Task 06 
        // * Bonus: Eager loading with suppliers and count
        $products = Product::with(['category', 'suppliers'])
                          ->withCount('suppliers') // Bonus: Count suppliers per product
                          ->latest()
                          ->paginate(10);
        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // ! From Task 05 : Load all categories and suppliers
        $categories = Category::withCount('products')->orderBy('name')->paginate(5);
        $suppliers = Supplier::orderBy('name')->get();
        
        return view('products.create', compact('categories', 'suppliers'));   
    }

    /**
     * Store a newly created resource in storage.
     * ! Updated with Request form class
     */
   public function store(StoreProductRequest $request)  
   {
        // Create the product
        $product = Product::create($request->validated());
        
        // Attach suppliers with pivot data
        $suppliersData = [];
        foreach ($request->suppliers as $supplierId => $data) {
            if ($data['selected'] ?? false) {
                $suppliersData[$supplierId] = [
                    'cost_price' => $data['cost_price'],
                    'lead_time_days' => $data['lead_time_days']
                ];
            }
        }
        
        $product->suppliers()->attach($suppliersData);
        
        return redirect()->route('products.index')
                         ->with('success', 'Product created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        // ! From Task 06: Eager load category and suppliers for Selected Product by The route
        $product->load(['category', 'suppliers']);
        return view('products.show', compact('product'));    
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        // ! From Task 06: Load all categories and suppliers to use in edit form
        $categories = Category::orderBy('name')->get();
        $suppliers = Supplier::orderBy('name')->get();
        
        // Load product with suppliers for editing
        $product->load('suppliers');
        
        return view('products.edit', compact('product', 'categories', 'suppliers')); 
    }

    /**
     * Update the specified resource in storage.
     * ! Updated with Request form class
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        // Update the product
        $product->update($request->validated());
        
        // Sync suppliers with pivot data
        $suppliersData = [];
        foreach ($request->suppliers as $supplierId => $data) {
            if ($data['selected'] ?? false) {
                $suppliersData[$supplierId] = [
                    'cost_price' => $data['cost_price'],
                    'lead_time_days' => $data['lead_time_days']
                ];
            }
        }
        
        $product->suppliers()->sync($suppliersData);
        
        return redirect()->route('products.index')
                         ->with('success', 'Product updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')
                         ->with('success', 'Product deleted Successfully!');
    }

    // ! from Task05: Show products by category
    public function showCategoryProducts(Category $category)
    {   
        // Get all products for this category with eager loading
        $products = $category->products()
            ->with(['category', 'suppliers'])  // Eager load category and suppliers
            ->orderBy('created_at', 'desc')
            ->paginate(10);  // Paginate for better performance
        
        // Get category statistics
        $categoryStats = [
            'total_products' => $category->products_count ?? $category->products()->count(),
            'avg_price' => $category->products()->avg('price') ?? 0,
            'total_value' => $category->products()->sum('price') ?? 0,
            'most_expensive' => $category->products()->max('price') ?? 0,
            'least_expensive' => $category->products()->min('price') ?? 0,
        ];
        
        return view('categories.products', compact('category', 'products', 'categoryStats'));
    }
}