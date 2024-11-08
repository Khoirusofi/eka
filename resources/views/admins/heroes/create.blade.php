<x-app-layout>
    <x-heading level="h2">
        <x-slot name="title">
            {{ __('Tambah Data Hero') }}
        </x-slot>

        <x-slot name="description">
            {{ __('Tambah Data Hero, dan pastikan data yang dikirim benar') }}
        </x-slot>
    </x-heading>

    <form action="{{ route('admins.heroes.store') }}" method="post" class="grid gap-6 lg:grid-cols-2" novalidate
        enctype="multipart/form-data">
        @csrf

        <div>
            <x-label for="title" :value="__('heroes.title.label')" />
            <x-input id="title" type="text" name="title" placeholder="{{ __('heroes.title.placeholder') }}"
                value="{{ old('title') }}" autocomplete="title" autofocus required />
            <x-error :value="$errors->get('title')" />
        </div>
        <div>
            <x-label for="description" :value="__('heroes.description.label')" />
            <x-input id="description" type="text" name="description"
                placeholder="{{ __('heroes.description.placeholder') }}" value="{{ old('description') }}"
                autocomplete="description" autofocus required />
            <x-error :value="$errors->get('description')" />
        </div>

        <div>
            <x-label for="button_text" :value="__('heroes.title.label')" />
            <x-input id="button_text" type="text" name="button_text"
                placeholder="{{ __('heroes.title.placeholder') }}" value="{{ old('button_text') }}"
                autocomplete="button_text" autofocus required />
            <x-error :value="$errors->get('button_text')" />
        </div>

        <div class="col-span-full">
            <x-label for="background_hero" :value="__('heroes.background_hero.label')" />
            <x-image-upload name="background_hero" value="{{ old('background_hero') }}"
                placeholder="{{ __('heroes.background_hero.placeholder') }}" required />
            <x-error :value="$errors->get('background_hero')" />
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
