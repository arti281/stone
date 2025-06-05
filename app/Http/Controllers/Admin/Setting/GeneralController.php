<?php

namespace App\Http\Controllers\Admin\Setting;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Setting;

class GeneralController extends Controller
{
    public function index(){
        $data['heading_title'] = "General";
        $data['list_title'] = "General Edit";

        $data['breadcrumbs'][] = [
            'text' => 'Home',
            'href' => route('admin-dashboard'),
        ];
        $data['breadcrumbs'][] = [
			'text' => 'Setting',
			'href' => route('admin-setting')
		];
        $data['breadcrumbs'][] = [
            'text' => 'General',
            'href' => null
        ];
        
        $data['back'] = route('admin-setting');
        $data['action'] = route('admin.generalSave');

        $data['general_cod_fee'] = app('settings')['general_cod_fee'] ?? 0;
        $data['general_prepaid_fee'] = app('settings')['general_prepaid_fee'] ?? 0;
        $data['general_cod_fee_status'] = app('settings')['general_cod_fee_status'] ?? 0;
        $data['general_prepaid_fee_status'] = app('settings')['general_prepaid_fee_status'] ?? 0;


        return view('admin.setting.general',$data);
    }

    public function save(Request $request){

        $validated = $request->validate([
            'general_cod_fee' => 'nullable', 
            'general_prepaid_fee' => 'nullable', 
            'general_cod_fee_status' => 'nullable', 
            'general_prepaid_fee_status' => 'nullable', 
        ]);

        $validated['general_cod_fee_status'] = $validated['general_cod_fee_status'] ? true : false;
        $validated['general_prepaid_fee_status'] = $validated['general_prepaid_fee_status'] ? true : false;

        Setting::editSetting('general', $validated);
            
        return redirect()->route('admin-setting')->with('success', 'Configuration saved successfully.');
    }
}
