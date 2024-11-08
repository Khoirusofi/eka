<x-app-layout>
    @section('title', 'Perbarui Kategori - ' . config('app.name'))

    <x-heading level="h2">
        <x-slot name="title">
            {{ __('Perbarui Data Kategori') }}
        </x-slot>

        <x-slot name="description">
            {{ __('Perbarui Data Kategori, dan pastikan data yang dikirim benar') }}
        </x-slot>
    </x-heading>

    <form action="{{ route('admins.categories.update', $category->id) }}" method="post"
        class="grid items-start gap-6 lg:grid-cols-2" novalidate>
        @csrf
        @method('PUT')

        <div>
            <x-label for="name" :value="__('categories.name.label')" />
            <x-input id="name" type="text" name="name" placeholder="{{ __('categories.name.placeholder') }}"
                value="{{ old('name') ?? $category->name }}" autocomplete="name" autofocus required />
            <x-error :value="$errors->get('name')" />
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

</x-app-layout>
