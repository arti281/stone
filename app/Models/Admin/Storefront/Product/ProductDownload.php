<?php

namespace App\Models\Admin\Storefront\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductDownload extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'product_downloads';

    protected $fillable = [
        'product_id',
        'download_id'
    ];

}
