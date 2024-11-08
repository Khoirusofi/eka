<x-app-layout>
    @section('title', 'Rekam Medis - ' . config('app.name'))
    @php
        $title = auth()->user()->role === 'patient' ? __('Riwayat Rekam Medis') : __('Kelola Data Rekam Medis');
        $description =
            auth()->user()->role === 'patient'
                ? __('Lihat Riwayat Rekam Medis') . ' ' . auth()->user()->name
                : __('Kelola Data Rekam Medis pada aplikasi') . ' ' . config('app.name');
    @endphp

    <x-heading level="h2">
        <x-slot name="title">
            {{ $title }}
        </x-slot>

        <x-slot name="description">
            {{ $description }}
        </x-slot>
    </x-heading>


    <div class="flex flex-col justify-between gap-6 lg:items-end lg:flex-row">
        <form action="{{ route('patients.diagnoses.index') }}" method="get"
            class="flex flex-col items-end gap-4 lg:flex-row" x-data="{
                $form: null,
                init() {
                    this.$form = this.$refs.form;
                },
            }" x-ref="form">

            @if (auth()->user()->hasRole('bidan') || auth()->user()->hasRole('admin'))
                <div class="w-full min-w-40">
                    <x-label for="registration_number" :value="__('Cari No Registrasi')" />
                    <x-input id="registration_number" type="text" name="registration_number"
                        placeholder="{{ __('Cari No Registrasi') }}" value="{{ request('registration_number') }}"
                        autocomplete="search" x-on:input.debounce.300ms="$form.submit()" autofocus />
                </div>

                <div class="w-full min-w-40">
                    <x-label for="name" :value="__('fields.name.label')" />
                    <x-input id="name" type="text" name="name"
                        placeholder="{{ __('fields.name.placeholder') }}" value="{{ request('name') }}"
                        autocomplete="name" x-on:input.debounce.300ms="$form.submit()" autofocus />
                </div>
            @endif

            <x-datepicker :start="$start" :end="$end" />

        </form>
    </div>

    <x-table>
        <x-slot name="head">
            <th>{{ __('No') }}</th>
            @if (auth()->user()->hasRole('bidan') || auth()->user()->hasRole('admin'))
                <th class="min-w-40">{{ __('Nama Pasien') }}</th>
                <th>{{ __('No Registrasi') }}</th>
            @endif
            <th>{{ __('Tanggal') }}</th>
            <th>{{ __('Jam') }}</th>
            <th>{{ __('Layanan') }}</th>
            <th>{{ __('Aksi') }}</th>
        </x-slot>

        <x-slot name="body">
            @forelse ($diagnoses->sortByDesc('created_at') as $diagnosis)
                <tr>
                    <td>{{ ($diagnoses->currentPage() - 1) * $diagnoses->perPage() + $loop->iteration }}</td>
                    @if (auth()->user()->hasRole('bidan') || auth()->user()->hasRole('admin'))
                        <td>
                            <x-avatar value="{{ $diagnosis->appointment->patient->user->name }}" size="sm"
                                expand />
                        </td>
                        <td>
                            <x-badge value="{{ $diagnosis->appointment->patient->no_registrasi }}" />
                        </td>
                    @endif
                    <td><x-date value="{{ $diagnosis->appointment->date }}" /></td>
                    <td>{{ $diagnosis->appointment->time }} WIB</td>
                    <td>{{ $diagnosis->appointment->service->title }}</td>
                    <td>
                        <a href="{{ route('patients.diagnoses.show', $diagnosis) }}">
                            <x-button variant="outline" size="icon" label="{{ __('Baca Detail') }}">
                                <i data-lucide="folder-search"></i>
                            </x-button>
                        </a>

                        @if (auth()->user()->hasRole('admin') || auth()->user()->hasRole('bidan'))
                            <a href="{{ route('admins.diagnoses.edit', $diagnosis) }}">
                                <x-button variant="outline" size="icon" label="{{ __('Edit') }}">
                                    <i data-lucide="edit"></i>
                                </x-button>
                            </a>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colSpan="5" class="text-center">{{ __('Tidak ada data') }}</td>
                </tr>
            @endforelse
        </x-slot>
    </x-table>

    {{ $diagnoses->links() }}

    <div class="flex flex-col-reverse lg:flex-row lg:justify-end gap-4 col-span-full">
        <x-button type="button" variant="primary" onclick="window.location.href='{{ route('dashboard') }}'">
            <i data-lucide="arrow-left"></i>
            {{ __('Kembali') }}
        </x-button>
    </div>
</x-app-layout>
