<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tenant;

class AdminController extends Controller
{
    public function index(){
        $tenants = Tenant::all();
        return view ('admin.dashboard', compact('tenants'));   
    }
}
