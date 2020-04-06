<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\HouseAdvert;
use App\Mail\ContactFormMail;
use Illuminate\Support\Facades\Mail;

class FeaturedListingsController extends Controller
{
    public function index(){
        $perPage = 25;
        $houseadverts = HouseAdvert::latest()->paginate($perPage);

        return view('static.featured-listings.index', compact('houseadverts'));
    }

    public function show($id){
        $houseadvert = HouseAdvert::findOrFail($id);

        $images = $houseadvert->images;
        $images = explode(', ', $images);

        return view('static.featured-listings.show', compact('houseadvert', 'images'));
    }

    public function sendQuestion(Request $request, $id){
       // validate request
        $data = $request->validate([
            'subject' => 'required',
            'name' => 'required',
            'email' => 'required|email',
            'message' => 'required',
        ]);

        // Send email in a queue
        Mail::to('info.remss@gmail.com')->queue(new ContactFormMail($data));

        return redirect('/featured-listings/'.$id)->with('main_flash_message', 'Thank you for your message! We will get back to you through the email you provided');
    }
}
