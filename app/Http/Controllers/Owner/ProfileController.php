<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\User; // Pastikan use statement ini ada
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    /**
     * Menampilkan form edit profil pemilik.
     */
    public function edit()
    {
        // Mengarah ke view 'editOwner'
        return view('owner.profile.editOwner', ['user' => Auth::user()]);
    }

    /**
     * Memproses pembaruan profil pemilik.
     */
    public function update(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Validasi lengkap sesuai form
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
           'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id, 'regex:/^[^@]+@gmail\.com$/i'],
            'phone' => ['nullable', 'string', 'max:20', 'regex:/^(\+62|0)[0-9]{8,15}$/'],
            'address' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'phone.regex' => 'Format nomor telepon tidak valid. Gunakan format yang benar.',
            'email.regex' => 'Email harus menggunakan domain Gmail (@gmail.com).',
        ]);

        // Mengambil semua data yang relevan dari request
        $dataToUpdate = $request->only(['name', 'username', 'email', 'phone', 'address']);

        if ($request->has('remove_photo') && $request->input('remove_photo') == 'true') {
            // Hapus foto lama dari storage
            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
            }
            $dataToUpdate['photo'] = null; // Set kolom photo menjadi NULL di database
        }
        // Menangani upload foto
       elseif ($request->hasFile('photo')) {
            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
            }
            $dataToUpdate['photo'] = $request->file('photo')->store('photos', 'public');
        }

        $user->update($dataToUpdate);

        // Arahkan kembali ke halaman edit dengan pesan sukses
        return redirect()->route('owner.profile.edit')->with('success', 'Profil berhasil diperbarui!');
    }

    /**
     * Menampilkan halaman form untuk mengubah password.
     */
    public function editPassword()
    {
        // Mengarah ke view 'passwordOwner'
        return view('owner.profile.passwordOwner');
    }

    /**
     * Memproses dan menyimpan password baru.
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();
        $user->password = Hash::make($request->password);
        $user->save();

        return back()->with('success', 'Password berhasil diubah!');
    }
}
