<?php

namespace App\Models;

use App\Mail\Email;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;

class Payment extends Model
{
    protected $guarded = [];

    protected static function booted()
    {
        static::created(function ($payment) {
            $orderMaster = OrderMaster::with('orders')->where('id', $payment->order_master_id)->first();
            $emailData = [
                "subject" => "New order placed",
                "orderMaster" => $orderMaster
            ];

            Mail::to('pstonearts02@gmail.com')->send(new Email($emailData, 'Payment'));
        });
    }
}
