<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    /**
     * Menampilkan halaman utama profil.
     */
    public function dashboard()
    {
        return view('profile.pelanggan_dashboard');
    }

    /**
     * Menampilkan halaman pesanan pengguna.
     */
    public function orders()
    {
        $orders = Order::with('orderItems.product')
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('profile.orders', compact('orders'));
    }

    /**
     * Menampilkan form edit profil.
     */
    public function edit()
    {
        // PERBAIKAN: Kirim data user yang sedang login ke view
        return view('profile.edit', ['user' => Auth::user()]);
    }

    /**
     * Memproses pembaruan profil (biodata & foto).
     */
    public function update(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $dataToUpdate = $request->only(['name', 'username', 'email', 'phone', 'address']);

        // PERBAIKAN: Logika untuk menangani upload foto baru
        if ($request->hasFile('photo')) {
            // Hapus foto lama jika ada
            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
            }
            // Simpan foto baru dan dapatkan path-nya
            $dataToUpdate['photo'] = $request->file('photo')->store('photos', 'public');
        }

        $user->update($dataToUpdate);

        // Arahkan kembali ke halaman edit dengan pesan sukses
        return redirect()->route('profile.edit')->with('success', 'Profil berhasil diperbarui!');
    }
    
    // ===================================================
    // ============== FUNGSI BARU UNTUK PASSWORD =========
    // ===================================================

    /**
     * Menampilkan halaman form untuk mengubah password.
     */
    public function editPassword()
    {
        return view('profile.passwordCustomer'); // Anda perlu membuat view ini
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
