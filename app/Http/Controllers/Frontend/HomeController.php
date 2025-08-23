<?php

namespace App\Http\Controllers\Frontend;

use Carbon\Carbon;
use App\Models\Promo;
use App\Models\Product;
use App\Mail\KontakMail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
            public function index()
        {
            $products = Product::all();
            
            // Mengambil SATU promo pertama yang aktif
            $promo = Promo::where('is_active', true)
                            ->where('end_date', '>=', Carbon::now())
                            ->first(); // <-- Pastikan menggunakan first(), bukan get()

            return view('home', [
                'products' => $products,
                'promo' => $promo // <-- Pastikan nama variabelnya 'promo' (tunggal)
            ]);
        }
        public function about()
    {
        return view('about');
    }

        public function contact()
    {
        return view('contact');
    }

    /**
     * Proses pengiriman form kontak.
     */
    public function kirimPesan(Request $request)
    {
        // 1. Validasi Data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'topic' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        try {
            // 2. Kirim Email
            // Gunakan Mail::to() untuk mengirim email ke alamat tujuan
            Mail::to('sidudigitalprintmajalaya@gmail.com')->send(new KontakMail($validatedData));

            // 3. Berikan respons sukses dan arahkan kembali
            return redirect()->back()->with('success', 'Pesan Anda berhasil terkirim. Terima kasih!');

        } catch (\Exception $e) {
            // Tangani error jika pengiriman email gagal
            return redirect()->back()->with('error', 'Maaf, pesan Anda gagal terkirim. Silakan coba lagi.');
        }
    }

}
