<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ServiceSeeder extends Seeder
{
    protected array $services = [
        [
            'title' => 'Periksa Kehamilan',
            'description' => 'Pemeriksaan rutin untuk memantau kesehatan ibu dan janin. Termasuk pemeriksaan tekanan darah, berat badan, detak jantung janin, dan pemeriksaan fisik umum.',
            'price' => 200000,
        ],
        [
            'title' => 'Suntik Keluarga Berencana',
            'description' => 'Layanan kontrasepsi suntik untuk mencegah kehamilan. Termasuk konseling sebelum dan sesudah penyuntikan.',
            'price' => 150000,
        ],
        [
            'title' => 'Imunisasi',
            'description' => 'Pemberian vaksin untuk bayi dan anak-anak untuk mencegah berbagai penyakit',
            'price' => 150000,
        ],
        [
            'title' => 'Pijat Bayi',
            'description' => 'Pijat',
            'price' => 50000,
        ],
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        foreach ($this->services as $service) {
            $imagePath = $faker->image('public/media/services', 640, 480, null, false);

            Service::create([
                'title' => $service['title'],
                'description' => $service['description'],
                'photo' => $imagePath,
                'price' => $service['price'],
            ]);
        }
    }
}
