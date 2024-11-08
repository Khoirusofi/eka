<x-app-layout>
    <x-heading level="h2">
        <x-slot name="title">
            {{ __('Kelola Data Metode Pembayaran') }}
        </x-slot>

        <x-slot name="description">
            {{ __('Kelola Data Metode Pembayaran pada aplikasi') . ' ' . config('app.name') }}
        </x-slot>
    </x-heading>

    <div class="flex flex-col justify-between gap-6 lg:items-end lg:flex-row">
        <form action="{{ route('admins.payments.index') }}" method="get"
            class="flex flex-col items-end gap-4 lg:flex-row" x-data="{
                $form: null,
                init() {
                    this.$form = this.$refs.form;
                },
            }" x-ref="form">

            <div class="w-full min-w-40">
                <x-label for="search" :value="__('fields.search.label')" />
                <x-input id="search" type="text" name="search"
                    placeholder="{{ __('fields.search.placeholder') }}" value="{{ $search }}"
                    autocomplete="search" x-on:input.debounce.300ms="$form.submit()" autofocus />
            </div>
        </form>

        <a href="{{ route('admins.payments.create') }}">
            <x-button variant="accent">
                <i data-lucide="plus"></i>
                {{ __('Metode Pembayaran') }}
            </x-button>
        </a>
    </div>

    <x-table>
        <x-slot name="head">
            <th>{{ __('No') }}</th>
            <th class="min-w-40">{{ __('Nama Rekening') }}</th>
            <th>{{ __('Nomor Rekening') }}</th>
            <th>{{ __('Keterangan') }}</th>
            <th>{{ __('Tanggal Dibuat') }}</th>
            <th>{{ __('Aksi') }}</th>
        </x-slot>

        <x-slot name="body">
            @forelse ($payments as $payment)
                <tr>
                    <td>{{ ($payments->currentPage() - 1) * $payments->perPage() + $loop->iteration }}</td>
                    <td>
                        {{ $payment->account }}
                    </td>
                    <td>
                        {{ $payment->number }}
                    </td>
                    <td>
                        {{ \Illuminate\Support\Str::words($payment->description, 6) }}
                    </td>
                    <td> <x-date value="{{ $payment->created_at }}" /> </td>
                    <td>
                        <x-action edit="{{ route('admins.payments.edit', $payment) }}"
                            delete="{{ route('admins.payments.destroy', $payment) }}" />
                    </td>
                </tr>
            @empty
                <tr>
                    <td colSpan="5" class="text-center">{{ __('Tidak ada data') }}</td>
                </tr>
            @endforelse
        </x-slot>
    </x-table>

    {{ $payments->links() }}


</x-app-layout>
