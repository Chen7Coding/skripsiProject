<?php

namespace Database\Seeders;

use App\Models\Kecamatan; // <-- Pastikan model Kecamatan sudah diimpor
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class KecamatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Hapus data lama untuk menghindari duplikasi saat seeder dijalankan ulang
        Kecamatan::truncate();

        $kecamatans = [
            ['name' => 'Baleendah', 'shipping_cost' => 19000],
            ['name' => 'Bojongsoang', 'shipping_cost' => 23000],
            ['name' => 'Cicalengka', 'shipping_cost' => 14000],
            ['name' => 'Cikancung', 'shipping_cost' => 12000],
            ['name' => 'Cileunyi', 'shipping_cost' => 20000],
            ['name' => 'Ciparay', 'shipping_cost' => 8000],
            ['name' => 'Ibun', 'shipping_cost' => 4000],
            ['name' => 'Majalaya', 'shipping_cost' => 2000],
            ['name' => 'Pacet', 'shipping_cost' => 13000],
            ['name' => 'Paseh', 'shipping_cost' => 2000],
            ['name' => 'Rancaekek', 'shipping_cost' => 13000],
            ['name' => 'Solokanjeruk', 'shipping_cost' => 6000],
        ];

        foreach ($kecamatans as $kecamatan) {
            Kecamatan::create($kecamatan);
        }
    }
}