<x-app-layout>
    @section('title', 'Kritik Saran dan Testimoni - ' . config('app.name'))
    @php
        $title =
            auth()->user()->role === 'patient'
                ? __('Riwayat Kritik Saran dan Testimoni')
                : __('Kelola Data Kritik Saran dan Testimoni');
        $description =
            auth()->user()->role === 'patient'
                ? __('Lihat Riwayat Kritik Saran dan Testimoni') . ' ' . auth()->user()->name
                : __('Kelola Data Kritik Saran dan Testimoni pada aplikasi') . ' ' . config('app.name');
    @endphp

    <x-heading level="h2">
        <x-slot name="title">
            {{ $title }}
        </x-slot>

        <x-slot name="description">
            {{ $description }}
        </x-slot>
    </x-heading>

    <div class="flex flex-col justify-between gap-6 lg:items-end lg:flex-row">
        <form action="{{ route('patients.reviews.index') }}" method="get"
            class="flex flex-col items-end gap-4 lg:flex-row" x-data="{
                $form: null,
                init() {
                    this.$form = this.$refs.form;
                },
            }" x-ref="form">

            @if (auth()->user()->hasRole('admin') || auth()->user()->hasRole('bidan'))
                <div class="w-full min-w-40">
                    <x-label for="search" :value="__('fields.search.label')" />
                    <x-input id="search" type="text" name="search"
                        placeholder="{{ __('fields.search.placeholder') }}" value="{{ $search }}"
                        autocomplete="search" x-on:input.debounce.300ms="$form.submit()" autofocus />
                </div>
            @endif
        </form>

        @role('patient')
            <a href="{{ route('patients.reviews.create') }}" class=" animate-bounce">
                <x-button variant="accent">
                    <i data-lucide="message-square-plus"></i>
                    {{ __('Kritik Saran dan Testimoni') }}
                </x-button>
            </a>
        @endrole
    </div>

    <x-table>
        <x-slot name="head">
            <th>{{ __('No') }}</th>
            @if (auth()->user()->hasRole('admin') || auth()->user()->hasRole('bidan'))
                <th class="min-w-40">{{ __('Nama') }}</th>
            @endif
            <th>{{ __('Kritik dan Saran') }}</th>
            <th>{{ __('Testimoni') }}</th>
            <th>{{ __('Aksi') }}</th>
        </x-slot>

        <x-slot name="body">
            @forelse ($reviews as $review)
                <tr>
                    <td>{{ ($reviews->currentPage() - 1) * $reviews->perPage() + $loop->iteration }}</td>
                    @if (auth()->user()->hasRole('admin') || auth()->user()->hasRole('bidan'))
                        <td> <x-avatar value="{{ $review->user->name }}" size="sm" expand /></td>
                    @endif
                    <td>
                        {{ \Illuminate\Support\Str::words($review->body, 4) }}
                    </td>
                    <td>
                        {{ \Illuminate\Support\Str::words($review->action, 4) }}
                    </td>
                    <td>
                        <a href="{{ route('patients.reviews.show', $review) }}" class="inline-flex">
                            <x-button variant="outline" size="icon" label="{{ __('Lihat') }}">
                                <i data-lucide="folder-search" class="size-5"></i>
                            </x-button>
                        </a>

                        @role('admin')
                            <a href="{{ route('admins.reviews.edit', $review) }}" class="inline-flex">
                                <x-button variant="outline" size="icon" label="{{ __('Edit') }}">
                                    <i data-lucide="settings-2" class="size-5"></i>
                                </x-button>
                            </a>

                            <x-button class="block" variant="outline" size="icon" label="{{ __('Hapus') }}"
                                x-on:click="$dispatch('modal', {
                                    name: 'delete-modal',
                                    action: '{{ route('admins.reviews.destroy', $review) }}'
                                })">
                                <i data-lucide="trash-2" class="size-5"></i>
                            </x-button>
                        @endrole
                    </td>
                </tr>
            @empty
                <tr>
                    <td colSpan="5" class="text-center">{{ __('Tidak ada data') }}</td>
                </tr>
            @endforelse
        </x-slot>
    </x-table>

    {{ $reviews->links() }}

    <div class="flex flex-col-reverse lg:flex-row lg:justify-end gap-4 col-span-full">
        <x-button type="button" variant="primary" onclick="window.location.href='{{ route('dashboard') }}'">
            <i data-lucide="arrow-left"></i>
            {{ __('Kembali') }}
        </x-button>
    </div>
</x-app-layout>
