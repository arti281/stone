<?php

namespace App\Http\Controllers\Catalog;

use App\Http\Controllers\Catalog\Product\ProductThumbController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Catalog\Contact;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index(){
        // Product thumb template
        $data['product_thumb'] = ProductThumbController::index();

        $data['banners'] = DB::table('banners')->where('status', 1)->orderBy('sort','asc')->get();

        $data['product_route'] = route('catalog.product-all') . '?sort=latest';

        $data['category_route'] = route('catalog.getAllCategories');

        $data['categories'] = DB::table('category')
        ->where('status', true)
        ->where('Parent_id', null)                                          
        ->orderByRaw('CASE WHEN sort_order = 0 THEN 1 ELSE 0 END, sort_order ASC')
        ->limit(6)                                        
        ->get();
        
        return view('catalog.index', $data);
    }

    
}

