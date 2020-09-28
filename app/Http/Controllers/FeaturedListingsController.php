<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\HouseAdvert;
use App\Mail\ContactFormMail;
use App\Mail\HouseBookingRequestMail;
use Illuminate\Support\Facades\Mail;

class FeaturedListingsController extends Controller
{
    public function index()
    {
        $perPage = 20;
        $houseadverts = HouseAdvert::latest()->paginate($perPage);

        return view('static.featured-listings.index', compact('houseadverts'));
    }

    public function show($id)
    {
        $houseadvert = HouseAdvert::findOrFail($id);

        $images = $houseadvert->images;
        $images = explode(', ', $images);

        return view('static.featured-listings.show', compact('houseadvert', 'images'));
    }

    public function sendQuestion(Request $request, $id)
    {
        // validate request
        $data = $request->validate([
            'subject' => 'required',
            'name' => 'required',
            'email' => 'required|email',
            'message' => 'required',
        ]);

        // Send email in a queue
        Mail::to('info.remss@gmail.com')->queue(new ContactFormMail($data));

        return redirect('/featured-listings/' . $id)->with('main_flash_message', 'Thank you for your message! We will get back to you through the email you provided');
    }

    // send mail to sender & admin for a house request
    public function bookHouse(Request $request, $id)
    {
        // validate request
        $data = $request->validate([
            'subject' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'national_id' => 'required',
            'phone_no' => 'required|max:12',
            'agreement_checkbox' => 'required'
        ]);

        // Send Request for Booking House to Property Manager & Sender in a queue
        Mail::to('requests.remss@gmail.com')->queue(new HouseBookingRequestMail($data));
        Mail::to($data['email'])->queue(new HouseBookingRequestMail($data));

        // Make HouseAdvert booking_status == 'booked'
        $houseadvert = HouseAdvert::findOrFail($id);
        $houseadvert->booking_status = 'Booked';
        $houseadvert->save();

        return redirect('/featured-listings/' . $id)->with('main_flash_message', 'Thank you for your request! We will get back to you through the email or phone number you provided');
    }
}
