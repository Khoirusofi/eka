<x-app-layout>
    @section('title', 'Pembayaran - ' . config('app.name'))
    @php
        $title = auth()->user()->role === 'patient' ? __('Riwayat Pembayaran') : __('Kelola Data Pembayaran');
        $description =
            auth()->user()->role === 'patient'
                ? __('Lihat Riwayat Pembayaran') . ' ' . auth()->user()->name
                : __('Kelola Data Pembayaran pada aplikasi') . ' ' . config('app.name');
    @endphp

    <x-heading level="h2">
        <x-slot name="title">
            {{ $title }}
        </x-slot>

        <x-slot name="description">
            {{ $description }}
        </x-slot>
    </x-heading>

    <div class="grid gap-4 lg:grid-cols-2 xl:grid-cols-4">
        @foreach ($sums as $item)
            <div class="flex flex-col p-4 mb-2 text-sm rounded-lg frame gap-y-4">
                <div class="flex items-center justify-between text-zinc-500">
                    <span> {{ \Illuminate\Support\Str::title(__('status.' . $item->status)) }}</span>
                </div>
                <span class="text-2xl font-semibold text-primary">
                    <x-currency value="{{ $item->sum }}" />
                </span>
            </div>
        @endforeach
    </div>

    <x-table>
        <x-slot name="head">
            <th>{{ __('No') }}</th>
            <th>{{ __('Tanggal') }}</th>
            <th>{{ __('Layanan') }}</th>
            <th>{{ __('Metode Pembayaran') }}</th>
            <th>{{ __('Jumlah Pembayaran') }}</th>
            <th>{{ __('Status') }}</th>
        </x-slot>

        <x-slot name="body">
            @forelse ($receipts as $receipt)
                <tr>
                    <td>{{ ($receipts->currentPage() - 1) * $receipts->perPage() + $loop->iteration }}</td>
                    <td> <x-date value="{{ $receipt->date }}" /> </td>
                    <td>{{ $receipt->service->title }}</td>
                    <td>{{ $receipt->payment->account }}</td>
                    <td>
                        <x-currency value="{{ $receipt->service->price + $receipt->code }}" />
                    </td>
                    <td> <x-badge value="{{ $receipt->status }}" /></td>
                </tr>
            @empty
                <tr>
                    <td colSpan="5" class="text-center">{{ __('Tidak ada data') }}</td>
                </tr>
            @endforelse
        </x-slot>
    </x-table>

    {{ $receipts->links() }}

    <div class="flex flex-col-reverse lg:flex-row lg:justify-end gap-4 col-span-full">
        <x-button type="button" variant="primary" onclick="window.location.href='{{ route('dashboard') }}'">
            <i data-lucide="arrow-left"></i>
            {{ __('Kembali') }}
        </x-button>
    </div>
</x-app-layout>
