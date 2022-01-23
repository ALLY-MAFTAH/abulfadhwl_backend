<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function getAllUsers(){
        $users=User::all();

        return view('users')->with('users',$users);
    }
}
