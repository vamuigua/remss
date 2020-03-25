<?php

namespace App\Http\Controllers\User;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UsersController extends Controller
{
    public function index(){
        $user = Auth::user();
        return view ('user.dashboard', compact('user'));   
    }

    public function house(){
        $user = Auth::user();
        $house = $user->tenant->house;

        return view ('user.house', compact('house'));   
    }
}
