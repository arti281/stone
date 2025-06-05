<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Size extends Model
{
    use HasFactory;

    protected $table = 'sizes';

    public $timestamps = false;

    protected $fillable = [
        'size_name',
        'sort'
    ];
    
}
