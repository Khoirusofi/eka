<x-app-layout>
    <x-heading level="h2">
        <x-slot name="title">
            {{ __('Edit Pengaturan') }}
        </x-slot>

        <x-slot name="description">
            {{ __('Edit Pengaturan, dan pastikan data yang dikirim benar') }}
        </x-slot>
    </x-heading>

    <form action="{{ route('admins.settings.update', $setting->id) }}" method="POST" class="grid gap-6 lg:grid-cols-2"
        novalidate>
        @csrf
        @method('PUT')

        <div>
            <x-label for="status" :value="__('Status')" />
            <x-select id="status" name="is_open" required>
                <option value="1" @if ($setting->is_open) selected @endif>Buka Janji Temu </option>
                <option value="0" @if (!$setting->is_open) selected @endif>Tutup Janji Temu </option>
            </x-select>
            <x-error :value="$errors->get('is_open')" />
        </div>

        <div class="flex justify-end space-x-2 col-span-full">
            <x-button type="submit" variant="primary">
                {{ __('Update') }}
            </x-button>
        </div>
    </form>
</x-app-layout>
