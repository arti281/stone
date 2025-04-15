<?php
namespace App\Http\Controllers\Admin\Setting;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

class EcommerceLinkController extends Controller{

    public function index(){
        $data['heading_title'] = "E-commerce Links";

        $data['breadcrumbs'] = [];
        $data['breadcrumbs'][] = [
            'text' => 'Home',
            'href' => URL::to('/admin/dashboard')
        ];
        $data['breadcrumbs'][] = [
			'text' => 'Setting',
			'href' => URL::to('/admin/setting')
		];
        $data['breadcrumbs'][] = [
			'text' => 'E-commerce Links',
			'href' => URL::to('/admin/setting/ecommerce-links')
		];

        $data['back'] = route('admin-setting');
        $data['action'] = route('ecommerce-links-save');

        $data['ecommerce_other_url_status'] = app('settings')['ecommerce_other_url_status'] ?? 0;
        $data['ecommerce_checkout_status'] = app('settings')['ecommerce_checkout_status'] ?? 0;

        return view('admin.setting.ecommerce_links',$data);
    }

    public function save(Request $request){
        try{
            Setting::editSetting('ecommerce', $request->all());
            
            return redirect('admin/setting')->with('success', 'Configuration saved successfully.');
        }catch(\Exception $e){
            return redirect('admin/setting')->with('error', $e->getMessage());
        }
    }
}