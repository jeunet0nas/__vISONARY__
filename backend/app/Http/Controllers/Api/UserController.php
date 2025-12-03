<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function store(StoreUserRequest $req){
        if($req->validated()){
            User::create($req->validated());
            return response()->json([
                'message' => "Tài khoản đã đăng kí thành công!"
            ]);
        }
    }

    public function auth(AuthUserRequest $req){
        if($req->validated()){
            $user = User::whereEmail($req->email)->first();
            if(!$user || !Hash::check($req->password, $user->password)){
                return response()->json([
                    'error' => "Thông tin đăng nhập sai. Vui lòng nhập lại!"
                ]);
            } else{
                return response()->json([
                    'user' => UserResource::make($user),
                    'access_token' => $user->createToken('new_user')->plainTextToken
                ]);
            }
        }
    }

    public function logout(Request $req){
        $req->user()->currentAccessToken()->delete();
        return response()->json([
            'message' => "Đăng xuất thành công!"
        ]);
    }

    public function UpdateUserProfile(Request $req){
        $req->validate([
            'profile_img' => 'image|mimes:png,jpg,jpeg|max:2048'
        ]);

        if($req->has('profile_img')){
            if(File::exists(asset($req->user()->profile_img))){
                File::delete(asset($req->user()->profile_img));
            }

            $file = $req->file('profile_img');
            $profile_img_name = time().'_'.$file->getClientOriginalName();
            $file->storeAs('images/users/', $profile_img_name, 'public');
            $req->user()->update([
                'profile_img' => 'storage/images/users/'.$profile_img_name
            ]);

            return response()->json([
                'message' => 'Ảnh đã được cập thành công',
                'user' => UserResource::make($req->user())
            ]);
        } else{
            $req->user()->update([
                'email' => $req->email,
                'city' => $req->city,
                'province' => $req->province,
                'address' => $req->address,
                'phone_number' => $req->phone_number,
                'profile_completed' => 1
            ]);

            return response()->json([
                'message' => 'Thông tin cá nhân đã được cập nhật!',
                'user' => UserResource::make($req->user())
            ]);
        }
    }
}
