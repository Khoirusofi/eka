<x-print-layout>
    @section('title', 'Laporan Data Pengguna - ' . config('app.name'))
    <p>{{ __('Laporan Data Pengguna') . ' ' . config('app.name') }}
    </p>

    <table>
        <thead>
            <tr>
                <th>{{ __('No') }}</th>
                <th>{{ __('Tanggal Dibuat') }}</th>
                <th>{{ __('Nama') }}</th>
                <th>{{ __('Email') }}</th>
                <th>{{ __('Role') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ \Carbon\Carbon::parse($user->created_at)->translatedFormat('l, d F Y') }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->role === 'patient' ? 'Pasien' : $user->role }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</x-print-layout>
