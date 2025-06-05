<?php

namespace App\Models\Admin\Storefront\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductFilter extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'product_filters';

    protected $fillable = [
        'product_id',
        'filter_id'
    ];
}
