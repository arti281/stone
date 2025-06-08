<?php

namespace App\Http\Controllers\catalog;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Catalog\Review;

class ReviewController extends Controller
{
    //
    public function store(Request $request)
{
    $request->validate([
        'product_id' => 'required|exists:products,id',
        'review' => 'required|string|max:1000',
    ]);

    // Review::create([
    //     'product_id' => $request->product_id,
    //     'review' => $request->review,
    //     'user_id' => auth()->id(), // optional if using login
    // ]);

    return back()->with('success', 'Review submitted successfully!');
}
}

