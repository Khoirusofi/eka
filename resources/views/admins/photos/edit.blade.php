<x-app-layout>
    <x-heading level="h2">
        <x-slot name="title">
            {{ __('Perbarui Data Galleri') }}
        </x-slot>

        <x-slot name="description">
            {{ __('Perbarui Data Galleri, dan pastikan data yang dikirim benar') }}
        </x-slot>
    </x-heading>

    <form action="{{ route('admins.photos.update', $photo) }}" method="post" class="grid items-start gap-6 lg:grid-cols-2"
        novalidate enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div>
            <x-label for="title" :value="__('galleries.title.label')" />
            <x-input id="title" type="text" name="title" placeholder="{{ __('galleries.title.placeholder') }}"
                value="{{ old('title') ?? $photo->title }}" autocomplete="title" autofocus required />
            <x-error :value="$errors->get('title')" />
        </div>

        <div>
            <x-label for="status" :value="__('galleries.status.label')" />
            <x-select id="status" name="status" required>
                @foreach ($statuses as $item)
                    <option value="{{ $item }}" @if ($item == (old('status') ?? $photo->status)) selected @endif>
                        {{ \Illuminate\Support\Str::title($item) }}
                    </option>
                @endforeach
            </x-select>
            <x-error :value="$errors->get('status')" />
        </div>

        <div class="col-span-full">
            <x-label for="photo" :value="__('galleries.photo.label')" />
            <x-image-upload name="photo" value="{{ $photo->photo ? asset('media/photo/' . $photo->photo) : null }}"
                placeholder="{{ __('galleries.photo.placeholder') }}" />
            <x-error :value="$errors->get('photo')" />
        </div>

        <div class="flex justify-end space-x-2 col-span-full">
            <x-button type="reset" variant="outline">
                {{ __('actions.reset') }}
            </x-button>

            <x-button type="submit" variant="primary">
                {{ __('actions.submit') }}
            </x-button>
        </div>
    </form>
    </div>
</x-app-layout>
