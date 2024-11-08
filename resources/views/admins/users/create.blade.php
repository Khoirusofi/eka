<x-app-layout>
    <x-heading level="h2">
        <x-slot name="title">
            {{ __('Tambah Data Pengguna') }}
        </x-slot>

        <x-slot name="description">
            {{ __('Tambah Data Pengguna, dan pastikan data yang dikirim benar') }}
        </x-slot>
    </x-heading>

    <form action="{{ route('admins.users.store') }}" method="post" class="grid gap-6 lg:grid-cols-2">
        @csrf

        <div class="col-span-full">
            <x-label for="name" :value="__('users.name.label')" />
            <x-input id="name" type="text" name="name" placeholder="{{ __('users.name.placeholder') }}"
                value="{{ old('name') }}" required />
            <x-error :value="$errors->get('name')" />
        </div>

        <div class="col-span-full">
            <x-label for="email" :value="__('users.email.label')" />
            <x-input id="email" type="email" name="email" placeholder="{{ __('users.email.placeholder') }}"
                value="{{ old('email') }}" required />
            <x-error :value="$errors->get('email')" />
        </div>

        <div>
            <x-label for="role" :value="__('users.role.label')" />
            <x-select id="role" name="role" required>
                @foreach ($roles as $key => $value)
                    <option value="{{ $key }}" @if ($key == old('role')) selected @endif>
                        {{ \Illuminate\Support\Str::title($value) }}
                    </option>
                @endforeach
            </x-select>
            <x-error :value="$errors->get('role')" />
        </div>

        <div>
            <x-label for="password" :value="__('users.password.label')" />
            <x-input id="password" type="password" name="password" placeholder="{{ __('users.password.placeholder') }}"
                value="{{ old('password') }}" required />
            <x-error :value="$errors->get('password')" />
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
