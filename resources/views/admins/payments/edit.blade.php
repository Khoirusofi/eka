<x-app-layout>
    <x-heading level="h2">
        <x-slot name="title">
            {{ __('Perbarui Data Metode Pembayaran') }}
        </x-slot>

        <x-slot name="description">
            {{ __('Perbarui Data Metode Pembayaran, dan pastikan data yang dikirim benar') }}
        </x-slot>
    </x-heading>

    <form action="{{ route('admins.payments.update', $payment) }}" method="post" class="grid gap-6 lg:grid-cols-2">
        @csrf
        @method('PUT')

        <div>
            <x-label for="account" :value="__('payments.account.label')" />
            <x-input id="account" type="text" name="account" placeholder="{{ __('payments.account.placeholder') }}"
                value="{{ old('account') ?? $payment->account }}" autocomplete="account" autofocus required />
            <x-error :value="$errors->get('account')" />
        </div>

        <div>
            <x-label for="number" :value="__('payments.number.label')" />
            <x-input id="number" type="number" name="number" placeholder="{{ __('payments.number.placeholder') }}"
                value="{{ old('number') ?? $payment->number }}" required />
            <x-error :value="$errors->get('number')" />
        </div>

        <div class="col-span-full">
            <x-label for="description" :value="__('payments.description.label')" />
            <x-textarea id="description" name="description" placeholder="{{ __('payments.description.placeholder') }}"
                value="{{ old('description') ?? $payment->description }}" required rows="5" />
            <x-error :value="$errors->get('description')" />
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
