<x-app-layout>
    <x-heading level="h2">
        <x-slot name="title">
            {{ __('Kelola Data Galeri') }}
        </x-slot>

        <x-slot name="description">
            {{ __('Kelola Data Galeri pada aplikasi') . ' ' . config('app.name') }}
        </x-slot>
    </x-heading>

    <div class="flex flex-col justify-between gap-6 lg:items-end lg:flex-row">
        <form action="{{ route('admins.photos.index') }}" method="get" class="flex flex-col items-end gap-4 lg:flex-row"
            x-data="{ $form: null, init() { this.$form = this.$refs.form; } }" x-ref="form">

            <div class="w-full min-w-40">
                <x-label for="search" :value="__('fields.search.label')" />
                <x-input id="search" type="text" name="search"
                    placeholder="{{ __('fields.search.placeholder') }}" value="{{ $search }}"
                    autocomplete="search" x-on:input.debounce.300ms="$form.submit()" autofocus />
            </div>

            <div class="w-full min-w-40">
                <x-label for="status" :value="__('galleries.status.label')" />
                <x-select id="status" name="status" required x-on:input="$form.submit()">
                    <option value="" @if ($status == null) selected @endif>
                        {{ __('galleries.status.placeholder') }}
                    </option>

                    @foreach ($statuses as $item)
                        <option value="{{ $item }}" @if ($item == $status) selected @endif>
                            {{ \Illuminate\Support\Str::title($item) }}
                        </option>
                    @endforeach
                </x-select>
            </div>
        </form>

        {{-- <div class="flex items-center justify-end space-x-2">
            <a href="{{ route('admins.photos.create') }}">
                <x-button variant="accent">
                    <i data-lucide="plus"></i>
                    {{ __('Gambar') }}
                </x-button>
            </a>
        </div> --}}
    </div>

    <x-table>
        <x-slot name="head">
            <th>{{ __('No') }}</th>
            <th>{{ __('Gambar') }}</th>
            <th class="min-w-40">{{ __('Judul') }}</th>
            <th>{{ __('Status') }}</th>
            <th>{{ __('Tanggal Dibuat') }}</th>
            <th>{{ __('Aksi') }}</th>
        </x-slot>

        <x-slot name="body">
            @forelse ($photos as $photo)
                <tr>
                    <td> {{ $loop->iteration }} </td>
                    <td>
                        @if ($photo->photo)
                            <img src="{{ asset('media/photo/' . $photo->photo) }}" alt="{{ $photo->title }}"
                                class="h-16 w-16 object-cover rounded-lg" />
                        @else
                            {{ __('No Image') }}
                        @endif
                    </td>
                    <td>
                        {{ \Illuminate\Support\Str::words($photo->title, 3) }}
                    </td>
                    <td> <x-badge value="{{ $photo->status }}" /> </td>
                    <td> <x-date value="{{ $photo->created_at }}" /> </td>
                    <td>
                        <x-action edit="{{ route('admins.photos.edit', $photo) }}"
                            delete="{{ route('admins.photos.destroy', $photo) }}"
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

    {{ $photos->links() }}
</x-app-layout>
