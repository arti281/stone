<?php

namespace App\Http\Controllers\Catalog\Product;

use App\Http\Controllers\Catalog\Common\Pagination;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Color;
use App\Models\Product;
use App\Models\ProductVariation;
use App\Models\RelatedProduct;
use App\Models\Review;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function productDetail($product_id, $slug = null){
        $data['product'] = Product::getProduct($product_id);
        $data['updated_qty'] = Cart::where('product_id', $product_id)->where('user_id', session('isUser'))->first();
        $data['ecommerce_url'] = DB::table('product_other_links')->where('product_id', $product_id)->first();

        $variations = ProductVariation::where('product_id', $product_id)->get();
        $colorIds = $variations->pluck('color_id')->unique();
        $sizeIds = $variations->pluck('size_id')->unique();

        $data['colors'] = Color::whereIn('id', $colorIds)->get();
        $data['sizes'] = Size::whereIn('id', $sizeIds)->get();
        $data['reviews'] = Review::with('replies')->where('product_id', $product_id)->latest('created_at')->paginate();
        $data['relatedProducts'] = RelatedProduct::with('product')->where('product_id', $product_id)->get();

        return view('catalog.product.product', $data);
    }

    public function getAllProduct(Request $request, $category_id=null, $category_slug=null){

        $sort = $request->query('sort');

        // Filter 
        $filter = [];
        if($sort === 'desc'){
            $filter['desc'] = $sort;
        }else if($sort === 'asc'){
            $filter['asc'] = $sort;
        }else if($sort === 'latest'){
            $filter['latest'] = 'desc';
        }else if($sort === 'discounted'){
            $filter['discounted'] = $sort;
        }else if($sort === 'low_to_high'){
            $filter['low_to_high'] = 'asc';
        }else if($sort === 'high_to_low'){
            $filter['high_to_low'] = 'desc';
        }

        if($category_id){
            $filter['category_id'] = $category_id;
        }

        // Filters
        $filter['query_size'] = $data['query_size'] = $request->query('size') ?? null;
        $filter['query_color'] = $data['query_color'] = $request->query('color') ?? null;

        // search
        $filter['search'] = $data['search'] = $request->query('search') ?? null;

        // Removed sort for url
        $data['query_string'] = $_SERVER['QUERY_STRING'] ?? '';
        $data['query_string'] = explode('&', $data['query_string']);
        $data['query_string'] = array_filter($data['query_string'], function($param) {
            return !preg_match('/^sort=/', $param);
        });
        $data['query_string'] = implode('&', $data['query_string']);

        // Pagination
        $results = Product::getProducts($filter);
        
        $perPage = 40;
        $paginator = Pagination::pagination($results, $perPage);

        $data['products'] = $paginator['items'];
        $data['pagination'] = $paginator['pagination'];

        $data['colors'] = DB::table('colors')->get();
        $data['sizes'] = DB::table('sizes')->get();
        $data['sort'] = $sort;
        $data['category_id'] = $category_id;
        $data['category_slug'] = $category_slug;
        
        return view('catalog.product.product_all', $data);
    }

    // When saving (store or update)

}
