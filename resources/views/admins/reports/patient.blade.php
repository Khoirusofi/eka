<x-app-layout>
    @section('title', 'Laporan Data Pasien - ' . config('app.name'))
    <x-heading level="h2">
        <x-slot name="title">
            {{ __('Laporan Data Pasien') }}
        </x-slot>

        <x-slot name="description">
            {{ __('Laporan Data Pasien pada aplikasi') . ' ' . config('app.name') }}
        </x-slot>
    </x-heading>


    <div class="flex flex-col justify-between gap-6 lg:items-end lg:flex-row">
        <form action="{{ route('admins.patients.report') }}" method="get"
            class="flex flex-col items-end gap-4 lg:flex-row" x-data="{
                $form: null,
                init() {
                    this.$form = this.$refs.form;
                },
            }" x-ref="form">

            <x-datepicker :start="$start" :end="$end" />
        </form>

        <div class="flex flex-col justify-start gap-6 lg:items-end lg:flex-row">
            <a href="{{ route('admins.patients.export', [
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

            <a href="{{ route('admins.patients.export', [
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
            <th>{{ __('No Registrasi') }}</th>
            <th>{{ __('NIK') }}</th>
            <th>{{ __('Jenis Kelamin') }}</th>
            <th>{{ __('Golongan Darah') }}</th>
            <th>{{ __('Alamat') }}</th>
            <th>{{ __('Telefon') }}</th>
            <th>{{ __('Tempat Lahir') }}</th>
            <th>{{ __('Tanggal Lahir') }}</th>
        </x-slot>

        <x-slot name="body">
            @forelse ($patients as $patient)
                <tr>
                    <td>{{ $patient->id }}</td>
                    <td><x-date value="{{ $patient->created_at }}" /></td>
                    <td><x-avatar value="{{ $patient->user->name }}" size="sm" expand /></td>
                    <td><x-badge value="{{ $patient->no_registrasi }}" /></td>
                    <td>{{ $patient->nik }}</td>
                    <td><x-gender value="{{ $patient->gender }}" /></td>
                    <td>{{ $patient->blood_type }}</td>
                    <td>{{ $patient->address }}</td>
                    <td>{{ $patient->phone }}</td>
                    <td>{{ $patient->birth_place }}</td>
                    <td>{{ \Carbon\Carbon::parse($patient->birth_date)->translatedFormat('d F Y') }}</td>
                </tr>
            @empty
                <tr>
                    <td colSpan="9" class="text-center">{{ __('Tidak ada data') }}</td>
                </tr>
            @endforelse
        </x-slot>
    </x-table>

    {{ $patients->links() }}
</x-app-layout>
