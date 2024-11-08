<x-print-layout>
    @section('title', 'Laporan Data Metode Pembayaran - ' . config('app.name'))
    <p>{{ __('Laporan Data Metode Pembayaran') . ' ' . config('app.name') }}
    </p>

    <table>
        <thead>
            <tr>
                <th>{{ __('No') }}</th>
                <th>{{ __('Tanggal Dibuat') }}</th>
                <th>{{ __('Nama Rekening') }}</th>
                <th>{{ __('Nomor Rekening') }}</th>
                <th>{{ __('Keterangan') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($payments as $payment)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $payment->created_at->format('d F Y') }}</td>
                    <td>{{ $payment->account }}</td>
                    <td>{{ $payment->number }}</td>
                    <td>{{ $payment->description }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</x-print-layout>
