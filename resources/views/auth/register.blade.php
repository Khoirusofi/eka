<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" class="flex flex-col gap-6">
        @csrf

        <x-heading level="h2">
            <x-slot name="title">
                {{ __('Daftar Akun Baru') }}
            </x-slot>
            <x-slot name="description">
                {{ __('Masukkan informasi Anda untuk membuat akun.') }}
            </x-slot>
        </x-heading>

        <div>
            <x-label for="name" :value="__('fields.name.label')" />
            <x-input id="name" type="text" name="name" :value="old('name')" required autofocus autocomplete="name"
                placeholder="{{ __('Masukkan Nama Lengkap Sesuai KTP') }}" />
            <x-error :value="$errors->get('name')" />
        </div>

        <div>
            <x-label for="email" :value="__('fields.email.label')" />
            <x-input id="email" type="email" name="email" :value="old('email')" required autocomplete="username"
                placeholder="{{ __('fields.email.placeholder') }}" />
            <x-error :value="$errors->get('email')" />
        </div>

        <div>
            <x-label for="password" :value="__('fields.password.label')" />
            <x-input id="password" type="password" name="password" required autocomplete="new-password"
                placeholder="{{ __('fields.password.placeholder') }}" />
            <x-error :value="$errors->get('password')" />
        </div>

        <div>
            <x-label for="password_confirmation" :value="__('fields.password_confirmation.label')" />
            <x-input id="password_confirmation" type="password" name="password_confirmation" required
                autocomplete="new-password" placeholder="{{ __('fields.password_confirmation.placeholder') }}" />
            <x-error :value="$errors->get('password_confirmation')" />
        </div>

        <x-button type="submit" variant="accent" size="lg">
            {{ __('Daftar') }}
        </x-button>

        <p class="text-center text-gray-600">
            {{ __('Sudah memiliki akun? ') }}
            <a href="{{ route('login') }}" class="font-semibold text-accent">
                {{ __('Masuk') }}
            </a>
        </p>
    </form>
</x-guest-layout>
