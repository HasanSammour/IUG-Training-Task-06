<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Category;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // ! Share categories with all views :: From Task 05
        // * I do this to make categories shown all in drop down menu in the create page 
        // * even i use paginate in The controller
        view()->composer('*', function ($view) {
            $allCategories = Category::withCount('products')
                ->orderBy('name')
                ->get();
            
            $view->with('allCategories', $allCategories);
        });


        // ! Share category data with category.products view :: from task 06
        view()->composer('categories.products', function ($view) {
            // Get the category from the view data
            $category = $view->getData()['category'] ?? null;
            
            if ($category) {
                // Get ALL products for this category (for popovers and statistics)
                $allProducts = $category->products()
                    ->with(['suppliers' => function($query) {
                        $query->withPivot('cost_price', 'lead_time_days');
                    }])
                    ->orderBy('name', 'asc')
                    ->get();
                
                // Share the data with the view
                $view->with('allProducts', $allProducts);
                
                // calculate and share supplier statistics here so we can use them then in the view statistics cards
                $suppliersData = [];
                $totalSuppliers = 0;
                $costPrices = collect();
                $leadTimes = collect();
                
                foreach($allProducts as $product) {
                    if($product->suppliers && $product->suppliers->count() > 0) {
                        foreach($product->suppliers as $supplier) {
                            $totalSuppliers++;
                            $costPrice = $supplier->pivot->cost_price ?? 0;
                            $leadTime = $supplier->pivot->lead_time_days ?? 0;
                            
                            $costPrices->push($costPrice);
                            $leadTimes->push($leadTime);
                            
                            $suppliersData[] = [
                                'product_id' => $product->id,
                                'product_name' => $product->name,
                                'supplier_name' => $supplier->name,
                                'cost_price' => $costPrice,
                                'lead_time_days' => $leadTime,
                                'email' => $supplier->email
                            ];
                        }
                    }
                }
                
                // Share the calculated data
                $view->with([
                    'suppliersData' => $suppliersData,
                    'totalSuppliers' => $totalSuppliers,
                    'costPrices' => $costPrices,
                    'leadTimes' => $leadTimes,
                ]);
            }
        });
    }
}