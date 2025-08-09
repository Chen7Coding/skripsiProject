<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        Product::create([
            'name' => 'Spanduk Custom',
            'slug' => 'spanduk-custom',
            'description' => 'Spanduk custom berkualitas tinggi, cocok untuk outdoor & indoor.',
            'price' => 25000,
            'image' => 'image/spanduk.png'
        ]);

        Product::create([
            'name' => 'Roll Banner',
            'slug' => 'roll-banner',
            'description' => 'Banner untuk keperluan dalam ruangan, hasil cetak tajam.',
            'price' => 50000,
            'image' => 'image/roll_banner.png'
        ]);

        Product::create([
            'name' => 'Stiker Vinyl & Cromo',
            'slug' => 'stiker-vinyl & cromo',
            'description' => 'Stiker bahan vinyl anti air, cocok untuk label kemasan.',
            'price' => 10000,
            'image' => 'image/stiker.png'
        ]);

         Product::create([
            'name' => 'ART Paper',
            'slug' => 'art-paper',
            'description' => 'Art Paper bahan jenis kertas yang permukaannya halus dan mengkilap (glossy).',
            'price' => 5000,
            'image' => 'image/art_paper.jpg'
        ]);
        Product::create([
            'name' => 'Bon & Nota',
            'slug' => 'bon-nota',
            'description' => 'Cetak buku Bon atau Nota suka-suka (custom) sesuai keinginan anda.',
            'price' => 15000,
            'image' => 'image/bon_nota.png'
        ]);
    }
}
