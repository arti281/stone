<?php

namespace App\Models\Admin\Storefront\Category;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CategoryPath extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'category_path';

    protected $fillable = [
        'category_id',
        'category_path',
        'level'
    ];

    public static function categoryPath($category_id){
        $category = DB::table('category_path')->where('category_id', $category_id)->first();
        return $category ?? null;
    }
}
