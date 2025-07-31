<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Location; // Import model Location

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Location::create([
            'name' => 'PT. SchoolTech Indonesia',
            'latitude' => -7.940561, // Contoh: koordinat dekat Politeknik Negeri Malang
            'longitude' => 112.617887, // Ganti dengan koordinat akurat PT. SchoolTech
            'radius_km' => 0.1, // 100 meter
        ]);
        // Anda bisa menambahkan lokasi lain di sini jika ada cabang
    }
}
