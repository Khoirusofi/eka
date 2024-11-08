<x-app-layout>
    @section('title', 'Data Kategori - ' . config('app.name'))

    <x-heading level="h2">
        <x-slot name="title">
            {{ __('Kelola Data Kategori') }}
        </x-slot>

        <x-slot name="description">
            {{ __('Kelola Data Kategori pada aplikasi') . ' ' . config('app.name') }}
        </x-slot>
    </x-heading>

    <div class="flex flex-col justify-between gap-6 lg:items-end lg:flex-row">
        <form action="{{ route('admins.categories.index') }}" method="get"
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

        <div class="flex items-center justify-end space-x-2">
            <a href="{{ route('admins.categories.create') }}">
                <x-button variant="accent">
                    <i data-lucide="plus"></i>
                    {{ __('Kategori') }}
                </x-button>
            </a>
        </div>
    </div>

    <x-table>
        <x-slot name="head">
            <th>{{ __('No') }}</th>
            <th class="min-w-40">{{ __('Nama') }}</th>
            <th>{{ __('Jumlah Artikel') }}</th>
            <th>{{ __('Aksi') }}</th>
        </x-slot>

        <x-slot name="body">
            @forelse ($categories as $category)
                <tr>
                    <td>{{ $category->id }}</td>
                    <td>{{ $category->name }}</td>
                    <td> <x-badge value="{{ $category->articles_count }}" /> </td>
                    <td>
                        <x-action edit="{{ route('admins.categories.edit', $category->id) }}"
                            delete="{{ route('admins.categories.destroy', $category->id) }}" />
                    </td>
                </tr>
            @empty
                <tr>
                    <td colSpan="4" class="text-center">{{ __('Tidak ada data') }}</td>
                </tr>
            @endforelse
        </x-slot>
    </x-table>

    {{ $categories->links() }}
</x-app-layout>
