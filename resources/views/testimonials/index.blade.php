<x-landing-layout>
    @section('title', 'Testimonial - ' . config('app.name'))
    <section id="hero" class="grid items-center gap-8 py-20">
        <x-heading level="h1">
            <x-slot name="title">
                {{ __('Testimonial') }}
            </x-slot>

            <x-slot name="description">
                {{ __('Apa yang customers menilai tentang layanan kami?') }}
            </x-slot>

            <a href="{{ route('login') }}" class="block">
                <x-button variant="accent" label="Daftar">
                    {{ __('Daftar') }}
                </x-button>
            </a>
        </x-heading>
    </section>
    @php
        $uniqueReviews = $reviews->groupBy('user_id')->map(function ($group) {
            return $group->first();
        });
    @endphp

    <section id="services" class="max-w-6xl mx-auto">
        <div class="grid gap-8 sm:grid-cols-1 md:grid-cols-2 p-4">
            @foreach ($uniqueReviews as $review)
                <div class="p-6 space-y-4 bg-white rounded-xl shadow-lg">
                    <div class="flex items-center gap-4">
                        <x-avatar value="{{ $review->user->name }}" size="md" expand />
                    </div>
                    <p class="text-zinc-600">
                        {{ $review->action }}
                    </p>
                </div>
            @endforeach
        </div>
    </section>
    {{ $reviews->links() }}
</x-landing-layout>
