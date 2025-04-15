<?php

namespace App\Http\Controllers\Catalog\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class ProductThumbController extends Controller
{
    public static function index()
    {
        $filter = [
            'latest' => 'desc'
        ];
        $products = Product::getProducts($filter);

        $data['products'] = [];
        $data['categories'] = [];
        $uniqueCategories = [];
        $categoryProductLimit = 4; // Limit of products per category
        $categoryProductCount = []; // To count products per category
        
        foreach ($products as $product) {
            $product_categories = DB::table('product_categories')->where('product_id', $product->product_id)->orderBy('id', 'desc')->get();
        
            foreach ($product_categories as $product_category) {
                if ($product->product_id == $product_category->product_id) {
                    $category = DB::table('category')->where('id', $product_category->category_id)->first();
                    if ($category && $category->parent_id !== null) {
                        // Initialize the count for this category if not set
                        if (!isset($categoryProductCount[$category->id])) {
                            $categoryProductCount[$category->id] = 0;
                        }
        
                        // Only add the product if we haven't reached the limit for this category
                        if ($categoryProductCount[$category->id] < $categoryProductLimit) {
                            $product->category_id = $category->id;
                            $data['products'][] = $product;
                            $categoryProductCount[$category->id]++;
        
                            // Add the category if it's not already added
                            if (!isset($uniqueCategories[$category->id])) {
                                $data['categories'][] = [
                                    'category_id' => $category->id,
                                    'sort_order' => $category->sort_order,
                                    'category_name' => $category->category_name,
                                ];
                                $uniqueCategories[$category->id] = true; // Mark this category_id as seen
                            }
                        }
                    }
                }
            }
        }
        // Sort the categories by sort_order in ascending order
        usort($data['categories'], function ($a, $b) {
            if ($a['sort_order'] === 0 && $b['sort_order'] === 0) {
                return 0; // Both are 0, so they are equal
            }
            if ($a['sort_order'] === 0) {
                return 1; // Move $a (sort_order 0) to the end
            }
            if ($b['sort_order'] === 0) {
                return -1; // Move $b (sort_order 0) to the end
            }
            return $a['sort_order'] <=> $b['sort_order'];
        });

        return view('catalog.product.thumb',$data);
    }
}
