<?php

namespace App\Http\Controllers\Tenant;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TenantController extends Controller
{
    public function index(){
        $user = Auth::user();
        return view ('tenant.dashboard', compact('user'));   
    }

    public function house(){
        $user = Auth::user();
        $house = $user->tenant->house;

        return view ('tenant.house', compact('house'));   
    }
}
