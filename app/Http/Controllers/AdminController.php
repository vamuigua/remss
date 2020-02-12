<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tenant;
use App\House;

class AdminController extends Controller
{
    public function index(){
        $houses = House::all();
        $tenants = Tenant::all();
        return view ('admin.dashboard', compact('tenants', 'houses'));   
    }
}
