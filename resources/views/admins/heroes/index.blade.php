<x-app-layout>
    <x-heading level="h2">
        <x-slot name="title">
            {{ __('Kelola Data Hero') }}
        </x-slot>

        <x-slot name="description">
            {{ __('Kelola Data Hero pada aplikasi') . ' ' . config('app.name') }}
        </x-slot>
    </x-heading>

    <div class="flex flex-col justify-between gap-6 lg:items-end lg:flex-row">
        <form action="{{ route('admins.heroes.index') }}" method="get" class="flex flex-col items-end gap-4 lg:flex-row"
            x-data="{ $form: null, init() { this.$form = this.$refs.form; } }" x-ref="form">

            <div class="w-full min-w-40">
                <x-label for="search" :value="__('fields.search.label')" />
                <x-input id="search" type="text" name="search"
                    placeholder="{{ __('fields.search.placeholder') }}" value="{{ $search }}"
                    autocomplete="search" x-on:input.debounce.300ms="$form.submit()" autofocus />
            </div>
        </form>

        <div class="flex items-center justify-end space-x-2">
            <a href="{{ route('admins.heroes.create') }}">
                <x-button variant="accent">
                    <i data-lucide="plus"></i>
                    {{ __('Gambar') }}
                </x-button>
            </a>
        </div>
    </div>

    <x-table>
        <x-slot name="head">
            <th>{{ __('Gambar') }}</th>
            <th class="min-w-40">{{ __('Judul') }}</th>
            <th>{{ __('Deskripsi') }}</th>
            <th>{{ __('Text') }}</th>
            <th>{{ __('Tanggal Dibuat') }}</th>
            <th>{{ __('Aksi') }}</th>
        </x-slot>

        <x-slot name="body">
            @forelse ($heroes as $hero)
                <tr>
                    <td>
                        @if ($hero->background_hero)
                            <img src="{{ asset('media/hero/' . $hero->background_hero) }}" alt="{{ $hero->title }}"
                                class="h-16 w-16 object-cover rounded-lg" />
                        @else
                            {{ __('No Image') }}
                        @endif
                    </td>
                    <td>
                        {{ Str::words($hero->title, 3) }}
                    </td>
                    <td>
                        {{ Str::limit($hero->description, 17) }}
                    </td>
                    <td>
                        {{ Str::limit($hero->button_text, 17) }}
                    </td>
                    <td> <x-date :value="$hero->created_at" /> </td>
                    <td>
                        <x-action edit="{{ route('admins.heroes.edit', $hero) }}"
                            delete="{{ route('admins.heroes.destroy', $hero) }}"
                            onDeleteConfirm="return confirm('Are you sure you want to delete this photo?');" />
                    </td>
                </tr>
            @empty
                <tr>
                    <td colSpan="6" class="text-center">{{ __('Tidak ada data') }}</td>
                </tr>
            @endforelse
        </x-slot>
    </x-table>

    {{ $heroes->links() }}
</x-app-layout>
