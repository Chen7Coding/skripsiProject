<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use App\Models\ProductAttribute;
use Illuminate\Support\Facades\Schema;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Menonaktifkan foreign key untuk membersihkan tabel
        Schema::disableForeignKeyConstraints();
        Product::truncate();
        ProductAttribute::truncate();
        Schema::enableForeignKeyConstraints();

        // --- Variabel Harga & Ukuran Referensi ---
        $hargaCetakPerSqm = [
            'Flexi China 300 gsm' => 20000,
            'Flexi China 270 gsm' => 17000,
            'Flexi China 440 gsm' => 35000,
            'Flexi Korea 300 gsm' => 30000,
            'Flexi Korea 270 gsm' => 25000,
            'Flexi Korea 440 gsm' => 45000,
            'Albartos 300 gsm' => 50000,
            'Albartos 270 gsm' => 45000,
            'Albartos 440 gsm' => 60000,
        ];
        
        $luasMeterPersegi = [
            '1x1 meter' => 1, '1x2 meter' => 2, '1x3 meter' => 3, '1x4 meter' => 4, '1x5 meter' => 5
        ];

        // --- Produk: Spanduk Custom (dihitung per meter persegi) ---
        $spanduk = Product::create([
            'name' => 'Spanduk Custom',
            'slug' => 'spanduk-custom',
            'description' => 'Spanduk custom berkualitas tinggi, cocok untuk outdoor & indoor.',
            'price' => 20000, 
            'price_per_sqm' => 20000,
            'image' => 'image/spanduk.png',
            'unit' => 'sqm'
        ]);
        
        foreach ($hargaCetakPerSqm as $material => $harga) {
            foreach ($luasMeterPersegi as $size => $m2) {
                $price = $harga * $m2;
                $spanduk->attributes()->create([
                    'material' => $material,
                    'size' => $size,
                    'price_modifier' => $price,
                ]);
            }
        }
        
        // --- Produk: X Banner ---
        $hargaTiang = 140000;
        $hargaCetakXBanner = [
            'Flexi China' => 60000,
            'Flexi Korea' => 70000,
            'Albartos' => 85000,
        ];
        $luasXBanner = [
            '60x160 cm' => 0.96, '80x200 cm' => 1.6, '85x200 cm' => 1.7, '100x200 cm' => 2,
        ];
        
        $bannerX = Product::create([
            'name' => 'X Banner',
            'slug' => 'x-banner',
            'description' => 'Banner untuk keperluan dalam ruangan, hasil cetak tajam.',
            'price' => 60000, 
            'image' => 'image/x_banner.png',
            'unit' => 'sqm'
        ]);

        foreach ($hargaCetakXBanner as $material => $harga) {
            foreach ($luasXBanner as $size => $m2) {
                $hargaCetak = $harga * $m2;

                $bannerX->attributes()->create([
                    'material' => "{$material} (Tanpa Tiang)",
                    'size' => $size,
                    'price_modifier' => $hargaCetak,
                ]);

                $bannerX->attributes()->create([
                    'material' => "{$material} (Dengan Tiang)",
                    'size' => $size,
                    'price_modifier' => $hargaCetak + $hargaTiang,
                ]);
            }
        }

        // --- Produk: Roll Banner ---
        $hargaRollBanner = 140000;
        $hargaCetakRollBanner = [
            'Flexi China' => 60000,
            'Flexi Korea' => 75000,
            'Albartos' => 85000,
        ];
        $ukuranRollBanner = ['60x160 cm', '80x200 cm', '85x200 cm', '100x200 cm'];
        
        $bannerRoll = Product::create([
            'name' => 'Roll Banner',
            'slug' => 'roll-banner',
            'description' => 'Banner untuk keperluan dalam ruangan, hasil cetak tajam.',
            'price' => 60000,
            'image' => 'image/roll_banner.png',
            'unit' => 'sqm'
        ]);

        foreach ($hargaCetakRollBanner as $material => $harga) {
            foreach ($ukuranRollBanner as $size) { // Perbaikan di sini
                $m2 = $luasXBanner[$size] ?? 1; // Mengambil luas dari X Banner
                $hargaCetak = $harga * $m2;

                $bannerRoll->attributes()->create([
                    'material' => "{$material} (Tanpa Tiang)",
                    'size' => $size,
                    'price_modifier' => $hargaCetak,
                ]);

                $bannerRoll->attributes()->create([
                    'material' => "{$material} (Dengan Tiang)",
                    'size' => $size,
                    'price_modifier' => $hargaCetak + $hargaRollBanner,
                ]);
            }
        }

        // --- Produk: Stiker Vinyl & Cromo (per m2) ---
        $hargaStiker = [
            'Vinyl' => 65000,
            'Cromo' => 30000,
        ];
        $ukuranStiker = ['1x1 meter', '1x2 meter', '1x3 meter', '1x4 meter', '1x5 meter'];
        
        $stiker = Product::create([
            'name' => 'Stiker Vinyl & Cromo',
            'slug' => 'stiker-vinyl-cromo',
            'description' => 'Stiker bahan vinyl anti air & stiker cromo ekonomis.',
            'price' => 65000,
            'price_per_sqm' => 65000,
            'image' => 'image/stiker.png',
            'unit' => 'sqm'
        ]);

        foreach ($hargaStiker as $material => $harga) {
            foreach ($ukuranStiker as $size) {
                $m2 = $luasMeterPersegi[$size];
                $stiker->attributes()->create([
                    'material' => $material,
                    'size' => $size,
                    'price_modifier' => ($harga * $m2),
                ]);
            }
        }
        
        // --- Produk: Art Paper (per lembar A3) ---
        $artPaper = Product::create([
            'name' => 'Art Paper',
            'slug' => 'art-paper',
            'description' => 'Art Paper adalah kertas halus dan mengkilap (glossy).',
            'price' => 5000,
            'price_per_sqm' => 5000,
            'image' => 'image/art_paper.jpg',
            'unit' => 'sheet'
        ]);

        $hargaArtPaper = [
            'A3' => ['120 gsm' => 5000, '150 gsm' => 6000, '210 gsm' => 7000, '260 gsm' => 8000, '310 gsm' => 9000],
            'A3+' => ['120 gsm' => 6000, '150 gsm' => 7000, '210 gsm' => 8000, '260 gsm' => 9000, '310 gsm' => 10000],
            'A4' => ['120 gsm' => 2500, '150 gsm' => 3500, '210 gsm' => 4500, '260 gsm' => 5500, '310 gsm' => 6500],
            'A5' => ['120 gsm' => 1250, '150 gsm' => 2250, '210 gsm' => 3250, '260 gsm' => 4250, '310 gsm' => 5250],
        ];

        foreach ($hargaArtPaper as $size => $gramasi) {
            foreach ($gramasi as $gsm => $harga) {
                $artPaper->attributes()->create([
                    'material' => "Art Paper {$gsm}",
                    'size' => $size,
                    'price_modifier' => $harga,
                ]);
            }
        }
        
        // --- Produk: Bon & Nota (per buku) ---
        $bonNota = Product::create([
            'name' => 'Bon & Nota',
            'slug' => 'bon-nota',
            'description' => 'Cetak buku Bon atau Nota suka-suka.',
            'price' => 15000,
            'price_per_sqm' => 15000,
            'image' => 'image/bon_nota.png',
            'unit' => 'book'
        ]);
        
        $bonNota->attributes()->createMany([
            ['material' => 'NCR 1 Ply', 'size' => 'A5 - 50 Lembar', 'price_modifier' => 15000],
            ['material' => 'NCR 2 Ply', 'size' => 'A5 - 50 Lembar', 'price_modifier' => 20000],
            ['material' => 'NCR 3 Ply', 'size' => 'A5 - 50 Lembar', 'price_modifier' => 25000],
            ['material' => 'NCR 1 Ply', 'size' => 'A5 - 100 Lembar', 'price_modifier' => 25000],
            ['material' => 'NCR 2 Ply', 'size' => 'A5 - 100 Lembar', 'price_modifier' => 30000],
            ['material' => 'NCR 3 Ply', 'size' => 'A5 - 100 Lembar', 'price_modifier' => 35000],
            ['material' => 'NCR 1 Ply', 'size' => 'A4 - 50 Lembar', 'price_modifier' => 25000],
            ['material' => 'NCR 2 Ply', 'size' => 'A4 - 50 Lembar', 'price_modifier' => 30000],
            ['material' => 'NCR 3 Ply', 'size' => 'A4 - 50 Lembar', 'price_modifier' => 35000],
            ['material' => 'NCR 1 Ply', 'size' => 'A4 - 100 Lembar', 'price_modifier' => 35000],
            ['material' => 'NCR 2 Ply', 'size' => 'A4 - 100 Lembar', 'price_modifier' => 40000],
            ['material' => 'NCR 3 Ply', 'size' => 'A4 - 100 Lembar', 'price_modifier' => 45000],
            ['material' => 'NCR Rim', 'size' => 'A5 - 1 Rim (500 lbr)', 'price_modifier' => 135000],
            ['material' => 'NCR Rim', 'size' => 'A4 - 1 Rim (500 lbr)', 'price_modifier' => 150000],
        ]);
    }
}