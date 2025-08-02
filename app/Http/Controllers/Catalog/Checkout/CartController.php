<?php

namespace App\Http\Controllers\Catalog\Checkout;

use Exception;
use Carbon\Carbon;
use App\Models\Cart;
use App\Models\Size;
use App\Models\Product;
use App\Models\StockStatus;
use App\Models\Coupon;
use App\Models\ProductPrice;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Color;

class CartController extends Controller
{
    public function index(){
        $data['carts'] = [];
        $data['total_amount'] = 0;
        $data['total_mrp'] = 0;
        $data['discount_on_mrp'] = 0;
        $cart_product = Cart::where('user_id', session('isUser'))->get();
        foreach ($cart_product as $cart) {
            $product = Product::leftJoin('product_prices', 'products.id', '=', 'product_prices.product_id')
                                        ->select('products.*', 'product_prices.price','product_prices.mrp')
                                        ->where('products.id', $cart->product_id)->first();

            $stock = StockStatus::where('id', $product->stock_status_id)->first();
            $size = Size::where("id", $cart->size_id)->first();
            $color = Color::where("id", $cart->color_id)->first();
            $data['carts'][] = [
                "product_id" => $cart->product_id,
                "user_id" => $cart->user_id,
                "product_name" => $product->product_name,
                "slug" => $product->slug,
                "image" => ($product->image) ? asset("image/cache/products").'/'.($cart->product_id .'/'. str_replace(".jpg",'',$product->image) .'_700x700.jpg') : asset('not-image-available.png'),
                "quantity" => $cart->quantity,
                "stock_status" => $stock->name ?? '',
                "price" => $product->price * $cart->quantity,
                // "size_id" => $size->id,
                // "size_name" => $size->size_name,
                // "color_id" => $color->id,
                // "color_name" => $color->color_name,
            ];
            if($product->stock_status_id == 3) {
                $data['total_amount'] = $data['total_amount'] + $product->price * $cart->quantity;
                $data['total_mrp'] = $data['total_mrp'] + $product->mrp * $cart->quantity;
                $data['discount_on_mrp'] = $data['discount_on_mrp'] + (($product->mrp * $cart->quantity) - ($product->price * $cart->quantity));
            }
        }
        $data['cart_total'] = $cart_product->count();

        // apply coupon discount
        $coupon_discount = session('discount') ?? 0;
        $data['total_amount'] = $data['total_amount'] - $coupon_discount;
        return view('catalog.checkout.cart', $data);
    }

    public function addCart(Request $request){
        try{
            $validated = $request->validate([
                'user_id'=> 'required',
                'product_id'=> 'required',
                'quantity'=> 'required',
                // 'color_id'=> 'required',
                // 'size_id'=> 'required',
            ]);

            if($validated['quantity'] <= 0 ){
                $array = [
                    "success" => false,
                    "message" => "The cart must be at least 1 quantity."
                ];
                return response()->json($array);
            }

            $carts = Cart::where('user_id', $validated['user_id'])
            ->where('product_id', $validated['product_id'])
            // ->where('color_id', $validated['color_id'])
            // ->where('size_id', $validated['size_id'])
            ->first();
            if($carts){
                $carts->update([
                        "quantity" => $validated['quantity'],
                        "updated_at" => Carbon::now()
                    ]);
                $product_price = ProductPrice::where('product_id', $validated['product_id'])->first();

                // get updated cart
                $total_amount = 0;
                $total_mrp = 0;
                $discount_on_mrp = 0;
                $cart_product = Cart::where('user_id', session('isUser'))->get();
                foreach ($cart_product as $cart) {
                    $product = Product::leftJoin('product_prices', 'products.id', '=', 'product_prices.product_id')
                                                ->select('products.*', 'product_prices.price','product_prices.mrp')
                                                ->where('products.id', $cart->product_id)->first();
                    if($product->stock_status_id == 3) {
                        $total_amount = $total_amount + $product->price * $cart->quantity;
                        $total_mrp = $total_mrp + $product->mrp * $cart->quantity;
                        $discount_on_mrp = $discount_on_mrp + (($product->mrp * $cart->quantity) - ($product->price * $cart->quantity));
                    }
                }

                $array = [
                    "success" => true,
                    "message" => "Updated Cart Successfully!",
                    "price" => $product_price->price * $validated['quantity'],
                    "total_amount" => $total_amount,
                    "total_mrp" => $total_mrp,
                    "discount_on_mrp" => $discount_on_mrp,
                ];
                return response()->json($array);
            }else{
                Cart::create([
                    "user_id" => $validated['user_id'],
                    "product_id" => $validated['product_id'],
                    "quantity" => $validated['quantity'],
                    // "color_id" => $validated['color_id'],
                    // 'size_id'=> $validated['size_id'],
                ]);
                $array = [
                    "success" => true,
                    "message" => "Added Cart Successfully!"
                ];
                return response()->json($array);
            }
            
        }catch(Exception $e){
            dd($e->getMessage());
        }
    }

    public function removeCartProduct($product_id, $color_id, $size_id, $product_name){
        try{
            Cart::where('user_id', session('isUser'))
            ->where('product_id', $product_id)
            // ->where('color_id', $color_id)
            // ->where('size_id', $size_id)
            ->delete();
            return redirect()->route('catalog.cart')->with('success', 'Your "'.$product_name.'" has been successfully removed from the cart!');
        }catch(Exception $e){
            dd($e->getMessage());
        }
    }

    public function applyCoupon(Request $request)
    {
        $request->validate([
            'coupon_code' => 'required',
        ]);

        $coupon = Coupon::where('code', $request->coupon_code)
            ->where('status', 1)
            ->whereDate('valid_from', '<=', now())
            ->whereDate('valid_to', '>=', now())
            ->first();

        if (!$coupon) {
            return back()->with('error', 'Invalid or expired coupon code.');
        }

        // Example cart subtotal
        $subtotal = session('cart_subtotal', 0);

        if ($coupon->discount_type == 'fixed') {
            $discount = $coupon->discount;
        } else {
            $discount = ($subtotal * $coupon->discount) / 100;
        }

        session([
            'coupon' => $coupon->code,
            'discount' => $discount,
        ]);

        return back()->with('success', 'Coupon applied successfully!');
    }

    public function removeCoupon()
    {
        session()->forget(['discount', 'coupon']);
        return back()->with('success', 'Coupon removed successfully.');
    }

}

