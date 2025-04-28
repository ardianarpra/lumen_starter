<?php

namespace Database\Seeders;

use App\Models\GawatDarurat;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class GawatDaruratSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        for ($i = 0; $i < 5; $i++) {
            GawatDarurat::create([
                'jenis_gawat_darurat' => $faker->randomElement(['Gawat Kebakaran', 'Gawat Kecelakaan', 'Gawat Kesehatan', 'Gawat Kebencanaan']),
                'nama_pelapor' => $faker->name,
                'telp_pelapor' => '08' . $faker->unique()->numerify('##########'),
                'latitude' => number_format($faker->latitude(-90, 90), 8),
                'longitude' => number_format($faker->longitude(-180, 180), 8),
                'penilaian' => $faker->randomElement([1, 2, 3]),
                'keterangan_penilaian' => $faker->sentence(),
            ]);
        }
    }
}
