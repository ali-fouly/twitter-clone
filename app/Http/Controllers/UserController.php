<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\User;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['search']]);
    }

    public function search(){

    	$users = User::where('name', 'LIKE', '%'. request('name') .'%')->get();
        
        return response([
            'data' => $users
        ]);

    }

    public function follow(){

        $user = User::where('name', request('user'))->first();

        foreach (Auth::user()->followings as $following) {
            if($following->id == $user->id){
                Auth::user()->followings()->detach($user->id);

                return response([
                    'message' => Auth::user()->name . ' unfollowed ' . request('user'),
                    'status' => '200'
                ]);
            }
        }

    	Auth::user()->followings()->attach($user->id);

        return response([
                'message' => Auth::user()->name . ' started following ' . request('user'),
                'status' => '200'
        ]);

    }
}
