<x-app-layout>
    @section('title', 'Tambah Data Artikel - ' . config('app.name'))
    <x-heading level="h2">
        <x-slot name="title">
            {{ __('Tambah Data Artikel') }}
        </x-slot>

        <x-slot name="description">
            {{ __('Tambah Data Artikel, dan pastikan data yang dikirim benar') }}
        </x-slot>
    </x-heading>

    <form action="{{ route('admins.articles.store') }}" method="post" class="grid gap-6 lg:grid-cols-2" novalidate
        enctype="multipart/form-data">
        @csrf

        <div>
            <x-label for="title" :value="__('articles.title.label')" />
            <x-input id="title" type="text" name="title" placeholder="{{ __('articles.title.placeholder') }}"
                value="{{ old('title') }}" autocomplete="title" autofocus required />
            <x-error :value="$errors->get('title')" />
        </div>

        <div>
            <x-label for="status" :value="__('articles.status.label')" />
            <x-select id="status" name="status" required>
                @foreach ($statuses as $item)
                    <option value="{{ $item }}" @if ($item == old('status')) selected @endif>
                        {{ \Illuminate\Support\Str::title($item) }}
                    </option>
                @endforeach
            </x-select>
            <x-error :value="$errors->get('status')" />
        </div>

        <div>
            <x-label for="category_id" :value="__('articles.category.label')" />
            <x-select id="category_id" name="category_id" required>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @if ($category->id == old('kategori')) selected @endif>
                        {{ \Illuminate\Support\Str::title($category->name) }}
                    </option>
                @endforeach
            </x-select>
            <x-error :value="$errors->get('category_id')" />
        </div>

        <div class="col-span-full">
            <x-label for="photo" :value="__('articles.photo.label')" />
            <x-image-upload name="photo" value="{{ old('photo') }}"
                placeholder="{{ __('articles.photo.placeholder') }}" required />
            <x-error :value="$errors->get('photo')" />
        </div>

        <div class="col-span-full">
            <x-label for="excerpt" :value="__('articles.excerpt.label')" />
            <x-textarea id="excerpt" name="excerpt" placeholder="{{ __('articles.excerpt.placeholder') }}"
                value="{{ old('excerpt') }}" required />
            <x-error :value="$errors->get('excerpt')" />
        </div>

        <div class="col-span-full">
            <x-label for="body" :value="__('articles.body.label')" />
            <x-textarea id="body" name="body" placeholder="{{ __('articles.body.placeholder') }}"
                value="{{ old('body') }}" required />
            <x-error :value="$errors->get('body')" />
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

    @push('scripts')
        <script src="{{ asset('vendor/tinymce/js/tinymce/tinymce.min.js') }}"></script>
        <script>
            tinymce.init({
                selector: 'textarea#body',
                license_key: 'gpl',
            });
        </script>
    @endpush
</x-app-layout>
