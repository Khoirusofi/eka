<x-guest-layout>
    <form method="POST" action="{{ route('password.store') }}" class="flex flex-col gap-6">
        @csrf

        <x-heading level="h2">
            <x-slot name="title">
                {{ __('Reset Kata Sandi') }}
            </x-slot>

            <x-slot name="description">
                {{ __('Silakan masukkan kata sandi Anda untuk mengubah ulang kata sandi Anda.') }}
            </x-slot>
        </x-heading>

        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div>
            <x-label for="email" :value="__('fields.email.label')" />
            <x-input id="email" type="email" name="email" :value="old('email', $request->email)" required autofocus
                autocomplete="username" placeholder="{{ __('fields.email.placeholder') }}" />
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
            {{ __('Reset') }}
        </x-button>
    </form>
</x-guest-layout>
