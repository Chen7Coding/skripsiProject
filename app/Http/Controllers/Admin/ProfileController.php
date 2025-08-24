<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User; // Pastikan use statement ini ada
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class AdminProfileController extends Controller
{
    /**
     * Menampilkan form edit profil admin.
     */
    public function edit()
    {
        // Mengarah ke view 'admin.profile.edit'
        return view('admin.profile.edit', ['user' => Auth::user()]);
    }

    /**
     * Memproses pembaruan profil admin.
     */
    public function update(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Validasi lengkap sesuai form
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);
                
        // Inisialisasi array data yang akan diupdate
        $dataToUpdate = $request->only(['name', 'username', 'email', 'phone', 'address']);
        

        // Menangani upload foto
        if ($request->hasFile('photo')) {
            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
            }
            $dataToUpdate['photo'] = $request->file('photo')->store('photos', 'public');
        }

        // Lakukan SATU KALI update
        $user->update($dataToUpdate);

        // Arahkan kembali ke halaman edit dengan pesan sukses
        return redirect()->route('admin.profile.edit')->with('success', 'Profil berhasil diperbarui!');
    }
    /**
     * Menampilkan halaman form untuk mengubah password.
     */
    public function editPassword()
    {
        // Mengarah ke view 'admin.profile.password'
        return view('admin.profile.password');
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
