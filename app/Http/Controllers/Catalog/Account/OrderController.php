<?php

namespace App\Http\Controllers\Catalog\Account;

use App\Models\Order;
use App\Models\OrderMaster;
use App\Models\OrderHistory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    public function index(){

        $data['orderMaster'] = OrderMaster::with([
            'orders' => function ($orderQuery) {
                $orderQuery->with([
                    'product' => function ($productQuery) {
                        $productQuery->select('id', 'product_name','slug', 'image'); // Specific fields for Product
                    },
                    'color' => function ($colorQuery) {
                        $colorQuery->select('id', 'color_name'); // Specific fields for Color
                        
                    },
                    'size' => function ($sizeQuery) {
                        $sizeQuery->select('id', 'size_name'); // Specific fields for Size
                    },
                    'orderHistory' => function ($historyQuery){
                        $historyQuery->select('id', 'order_id', 'order_status')->latest('created_at'); // Specific fields for history
                    }
                ])->select('id', 'order_master_id', 'product_id', 'color_id', 'size_id'); // Specific fields for Orders
            }
        ])
            ->where('user_id', session('isUser'))
            ->select('id', 'name', 'total_amount', 'payment_method', 'order_status', 'created_at')
            ->latest('created_at')
            ->simplePaginate(10);

            // dd($data['orderMaster']);

        return view('catalog.account.order', $data);
    }

    public function orderInfo($order_master_id){
        $data['orderMaster'] = OrderMaster::where('user_id', session('isUser'))
        ->where('id', $order_master_id)
        ->first();

        $data['orders'] = Order::leftJoin('products', 'orders.product_id', '=', 'products.id')
            ->where('order_master_id', $order_master_id)
            ->select('orders.*', 'products.product_name')
            ->get();

        return view('catalog.account.order-info', $data);
    }

    public function getOrderHistory($id){
        $histories = OrderHistory::where('order_master_id', $id)->latest('created_at')->simplePaginate(5);

        return response()->json([
            'histories' => $histories
        ]);
    }

    public function invoice($order_master_id){
        $data['orderMaster'] = OrderMaster::with([
            'orders' => function ($orderQuery) {
                $orderQuery->with([
                    'product' => function ($productQuery) {
                        $productQuery->select('id', 'product_name'); // Specific fields for Product
                    },
                    'color' => function ($colorQuery) {
                        $colorQuery->select('id', 'color_name'); // Specific fields for Color
                    },
                    'size' => function ($sizeQuery) {
                        $sizeQuery->select('id', 'size_name'); // Specific fields for Size
                    }
                ]); // Specific fields for Orders
            }
        ])
        
            ->where('user_id', session('isUser'))
            ->where('id', $order_master_id)
            ->select('id','name', 'total_amount', 'coupon_discount', 'payment_method', 'invoice_no','invoice_prefix','created_at')
            ->first();
// dd($data['orderMaster']);
        return view('catalog.account.invoice', $data);
    }

}
