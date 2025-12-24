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
    }
}
