<x-guest-layout>
    <form method="POST" action="{{ route('password.email') }}" class="flex flex-col gap-6">
        @csrf

        <x-heading level="h2">
            <x-slot name="title">
                {{ __('Lupa Password') }}
            </x-slot>
            <x-slot name="description">
                {{ __('Kami akan mengirim email untuk mengatur ulang kata sandi Anda.') }}
            </x-slot>
        </x-heading>

        @if (session('status') == 'verification-link-sent')
            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                {{ session('Kami telah mengirimkan email pengaturan ulang kata sandi Anda!') }}
            </div>
        @endif

        <div>
            <x-label for="email" :value="__('fields.email.label')" />
            <x-input id="email" type="email" name="email" :value="old('email')" :placeholder="__('fields.email.placeholder')" autocomplete="email"
                required />
            <x-error :value="$errors->get('email')" />
        </div>

        <x-button type="submit" variant="accent" size="lg">
            {{ __('Kirim Email') }}
        </x-button>
    </form>
</x-guest-layout>
