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

    public static function getProducts($filter = array()){
        $query = 'SELECT p.id as product_id, p.product_description, p.image, p.product_name, p.tag, p.model, pp.price, pp.mrp, p.quantity,p.slug FROM  products p LEFT JOIN  product_prices pp ON pp.product_id = p.id  WHERE p.status=1';

        $size_product_ids = [];
        $color_product_ids = [];
        $category_product_ids = [];

        //Get Category
        if (isset($filter['category_id']) && null !== $filter['category_id']) {
            $product_ids = '';
            $category = DB::table('product_categories')->where('category_id', $filter['category_id'])->get();
            foreach ($category as $value) {
                $category_product_ids[] = $value->product_id;
            }
        }

        if($category_product_ids){
            if((isset($filter['query_size']) && null !== $filter['query_size']) || isset($filter['query_color']) && null !== $filter['query_color']){
                if(isset($filter['query_size']) && null !== $filter['query_size']){
                    foreach($category_product_ids as $cat_product_id){
                        foreach ($filter['query_size'] as $value) {
                            $getSizeId = DB::table('sizes')->where('size_name', $value)->first();
                            $sizes = DB::table('product_variation')->where('size_id', $getSizeId->id)->where('product_id', $cat_product_id)->get();
                            foreach ($sizes as $size) {
                                $size_product_ids[] = $size->product_id;
                            }
                        }
                    }
                }
                if(isset($filter['query_color']) && null !== $filter['query_color']){
                    foreach($category_product_ids as $cat_product_id){
                        foreach ($filter['query_color'] as $value) {
                            $getColorId = DB::table('colors')->where('color_name', $value)->first();
                            $color = DB::table('product_variation')->where('color_id', $getColorId->id)->where('product_id', $cat_product_id)->get();
                            foreach ($color as $size) {
                                $color_product_ids[] = $size->product_id;
                            }
                        }
                    }
                }
                // Remove duplicate product Ids
                $union = array_unique(array_merge($size_product_ids, $color_product_ids));
            }else{
                // Remove duplicate product Ids
                $union = array_unique(array_merge($category_product_ids));
            }

            if($union){
                $product_ids = '';
                foreach ($union as $value) {
                    $product_ids .= $value . ',';
                }
                // Remove the trailing comma, if any
                $product_ids = rtrim($product_ids, ',');
                $query .= " and p.id IN (" . $product_ids . ")";
            }else{
                $query .= " and p.id IN (0)";
            }
        }else{
            // Size and color Filters
            if((isset($filter['query_size']) && null !== $filter['query_size']) || isset($filter['query_color']) && null !== $filter['query_color']){
                if(isset($filter['query_size']) && null !== $filter['query_size']){
                    foreach ($filter['query_size'] as $value) {
                        $getSizeId = DB::table('sizes')->where('size_name', $value)->first();
                        $sizes = DB::table('product_variation')->where('size_id', $getSizeId->id)->get();
                        foreach ($sizes as $size) {
                            $size_product_ids[] = $size->product_id;
                        }
                    }
                }
                if(isset($filter['query_color']) && null !== $filter['query_color']){
                    foreach ($filter['query_color'] as $value) {
                        $getColorId = DB::table('colors')->where('color_name', $value)->first();
                        $color = DB::table('product_variation')->where('color_id', $getColorId->id)->get();
                        foreach ($color as $size) {
                            $color_product_ids[] = $size->product_id;
                        }
                    }
                }

                // Remove duplicate product Ids
                $union = array_unique(array_merge($size_product_ids, $color_product_ids));
                if($union){
                    $product_ids = '';
                    foreach ($union as $value) {
                        $product_ids .= $value . ',';
                    }
                    // Remove the trailing comma, if any
                    $product_ids = rtrim($product_ids, ',');
                    $query .= " and p.id IN (" . $product_ids . ")";
                }else{
                    $query .= " and p.id IN (0)";
                }
            }
        }

        // Filter
        if($filter){
            if(isset($filter['search']) && null !== $filter['search']){
                $query .= ' AND p.product_name LIKE \'%' . $filter['search'] . '%\'';
            }
            if (isset($filter['desc']) && null !== $filter['desc']) {
                $query .= " order by p.product_name " . $filter['desc'] . "";
            }
            if (isset($filter['asc']) && null !== $filter['asc']) {
                $query .= " order by p.product_name " . $filter['asc'] . "";
            }
            if (isset($filter['latest']) && null !== $filter['latest']) {
                $query .= " order by p.created_at "  . $filter['latest'] . "";
            }
            if (isset($filter['low_to_high']) && null !== $filter['low_to_high']) {
                $query .= " order by pp.price "  . $filter['low_to_high'] . "";
            }
            if (isset($filter['high_to_low']) && null !== $filter['high_to_low']) {
                $query .= " order by pp.price "  . $filter['high_to_low'] . "";
            }
            if (isset($filter['limit']) && null !== $filter['limit']) {
                $query .= " limit "  . $filter['limit'] . "";
            }
        }
        
        return DB::select($query);
    }
}
