<?php

namespace App\Models\Admin\Storefront\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductReward extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'product_rewards';

    protected $fillable = [
        'product_id',
        'point'
    ];
}
