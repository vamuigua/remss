<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Mail\ContactFormMail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class QuestionsController extends Controller
{
    public function index(){
        return view ('user.questions.index');
    }

    public function store(Request $request){
       // validate request
        $data = $request->validate([
            'subject' => 'required',
            'name' => 'required',
            'email' => 'required|email',
            'message' => 'required',
        ]);

        // dd($data);

        // Send email in a queue
        Mail::to('info.remss@gmail.com')->queue(new ContactFormMail($data));

        return redirect('/user/questions')->with('flash_message', 'Thank you for your message! We will get back to you through the email you provided');
    }
}
