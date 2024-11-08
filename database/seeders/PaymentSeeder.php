<?php

namespace Database\Seeders;

use App\Models\Payment;
use Illuminate\Database\Seeder;

class PaymentSeeder extends Seeder
{
    protected array $payments = [
        [
            'account' => 'Bank BNI Transfer',
            'description' => 'Metode Pembayaran menggunakan Bank BNI Transfer',
            'number' => '1234567890',
        ],
        [
            'account' => 'Bank BRI Transfer',
            'description' => 'Metode Pembayaran menggunakan Bank BRI Transfer',
            'number' => '1234567890',
        ],
        [
            'account' => 'Bank BCA Transfer',
            'description' => 'Metode Pembayaran menggunakan Bank BCA Transfer',
            'number' => '1234567890',
        ],
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->payments as $payment) {
            Payment::factory()->create([
                'account' => $payment['account'],
                'description' => $payment['description'],
                'number' => $payment['number'],
            ]);
        }
    }
}
