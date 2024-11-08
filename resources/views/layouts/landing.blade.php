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
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.css" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    @stack('styles')
</head>

<body class="font-['Poppins']" x-data x-cloak>
    <x-navigation />
    <main class="w-content">
        {{ $slot }}
    </main>
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
    <!-- scrollbar -->
    <style>
        ::-webkit-scrollbar {
            width: 0.4rem;
            background: #858e8a;
            opacity: 0;
            transition: opacity 0.3s;
        }

        ::-webkit-scrollbar-thumb {
            background: #365949;
            border-radius: 0.3rem;
        }

        ::-webkit-scrollbar-thumb:hover {
            cursor: pointer;
            background: #2c473b;
        }

        .scrollable-area:hover::-webkit-scrollbar {
            opacity: 1;
        }

        .scrollable-area {
            overflow-y: auto;
        }

        .scrollable-area {
            scrollbar-width: thin;
            scrollbar-color: transparent transparent;
        }

        .scrollable-area::-webkit-scrollbar {
            width: 0;
        }

        .scrollable-area:hover::-webkit-scrollbar {
            width: 0.4rem;
            background: #858e8a;
        }
    </style>

</body>
<script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.js"></script>

</html>
