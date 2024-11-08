<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use Illuminate\Support\Facades\Mail;

class ContactUsFormController extends Controller
{
    // Create Contact Form
    public function createForm(Request $request)
    {
        return view('welcome');
    }

    public function contactUsForm(Request $request) {
        $validatedData = $request->validate([
            'email' => 'required|email',
            'subject' => 'required',
            'message' => 'required'
        ]);

        Contact::create($validatedData);
        Mail::send('email.contact', [
            'email' => $request->get('email'),
            'subject' => $request->get('subject'),
            'messageContent' => $request->get('message'),
        ], function($message) use ($request) {
            $message->from($request->get('email'));
            $message->to(env('ADMIN_EMAIL', 'alerts@bidaneka.com'), 'Admin');
            $message->subject('Pesan baru dari Website Bidan Eka Muzaifa');
        });
        return back()->with('success', 'Pesan Anda telah berhasil dikirim. Terima kasih telah menghubungi kami.');
    }
    
}
