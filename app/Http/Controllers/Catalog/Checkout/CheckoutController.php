<?php

namespace App\Http\Controllers\Catalog\Checkout;

use App\Models\Cart;
use App\Models\Size;
use App\Models\Color;
use App\Models\State;
use App\Models\Product;
use App\Models\StockStatus;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Order;
use App\Models\OrderMaster;
use App\Models\ProductPrice;
use App\Models\ProductVariation;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function index(){
        $data['total_amount'] = 0;
        $data['total_mrp'] = 0;
        $data['discount_on_mrp'] = 0;
        $data['cod_fee'] = (int)app('settings')['general_cod_fee'];
        $data['prepaid_fee'] = (int)app('settings')['general_prepaid_fee']; // in percentage
        
        $cart_product = Cart::where('user_id', session('isUser'))->get();
        foreach ($cart_product as $cart) {
            $product = Product::leftJoin('product_prices', 'products.id', '=', 'product_prices.product_id')
                                        ->select('products.*', 'product_prices.price','product_prices.mrp')
                                        ->where('products.id', $cart->product_id)->first();

            if($product->stock_status_id == 3) {
                $data['total_amount'] = $data['total_amount'] + $product->price * $cart->quantity;
                $data['total_mrp'] = $data['total_mrp'] + $product->mrp * $cart->quantity;
                $data['discount_on_mrp'] = $data['discount_on_mrp'] + (($product->mrp * $cart->quantity) - ($product->price * $cart->quantity));
            }
        }
        $data['cart_total'] = $cart_product->count();

        $data['states'] = State::all();

        $data['action'] = route('catalog.checkout');

        $data['addresses'] = Address::where('user_id', session('isUser'))->get();
        
        if($data['cart_total'] > 0){
            return view('catalog.checkout.checkout', $data);
        }else{
            return redirect()->route('catalog.cart');
        }
    }

    public function checkout(Request $request){

        $validated = $request->validate([
            "name" => 'required',
            "contact" => 'required',
            "address_1" => 'required',
            "address_2" => 'required',
            "city" => 'required',
            "pincode" => 'required',
            "state" => 'required',
            "payment_method" => 'required'
        ],[
            'payment_method.required' => 'Please select a payment method.',
        ]);

        $data['total_amount'] = 0;
        $data['total_mrp'] = 0;
        $data['discount_on_mrp'] = 0;
        $data['coupon_discount'] = 0;
        $data['platform_fee'] = 0;
        $data['shipping_fee'] = 0;

        $cart_product = Cart::where('user_id', session('isUser'))->get();
        foreach ($cart_product as $cart) {
            $product = Product::leftJoin('product_prices', 'products.id', '=', 'product_prices.product_id')
                                        ->select('products.*', 'product_prices.price','product_prices.mrp')
                                        ->where('products.id', $cart->product_id)->first();

            if($product->stock_status_id == 3) {
                $data['total_amount'] = $data['total_amount'] + $product->price * $cart->quantity;
                $data['total_mrp'] = $data['total_mrp'] + $product->mrp * $cart->quantity;
                $data['discount_on_mrp'] = $data['discount_on_mrp'] + (($product->mrp * $cart->quantity) - ($product->price * $cart->quantity));
            }
        }

        $user = User::where('id', session('isUser'))->first();

        $orderArr = [
            'user_id' => session('isUser'),
            'name' => $validated['name'],
            'contact' => $validated['contact'],
            'email' => $user->email,
            'address_1' => $validated['address_1'],
            'address_2' => $validated['address_2'],
            'country' => 'India',
            'state' => $validated['state'],
            'city' => $validated['city'],
            'pincode' => $validated['pincode'],
            'total_mrp' => $data['total_mrp'],
            'total_amount' => $data['total_amount'],
            'discount_on_mrp' => $data['discount_on_mrp'],
            'coupon_discount' => $data['coupon_discount'],
            'platform_fee' => $data['platform_fee'],
            'shipping_fee' => $data['shipping_fee'],
            'tracking_no' => Str::random(10),
            'invoice_prefix' => 'INV-' . date('Y') . '-00',
            'payment_method' => $validated['payment_method'],
            'order_status' => 'Order Booked',
            'payment_status' => 'Pending'
        ];

        // COD payment method
        if($validated['payment_method'] == 'cod'){

            if(app('settings') && (int)app('settings')['general_cod_fee_status']){
                $orderArr['cod_fee'] = (int)app('settings')['general_cod_fee'];
                $orderArr['total_amount'] = ceil($data['total_amount']  + (int)app('settings')['general_cod_fee']); // added code fee
            }            

            // create order master
            $order_master = OrderMaster::create($orderArr);
    
            // create orders
            foreach ($cart_product as $cart) {
    
                $productVariation = ProductVariation::where('color_id', $cart->color_id)
                    ->where('size_id', $cart->size_id)
                    ->where('product_id', $cart->product_id)->first();

                $product_price = ProductPrice::where('product_id', $cart->product_id)->first();
    
                Order::create([
                    'order_master_id' => $order_master->id,
                    'product_id' => $cart->product_id,
                    'color_id' => $cart->color_id,
                    'size_id' => $cart->size_id,
                    'quantity' => $cart->quantity,
                    'sku' => $productVariation->sku ?? null,
                    'price' => $product_price->price * $cart->quantity,
                ]);
            }

            // delete cart items
            // Cart::where('user_id', session('isUser'))->delete();

        }
        // Razorpay payment method
        else if($validated['payment_method'] == 'razorpay'){

            // discount on the prepaid
            if(app('settings') && (int)app('settings')['general_prepaid_fee_status']){
                $prepaid_fee = (int)app('settings')['general_prepaid_fee']; // fee in percentage
                $orderArr['prepaid_fee'] = $prepaid_fee;
                $prepaid = ($data['total_amount'] / 100)  * $prepaid_fee;
                $orderArr['total_amount'] = ceil($data['total_amount']  - $prepaid);
            }

            // create order master
            $order_master = OrderMaster::create($orderArr);
    
                // 'payment_id' => '',
                // 'payment_request_id' => '',
                // 'payment_status' => '',
                
                
            
    
            // create orders
            foreach ($cart_product as $cart) {
    
                $productVariation = ProductVariation::where('color_id', $cart->color_id)
                    ->where('size_id', $cart->size_id)
                    ->where('product_id', $cart->product_id)->first();
                
                $product_price = ProductPrice::where('product_id', $cart->product_id)->first();
    
                Order::create([
                    'order_master_id' => $order_master->id,
                    'product_id' => $cart->product_id,
                    'color_id' => $cart->color_id,
                    'size_id' => $cart->size_id,
                    'quantity' => $cart->quantity,
                    'sku' => $productVariation->sku ?? null,
                    'price' => $product_price->price * $cart->quantity,
                ]);
            }

            // delete cart items
            // Cart::where('user_id', session('isUser'))->delete();

        }else{
            return redirect()->route('catalog.checkout')->with('error', 'Please select correct payment method');
        }

        return redirect()->route('catalog.order')->with('success', 'Product ordered successfully!');
    }
}
