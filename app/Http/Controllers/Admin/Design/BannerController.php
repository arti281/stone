<?php

namespace App\Http\Controllers\Admin\Design;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

class BannerController extends Controller
{
    public function index(){ 
        $data['heading_title'] = "Banner";

        $data['breadcrumbs'] = [];
        $data['breadcrumbs'][] = [
            'text' => 'Home',
            'href' => URL::to('/admin/dashboard')
        ];
        $data['breadcrumbs'][] = [
			'text' => 'Banner',
			'href' => URL::to('/admin/banner')
		];

        return view('admin.design.banner',$data);
    }

    public function saveBanner(Request $request){
        // $request->validate([
        //     'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // adjust max file size as needed
        // ]);
        
        try{
            
            $data = $request->all();
            $banner = DB::table("banners")->where('id', $data['banner_id'])->first();
            
            // upload image
            if(isset($data['image'])){
                $imageName = $data['image']->getClientOriginalName();
                $imagePath = public_path('image/banner/') . $imageName ; // Adjust this to your image path
    
                if (!file_exists($imagePath)) {
                    $request->image->move(public_path('image/banner'), $imageName);
                }
            }else{
                $imageName = $banner->image ?? '';
            }
            
            if($banner){
                DB::update("UPDATE banners set 
                title = '". $data['title'] ."',
                description = '". $data['description'] ."',
                button_url = '". $data['button_url'] ."',
                button_text = '". $data['button_text'] ."',
                sort = '". $data['sort'] ."',
                status = '". $data['status'] ."',
                image = '". $imageName ."' WHERE id = '".$data['banner_id']."'
            ");
            return redirect('admin/banner')->with('success', 'Banner updated successfully.');
            }else{
                DB::insert("INSERT into banners set 
                title = '". $data['title'] ."',
                description = '". $data['description'] ."',
                button_url = '". $data['button_url'] ."',
                button_text = '". $data['button_text'] ."',
                sort = '". $data['sort'] ."',
                status = '". $data['status'] ."',
                image = '". $imageName ."'
            ");
            return redirect('admin/banner')->with('success', 'Banner saved successfully.');
            }
        }catch(\Exception $e){
            return redirect('admin/banner')->with('error', $e);
        }
    }

    public function getBanner(){
        $data['banners'] = DB::table('banners')->get();  
        if ($data['banners']) {
            return response()->json($data['banners']);
        } else {
            return response()->json(['error' => 'Banner not found']);
        }
    }

    public function getBannerById($banner_id){
        $banner = DB::table('banners')->where('id',$banner_id)->first();
        if ($banner) {
            return response()->json($banner);
        } else {
            return response()->json(['error' => 'Banner not found']);
        }
    }

    public function deleteBanner($banner_id){

        $banner = DB::table('banners')->where('id',$banner_id)->delete();
        if ($banner) {
            return response()->json(['success' => 'Banner deleted successfully']);
        } else {
            return response()->json(['error' => 'Banner not found']);
        }
    }
}
