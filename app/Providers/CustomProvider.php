<?php

namespace App\Providers;

use App\Models\Setting;
use App\Models\Cart;
use App\Models\Wishlist;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class CustomProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register()
    {
        /**
         * The pluck method can be used to retrieve values from a single column, and optionally, you can specify a key column to use as the array keys. Here’s a detailed explanation of how it works and how to use it:
         */

        $this->app->singleton('settings', function () {
            $settings = Setting::pluck('value', 'key')->toArray();
            return $settings;
        });

        /**
         * How can access data
         * app('settings')['site_name']
         */
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            // Fetch active top-level categories
            $categories = DB::table('category')
                ->where('status', true)
                ->whereNull('parent_id') // Only top-level categories
                ->get();

            // Recursive function to get children
            $service_categories = $categories->map(function ($category) {
                return $this->getCategoryWithChildren($category);
            });

            $view->with('getCart', Cart::where('user_id', session('isUser'))->count());
            $view->with('getWishlist', Wishlist::where('user_id', session('isUser'))->count());

            // Make categories available to all views
            $view->with('service_categories', $service_categories);
        });
    }

    private function getCategoryWithChildren($category)
    {
        $category->children = DB::table('category')
            ->where('parent_id', $category->id)
            ->where('status', true)
            ->get()
            ->map(function ($child) {
                return $this->getCategoryWithChildren($child); // Recursively get children
            });

        return $category;
    }


    
}
