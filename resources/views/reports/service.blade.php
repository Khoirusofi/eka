<x-print-layout>
    @section('title', 'Laporan Data Layanan - ' . config('app.name'))
    <p>{{ __('Laporan Data Layanan') . ' ' . config('app.name') }}
    </p>

    <table>
        <thead>
            <tr>
                <th>{{ __('No') }}</th>
                <th>{{ __('Tanggal Dibuat') }}</th>
                <th>{{ __('Nama Layanan') }}</th>
                <th>{{ __('Harga') }}</th>
                <th>{{ __('Deskripsi') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($services as $service)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ \Carbon\Carbon::parse($service->created_at)->translatedFormat('l, d F Y') }}</td>
                    <td>{{ $service->title }}</td>
                    <td><x-currency value="{{ $service->price }}" /></td>
                    <td>{{ $service->description }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</x-print-layout>
