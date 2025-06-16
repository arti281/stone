<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $emailData = [
    'order_id',
    'order_master_id',
    'product_name',
    'quantity',
    'price'
    ];
}
