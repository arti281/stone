<?php

namespace App\Models\Admin\Storefront\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ProductCategory extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'product_categories';

    protected $fillable = [
        'product_id',
        'category_id'
    ];

    public static function getProductCategory($product_id){
        $data = DB::table('product_categories')->where('product_id', (int)$product_id)->get();
        return $data ?: null;
    }

    public static function deleteProductCategory($product_id){
        DB::table('product_categories')->where('product_id', $product_id)->delete();
        return true;
    }
}
