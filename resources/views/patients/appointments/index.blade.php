<x-app-layout>
    @section('title', 'Data Janji - ' . config('app.name'))
    @php
        $title = auth()->user()->role === 'patient' ? __('Riwayat Janji Temu') : __('Kelola Data Janji Temu');
        $description =
            auth()->user()->role === 'patient'
                ? __('Lihat Riwayat Janji Temu') . ' ' . auth()->user()->name
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
        <form action="{{ route('patients.appointments.index') }}" method="get"
            class="flex flex-col items-end gap-4 lg:flex-row" x-data="{
                $form: null,
                init() {
                    this.$form = this.$refs.form;
                },
            }" x-ref="form">
            @if (auth()->user()->hasRole('admin') || auth()->user()->hasRole('bidan'))
                <div class="w-full min-w-40">
                    <x-label for="registration_number" :value="__('Cari No Registrasi')" />
                    <x-input id="registration_number" type="text" name="registration_number"
                        placeholder="{{ __('Cari No Registrasi') }}" value="{{ request('registration_number') }}"
                        autocomplete="search" x-on:input.debounce.300ms="$form.submit()" autofocus />
                </div>
            @endif

            <x-datepicker :start="$start" :end="$end" />

            <div class="w-full min-w-40">
                <x-label for="status" :value="__('fields.status.label')" />
                <x-select id="status" name="status" x-on:change="$form.submit()">
                    <option value="" @if ($status == null) selected @endif>
                        {{ __('fields.status.placeholder') }}
                    </option>
                    @foreach ($statuses as $item)
                        <option value="{{ $item }}" @if ($item == $status) selected @endif>
                            {{ \Illuminate\Support\Str::title(__('status.' . $item)) }}
                        </option>
                    @endforeach
                </x-select>
            </div>
        </form>

        <a href="{{ route('patients.appointments.create') }}" class=" animate-bounce">
            @if (in_array(auth()->user()->role, ['patient']))
                <x-button variant="accent">
                    <i data-lucide="calendar-plus"></i>
                    {{ __('Buat Janji Temu') }}
                </x-button>
            @endif
        </a>
    </div>

    <x-table>
        <x-slot name="head">
            <th>{{ __('No') }}</th>
            @if (auth()->user()->hasRole('admin') || auth()->user()->hasRole('bidan'))
                <th class="min-w-40">{{ __('Nama Pasien') }}</th>
                <th>{{ __('No Registrasi') }}</th>
            @endif
            <th>{{ __('Layanan') }}</th>
            <th>{{ __('Tanggal Janji') }}</th>
            <th>{{ __('Jam Janji') }}</th>
            <th>{{ __('Status') }}</th>
            <th>{{ __('Aksi') }}</th>
        </x-slot>

        <x-slot name="body">
            @forelse ($appointments->sortBy([
            ['date', 'desc'],
            ['time', 'desc'],
        ]) as $appointment)
                <tr class="{{ $appointment->created_at->gt(now()->subDay()) ? 'bg-green-50' : '' }}">
                    <td>{{ ($appointments->currentPage() - 1) * $appointments->perPage() + $loop->iteration }}</td>
                    @if (auth()->user()->hasRole('admin') || auth()->user()->hasRole('bidan'))
                        <td><x-avatar value="{{ $appointment->patient->user->name }}" size="sm" expand /></td>
                        <td>
                            <x-badge value="{{ $appointment->patient->no_registrasi }}" />
                            @if ($appointment->created_at->gt(now()->subDay()))
                                <span class="ml-1 text-xs font-semibold text-green-500 animate-bounce">Baru</span>
                            @endif
                        </td>
                    @endif
                    <td>{{ $appointment->service->title }}</td>
                    <td><x-date value="{{ $appointment->date }}" /></td>
                    <td>{{ $appointment->time }} WIB</td>
                    <td><x-badge value="{{ $appointment->status }}" /></td>
                    <td>
                        <div class="flex items-center space-x-2">
                            @if (in_array(auth()->user()->role, ['admin', 'bidan', 'patient']) && $appointment->patient->user_id)
                                <a href="{{ route('patients.appointments.show', $appointment) }}" class="inline-flex">
                                    <x-button variant="outline" size="icon" label="{{ __('Lihat') }}">
                                        <i data-lucide="folder-search" class="size-5"></i>
                                    </x-button>
                                </a>
                            @endif

                            @if ($appointment->status == 'pending' && in_array(auth()->user()->role, ['admin', 'bidan']))
                                <a href="{{ route('patients.appointments.edit', $appointment) }}" class="inline-flex">
                                    <x-button variant="outline" size="icon" label="{{ __('Pembayaran') }}">
                                        <i data-lucide="banknote" class="size-5"></i>
                                    </x-button>
                                </a>
                            @endif

                            @if (in_array(auth()->user()->role, ['admin', 'bidan']) && $appointment->status == 'confirmed')
                                <a href="{{ route('admins.appointments.diagnoses.create', $appointment) }}"
                                    class="inline-flex">
                                    <x-button variant="outline" size="icon" label="{{ __('Rekam Medis') }}">
                                        <i data-lucide="pencil" class="size-5"></i>
                                    </x-button>
                                </a>
                            @endif

                            @if (!in_array($appointment->status, ['cancelled', 'finished', 'confirmed']))
                                <x-button variant="outline" size="icon" label="{{ __('Batalkan') }}"
                                    x-on:click="$dispatch('modal', {
                                    name: 'delete-modal',
                                    action: '{{ route('patients.appointments.cancel', $appointment) }}'
                                })">
                                    <i data-lucide="x" class="size-5"></i>
                                </x-button>
                            @endif
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colSpan="7" class="text-center">{{ __('Tidak ada data') }}</td>
                </tr>
            @endforelse
        </x-slot>
    </x-table>

    {{ $appointments->links() }}

    <div class="flex flex-col-reverse lg:flex-row lg:justify-end gap-4 col-span-full">
        @if (in_array(auth()->user()->role, ['patient']))
            <x-button type="button" variant="primary" onclick="window.location.href='{{ route('dashboard') }}'">
                <i data-lucide="arrow-left"></i>
                {{ __('Kembali') }}
            </x-button>
        @endif
    </div>

</x-app-layout>
