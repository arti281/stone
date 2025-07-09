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
        return view('admin.coupon.index');
     }
   public function store(Request $request)
   {

    $request->validate([
    'code' => 'required|unique:coupons',
    'discount' => 'required|numeric|min:1',
    'discount_type' => 'required|in:fixed,percent',
    'valid_from' => 'required|date',
    'valid_to' => 'required|date|after_or_equal:valid_from',
], [
    'code.required' => 'The coupon code is required.',
    'code.unique' => 'This coupon code already exists.',
    'discount.required' => 'Please enter a discount value.',
    'valid_to.after_or_equal' => 'The valid to date must be after the valid from date.',
]);

    // $request->validate([
    //     'code' => 'required|unique:coupons',
    //     'discount' => 'required|numeric',
    //     'discount_type' => 'required|in:fixed,percent',
    //     'valid_from' => 'required|date',
    //     'valid_to' => 'required|date|after_or_equal:valid_from',
    // ]);

    Coupon::create($request->all());

    return redirect()->route('admin.coupons.index')->with('success', 'Coupon created successfully!');
}

}
