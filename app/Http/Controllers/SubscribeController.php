<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subscribe;
use Illuminate\Support\Facades\Mail;

class SubscribeController extends Controller
{
    // Menampilkan formulir berlangganan
    public function showForm()
    {
        return view('components.footer');
    }

    // Menangani pengiriman formulir berlangganan
    public function store(Request $request)
    {
        // Validasi input formulir
        $validatedData = $request->validate([
            'email' => 'required|email|unique:subscribes,email',
        ]);

        // Simpan data ke database
        Subscribe::create($validatedData);

        // Kirim email
        Mail::send('email.subscription', [
            'email' => $request->get('email')
        ], function($message) {
            $message->to(env('ADMIN_EMAIL', 'alerts@bidaneka.com'), 'Admin');
            $message->subject('Berlangganan baru telah diterima');
        });

        return back()->with('success', 'Terima kasih telah berlangganan!');
    }
}
