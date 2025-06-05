<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Color extends Model
{
    use HasFactory;

    protected $table = 'colors';

    public $timestamps = false;

    protected $fillable = [
        'color_name',
        'code',
        'sort'
    ];
}
