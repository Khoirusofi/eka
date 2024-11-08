<x-app-layout>
    @section('title', 'Laporan Data Pengguna - ' . config('app.name'))
    <x-heading level="h2">
        <x-slot name="title">
            {{ __('Laporan Data Pengguna') }}
        </x-slot>

        <x-slot name="description">
            {{ __('Laporan Data Pengguna pada aplikasi') . ' ' . config('app.name') }}
        </x-slot>
    </x-heading>

    <div class="flex flex-col justify-between gap-6 lg:items-end lg:flex-row">
        <form action="{{ route('admins.users.report') }}" method="get" class="flex flex-col items-end gap-4 lg:flex-row"
            x-data="{
                $form: null,
                init() {
                    this.$form = this.$refs.form;
                },
            }" x-ref="form">

            <x-datepicker :start="$start" :end="$end" />
        </form>

        <div class="flex flex-col justify-start gap-6 lg:items-end lg:flex-row">
            <a href="{{ route('admins.users.export', [
                'format' => 'csv',
                'start' => $start,
                'end' => $end,
            ]) }}"
                target="_blank">
                <x-button variant="outline">
                    <i data-lucide="download"></i>
                    {{ __('Unduh CSV') }}
                </x-button>
            </a>

            <a href="{{ route('admins.users.export', [
                'format' => 'pdf',
                'start' => $start,
                'end' => $end,
            ]) }}"
                target="_blank">
                <x-button variant="outline">
                    <i data-lucide="download"></i>
                    {{ __('Unduh PDF') }}
                </x-button>
            </a>
        </div>
    </div>

    <x-table>
        <x-slot name="head">
            <th>{{ __('No') }}</th>
            <th>{{ __('Tanggal Dibuat') }}</th>
            <th>{{ __('Nama') }}</th>
            <th>{{ __('Email') }}</th>
            <th>{{ __('Role') }}</th>
        </x-slot>

        <x-slot name="body">
            @forelse ($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td><x-date value="{{ $user->created_at }}" /></td>
                    <td> <x-avatar value="{{ $user->name }}" size="sm" expand /></td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @php
                            $icon = match ($user->role) {
                                'admin' => '<i class="ri-user-settings-line mr-1"></i>',
                                'patient' => '<i class="ri-user-heart-line mr-1 ml-1"></i>',
                                default => '<i class="ri-user-heart-line mr-1 ml-1"></i>',
                            };
                        @endphp
                        <span
                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-sm font-medium {{ $user->role === 'admin' ? 'bg-accent text-white' : 'bg-gray-100 text-gray-800' }}">
                            {!! $icon !!}
                            {{ $user->role === 'admin' ? 'Admin' : ($user->role === 'bidan' ? 'Bidan' : ($user->role === 'patient' ? 'Pasien' : $user->role)) }}
                        </span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colSpan="6" class="text-center">{{ __('Tidak ada data') }}</td>
                </tr>
            @endforelse
        </x-slot>
    </x-table>

    {{ $users->links() }}
</x-app-layout>
