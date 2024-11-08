<x-guest-layout>
    <form method="POST" action="{{ route('login') }}" class="flex flex-col gap-6">
        @csrf

        <x-heading level="h2">
            <x-slot name="title">
                {{ __('Masuk ke Akun Anda') }}
            </x-slot>
            <x-slot name="description">
                {{ __('Masukkan informasi Anda untuk mulai membuat Janji.') }}
            </x-slot>
        </x-heading>

        <div>
            <x-label for="email" :value="__('fields.email.label')" />
            <x-input id="email" type="email" name="email" :value="old('email')" :placeholder="__('fields.email.placeholder')"
                autocomplete="username" required />
            <x-error :value="$errors->get('email')" />
        </div>

        <div>
            <x-label for="password" :value="__('fields.password.label')" />
            <x-input id="password" type="password" name="password" :value="old('password')" :placeholder="__('fields.password.placeholder')"
                autocomplete="current-password" required />
            <x-error :value="$errors->get('password')" />
        </div>

        <div class="flex items-center space-x-2">
            <x-checkbox id="remember_me" name="remember_me" />
            <x-label for="remember_me" :value="__('fields.remember_me.label')" class="mb-0" />
        </div>

        <x-button type="submit" variant="accent" size="lg">
            {{ __('Masuk') }}
        </x-button>

        <p class="text-center text-gray-600">
            {{ __('Belum memiliki akun? ') }}
            <a href="{{ route('register') }}" class="font-semibold text-accent">
                {{ __('Daftar') }}
            </a>
        </p>
    </form>
    <p class="text-center text-gray-600">
        {{ __('Lupa Password? ') }}
        <a href="{{ route('password.email') }}" class="font-semibold text-accent">
            {{ __('Ganti Password') }}
        </a>
    </p>

</x-guest-layout>
