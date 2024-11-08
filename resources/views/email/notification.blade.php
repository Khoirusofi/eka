<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesan Kontak</title>
    <style>
        body {
            background-color: #f0f8f4;
            font-family: 'Open Sans', sans-serif;
            font-size: 16px;
            font-weight: 400;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 100%;
            max-width: 670px;
            margin: 50px auto;
            background-color: #ffffff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-top: solid 10px #365949;
            box-sizing: border-box;
        }

        h1 {
            font-size: 26px;
            font-weight: bold;
            margin: 0;
            color: #365949;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            flex-wrap: wrap;
        }

        .header .date {
            font-weight: 400;
            font-size: 14px;
            color: #777;
        }

        .section {
            margin-bottom: 30px;
        }

        .section h2 {
            font-size: 22px;
            margin-bottom: 15px;
            color: #365949;
        }

        .section p {
            font-size: 16px;
            margin: 0 0 15px 0;
            color: #333;
        }

        .section p span {
            font-weight: bold;
            display: inline-block;
            min-width: 150px;
            color: #333;
        }

        .footer {
            font-size: 14px;
            text-align: center;
            color: #777;
            margin-top: 20px;
            line-height: 1.6;
        }

        .footer b {
            display: inline-block;
            margin-top: 10px;
            color: #333;
        }

        .section ul {
            padding-left: 20px;
            margin: 0;
            list-style-type: disc;
        }

        .section ul li {
            margin-bottom: 10px;
        }

        /* Responsive Styles */
        @media (max-width: 480px) {
            body {
                font-size: 14px;
            }

            .container {
                padding: 20px;
                margin: 20px auto;
            }

            h1 {
                font-size: 22px;
            }

            .header .date {
                font-size: 12px;
            }

            .section h2 {
                font-size: 18px;
            }

            .section p span {
                min-width: 100px;
            }

            .footer {
                font-size: 12px;
            }

            .section ul {
                padding-left: 15px;
            }

            .section ul li {
                margin-bottom: 8px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <img src="{{ asset('images/logo.png') }}" alt="Logo Bidan Eka Muzaifa" style="width: 30px; height: 30px;">
            <h1>{{ $app }}</h1>
            <div class="date">{{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM YYYY') }}</div>
        </div>

        <div class="section">
            <p>Terima kasih telah melakukan janji temu di Bidan Eka Muzaifa.<br>
                Berikut ini adalah detail janji temu Anda:</p>
            <p><span>Status Janji:</span>
                <b
                    style="
                    @switch($appointment->status)
                        @case('pending')
                            color: #f39c12;
                        @break
                        @case('confirmed')
                            color: #27ae60;
                        @break
                        @case('finished')
                            color: #27ae60;
                        @break
                        @case('cancelled')
                            color: #e74c3c;
                        @break
                        @default
                            color: #95a5a6;
                    @endswitch
                ">
                    @switch($appointment->status)
                        @case('pending')
                            Menunggu Konfirmasi Pembayaran
                        @break

                        @case('confirmed')
                            Terkonfirmasi - Lunas
                        @break

                        @case('finished')
                            Selesai - Silahkan Lihat Rekam Medis
                        @break

                        @case('cancelled')
                            Dibatalkan
                        @break

                        @default
                            Status Tidak Dikenal
                    @endswitch
                </b>
            </p>
            <p><span>No Registrasi:</span> {{ $appointment->patient->no_registrasi }}</p>
            <p><span>Total Harga:</span> {{ $price }}</p>
        </div>


        <div class="section">
            <h2>Informasi Pasien</h2>
            <p><span>Nama:</span> {{ $user->name }}</p>
            <p><span>Email:</span> {{ $user->email }}</p>
            <p><span>Telefon:</span> {{ $patient->phone }}</p>
            <p><span>Alamat:</span> {{ $patient->address }}</p>
        </div>

        <div class="section">
            <h2>Layanan</h2>
            <p>
                <span style="display:block; font-weight:bold;">{{ $appointment->service->title }}</span>
                {{ $price }}<br>
                <b style="font-size:14px; font-weight:300;">{{ \Carbon\Carbon::parse($appointment->date)->isoFormat('dddd, D MMMM YYYY') }}
                    - {{ \Carbon\Carbon::parse($appointment->time)->format('H:i') }} WIB</b>
            </p>
        </div>

        <div class="section">
            <h2>SOP Janji Temu</h2>
            <p>Kami menghargai waktu dan komitmen Anda dalam membuat janji temu dengan kami. Untuk memastikan pelayanan
                yang optimal, mohon ikuti panduan berikut:</p>
            <ul>
                <li>Harap datang tepat waktu sesuai jadwal yang telah disepakati.</li>
                <li>Jika Anda perlu membatalkan atau mengubah jadwal janji temu, mohon lakukan setidaknya 24 jam sebelum
                    waktu yang ditentukan.</li>
                <li>Pembatalan mendadak atau ketidakhadiran tanpa pemberitahuan dapat mempengaruhi prioritas Anda untuk
                    janji temu di masa mendatang.</li>
                <li>Pastikan Anda sudah menyelesaikan semua pembayaran yang diperlukan sebelum kedatangan.</li>
                <li>Jika Anda sudah melakukan pembayaran, pengembalian dana (refund) bisa dilakukan dengan mengikuti SOP
                    yang ada, sesuai ketentuan yang berlaku.</li>
            </ul>
        </div>

        <div class="footer">
            <strong>Hormat Kami</strong><br>
            {{ $app }}<br>
            Jl. Masjid Assalafiyah, RT.01 RW.03 No.50 Kel. Cipayung Jaya, Kec. Cipayung, Kota Depok, Jawa Barat
            16437<br>
            <b>Email:</b> {{ $from }}
            <p>Jika Anda memiliki pertanyaan lebih lanjut, jangan ragu untuk membalas email ini.</p>
        </div>
    </div>
</body>

</html>
