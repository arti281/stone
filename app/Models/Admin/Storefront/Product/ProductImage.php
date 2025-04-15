<?php

namespace App\Models\Admin\Storefront\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'product_images';

    protected $fillable = [
        'product_id',
        'image',
        'sort'
    ];
}
