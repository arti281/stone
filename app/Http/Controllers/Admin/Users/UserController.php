<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Admin\Common\Pagination;
use App\Http\Controllers\Controller;
use App\Models\Admin\Users\User;
use App\Models\Country;
use App\Models\State;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

class UserController extends Controller
{
    public function index(Request $request){
        $data['heading_title'] = "Users";

        $data['breadcrumbs'] = [];
        $data['breadcrumbs'][] = [
            'text' => 'Home',
            'href' => URL::to('/admin/dashboard')
        ];
        $data['breadcrumbs'][] = [
            'text' => 'Users',
            'href' => URL::to('/admin/user/user')
        ];

        $data['add'] = URL::to('/admin/user/user-form');

        // Filter
        $data['user_name'] = $request->query('user_name') ?? null;
        $data['email'] = $request->query('email') ?? null;
        $data['contact'] = $request->query('contact') ?? null;
        $data['status'] = $request->query('status') ?? 1;

        $data['page_url'] = route('user');

        // Pagination
        $results = User::getUsers($request);
        $perPage = 15;
        $paginator = Pagination::pagination($results, $perPage);
        $data['users'] = $paginator['items'];
        $data['pagination'] = $paginator['pagination'];


        return view('admin.user.user', $data);
    }

    public function form(){
        $data['heading_title'] = "Users";

        $data['breadcrumbs'] = [];
        $data['breadcrumbs'][] = [
            'text' => 'Home',
            'href' => URL::to('/admin/dashboard')
        ];
        $data['breadcrumbs'][] = [
            'text' => 'Users',
            'href' => URL::to('/admin/user/user-form')
        ];

        $data['action'] = route('user-save');
        $data['back'] = route('user');

        $data['states'] = State::all();
        $data['countries'] = Country::all();

        return view('admin.user.user-form', $data);
    }

    public function edit($user_id = null){
        $data['heading_title'] = "Users";

        $data['breadcrumbs'] = [];
        $data['breadcrumbs'][] = [
            'text' => 'Home',
            'href' => URL::to('/admin/dashboard')
        ];
        $data['breadcrumbs'][] = [
            'text' => 'Users',
            'href' => URL::to('/admin/user/user/')
        ];

        $data['breadcrumbs'][] = [
            'text' => 'Edit user',
            'href' => URL::to('/admin/user/user-edit/user_id='.$user_id)
        ];

        $data['action'] = route('user-save', ['user_id' => $user_id]);
        $data['back'] = route('user');

        if($user_id){
            $data['user'] = User::getUserById($user_id);
        }

        $data['states'] = State::all();
        $data['countries'] = Country::all();

        return view('admin.user.user-form', $data);
    }

    public function save(Request $request, $user_id = null){

        $validate = $request->validate([
            'user_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:50',
            'number' => 'nullable|numeric|min:10',
            'password' => 'nullable|string|max:255',
            'confirm_password' => 'nullable|string|max:255|same:password'
        ]);

        try{
            $data = $request->all();

            // verify email 
            if($user_id){
                $getUser = User::getUserById($user_id);
                if($getUser->email !== $data['email']){
                    $verifyEmail = User::getUserByEmail($data['email']);
                    if($verifyEmail){
                        return redirect()->route('user-form', $user_id)->with('email_error', 'Email already exists');
                    }
                }
            }else{
                $verifyEmail = User::getUserByEmail($data['email']);
                if($verifyEmail){
                    return redirect()->route('user-form')->with('email_error', 'Email already exists');
                }
            }

            // Upload image
            $file = $request->file('image'); // get files
            if(null !== $file){
                // remove image before update
                $getUser = User::getUserById($user_id);
                if($getUser && $getUser->image){
                    $image_name = isset($getUser->image) ? $getUser->image : null;
                    if($image_name){
                        if(file_exists(public_path('image/user/') . $image_name)){
                            unlink(public_path('image/user/') . $image_name);
                        }
                    }
                }
                $folderPath = public_path('image/user');
                if (!file_exists($folderPath)) {
                    mkdir($folderPath, 0777, true);
                }
                $imageName = time() . '_' . $file->getClientOriginalName();
                $imagePath = public_path('image/user') . $imageName;
                if (!file_exists($imagePath)) {
                    $file->move(public_path('image/user/'), $imageName);
                }
                $data = array_replace($data, ['image' => $imageName]);
            }   

            if($user_id){
                User::updateUser($user_id, $data);
                return redirect()->route('user')->with('success', 'User updated successfully!');
            }else{
                User::addUser($data);
                return redirect()->route('user')->with('success', 'User created successfully!');
            }
        }catch(Exception $e){
            dd($e);
        }        
    }

    public function delete($user_id){
        $deleteUser = User::where('id', $user_id)->delete();
        if($deleteUser){
            return redirect()->route('user')->with('success', 'user deleted successfully!');
        }else{
            return redirect()->route('user')->with('error', 'user not deleted successfully!');
        }
    }

    public function deleteMultiSelection(Request $request){
        $userList = $request->input('userList');
        if($userList){
            foreach ($userList as $value) {
                $user_id = (int)$value;
                User::where('id', $user_id)->delete();
            }
            $json = [
                'success' => 1,
                'message' => "User deleted successfully"
            ];
            return response()->json($json);
        }else{
            $json = [
                'error' => 1,
                'message' => "You must select a user to delete."
            ];
            return response()->json($json);
        }
    }
}
