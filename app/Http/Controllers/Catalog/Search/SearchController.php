<?php

namespace App\Http\Controllers\Catalog\Search;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function liveSearch(Request $request){
        $query = $request->input('query');
        
        $results = Product::where('product_name', 'LIKE', '%' . $query . '%')
                       ->orWhere('product_description', 'LIKE', '%' . $query . '%')
                       ->select('id','product_name', 'image')
                       ->get();
        

        return response()->json(ProductResource::collection($results));
    }
}
