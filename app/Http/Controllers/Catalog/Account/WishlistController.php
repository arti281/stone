<?php

namespace App\Http\Controllers\Catalog\Account;

use App\Models\Cart;
use App\Models\Wishlist;
use App\Models\StockStatus;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;

class WishlistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $wishlist_product = Wishlist::where('user_id', session('isUser'))->get();
        foreach ($wishlist_product as $cart) {
            $product = Product::leftJoin('product_prices', 'products.id', '=', 'product_prices.product_id')
                                        ->select('products.*', 'product_prices.price','product_prices.mrp')
                                        ->where('products.id', $cart->product_id)->first();
                                    // dd($product);
            $stock = StockStatus::where('id', $product->stock_status_id)->first();
            $data['wishlists'][] = [
                "product_id" => $cart->product_id,
                "user_id" => $cart->user_id,
                "product_name" => $product->product_name,
                "slug" => $product->slug,
                "image" => ($product->image) ? asset("image/cache/products").'/'.($cart->product_id .'/'. str_replace(".jpg",'',$product->image) .'_700x700.jpg') : asset('not-image-available.png'),
                "quantity" => $cart->quantity,
                "stock_status" => $stock->name ?? '',
                "price" => $product->price * $cart->quantity,
            ];
        }
        $data['wishlist_total'] = $wishlist_product->count();
        return view('catalog.account.wishlist', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            "user_id" => "required",
            "product_id" => "required",
            "quantity" => "required",
        ]);

        if(Wishlist::where('product_id', $validated['product_id'])->where('user_id', $validated['user_id'])->first()){
            return response()->json([
                "success" => true,
                "message" => "Already Added Wishlist Successfully!"
            ]);
        }

        Wishlist::create($validated);

        return response()->json([
            "success" => true,
            "message" => "Added Wishlist Successfully!"
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Wishlist::where('user_id', session('isUser'))->where('product_id', $id)->delete();
        return response()->json([
            "success" => true,
            "message" => "Your item has been successfully removed from the wishlist!"
        ]);
    }
}
