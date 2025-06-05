<?php

namespace App\Models\Admin\Storefront\Product;

use App\Models\ProductVariation;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    // Define the fillable attributes
    protected $fillable = [
        'product_name',
        'product_description',
        'tag',
        'meta_title',
        'meta_description',
        'meta_keyword',
        'model',
        'sku',
        'upc',
        'ean',
        'jan',
        'isbn',
        'mpn',
        'quantity',
        'minimum',
        'subtract',
        'stock_status_id',
        'date_available',
        'shipping',
        'length',
        'width',
        'height',
        'length_class_id',
        'weight',
        'weight_class_id',
        'status',
        'sort_order'
    ];

    public static function getProduct($product_id){

        // products
        $product = DB::table('products')
                    ->leftJoin('product_prices', 'products.id', '=', 'product_prices.product_id')
                    ->where('products.id', $product_id)->first();

        $images = DB::table('product_images')->where('product_id', $product_id)->get();

        $data['product'] = $product;
        $data['images'] = $images;

        return $data ?? null;
    }

    public static function getProducts($request = null){
        $query = 'SELECT p.id as product_id, p.image, p.product_name, p.model, pp.price, pp.mrp, p.quantity, p.status FROM  products p LEFT JOIN  product_prices pp ON pp.product_id = p.id  WHERE 1=1';
        // Filter
        if($request){
            if (null !== $request->query('product_name')) {
                $query .= ' AND p.product_name like ' . '\'%'. $request->query('product_name') .'%\'';
            }
            if (null !== $request->query('model')) {
                $query .= ' AND p.model like ' . '\'%'. $request->query('model') .'%\'';
            }
            if (null !== $request->query('price')) {
                $query .= ' AND pp.price like ' . '\'%'. $request->query('price') .'%\'';
            }
            if (null !== $request->query('quantity')) {
                $query .= ' AND  p.quantity like ' . '\'%'. $request->query('quantity') .'%\'';
            }
            if (null !== $request->query('status')) {
                $query .= ' AND status=' . "'" . $request->query('status') . "'";
            }
        }

        $query .= ' order by created_at desc';
        
        return  DB::select($query);
        // dd($query);
    }

    public static function deleteProduct($product_id){
        Product::where('id', $product_id)->delete();
        ProductCategory::where('product_id', $product_id)->delete();
        ProductPrice::where('product_id', $product_id)->delete();
        ProductDiscount::where('product_id', $product_id)->delete();
        ProductSpecial::where('product_id', $product_id)->delete();
        ProductDownload::where('product_id', $product_id)->delete();
        ProductReward::where('product_id', $product_id)->delete();
        ProductFilter::where('product_id', $product_id)->delete();
        ProductOtherLink::where('product_id', $product_id)->delete();
        ProductVariation::where('product_id', $product_id)->delete();

        $images = ProductImage::where('product_id', $product_id)->get();
        foreach ($images as $image) {
            if($image){
                $imageName = $image->image;
                $imagePath = public_path('image/products/') . $imageName;
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
                $image->delete();
            }
        }

        return true;
    }
}
