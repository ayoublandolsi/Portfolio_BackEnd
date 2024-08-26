<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\ContactFormEmail;
use App\Models\Contact;
use Mail;
use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        try {
            // Validate the form data
            $validatedData = $request->validate([
                'name' => 'required|string',
                'email' => 'required|email',
                'message' => 'required|string',
            ]);

            // Store the contact in the database
            $contact = Contact::create($validatedData);

            // Send the email
            Mail::to('ayoublandolsie@gmail.com')->send(new ContactFormEmail($contact));

            return response()->json(['message' => 'true'], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while sending the message.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
