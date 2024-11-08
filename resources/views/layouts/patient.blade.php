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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">



    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    @stack('styles')
</head>

<body class="font-['Poppins']" x-data x-cloak>
    <x-navigation />
    <div class="flex flex-col min-h-screen md:flex-row">
        <div class="w-content">
            <x-profile />

            @if (session('success'))
                <x-status status="{{ session('success') }}" class="text-green-600" />
            @endif

            @if (session('error'))
                <x-status status="{{ session('error') }}" class="text-red-600 bg-red-100 border-red-300" />
            @endif

            <div class="p-8 my-12 space-y-8 bg-white frame rounded-xl">
                {{ $slot }}
            </div>
        </div>
    </div>
    <x-modal name="delete-modal" />
    <x-footer />
    <!-- Lucide -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        lucide.createIcons();
    </script>

    <!-- Scripts -->
    @stack('scripts')

    <a href="#"
        class="scrollup px-2 py-2 bg-[#3e6553] text-white rounded-md font-medium text-sm hover:bg-[#365949] transition duration-300 transform hover:-translate-y-1 fixed right-10 bottom-10 inline-flex z-10 opacity-0 pointer-events-none"
        id="scroll-up">
        <i class="ri-arrow-up-line"></i>
    </a>
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

        .no-scrollbar::-webkit-scrollbar {
            width: 0.4rem;
            background: #ffffff;
            width: 4px;
            height: 4px;
        }

        .no-scrollbar::-webkit-scrollbar-thumb {
            background: #365949;
            border-radius: 0.3rem;
        }

        /* Menghilangkan spinner di browser Webkit (Chrome, Safari) */
        input[type="number"]::-webkit-inner-spin-button,
        input[type="number"]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Menghilangkan spinner di browser Firefox */
        input[type="number"] {
            -moz-appearance: textfield;
        }
    </style>
</body>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

</html>
