<?php

namespace App\Http\Controllers\Catalog\Product;

use App\Http\Controllers\Catalog\Common\Pagination;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function getAllCategories(){


        $results = DB::table('category')->where('status', true)->orderBy('id','desc')->get();
        
        // Pagination
        $perPage = 20;
        $paginator = Pagination::pagination($results, $perPage);

        $data['categories'] = $paginator['items'];
        $data['pagination'] = $paginator['pagination'];

        return view('catalog.product.category', $data);
    }
}
