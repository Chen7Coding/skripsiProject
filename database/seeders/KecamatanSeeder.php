<?php

namespace Database\Seeders;

use App\Models\Kecamatan; // <-- Jangan lupa tambahkan ini
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KecamatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $kecamatans = [
            ['name' => 'Baleendah', 'shipping_cost' => 10000],
            ['name' => 'Bojongsoang', 'shipping_cost' => 8000],
            ['name' => 'Cicalengka', 'shipping_cost' => 15000],
            ['name' => 'Cikancung', 'shipping_cost' => 15000],
            ['name' => 'Cileunyi', 'shipping_cost' => 12000],
            ['name' => 'Ciparay', 'shipping_cost' => 12000],
            ['name' => 'Dayeuhkolot', 'shipping_cost' => 8000],
            ['name' => 'Ibun', 'shipping_cost' => 18000],
            ['name' => 'Majalaya', 'shipping_cost' => 15000],
            ['name' => 'Pacet', 'shipping_cost' => 18000],
            ['name' => 'Paseh', 'shipping_cost' => 18000],
            ['name' => 'Rancaekek', 'shipping_cost' => 12000],
            ['name' => 'Solokanjeruk', 'shipping_cost' => 15000],
        ];

        foreach ($kecamatans as $kecamatan) {
            Kecamatan::create($kecamatan);
        }
    }
}