<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class GawatDaruratKategoriPenilaianPivotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        for ($i = 0; $i < 10; $i++) {
            DB::table('gd_kategori_penilaian_pivot')->insert([
                'gawat_darurat_id' => $faker->randomElement([1, 2, 3, 4, 5]),
                'kategori_penilaian_id' => $faker->randomElement([1, 2, 3, 4, 5, 6, 7, 8, 9, 10]),
            ]);
        }
    }
}
