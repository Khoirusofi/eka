<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
{
    Setting::updateOrCreate([
        'id' => 1
    ], [
        'is_open' => true // Atur default status buka
    ]);
}
}
