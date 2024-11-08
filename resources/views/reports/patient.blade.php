<x-print-layout>
    @section('title', 'Laporan Data Pasien - ' . config('app.name'))
    <p>{{ __('Laporan Data Pasien') . ' ' . config('app.name') }}
    </p>

    <table>
        <thead>
            <tr>
                <th>{{ __('No') }}</th>
                <th>{{ __('NIK') }}</th>
                <th>{{ __('No Registrasi') }}</th>
                <th>{{ __('Nama') }}</th>
                <th>{{ __('Jenis Kelamin') }}</th>
                <th>{{ __('Golongan Darah') }}</th>
                <th>{{ __('Alamat') }}</th>
                <th>{{ __('No Telepon') }}</th>
                <th>{{ __('Tempat Lahir') }}</th>
                <th>{{ __('Tanggal Lahir') }}</th>
                <th>{{ __('Umur') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($patients as $patient)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $patient->nik }}</td>
                    <td>{{ $patient->no_registrasi }}</td>
                    <td>{{ $patient->user->name }}</td>
                    <td>
                        @if ($patient->gender === 'male')
                            {{ __('Laki-laki') }}
                        @elseif ($patient->gender === 'female')
                            {{ __('Perempuan') }}
                        @endif
                    </td>
                    <td>{{ $patient->blood_type }}</td>
                    <td>{{ $patient->address }}</td>
                    <td>{{ $patient->phone }}</td>
                    <td>{{ $patient->birth_place }}</td>
                    <td>{{ \Carbon\Carbon::parse($patient->birth_date)->translatedFormat('d F Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($patient->birth_date)->age }} Tahun</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</x-print-layout>
