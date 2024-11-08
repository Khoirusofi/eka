<x-app-layout>
    @section('title', 'Dashboards - ' . config('app.name'))
    <heading level="h2">
        <x-slot name="title">
            {{ __('Statistik') . ' ' . config('app.name') }}
        </x-slot>

        <x-slot name="description">
            {{ __('Statistik data pada aplikasi') . ' ' . config('app.name') }}
        </x-slot>
    </heading>

    <div class="flex flex-col gap-4">
        <x-heading level="h2">
            <x-slot name="title">
                {{ __('Data Pembayaran') }}
            </x-slot>

            <x-slot name="description">
                {{ __(' Data pembayaran aplikasi Bidan Eka Muzaifa.') }}
            </x-slot>
        </x-heading>

        <div class="grid gap-4 lg:grid-cols-2 xl:grid-cols-4">
            @foreach ($sums as $item)
                <div class="flex flex-col p-4 mb-2 text-sm rounded-lg frame gap-y-4">
                    <div class="flex items-center justify-between text-zinc-500">
                        <span class=" font-semibold text-primary">
                            {{ \Illuminate\Support\Str::title(__('status.' . $item->status)) }}</span>
                    </div>
                    <span class="text-2xl font-semibold text-primary">
                        <x-currency value="{{ $item->sum }}" />
                    </span>
                </div>
            @endforeach
        </div>
    </div>

</x-app-layout>
