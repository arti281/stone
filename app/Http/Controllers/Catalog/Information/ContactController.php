<?php

namespace App\Http\Controllers\Catalog\Information;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\Contact;

class ContactController extends Controller
{   
public function show()
    {
        return view('catalog.information.contactus');
    }

    public function submit(Request $request)
    {
        // 1. Validate
        $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email',
            'Mobile' => 'required',
            'message' => 'required|min:10',
        ]);
           
        Contact::create($request->only(['name', 'email', 'mobile', 'message']));
        // 2. Send email
        // Mail::raw("Message from: {$request->name}\nEmail: {$request->email}\n\n{$request->message}", function ($msg) use ($request) {
        //     $msg->to('pstonearts02@gmail.com')
        //         ->subject($request->subject)
        //         ->replyTo($request->email);
        // });
        

        // 3. Redirect with success
        return back()->with('success', 'Thanks for contacting us!');
    }
}