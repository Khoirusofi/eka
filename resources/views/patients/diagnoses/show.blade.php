<x-app-layout>
    @section('title', 'Rekam Medis - ' . config('app.name'))
    <x-heading level="h2">
        <x-slot name="title">
            {{ __('Detail Rekam Medis') }}
        </x-slot>

        <x-slot name="description">
            {{ __('Detail Rekam Medis, dan pastikan data yang dikirim benar') }}
        </x-slot>
    </x-heading>

    <form action="{{ route('admins.appointments.diagnoses.store', $appointment) }}" method="post"
        class="grid gap-6 lg:grid-cols-2" novalidate>
        @csrf

        <div>
            <x-label for="name" :value="__('diagnoses.name.label')" />
            <x-avatar value="{{ $appointment->patient->user->name }}" size="sm" expand />
        </div>

        <div>
            <x-label for="service" :value="__('diagnoses.service.label')" />
            <x-input id="service" type="text" name="service" value="{{ $appointment->service->title }}" readonly />
        </div>

        <div>
            <x-label for="date" :value="__('diagnoses.date.label')" />
            <x-input id="date" type="text" name="date"
                value="{{ \Carbon\Carbon::parse($appointment->date)->translatedFormat('l, d F Y') }}" readonly />
        </div>

        <div>
            <x-label for="time" :value="__('diagnoses.time.label')" />
            <x-input id="time" type="text" name="time"
                value="{{ \Carbon\Carbon::parse($appointment->time)->format('H:i') }} WIB" readonly />
        </div>

        <div class="col-span-full">
            <x-label for="detail" :value="__('diagnoses.detail.label')" />
            <x-textarea id="detail" name="detail" placeholder="{{ __('diagnoses.detail.placeholder') }}"
                value="{{ $diagnosis->detail }}" readonly />
            <x-error :value="$errors->get('detail')" />
        </div>
    </form>

    @push('scripts')
        <script src="{{ asset('vendor/tinymce/js/tinymce/tinymce.min.js') }}"></script>
        <script>
            tinymce.init({
                selector: 'textarea#detail',
                license_key: 'gpl',
                readonly: true,
            });
        </script>
    @endpush

    <div class="flex flex-col-reverse lg:flex-row lg:justify-end gap-4 col-span-full">
        <x-button type="button" variant="primary"
            onclick="window.location.href='{{ route('patients.diagnoses.index') }}'">
            <i data-lucide="arrow-left"></i>
            {{ __('Kembali') }}
        </x-button>
    </div>
</x-app-layout>
