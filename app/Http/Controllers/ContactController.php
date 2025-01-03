<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function show()
    {
        return view('contact');
    }

    public function submit(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'message' => 'required',
            'g-recaptcha-response' => 'required|captcha',
        ]);
        Mail::send('emails.contact', ['data' => $request->all()], function ($message) use ($request) {
            $message->to('sarifat60@gmail.com')
                    ->subject('Contact Form Submission')
                    ->replyTo($request->email);
        });


    }
}
