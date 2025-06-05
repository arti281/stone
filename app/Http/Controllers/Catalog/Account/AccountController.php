<?php

namespace App\Http\Controllers\Catalog\Account;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AccountController extends Controller
{
    public function index(){
        $data['route_profile'] = route('catalog.profile');
        $data['route_change_password'] = route('catalog.viewChangePassword');
        $data['route_cart'] = route('catalog.cart');
        $data['route_address'] = route('catalog.address');
        return view('catalog.account.account', $data);
    }

    public function profile(){
        $data['action'] = route('catalog.update-profile');
        $data['profile'] = DB::table('users')->where('id', session('isUser'))->first();
        return view('catalog.account.profile', $data);
    }

    public function update(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:3|max:50',
            'number' => 'required|numeric|digits:10'
        ],[
            'name.required' => 'The name field is required.',
            'name.min' => 'The name must be at least 3 characters.',
            'number.required' => 'The phone number field is required.',
            'number.numeric' => 'The phone number must be numeric.',
            'number.digits' => 'The phone number must be exactly 10 digits.',
        ]);
        if ($validator->fails()) {
            return redirect()->route('catalog.profile')
            ->withErrors($validator)
            ->withInput();
        }

        try{
            $data = $request->request;
            
            DB::table('users')->where('id', session('isUser'))->update([
                "name" => $data->get('name') ?? null,
                "number" => $data->get('number') ?? null
            ]);

            return redirect()->route('catalog.profile')->with('success', "Profile updated successfully!");

        }catch(Exception $e){
            dd($e->getMessage());
        }

    }

    public function viewChangePassword(){
        $data['action'] = route('catalog.changePassword');
        return view('catalog.account.change-password', $data);
    }

    public function changePassword(Request $request){
        $validator = Validator::make($request->all(), [
            'password' => 'required|string|min:4|max:20',
            'confirm_password' => 'required|string|min:4|max:20',
        ],[
            'password.required' => 'The password field is required.',
            'password.min' => 'The password must be at least 4 characters.',
            'confirm_password.required' => 'The confirm password field is required.',
            'confirm_password.min' => 'The confirm password must be at least 4 characters.',
        ]);
        if ($validator->fails()) {
            return redirect()->route('catalog.viewChangePassword')->withErrors($validator);
        }

        try{
            $data = $request->request;

            // checking password
            if($data->get('password') !== $data->get('confirm_password')){
                return redirect()->route('catalog.viewChangePassword')->with('password_not_match', 'The password does not match.');
            }

            DB::table('users')->where('id', session('isUser'))->update([
                "password" => Hash::make($data->get('password'))
            ]);

            return redirect()->route('catalog.viewChangePassword')->with('success', "Password updated successfully!");

        }catch(Exception $e){
            dd($e->getMessage());
        }
    }
}
