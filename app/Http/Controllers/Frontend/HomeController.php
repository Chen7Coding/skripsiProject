<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Promo;
use Carbon\Carbon;

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

}
