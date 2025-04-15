<?php

namespace App\Models\Admin\Users;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class User extends Model
{
    use HasApiTokens, HasFactory, Notifiable;
    
    protected $table = 'users';
    
    protected $fillable = ['name','email','email_verified_at','number','number_verified_at','password','user_group_id','status','ip'];

    public static function addUser($data = array()){
        if($data){
            $user = DB::table((new self())->getTable())->insert([
                "user_group_id" => $data['user_group_id'] ?? 0,
                "name" => $data['user_name'] ?? '',
                "email" => $data['email'] ?? '',
                "number" => $data['number'] ?? '',
                "password" => Hash::make($data['password']) ?? null,
                "email_verified_at" => null,
                "number_verified_at" => null,
                "status" => $data['status'] ?? 0,
                "image" => isset($data['image']) ? $data['image'] : '',
                "created_at" => now(),
                "updated_at" => now()
            ]);

            if($user){
                return true;
            }else{
                return false;
            }
        }
    }

    public static function updateUser(int $user_id, $data = array()){
        if (!empty($data)) {
            $updateData = [
                "user_group_id" => $data['user_group_id'] ?? 0,
                "name" => $data['user_name'] ?? '',
                "email" => $data['email'] ?? '',
                "number" => $data['number'] ?? '',
                "status" => $data['status'] ?? 0,
                "updated_at" => now()
            ];
    
            if (isset($data['password'])) {
                $updateData['password'] = Hash::make($data['password']);
            }
    
            if (isset($data['image'])) {
                $updateData['image'] = $data['image'];
            }
    
            // Perform the update
            DB::table((new self())->getTable())->where('id', $user_id)->update($updateData);
    
            return true;
        }
        return false;
    }

    public static function getUserByEmail($email = null){
        $user = DB::table((new self())->getTable())->where('email', $email)->get()->first();
        return $user;
    }

    public static function getUserById($user_id = null){
        $user = DB::table((new self())->getTable())->where('id', $user_id)->get()->first();
        return $user;
    }

    public static function getUsers($request = null){
        // Start the query using Eloquent
        $query = self::query();

        // Apply filters based on the request
        if ($request) {
            if ($request->filled('user_name')) {
                $query->where('name', 'like', '%' . $request->query('user_name') . '%');
            }
            if ($request->filled('email')) {
                $query->where('email', 'like', '%' . $request->query('email') . '%');
            }
            if ($request->filled('contact')) {
                $query->where('number', 'like', '%' . $request->query('contact') . '%');
            }
            if ($request->filled('status')) {
                $query->where('status', $request->query('status'));
            }
        }

        // Execute the query and get the results
        return $query->get();
    }

    public static function deleteUser($user_id){
        $user = DB::table((new self())->getTable())->where('id', $user_id)->get()->first();
        if($user && $user->image){
            $imageName = $user->image;
            $imagePath = public_path('image/user/') . $imageName;
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }
        DB::table((new self())->getTable())->where('id', $user_id)->delete();
        return true;
    }

}
