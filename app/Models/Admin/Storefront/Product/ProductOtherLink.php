<?php

namespace App\Models\Admin\Storefront\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductOtherLink extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'product_other_links';

    protected $fillable = [
            'product_id',
            'amazon',
            'flipkart',
            'myntra',
            'ajio',
            'meesho',
            'status'
    ];
}
