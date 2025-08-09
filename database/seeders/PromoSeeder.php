<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Promo;
use Carbon\Carbon;

class PromoSeeder extends Seeder
{
    public function run(): void
    {
        Promo::create([
            'title' => 'Promo Cetak Spanduk Merdeka!',
            'description' => 'Dapatkan diskon 17% untuk cetak spanduk outdoor dalam rangka menyambut hari kemerdekaan. Syarat dan ketentuan berlaku.',
            'image' => 'image/merdeka_promo.png',
            'start_date' => Carbon::now()->startOfMonth(),
            'end_date' => Carbon::now()->endOfMonth(),
            'is_active' => true
        ]);
    }
}
