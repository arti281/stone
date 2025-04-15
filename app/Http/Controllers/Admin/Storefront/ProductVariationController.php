<?php

namespace App\Http\Controllers\Admin\Storefront;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Color;
use App\Models\ProductVariation;
use App\Models\Size;

class ProductVariationController extends Controller
{
    public function addVariation(Request $request){
        // Add variations
        $product_id = $request->request->get('product_id');
        if($request->input('color_id') && $request->input('size_id') && $request->input('combinations')){

            $colorIds = $request->input('color_id');
            $sizeIds = $request->input('size_id');
            $combinations = $request->input('combinations');
            $quantities = $request->input('variation_qty');
            $prices = $request->input('variation_price');
            $variation_sku = $request->input('variation_sku');

            ProductVariation::where('product_id', $product_id)->delete();

            for ($i = 0; $i < count($colorIds); $i++) {
                ProductVariation::create([
                    'product_id' => $product_id,
                    'color_id' => $colorIds[$i],
                    'size_id' => $sizeIds[$i],
                    'combination' => $combinations[$i],
                    'price' => $prices[$i] ?? null, 
                    'quantity' => $quantities[$i] ?? null,
                    'sku' => $variation_sku[$i] ?? null
                ]);
            }
            return redirect('admin/storefront/product')->with('success', 'Product variation added successfully.');
        }else{
            ProductVariation::where('product_id', $product_id)->delete();
            return redirect('admin/storefront/product')->with('success', 'Product variation added successfully.');
        }
    }

    public function getVariation($product_id){
        $getVariation = ProductVariation::where('product_id', $product_id)->get();
        $collection = [];
        foreach ($getVariation as $value) {
            $getColor = Color::where('id', $value->color_id)->first();
            $getSize = Size::where('id', $value->size_id)->first();

            $collection[] = [
                'id' => $value->id ?? null,
                'color_id' => $value->color_id ?? null,
                'size_id' => $value->size_id ?? null,
                'combination' => $value->combination ?? null,
                'price' => intval($value->price) ?? null,
                'quantity' => $value->quantity ?? 0,
                'color_name' => $getColor->color_name ?? null,
                'sku' => $value->sku ?? null,
                'size_name' => $getSize->size_name ?? null,
                'created_at' => $value->created_at ?? null,
                'updated_at' => $value->updated_at ?? null,
                'product_id' => $product_id ?? null
            ];
        }
        
        if ($collection) {
            $data = [
                'success' => true,
                'variationData' => $collection
            ];
            return response()->json($data);
        } else {
            return response()->json(['error' => 'Not found any product variation']);
        }
    }
}
