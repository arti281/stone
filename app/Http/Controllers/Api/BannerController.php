<?php

namespace App\Http\Controllers\Api; 

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Catalog\Banner;

class BannerController extends Controller{
	public function banner(){
		$banners = Banner::where('status', 1)->latest('id')->get();
		$arr_banner = [];
        foreach ($banners as $banner) {
            $arr_banner[] = [
                "banner_id" => $banner->id,
                "image" => url("image/banner").'/' .$banner->image,
                "banner_name" => $banner->title
            ];
        } 
		return response()->json($arr_banner);
	}
}


?>