<x-app-layout>
    <x-heading level="h2">
        <x-slot name="title">
            {{ __('Pengaturan Janji Temu') }}
        </x-slot>

        <x-slot name="description">
            {{ __('Kelola pengaturan aplikasi Janji Temu ') . ' ' . config('app.name') }}
        </x-slot>
    </x-heading>

    <x-table>
        <x-slot name="head">
            <th>{{ __('Status') }}</th>
            <th>{{ __('Aksi') }}</th>
        </x-slot>

        <x-slot name="body">
            @foreach ($settings as $setting)
                <tr>
                    <td>
                        <x-badge :value="$setting->is_open ? 'janji temu buka' : 'janji temu tutup'" />
                    </td>

                    <td>
                        <x-action edit="{{ route('admins.settings.edit', $setting->id) }}" />
                    </td>
                </tr>
            @endforeach
        </x-slot>
    </x-table>

    {{ $settings->links() }}
</x-app-layout>
