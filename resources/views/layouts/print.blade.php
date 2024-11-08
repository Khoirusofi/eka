<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', config('app.name', 'Laravel'))</title>
    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/png">

    <style>
        @page {
            size: A4;
            margin: 5mm;
            /* Reduced margin */
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            color: #3e6553;
            font-size: 8px;
            /* Reduced font size */
        }

        .container {
            width: 100%;
            margin: 0 auto;
            padding: 5px;
            /* Reduced padding */
            box-sizing: border-box;
        }

        .header {
            text-align: center;
            margin-bottom: 5px;
            /* Reduced margin */
        }

        .header img {
            height: 30px;
            /* Further reduced image height */
        }

        .header h1 {
            font-size: 12px;
            /* Reduced font size */
            margin: 0;
        }

        .header p {
            margin: 1px 0;
            /* Reduced margin */
            font-size: 8px;
            /* Reduced font size */
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 5px;
            /* Reduced margin */
            font-size: 8px;
            /* Reduced font size */
            table-layout: fixed;
        }

        th,
        td {
            border: 1px solid #dddddd;
            padding: 1px;
            /* Reduced padding */
            text-align: left;
            word-break: break-word;
            /* Wrap long text */
        }

        th {
            background-color: #3e6553;
            color: white;
            text-align: center;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #e4fbea;
        }

        .footer {
            text-align: center;
            margin-top: 5px;
            /* Reduced margin */
            font-size: 6px;
            /* Further reduced font size */
            color: #777;
        }

        .footer .signature-section {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            margin-top: 1rem;
            margin-right: 1rem;
            /* Align items to the right */
            margin-bottom: 5px;
            /* Reduced margin */
        }

        .footer .owner-name {
            font-weight: bold;
            color: #3e6553;
            text-align: right;
            /* Align text to the right */
            font-size: 6px;
            /* Further reduced font size */
        }


        .footer p {
            margin: 1px 0;
            /* Reduced margin */
        }

        @media print {
            body {
                margin: 0;
                padding: 0;
                overflow: hidden;
            }

            .container {
                padding: 0;
            }

            .header,
            .footer {
                display: block;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <img src="{{ asset('images/logo/logo.png') }}" alt="Logo">
            <h1>Praktek Mandiri Bidan</h1>
            <h1>Eka Muzaifa, Amd, Keb</h1>
            <br>
            <p>Jl. Masjid Assalafiyah
                RT.01 RW.03 No.50 Kel. Cipayung Jaya, Kec. Cipayung, Kota Depok, Jawa Barat 16437</p>
            <p>Telepon: 0811 847 1812 - 0878 7002 008</p>
            <p>Email: bidannatural@gmail.com</p>
            <p>No. SIPB : 466 / 0326 / SIPB / DINKES / X / 2019</p>
        </div>

        <div class="content">
            {{ $slot }}
        </div>

        <div class="footer">
            <div class="signature-section">
                <p class="owner-name">....................., {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
                <div class="owner-name">
                    <br><br><br><br><br><br><br><br>
                    Eka Muzaifa, Amd, Keb.
                </div>
            </div>
            <p>Jl. Masjid Assalafiyah
                RT.01 RW.03 No.50 Kel. Cipayung Jaya, Kec. Cipayung, Kota Depok, Jawa Barat 16437</p>
            <p>Telp. 0811 847 1812 - 0878 7002 008</p>
            <p>&copy; {{ \Carbon\Carbon::now()->year }} Bidan Eka Muzaifa. All rights reserved.</p>
        </div>
    </div>
</body>

</html>
