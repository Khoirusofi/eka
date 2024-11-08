<x-app-layout>
    @section('title', 'Dashboards - ' . config('app.name'))
    <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
        <div class="text-center md:text-left">
            <x-heading level="h2">
                <x-slot name="title">
                    {{ __('Riwayat Layanan') }} {{ auth()->user()->name }}
                </x-slot>

                <x-slot name="description">
                    {{ __('Pada aplikasi') . ' ' . config('app.name') }}
                </x-slot>
            </x-heading>
        </div>
        <div class="text-center md:text-right animate-bounce">
            <a href="{{ route('patients.appointments.create') }}">
                <x-button variant="accent">
                    <i data-lucide="calendar-plus"></i>
                    {{ __('Buat Janji Temu') }}
                </x-button>
            </a>
        </div>
    </div>

    <div class="flex flex-col gap-4">
        <x-heading level="h3">
            <x-slot name="title">
                {{ __('Riwayat Pembayaran') }}
            </x-slot>

            <x-slot name="description">
                {{ __('Riwayat pembayaran dan status pembayaran. ') }}
            </x-slot>
        </x-heading>

        <div class="grid gap-4 lg:grid-cols-2 xl:grid-cols-4">
            @foreach ($sums as $item)
                <div class="flex flex-col p-4 mb-2 text-sm rounded-lg frame gap-y-4">
                    <div class="flex items-center justify-between text-zinc-500">
                        <span> {{ \Illuminate\Support\Str::title(__('status.' . $item->status)) }}</span>
                    </div>
                    <span class="text-2xl font-semibold text-primary">
                        <x-currency value="{{ $item->sum }}" />
                    </span>
                </div>
            @endforeach
        </div>
    </div>


    <div class="flex flex-col gap-4">
        @php
            $patients = [
                [
                    'icon' => 'calendar-check',
                    'label' => __('Riwayat Janji Temu'),
                    'href' => route('patients.appointments.index'),
                ],
                [
                    'icon' => 'heart-pulse',
                    'label' => __('Riwayat Rekam Medis'),
                    'href' => route('patients.diagnoses.index'),
                ],
                [
                    'icon' => 'wallet',
                    'label' => __('Riwayat Pembayaran'),
                    'href' => route('patients.receipts.index'),
                ],
                [
                    'icon' => 'message-square',
                    'label' => __('Riwayat Kritik dan Saran'),
                    'href' => route('patients.reviews.index'),
                ],
            ];
        @endphp

        <x-heading level="h3">
            <x-slot name="title">
                {{ __('Menu Pasien') }}
            </x-slot>

            <x-slot name="description">
                {{ __('Riwayat dan informasi terkait pasien, termasuk janji temu, rekam medis, riwayat pembayaran, dan testimoni dari pasien.') }}
            </x-slot>
        </x-heading>

        <div class="grid gap-4 lg:grid-cols-2 xl:grid-cols-4">
            @foreach ($patients as $patient)
                <a href="{{ $patient['href'] }}" class="block">
                    <div class="flex p-4 mb-2 text-sm rounded-lg frame gap-x-2">
                        <i data-lucide="{{ $patient['icon'] }}" class="flex-none text-accent size-5"></i>
                        {{ $patient['label'] }}
                    </div>
                </a>
            @endforeach
        </div>
    </div>


</x-app-layout>
