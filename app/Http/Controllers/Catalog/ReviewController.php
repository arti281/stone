<?php

namespace App\Http\Controllers\catalog;

use App\Models\Review;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    //
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'review' => 'required|string|max:1000',
            'rating'     => 'required|integer|min:1|max:5',
        ]);

        if(!empty(session('isUser'))){
            Review::create([
                'product_id' => $request->product_id,
                'review' => $request->review,
                'user_id' => session('isUser'),
                'rating' =>$request->rating,
            ]);
            
            return back()->with('success', 'Review submitted successfully!');
        }

        return redirect()->route('catalog.user-login');
    }
}

