<?php

namespace App\Models\Admin\Storefront\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductPrice extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'product_prices';

    protected $fillable = [
        'product_id',
        'price',
        'mrp'
    ];
}
