<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesan Kontak</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
        }

        .container {
            width: 100%;
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            box-sizing: border-box;
        }

        h1 {
            font-size: 24px;
            margin-bottom: 10px;
            color: #3e6553;
            font-weight: bold;
            text-align: center;
        }

        p {
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 15px;
        }

        .highlight {
            font-weight: bold;
            color: #3e6553;
        }

        .footer {
            font-size: 14px;
            text-align: center;
            color: #777;
            margin-top: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
        }

        .footer img {
            max-height: 30px;
            margin-bottom: 10px;
        }

        /* Responsive Styles */
        @media (max-width: 480px) {
            .container {
                padding: 15px;
            }

            h1 {
                font-size: 20px;
                margin-bottom: 8px;
            }

            p {
                font-size: 14px;
            }

            .footer {
                font-size: 12px;
            }

            .footer img {
                max-height: 25px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Berlangganan Baru dari Website Bidan Eka Muzaifa</h1>
        <p><span class="highlight">Email Berlangganan:</span> {{ $email }}</p>
        <div class="footer">
            <img src="{{ asset('images/logo.png') }}" alt="Logo Bidan Eka Muzaifa" style="width: 30px; height: 30px;">
            <p>Bidan Eka Muzaifa</p>
        </div>
    </div>
</body>

</html>
