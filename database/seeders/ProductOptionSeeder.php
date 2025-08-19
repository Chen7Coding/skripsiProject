<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductOptionSeeder extends Seeder
{
    /**
     * Jalankan seed untuk mengisi tabel product_options.
     *
     * @return void
     */
    public function run()
    {
        // Hapus data lama untuk mencegah duplikasi saat seeding ulang
        DB::table('product_options')->truncate();

        // Opsi untuk SPANDUK / BANNER
        DB::table('product_options')->insert([
            // Bahan
            ['product_id' => 1, 'option_type' => 'material', 'value' => 'Flexi China 280 gsm', 'price_modifier' => 0],
            ['product_id' => 1, 'option_type' => 'material', 'value' => 'Flexi Korea 340 gsm', 'price_modifier' => 5000],
            ['product_id' => 1, 'option_type' => 'material', 'value' => 'Albatros', 'price_modifier' => 10000],
            // Ukuran
            ['product_id' => 1, 'option_type' => 'size', 'value' => '1x1 meter', 'price_modifier' => 0],
            ['product_id' => 1, 'option_type' => 'size', 'value' => '1x2 meter', 'price_modifier' => 5000],
            ['product_id' => 1, 'option_type' => 'size', 'value' => '1x3 meter', 'price_modifier' => 10000],
            ['product_id' => 1, 'option_type' => 'size', 'value' => 'Roll Banner 60x160cm', 'price_modifier' => 15000],
            ['product_id' => 1, 'option_type' => 'size', 'value' => 'Roll Banner 80x200cm', 'price_modifier' => 20000],
        ]);
        
        // Opsi untuk ART PAPER / BROSUR
        DB::table('product_options')->insert([
            // Bahan
            ['product_id' => 2, 'option_type' => 'material', 'value' => 'Art Paper 120 gsm', 'price_modifier' => 0],
            ['product_id' => 2, 'option_type' => 'material', 'value' => 'Art Carton 210 gsm', 'price_modifier' => 2000],
            ['product_id' => 2, 'option_type' => 'material', 'value' => 'Art Carton 260 gsm', 'price_modifier' => 3000],
            // Ukuran
            ['product_id' => 2, 'option_type' => 'size', 'value' => 'A3', 'price_modifier' => 0],
            ['product_id' => 2, 'option_type' => 'size', 'value' => 'A4', 'price_modifier' => -500],
            ['product_id' => 2, 'option_type' => 'size', 'value' => 'A5', 'price_modifier' => -1000],
            // Finishing
            ['product_id' => 2, 'option_type' => 'finishing', 'value' => 'Doff Laminating', 'price_modifier' => 1000],
            ['product_id' => 2, 'option_type' => 'finishing', 'value' => 'Glossy Laminating', 'price_modifier' => 1000],
        ]);
        
        // Opsi untuk STIKER CROMO & VINYL
        DB::table('product_options')->insert([
            // Bahan
            ['product_id' => 3, 'option_type' => 'material', 'value' => 'Stiker Cromo', 'price_modifier' => 0],
            ['product_id' => 3, 'option_type' => 'material', 'value' => 'Stiker Vinyl', 'price_modifier' => 2000],
            ['product_id' => 3, 'option_type' => 'material', 'value' => 'Stiker Transparan', 'price_modifier' => 3000],
            // Ukuran
            ['product_id' => 3, 'option_type' => 'size', 'value' => 'A3', 'price_modifier' => 0],
            ['product_id' => 3, 'option_type' => 'size', 'value' => 'A4', 'price_modifier' => -500],
            ['product_id' => 3, 'option_type' => 'size', 'value' => 'F4', 'price_modifier' => -200],
        ]);
    }
}