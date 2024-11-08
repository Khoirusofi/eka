<x-app-layout>

    @section('title', 'Laporan Data Janji - ' . config('app.name'))
    <x-heading level="h2">
        <x-slot name="title">
            {{ __('Laporan Data Janji') }}
        </x-slot>

        <x-slot name="description">
            {{ __('Laporan Data Janji pada aplikasi') . ' ' . config('app.name') }}
        </x-slot>
    </x-heading>

    <div class="flex flex-col justify-between gap-6 lg:items-end lg:flex-row">
        <form action="{{ route('admins.appointments.report') }}" method="get"
            class="flex flex-col items-end gap-4 lg:flex-row" x-data="{
                $form: null,
                init() {
                    this.$form = this.$refs.form;
                },
            }" x-ref="form">

            <x-datepicker :start="$start" :end="$end" />
        </form>

        <div class="flex flex-col justify-start gap-6 lg:items-end lg:flex-row">
            <a href="{{ route('admins.appointments.export', [
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

            <a href="{{ route('admins.appointments.export', [
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
            <th>{{ __('Nama Pasien') }}</th>
            <th>{{ __('Layanan') }}</th>
            <th>{{ __('Tanggal Janji') }}</th>
            <th>{{ __('Jam Janji') }}</th>
            <th>{{ __('Status') }}</th>
            <th>{{ __('Metode Pembayaran') }}</th>
            <th>{{ __('Jumlah Pembayaran') }}</th>
        </x-slot>

        <x-slot name="body">
            @forelse ($appointments as $appointment)
                <tr>
                    <td>{{ ($appointments->currentPage() - 1) * $appointments->perPage() + $loop->iteration }}</td>
                    <td><x-avatar value="{{ $appointment->patient->user->name }}" size="sm" expand /></td>
                    <td>{{ $appointment->service->title }}</td>
                    <td><x-date value="{{ $appointment->date }} " /></td>
                    <td>{{ $appointment->time }} WIB </td>
                    <td><x-badge value="{{ $appointment->status }}" /></td>
                    <td>{{ $appointment->payment->account }}</td>
                    <td><x-currency value="{{ $appointment->service->price + $appointment->code }}" /></td>
                </tr>
            @empty
                <tr>
                    <td colSpan="8" class="text-center">{{ __('Tidak ada data') }}</td>
                </tr>
            @endforelse
        </x-slot>
    </x-table>

    {{ $appointments->links() }}
</x-app-layout>
