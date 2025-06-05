<?php

namespace App\Models\Admin\Storefront\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSpecial extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'product_specials';

    protected $fillable = [
        'product_id',
        'customer_group_id',
        'priority',
        'price',
        'start_date',
        'close_date'
    ];
}
