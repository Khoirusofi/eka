<?php

namespace Database\Factories;

use App\Models\Appointment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Diagnosis>
 */
class DiagnosisFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $appointment = Appointment::all()
            ->where('status', 'finished')
            ->random();
            return [
                'detail' => '
                    <strong>I. Identitas Pasien:</strong><br>
                    Nama: ' . ($appointment ? $appointment->patient->user->name : 'Nama Tidak Diketahui') . '<br>
                    Tanggal Lahir: '. ($appointment ? $appointment->patient->birth_date : 'Nama Tidak Diketahui'). '<br>
                    NIK: '. ($appointment ? $appointment->patient->nik : 'Nama Tidak Diketahui'). '<br>
                    Alamat: '. ($appointment ? $appointment->patient->address : 'Nama Tidak Diketahui'). '<br>
                    No. Telp/HP: '. ($appointment ? $appointment->patient->phone : 'Nama Tidak Diketahui'). '<br><br>
                    
                    <strong>II. Data Kehamilan:</strong><br>
                    Tanggal Pemeriksaan: 10 Agustus 2024<br>
                    Umur Kehamilan: 28 Minggu<br>
                    Gravida: 2<br>
                    Para: 1<br>
                    Aborsi: 0<br><br>
                    
                    <strong>III. Keluhan Utama:</strong><br>
                    Nyeri punggung bawah<br>
                    Sering kram perut<br>
                    Sesak napas ringan<br><br>
                    
                    <strong>IV. Riwayat Kesehatan:</strong><br>
                    Riwayat Penyakit Sebelumnya: Tidak ada penyakit kronis<br>
                    Riwayat Kesehatan Keluarga: Tidak ada penyakit keturunan<br>
                    Riwayat Alergi: Tidak ada alergi yang diketahui<br>
                    Riwayat Kehamilan Sebelumnya: Kehamilan pertama, melahirkan secara normal<br><br>
                    
                    <strong>V. Pemeriksaan Fisik:</strong><br>
                    Tekanan Darah: 110/70 mmHg<br>
                    Berat Badan: 70 kg<br>
                    Tinggi Badan: 160 cm<br>
                    Pemeriksaan Abdomen: Perut membesar sesuai umur kehamilan, tidak ada nyeri tekan<br>
                    Pemeriksaan Jantung: Irama jantung normal, tidak ada murmur<br>
                    Pemeriksaan Paru: Pernapasan normal, tidak ada wheezing<br><br>
                    
                    <strong>VI. Pemeriksaan Obstetri:</strong><br>
                    Denyut Jantung Janin: 140 bpm<br>
                    Ukuran Rahim: Tinggi fundus uteri 28 cm<br>
                    Posisi Janin: Kepala di bawah, posisi cephalic<br>
                    Tindakan Khusus: Tidak ada tindakan khusus<br><br>
                    
                    <strong>VII. Laboratorium dan Pemeriksaan Penunjang:</strong><br>
                    Hasil Laboratorium: Hemoglobin 12 g/dL, Glukosa darah normal<br>
                    Pemeriksaan Penunjang: USG menunjukkan janin dalam posisi yang baik dan perkembangan normal<br><br>
                    
                    <strong>VIII. Diagnosis:</strong><br>
                    Kehamilan 28 minggu, dalam keadaan baik<br>
                    Keluhan nyeri punggung bawah mungkin terkait dengan perubahan fisik selama kehamilan<br><br>
                    
                    <strong>IX. Rencana Tindak Lanjut:</strong><br>
                    Jadwal Pemeriksaan Berikutnya: 24 Agustus 2024<br>
                    Pengobatan atau Terapi: Rekomendasi untuk istirahat dan penggunaan bantal kehamilan<br>
                    Konseling atau Edukasi: Edukasi mengenai latihan pernapasan dan posisi tidur yang nyaman
                ',
            'appointment_id' => $appointment->id,
        ];
    }
}
