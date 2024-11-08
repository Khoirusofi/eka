<x-app-layout>
    <x-heading level="h2">
        <x-slot name="title">
            {{ __('Perbarui Data Rekam Medis') }}
        </x-slot>

        <x-slot name="description">
            {{ __('Perbarui Data Rekam Medis, dan pastikan data yang dikirim benar') }}
        </x-slot>
    </x-heading>

    <form action="{{ route('admins.diagnoses.update', $diagnosis) }}" method="post"
        class="space-y-6 lg:space-y-0 lg:grid lg:grid-cols-2 lg:gap-6" novalidate>
        @csrf
        @method('PUT')

        <!-- Bagian Data Pasien -->
        <div>
            <x-label for="name" :value="__('diagnoses.name.label')" />
            <x-avatar value="{{ $appointment->patient->user->name }}" size="sm" expand />
        </div>

        <!-- Bagian Service dan Date Time -->
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

        <!-- Bagian Detail -->
        <div class="col-span-full">
            <x-label for="detail" :value="__('diagnoses.detail.label')" />
            <x-textarea id="detail" name="detail" placeholder="{{ __('diagnoses.detail.placeholder') }}"
                value="{{ old('detail') ?? $diagnosis->detail }}" rows="5" />
            <x-error :value="$errors->get('detail')" />
        </div>

        <!-- Tombol Submit dan Reset -->
        <div class="flex justify-end space-x-2 col-span-full">
            <x-button type="reset" variant="outline">
                {{ __('actions.reset') }}
            </x-button>

            <x-button type="submit" variant="primary">
                {{ __('actions.submit') }}
            </x-button>
        </div>
    </form>



    @push('scripts')
        <script src="{{ asset('vendor/tinymce/js/tinymce/tinymce.min.js') }}"></script>
        <script>
            tinymce.init({
                selector: 'textarea#detail',
                license_key: 'gpl',
            });
        </script>
    @endpush
</x-app-layout>
