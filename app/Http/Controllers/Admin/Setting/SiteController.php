<?php

namespace App\Http\Controllers\Admin\Setting;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\File;

class SiteController extends Controller
{
    public function index(){
        $data['heading_title'] = "Site";

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
			'text' => 'Site',
			'href' => URL::to('/admin/setting/site')
		];

        $data['back'] = route('admin-setting');
        $data['action'] = route('site-save');

        $data['site_desktop_logo'] = app('settings')['desktop_logo'] ?? '';
        $data['site_mobile_logo'] = app('settings')['mobile_logo'] ?? '';
        $data['site_title'] = app('settings')['site_title'] ?? '';
        $data['site_description'] = app('settings')['site_description'] ?? '';

        return view('admin.setting.site',$data);
    }

    public function save(Request $request){
        try{
            $data = $request->all();
            // Upload image
            $site_desktop_logo = app('settings')['desktop_logo'] ?? '';
            $site_mobile_logo = app('settings')['mobile_logo'] ?? '';
            $folderPath = public_path('image/setting/site');
            
            // For desktop logo
            $input_desktop_logo = $request->file('desktop_logo'); // get files
            if(null !== $input_desktop_logo){
                $imageName = $input_desktop_logo->getClientOriginalName();
                $imagePath = $folderPath . '/' . $imageName;

                // Check if folder exists, create if not
                if (!File::exists($folderPath)) {
                    File::makeDirectory($folderPath, 0777, true);
                }

               // Check if the existing logo needs to be removed
                if (isset($site_desktop_logo) && File::exists($folderPath . '/' . $site_desktop_logo)) {
                    File::delete($folderPath . '/' . $site_desktop_logo);
                }

                // Move the new file if it doesn't already exist
                if (!File::exists($imagePath)) {
                    $input_desktop_logo->move($folderPath .'/', $imageName);
                }
                  // Get all the form data
                $data = array_merge($request->all(), ['desktop_logo' => $imageName]);
            }else{
                $data = array_merge($request->all(), ['desktop_logo' => $site_desktop_logo]);
            }

            // for mobile logo
            $input_mobile_logo = $request->file('mobile_logo'); // get files
            if(null !== $input_mobile_logo){
                $imageName = $input_mobile_logo->getClientOriginalName();
                $imagePath = $folderPath . '/' . $imageName;

                // Check if folder exists, create if not
                if (!File::exists($folderPath)) {
                    File::makeDirectory($folderPath, 0777, true);
                }

               // Check if the existing logo needs to be removed
                if (isset($site_mobile_logo) && File::exists($folderPath . '/' . $site_mobile_logo)) {
                    File::delete($folderPath . '/' . $site_mobile_logo);
                }

                // Move the new file if it doesn't already exist
                if (!File::exists($imagePath)) {
                    $input_mobile_logo->move($folderPath .'/', $imageName);
                }
                  // Get all the form data
                $data = array_merge($data, ['mobile_logo' => $imageName]);
            }else{
                $data = array_merge($data, ['mobile_logo' => $site_mobile_logo]);
            }

            // dd($data);

            Setting::editSetting('site', $data);
            
            return redirect('admin/setting')->with('success', 'Configuration saved successfully.');
        }catch(\Exception $e){
            return redirect('admin/setting')->with('error', $e->getMessage());
        }
    }
}
