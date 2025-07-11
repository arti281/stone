<?php

namespace App\Http\Controllers\Admin\Coupon;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Coupon;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function index(){
        
   $coupons = Coupon::all();
    return view('admin.coupon.index', compact('coupons'));
     }

      public function create(){
        return view('admin.coupon.create');
     }

      public function edit($id){
        $coupon = Coupon::findOrFail($id);
    return view('admin.coupon.edit', compact('coupon'));
     }

     public function update(Request $request, $id)
{
    $coupon = Coupon::findOrFail($id);

    $coupon->update([
        'code' => $request->input('code'),
        'discount' => $request->input('discount'),
        'status' => $request->input('status', 1),
    ]);

    return redirect()->route('coupon.index')->with('success', 'Coupon updated successfully!');
}


     public function destroy(){
        return view('admin.coupon.destroy');
     }

   public function store(Request $request)
        {
           $request->validate([
    'code' => 'required|string|unique:coupons',
    'discount' => 'required|numeric',
    'status' => 'required|in:active,inactive,1,0',
    'valid_from' => 'required|date',
]);

Coupon::create([
    'code' => $request->code,
    'discount' => $request->discount,
    'status' => $request->status,
    'valid_from' => now()->toDateString(),  // Set current date
]);

    return redirect()->route('admin.coupon.index')->with('success', 'Coupon created successfully.');
        }


}
