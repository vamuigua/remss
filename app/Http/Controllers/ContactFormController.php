<?php

namespace App\Http\Controllers;

use App\Mail\ContactFormMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactFormController extends Controller
{
    public function index(){
        return view('static.contact.index');
    }

    // sends message from contact form
    public function store(Request $request){
        // validate request
        $data = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'message' => 'required',
        ]);

        // Send email
        Mail::to('info.remss@gmail.com',)->send(new ContactFormMail($data));

        return redirect('/contact')->with('main_flash_message', 'Thank you for your message! We will get back to you through the email you provided');
    }
}
