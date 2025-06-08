<?php

namespace App\Models;

use App\Models\StockStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    public static function getProduct($product_id){
        // products
        $product = DB::table('products')
                    ->leftJoin('product_prices', 'products.id', '=', 'product_prices.product_id')
                    ->select('products.*', 'product_prices.price','product_prices.mrp')
                    ->where('products.id', $product_id)->first();

        $product->stock_status = StockStatus::find($product->stock_status_id)->name ?? "";

        $images = DB::table('product_images')->where('product_id', $product_id)->get();

        $data['product'] = $product;
        $data['images'] = $images;

        return $data ?? null;
    }

    public static function getProducts($filter = [])
    {
        $query = "SELECT p.id as product_id, p.product_description, p.image, p.product_name, p.tag, p.model, pp.price, pp.mrp, p.quantity, p.slug 
                FROM products p 
                LEFT JOIN product_prices pp ON pp.product_id = p.id 
                WHERE p.status = 1";

        // Category filtering
        if (!empty($filter['category_id'])) {
            $category_product_ids = DB::table('product_categories')
                ->where('category_id', $filter['category_id'])
                ->pluck('product_id')
                ->toArray();

            if (!empty($category_product_ids)) {
                $ids = implode(',', array_map('intval', $category_product_ids));
                $query .= " AND p.id IN ($ids)";
            } else {
                // No matching products in this category
                return [];
            }
        }

        // Search
        if (!empty($filter['search'])) {
            $search = addslashes($filter['search']); 
            $query .= " AND p.product_name LIKE '%$search%'";
        }

        // Sorting
        if (!empty($filter['desc'])) {
            $query .= " ORDER BY p.product_name DESC";
        } elseif (!empty($filter['asc'])) {
            $query .= " ORDER BY p.product_name ASC";
        } elseif (!empty($filter['latest'])) {
            $query .= " ORDER BY p.created_at " . $filter['latest'];
        } elseif (!empty($filter['low_to_high'])) {
            $query .= " ORDER BY pp.price ASC";
        } elseif (!empty($filter['high_to_low'])) {
            $query .= " ORDER BY pp.price DESC";
        }

        //Limit
        if (!empty($filter['limit'])) {
            $limit = (int) $filter['limit'];
            $query .= " LIMIT $limit";
        }

        return DB::select($query);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

}
