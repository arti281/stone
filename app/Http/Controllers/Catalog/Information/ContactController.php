<?php

namespace App\Http\Controllers\Catalog\Information;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\Contact;
use App\Mail\ContactMail;

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
      'name' => 'required|string|max:255',
        'email' => 'required|email',
        'mobile' => [
            'required',
            'regex:/^[6-9][0-9]{9}$/', // Indian mobile numbers
        ],
        'message' => 'required',
    ]);
           
       $data = $request->only(['name', 'email', 'mobile', 'message']);

    // ✅ Save to database
    Contact::create($data);

    // ✅ Send email
    Mail::to('pstonearts02@gmail.com')->send(new ContactMail($data));

    return back()->with('success', 'Your message has been sent and saved!');
    }
}