<?php

namespace App\Http\Controllers\Owner;

use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    /**
     * Tampilkan halaman pengaturan toko.
     */
    public function index()
    {
        // Mengambil data pengaturan yang pertama atau membuat data baru jika belum ada
        $setting = Setting::firstOrCreate([]);

        return view('owner.settings.index', compact('setting'));
    }

    /**
     * Perbarui data pengaturan toko.
     */
    public function update(Request $request)
    {
        // Validasi data yang masuk
        $request->validate([
            'store_name' => 'required|string|max:255',
            'store_email' => 'required|email|max:255',
            'store_contact' => 'required|string|max:255',
            'store_address' => 'required|string',
            'store_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Maksimal 2MB
        ]);

        $setting = Setting::first();
        $setting->update($request->except('store_logo'));

        // Cek jika ada file logo baru yang diunggah
        if ($request->hasFile('store_logo')) {
            // Hapus logo lama jika ada
            if ($setting->store_logo && Storage::disk('public')->exists($setting->store_logo)) {
                Storage::disk('public')->delete($setting->store_logo);
            }
            
            // Simpan logo baru dan dapatkan path-nya
            $path = $request->file('store_logo')->store('store_logos', 'public');
            $setting->update(['store_logo' => $path]);
        }

        return redirect()->route('owner.settings.index')->with('success', 'Pengaturan toko berhasil diperbarui.');
    }
}
