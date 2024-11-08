<x-app-layout>
    @section('title', 'Kritik Saran dan Testimoni - ' . config('app.name'))
    @php
        $title =
            auth()->user()->role === 'patient'
                ? __('Detail Kritik Saran dan Testimoni')
                : __('Detail Data Kritik Saran dan Testimoni');
        $description =
            auth()->user()->role === 'patient'
                ? __('Detail Riwayat Kritik Saran dan Testimoni') . ' ' . auth()->user()->name
                : __('Detail Data Kritik Saran dan Testimoni pada aplikasi') . ' ' . config('app.name');
    @endphp

    <x-heading level="h2">
        <x-slot name="title">
            {{ $title }}
        </x-slot>

        <x-slot name="description">
            {{ $description }}
        </x-slot>
    </x-heading>

    <div class="grid gap-6 lg:grid-cols-2">
        <div class="col-span-full">
            <x-label for="body" :value="__('reviews.body.label')" />
            <x-textarea id="body" name="body" value="{{ $review->body }}" readonly rows="5" />
        </div>

        <div class="col-span-full">
            <x-label for="action" :value="__('reviews.action.label')" />
            <x-textarea id="action" name="action" value="{{ $review->action }}" readonly rows="5" />
        </div>

        <div class="col-span-full">
            <x-label for="respond" :value="__('reviews.respond.label')" />
            <x-textarea id="respond" name="respond" value="{{ $review->respond }}" readonly rows="5" />
        </div>
    </div>

    <div class="flex flex-col-reverse lg:flex-row lg:justify-end gap-4 col-span-full">
        <x-button type="button" variant="primary"
            onclick="window.location.href='{{ route('patients.reviews.index') }}'">
            <i data-lucide="arrow-left"></i>
            {{ __('Kembali') }}
        </x-button>
    </div>

</x-app-layout>
