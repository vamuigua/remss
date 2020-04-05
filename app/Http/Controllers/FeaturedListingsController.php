<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\HouseAdvert;

class FeaturedListingsController extends Controller
{
    public function index(){
        $perPage = 25;
        $houseadverts = HouseAdvert::latest()->paginate($perPage);

        return view('static.featured-listings.index', compact('houseadverts'));
    }
}
