<x-app-layout>
    <x-heading level="h2">
        <x-slot name="title">
            {{ __('Kelola Data Pasien') }}
        </x-slot>

        <x-slot name="description">
            {{ __('Kelola Data Pasien pada aplikasi') . ' ' . config('app.name') }}
        </x-slot>
    </x-heading>

    <div class="flex flex-col justify-between gap-6 lg:items-end lg:flex-row">
        <form action="{{ route('admins.patients.index') }}" method="get" class="flex items-end space-x-4"
            x-data="{
                $form: null,
                init() {
                    this.$form = this.$refs.form;
                },
            }" x-ref="form">

            <!-- Pencarian berdasarkan No Registrasi -->
            <div class="w-full lg:w-auto">
                <x-label for="no_registrasi" :value="__('Cari No Registrasi')" />
                <x-input id="no_registrasi" type="text" name="no_registrasi"
                    placeholder="{{ __('Cari No Registrasi') }}" value="{{ request('no_registrasi') }}"
                    autocomplete="search" x-on:input.debounce.300ms="$form.submit()" autofocus />
            </div>

            <!-- Pencarian berdasarkan Nama -->
            <div class="w-full lg:w-auto">
                <x-label for="name" :value="__('fields.name.label')" />
                <x-input id="name" type="text" name="name" placeholder="{{ __('fields.name.placeholder') }}"
                    value="{{ request('name') }}" autocomplete="name" x-on:input.debounce.300ms="$form.submit()"
                    autofocus />
            </div>
        </form>

        </form>

        <div class="flex items-center justify-end space-x-2">
            <a href="{{ route('admins.patients.create') }}">
                <x-button variant="accent">
                    <i data-lucide="plus"></i>
                    {{ __('Pasien') }}
                </x-button>
            </a>
        </div>
    </div>

    <x-table>
        <x-slot name="head">
            <th> {{ __('No') }}</th>
            <th class="min-w-40">{{ __('Nama') }}</th>
            <th>{{ __('No Registrasi') }}</th>
            <th>{{ __('Jenis Kelamin') }}</th>
            <th>{{ __('Janji Total') }}</th>
            <th>{{ __('Janji Dibatalkan') }}</th>
            <th>{{ __('Kepatuhan') }}</th>
            <th>{{ __('Aksi') }}</th>
        </x-slot>

        <x-slot name="body">
            @forelse ($patients as $patient)
                <tr>
                    <td>{{ ($patients->currentPage() - 1) * $patients->perPage() + $loop->iteration }}</td>
                    <td><x-avatar value="{{ $patient->user->name }}" size="sm" expand /></td>
                    <td><x-badge value="{{ $patient->no_registrasi }}" /></td>
                    <td><x-gender value="{{ $patient->gender }}" /></td>
                    <td>{{ $patient->total }}</td>
                    <td>{{ $patient->cancelled }}</td>
                    <td>
                        @php
                            $value = $patient->total == 0 ? 0 : 100 - ($patient->cancelled / $patient->total) * 100;
                            $color = 'bg-zinc-200';

                            if ($value > 75) {
                                $color = 'bg-green-600';
                            } elseif ($value > 50) {
                                $color = 'bg-yellow-600';
                            } elseif ($value > 25) {
                                $color = 'bg-orange-600';
                            } elseif ($value > 0) {
                                $color = 'bg-red-600';
                            }
                        @endphp
                        <span
                            class="px-2 py-1 text-sm font-medium text-white rounded-full bg-primary {{ $color }}">
                            {{ number_format($value) }}%
                        </span>
                    </td>
                    <td>
                        <x-action edit="{{ route('admins.patients.edit', $patient) }}"
                            delete="{{ route('admins.patients.destroy', $patient) }}" />
                    </td>
                </tr>
            @empty
                <tr>
                    <td colSpan="5" class="text-center">{{ __('Tidak ada data') }}</td>
                </tr>
            @endforelse
        </x-slot>
    </x-table>

    {{ $patients->links() }}


</x-app-layout>
