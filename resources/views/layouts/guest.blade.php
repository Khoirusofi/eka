<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', config('app.name', 'Laravel'))</title>
    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/png">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;600;700;800;900&display=swap"rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-['Poppins']" x-data x-cloak>
    <div class="flex flex-col items-center justify-center min-h-screen gap-6">
        <a href="/" class="block">
            <x-logo variant="color" size="lg" />
        </a>

        @if (session('success'))
            <x-status status="{{ session('success') }}" class="text-green-600" />
        @endif

        @if (session('error'))
            <x-status status="{{ session('error') }}" class="text-red-600 bg-red-100" />
        @endif

        <div class="w-full max-w-lg p-8 bg-white frame rounded-2xl">
            {{ $slot }}
        </div>
    </div>


    <style>
        ::-webkit-scrollbar {
            width: 0.2rem;
            background: #858e8a;
        }

        ::-webkit-scrollbar-thumb {
            background: #365949;
            border-radius: 0.1rem;
        }

        ::-webkit-scrollbar-thumb:hover {
            cursor: pointer;
            background: #2c473b;
        }
    </style>
</body>

</html>
