<?php

namespace App\Http\Controllers\Admin\Common;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function editProfile(){
        $data['heading_title'] = "Edit Profile";

        $data['breadcrumbs'] = [];
        $data['breadcrumbs'][] = [
            'text' => 'Home',
            'href' => Route('admin-dashboard')
        ];
        $data['breadcrumbs'][] = [
            'text' => 'Edit Profile',
            'href' => Route('edit-profile')
        ];

        $data['action'] = Route('save-profile');
        $data['back'] = URL::to('/admin/dashboard');

        $data['profile'] = DB::table('admins')->where('id', session('admin_id'))->first();

        return view('admin.common.profile', $data);
    }

    public function saveProfile(Request $request){

        try{
            $data = $request->all();
            $input_image = $request->file('image'); // get files
            $profile= DB::table('admins')->where('id', session('admin_id'))->first();
            if($profile){
                $profileImageName = $profile->image;
            }
            if(null !== $input_image){
                $folderPath = public_path('image/profile');
                $imageName = $input_image->getClientOriginalName();
                $imagePath = $folderPath . '/' . $imageName;

                // Check if folder exists, create if not
                if (!File::exists($folderPath)) {
                    File::makeDirectory($folderPath, 0777, true);
                }

                // Check if the existing logo needs to be removed
                if (isset($profileImageName) && File::exists($folderPath . '/' . $profileImageName)) {
                    File::delete($folderPath . '/' . $profileImageName);
                }

                // Move the new file if it doesn't already exist
                if (!File::exists($imagePath)) {
                    $input_image->move($folderPath .'/', $imageName);
                }
                    // Get all the form data
                $data = array_merge($request->all(), ['image' => $imageName]);
            }

            $profileUpdate = [
                "username" => $data['username'] ?? '',
                "firstname" => $data['firstname'] ?? '',
                "lastname" => $data['lastname'] ?? '',
                "email" => $data['email'] ?? '',
                "status" => $data['status'] ?? 0,
                "updated_at" => now()
            ];

            if (isset($data['image'])) {
                $profileUpdate['image'] = $data['image'];
            }

            DB::table('admins')->where('id', session('admin_id'))->update($profileUpdate);
            return redirect()->route('edit-profile')->with('success', 'Profile updated successfully.');
        }catch(Exception $e){
            dd($e->getMessage());
        }
    }

    public function changePassword(){
        $data['heading_title'] = "Change Password";

        $data['breadcrumbs'] = [];
        $data['breadcrumbs'][] = [
            'text' => 'Home',
            'href' => Route('admin-dashboard')
        ];
        $data['breadcrumbs'][] = [
            'text' => 'Change Password',
            'href' => route('change-password')
        ];

        $data['action'] = Route('save-password');
        $data['back'] = URL::to('/admin/dashboard');
        
        return view('admin.common.change-password', $data);
    }

    public function savePassword(Request $request){
        $request->validate([
            'new_password' => 'required|string|max:255',
            'confirm_password' => 'required|string|max:255',
        ]);

        try{
            $newPassword = $request->get('new_password');
            $confirmPassword = $request->get('confirm_password');
            if($newPassword === $confirmPassword){
                $profile = DB::table('admins')->where('id', session('admin_id'))->first();
                if($profile){
                    $hash_password = Hash::make($newPassword);
                    $changePassword = [
                        "password" => $hash_password,
                        "updated_at" => now()
                    ];
                    DB::table('admins')->where('id', session('admin_id'))->update($changePassword);
                    return redirect()->route('change-password')->with('success', 'Password changed successfully');
                }
            }else{
                return redirect()->route('change-password')->with('error', 'Password does not match.');
            }
        }catch(Exception $e){
            dd($e->getMessage());
        }
    }
}
