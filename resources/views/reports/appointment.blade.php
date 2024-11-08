<x-print-layout>
    @section('title', 'Laporan Data Janji - ' . config('app.name'))
    <p>{{ __('Laporan Data Janji') . ' ' . config('app.name') }}
    </p>

    <table>
        <thead>
            <tr>
                <th>{{ __('No') }}</th>
                <th>{{ __('Nama Pasien') }}</th>
                <th>{{ __('Layanan') }}</th>
                <th>{{ __('Tanggal Janji') }}</th>
                <th>{{ __('Jam Janji') }}</th>
                <th>{{ __('Status') }}</th>
                <th>{{ __('Metode Pembayaran') }}</th>
                <th>{{ __('Jumlah Pembayaran') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($appointments as $appointment)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $appointment->patient->user->name }}</td>
                    <td>{{ $appointment->service->title }}</td>
                    <td>{{ \Carbon\Carbon::parse($appointment->date)->translatedFormat('l, d F Y') }}</td>
                    <td>{{ $appointment->time }} WIB </td>
                    <td>
                        {{ match ($appointment->status) {
                            'pending' => __('Menunggu Pembayaran'),
                            'confirmed' => __('Dikonfirmasi'),
                            'cancelled' => __('Dibatalkan'),
                            'finished' => __('Selesai'),
                            default => __('Status Tidak Dikenal'),
                        } }}
                    </td>
                    <td>{{ $appointment->payment->account }}</td>
                    <td><x-currency value="{{ $appointment->service->price + $appointment->code }}" /></td>
                </tr>
            @endforeach
        </tbody>
    </table>
</x-print-layout>
