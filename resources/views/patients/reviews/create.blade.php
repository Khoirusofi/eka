<x-app-layout>
    @section('title', 'Kritik dan Saran - ' . config('app.name'))
    <x-heading level="h2">
        <x-slot name="title">
            {{ __('Tambah Data Kritik dan Saran') }}
        </x-slot>

        <x-slot name="description">
            {{ __('Tambah Data Kritik dan Saran, dan pastikan data yang dikirim benar') }}
        </x-slot>
    </x-heading>

    <form action="{{ route('patients.reviews.store') }}" method="post" class="grid gap-6 lg:grid-cols-2">
        @csrf

        <div class="col-span-full">
            <x-label for="body" :value="__('reviews.body.label')" />
            <x-textarea id="body" name="body" placeholder="{{ __('reviews.body.placeholder') }}"
                value="{{ old('body') }}" required rows="5" />
            <x-error :value="$errors->get('body')" />
        </div>

        <div class="col-span-full">
            <x-label for="action" :value="__('reviews.action.label')" />
            <x-textarea id="action" name="action" placeholder="{{ __('reviews.action.placeholder') }}"
                value="{{ old('action') }}" required rows="5" />
            <x-error :value="$errors->get('action')" />
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
