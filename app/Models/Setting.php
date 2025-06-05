<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Setting extends Model
{
    use HasFactory;

    protected $table = 'settings';

    // Define the fillable attributes
    protected $fillable = [
        'code','key','value'
    ];

    public static function getSetting(string $code){
        return DB::table('settings')->where('code', $code)->get();
    }

    public static function editSetting(string $code, array $data){
        DB::table('settings')->where('code', $code)->delete();
        if(is_array($data)){
            foreach ($data as $key => $value) {
                if($key != '_token'){
                    DB::table('settings')->insert([
                        'code' => $code,
                        'key' => $key,
                        'value' => $value
                    ]);
                }
            }
        }
    }
}
