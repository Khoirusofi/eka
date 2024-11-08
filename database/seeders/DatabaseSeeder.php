<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(UserSeeder::class);
        $this->call(PatientSeeder::class);
        $this->call(ServiceSeeder::class);
        $this->call(PaymentSeeder::class);
        $this->call(AppointmentSeeder::class);
        $this->call(ArticleSeeder::class);
        $this->call(PhotoSeeder::class);
        $this->call(DiagnosisSeeder::class);
        $this->call(HeroSeeder::class);
        $this->call(SettingSeeder::class);
        $this->call(CategorySeeder::class);
    }
}
