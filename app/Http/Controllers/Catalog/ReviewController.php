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
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'review' => 'required|string|max:1000',
        ]);

        if(Auth::check()){
            Review::create([
                'product_id' => $request->product_id,
                'review' => $request->review,
                'user_id' => Auth::user()->id,
            ]);
            return back()->with('success', 'Review submitted successfully!');
        }

        return back()->with('success', 'Review not submitted successfully!');
    }
}

