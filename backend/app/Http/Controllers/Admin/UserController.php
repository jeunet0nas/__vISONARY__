<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(){
        return view('admin.users.index')->with([
            'users' => User::latest()->get()
        ]);
    }

    public function destroy(User $user){
        $user->delete();
        return redirect()->route('admin.users.index')->with([
            'success' => 'Người dùng đã được xóa thành công!'
        ]);
    }
}
