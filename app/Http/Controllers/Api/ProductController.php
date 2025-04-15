<?php

namespace App\Http\Controllers\Api; 

use App\Http\Controllers\Controller;
use App\Models\Catalog\Product\Product;
use App\Models\Catalog\Product\ProductPrice;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function getProducts(){
        $products = Product::get();

        $arr_product = [];
        foreach ($products as $product) {
            $prices = ProductPrice::where('product_id', $product->id)->first();
            $arr_product[] = [
                "product_id" => $product->id,
                "product_description" => $product->product_description,
                "image" => url("image/cache/products").'/'.($product->id .'/'. str_replace(".jpg",'',$product->image) .'_700x700.jpg'),
                "product_name" => $product->product_name,
                "tag" => $product->tag,
                "price" => $prices->price,
                "mrp" => $prices->mrp,
                "quantity" => $product->quantity,
            ];
        }        

        if($products->count() > 0){
            return response()->json([
                "status" => true,
                "total" => $products->count(),
                "products" => $arr_product
            ], 200);
        }else{
            return response()->json([
                "status" => true,
                "message" => "Product Not Found"
            ], 200);
        }
    }
}
