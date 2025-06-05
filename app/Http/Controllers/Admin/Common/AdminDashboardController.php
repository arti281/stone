<?php

namespace App\Http\Controllers\Admin\Common;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index(){
        $data['total_brands'] = '';
        $data['total_retailers'] = '';
        $data['total_wholesalers'] = '';
        $data['total_contacts'] = '';

        return view('admin.common.dashboard', $data);
    }
    public function dashboard(Request $request){
        
    }
}