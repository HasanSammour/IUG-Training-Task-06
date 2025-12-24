<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Category;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // ! Chain Products SELECT Query with the category that has relationship with this product
        $products = Product::with('category')->latest()->paginate(10);
        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // ! From Task 05 : Load all categories to use in create form
        $categories =  Category::withCount('products')->orderBy('name')->paginate(5);
        return view('products.create', compact('categories'));    
    }

    /**
     * Store a newly created resource in storage.
     * ! Updated with Request form class
     */
   public function store(StoreProductRequest $request)  
   {
        Product::create($request->validated()); 
        return redirect()->route('products.index')
                         ->with('success', 'Product created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        // ! From Task 05: Eager load category for Selected Product by The route
        $product->load('category');
        return view('products.show', compact('product'));    
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        // ! From Task 05 : Load all categories to use in edit form
        $categories = Category::orderBy('name')->get();
        return view('products.edit', compact('product', 'categories'));    
    }

    /**
     * Update the specified resource in storage.
     * ! Updated with Request form class
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $product->update($request->validated());
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
            ->with('category')  // Eager load category
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