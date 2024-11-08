<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    // Menampilkan daftar pengaturan dan formulir untuk memperbarui pengaturan
    public function index(Request $request)
    {
        $status = $request->input('status');
        $settingsQuery = Setting::query();

        if ($status !== null) {
            $settingsQuery->where('is_open', $status);
        }

        $settings = $settingsQuery->paginate(10); // Atur jumlah item per halaman sesuai kebutuhan

        $statuses = [1 => 'Buka', 0 => 'Tutup']; // Contoh status yang tersedia
        return view('admins.settings.index', compact('settings', 'statuses', 'status'));
    }

    // Menampilkan formulir untuk mengedit pengaturan yang ada
    public function edit(Setting $setting)
    {
        return view('admins.settings.edit', compact('setting'));
    }

    // Memperbarui pengaturan yang ada
    public function update(Request $request, Setting $setting)
    {
        $validated = $request->validate([
            'is_open' => 'required|boolean'
        ]);

        $setting->update($validated);

        return redirect()->route('admins.settings.index')->with('success', 'Pengaturan berhasil diperbarui.');
    }
}
