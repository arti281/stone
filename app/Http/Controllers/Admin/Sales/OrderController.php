<?php

namespace App\Http\Controllers\Admin\Sales;

use App\Models\Order;
use App\Models\OrderMaster;
use App\Models\OrderStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use App\Models\OrderHistory;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data['heading_title'] = "Orders";
        $data['list_title'] = "Order List";

        $data['breadcrumbs'][] = [
            'text' => 'Home',
            'href' => route('admin-dashboard'),
        ];
        $data['breadcrumbs'][] = [
            'text' => 'Orders',
            'href' => null
        ];

        $data['statuses'] = OrderStatus::all();

        $query = OrderMaster::select('id', 'name', 'total_amount', 'payment_method', 'order_status', 'created_at');
    
        //=========== start filter ===========
        if ($request->filled('order_id')) {
            $query->where('id', $request->order_id);
        }
        if ($request->filled('username')) {
            $query->where('name', $request->username);
        }
        // filter by date
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [
                $request->start_date . ' 00:00:00',  
                $request->end_date . ' 23:59:59'     
            ]);
        } elseif ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        } elseif ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }
        if ($request->filled('status')) {
            $query->where('order_status', $request->status);
        }
        //============= end filter ==============
    
        $data['orderMaster'] = $query->latest('created_at')->paginate();

        return view('admin.sales.order', $data);
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
            'order_master_id' => 'required|numeric',
            'order_id' => 'required|numeric',
            'order_status' => 'required',
            'notify' => 'nullable',
            'comment' => 'nullable'
        ]);

        $history = OrderHistory::where('order_id', $validated['order_id'])
            ->where('order_master_id', $validated['order_master_id'])
            ->latest('created_at')->first();

        if($history){

            if($history->order_status == 'Delivered' || $history->order_status == 'Completed'){
                return response()->json([
                    'success' => false,
                    'message' => "This Order is already Delivered/Completed successfully!"
                ]);
            }
    
            if($history->order_status == 'Canceled'){
                return response()->json([
                    'success' => false,
                    'message' => "This order is Canceled"
                ]);
            }
        }

        OrderHistory::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Order updated successfully!'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data['heading_title'] = "Order";
        $data['list_title'] = "Order Edit";

        $data['breadcrumbs'][] = [
            'text' => 'Home',
            'href' => route('admin-dashboard'),
        ];
        $data['breadcrumbs'][] = [
            'text' => 'Order',
            'href' => route('admin.order')
        ];
        $data['breadcrumbs'][] = [
            'text' => 'Order Edit',
            'href' => null
        ];

        $data['orderMaster'] = OrderMaster::where('id', $id)->first();

        $data['orders'] = Order::leftJoin('products', 'orders.product_id', '=', 'products.id')
            ->where('order_master_id', $id)
            ->select('orders.*', 'products.product_name')
            ->get();

        $data['back'] = route('admin.order');

        $data['statuses'] = OrderStatus::all();

        return view('admin.sales.order-info', $data);
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
        //
    }

    public function generateIncoice(Request $request){
        $request->validate([
            'order_id' => 'required|numeric'
        ]);

        $order = OrderMaster::where('id', $request->order_id)->first();

        if($order->invoice_no){
            return response()->json([
                'success' => false,
                'message' => 'Already Generated Invoice No'
            ]);
        }

        $maxInvoiceNo = OrderMaster::max('invoice_no');

        OrderMaster::where('id', $request->order_id)->update([
            'invoice_no' => $maxInvoiceNo + 1
        ]);

        $order = OrderMaster::where('id', $request->order_id)->first();
        return response()->json([
            'success' => true,
            'invoice' => $order->invoice_prefix . $order->invoice_no,
            'message' => 'Invoice No Generated Successfully!'
        ]);
    }

    public function getOrderHistory($id){
        $histories = OrderHistory::where('order_master_id', $id)->latest('created_at')->simplePaginate(5);

        return response()->json([
            'histories' => $histories
        ]);
    }
}
