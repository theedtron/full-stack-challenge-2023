<?php

namespace App\Http\Controllers;

use App\Role;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function index(){
        $users = User::query()->with('roles')->get();
        // print_r($users);exit;

        return view('user.index', compact('users'));
    }

    public function create(){
        $roles = Role::all();
        return view('user.add',compact('roles'));
    }

    public function post(Request $request){
        $this->validate($request,[
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $user->roles()->attach($request->role);

        return redirect('users');
    }

    public function delete($id){
        $user = User::query()->where('id',$id)->first();
        $user->delete();

        return redirect('users');
    }

    public function ban($id){
        $user = User::query()->where('id',$id)->first();
        $user->is_banned = 1;
        $user->save();

        return redirect('users');
    }

    public function unban($id){
        $user = User::query()->where('id',$id)->first();
        $user->is_banned = 0;
        $user->save();

        return redirect('users');
    }
}
