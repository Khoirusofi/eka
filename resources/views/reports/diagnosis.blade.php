<x-print-layout>
    @section('title', 'Laporan Data Rekam Medis - ' . config('app.name'))
    <p>{{ __('Laporan Data Rekam Medis') . ' ' . config('app.name') }}
    </p>

    <table>
        <thead>
            <tr>
                <th>{{ __('No') }}</th>
                <th>{{ __('Nama Pasien') }}</th>
                <th>{{ __('Tanggal Janji') }}</th>
                <th>{{ __('Jam Janji') }}</th>
                <th>{{ __('Layanan') }}</th>
                <th>{{ __('Catatan Pemeriksaan') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($diagnoses as $diagnosis)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $diagnosis->appointment->patient->user->name }}</td>
                    <td>{{ $diagnosis->appointment->date }}</td>
                    <td>{{ $diagnosis->appointment->time }} </td>
                    <td>{{ $diagnosis->appointment->service->title }}</td>
                    <td>{{ $diagnosis->detail }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</x-print-layout>
