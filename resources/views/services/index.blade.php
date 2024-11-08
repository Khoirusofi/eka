<x-landing-layout>
    @section('title', 'Layanan - ' . config('app.name'))
    <section id="hero" class="grid items-center gap-8 py-20">
        <x-heading level="h1">
            <x-slot name="title">
                {{ __('Layanan yang tersedia') }}
            </x-slot>

            <x-slot name="description">
                {{ __('Kami menyediakan layanan untuk membuat Janji yang lebih cepat dan efektif, dengan berbagai metode pembayaran yang tersedia.') }}
            </x-slot>

            <a href="{{ route('login') }}" class="block ">
                <x-button variant="accent" label="Daftar">
                    {{ __('Daftar') }}
                </x-button>
            </a>
        </x-heading>
    </section>

    <style>
        .no-scrollbar::-webkit-scrollbar {
            width: 0.4rem;
            background: #FAFAFA;
            width: 4px;
            height: 4px;
        }

        .no-scrollbar::-webkit-scrollbar-thumb {
            background: #365949;
            border-radius: 0.3rem;
        }

        .feature,
        .testimonial,
        {
        position: relative;
        }
    </style>
    <section id="services" class="max-w-6xl mx-auto py-12 mt-0.5">
        <div class="flex overflow-x-scroll gap-8 mx-4 py-2 no-scrollbar" id="scrollContainer ">
            @foreach ($services as $service)
                <div
                    class="card bg-[#e6efeb] rounded-2xl p-7 flex flex-col gap-y-5 transition duration-300 transform hover:-translate-y-1 min-w-[300px]">
                    <div class="relative w-full h-48">
                        <img src="{{ asset('media/services/' . $service->photo) }}" alt="{{ $service->title }}"
                            class="absolute inset-0 w-full h-full object-contain rounded-t-2xl">
                    </div>
                    <div class="flex flex-col gap-y-1">
                        <h3 class="font-semibold text-base">{{ $service->title }}</h3>
                        <p class="text-sm leading-relaxed text-[#565d59] ">{{ $service->description }}</p>
                        <p class="font-semibold text-base">
                            {{-- <x-currency value="{{ $service->price }}" /> --}}
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    {{ $services->links() }}

</x-landing-layout>
