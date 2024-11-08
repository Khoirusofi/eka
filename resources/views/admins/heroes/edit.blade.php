<x-app-layout>
    <x-heading level="h2">
        <x-slot name="title">
            {{ __('Perbarui Data Hero') }}
        </x-slot>

        <x-slot name="description">
            {{ __('Perbarui Data Hero, dan pastikan data yang dikirim benar') }}
        </x-slot>
    </x-heading>

    <form action="{{ route('admins.heroes.update', $hero) }}" method="post" class="grid items-start gap-6 lg:grid-cols-2"
        novalidate enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div>
            <x-label for="title" :value="__('heroes.title.label')" />
            <x-input id="title" type="text" name="title" placeholder="{{ __('heroes.title.placeholder') }}"
                value="{{ old('title') ?? $hero->title }}" autocomplete="title" autofocus required />
            <x-error :value="$errors->get('title')" />
        </div>

        <div>
            <x-label for="description" :value="__('Deskripsi Hero 1')" />
            <x-input id="description" type="text" name="description"
                placeholder="{{ __('heroes.description.placeholder') }}"
                value="{{ old('description') ?? $hero->description }}" autocomplete="description" autofocus required />
            <x-error :value="$errors->get('description')" />
        </div>

        <div>
            <x-label for="button_text" :value="__('Deskripsi Hero 2')" />
            <x-input id="button_text" type="text" name="button_text"
                placeholder="{{ __('heroes.excerpt.placeholder') }}"
                value="{{ old('button_text') ?? $hero->button_text }}" autocomplete="button_text" autofocus required />
            <x-error :value="$errors->get('button_text')" />
        </div>

        <div class="col-span-full">
            <x-label for="background_hero" :value="__('heroes.photo.label')" />
            <x-image-upload name="background_hero"
                value="{{ $hero->background_hero ? asset('media/hero/' . $hero->background_hero) : null }}"
                placeholder="{{ __('heroes.background_hero.placeholder') }}" />
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
