<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Promo;
use Carbon\Carbon;

class PromoController extends Controller
{
    public function index()
    {
        // Ambil semua promo yang aktif dan belum kadaluarsa
        $promos = Promo::where('is_active', true)
                       ->where('end_date', '>=', Carbon::now())
                       ->get();
        
        return view('promo', compact('promos'));
    }
}