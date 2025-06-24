<?php

namespace App\Http\Controllers\catalog;

use App\Models\ReviewReply;
use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReviewReplyController extends Controller
{
   public function store(Request $request)
{
    $request->validate([
        'review_id' => 'required|exists:reviews,id',
        'name'      => 'required|string',
        'reply'     => 'required|string',
    ]);

    ReviewReply::create($request->all());

    return back()->with('success', 'Reply added successfully!');
}

public function show($id)
{
    $product = Product::with('reviews.replies')->findOrFail($id);

    return view('catalog.product-detail', compact('product'));
}
}
