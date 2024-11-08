<x-app-layout>
    @section('title', 'Kritik dan Saran - ' . config('app.name'))
    <x-heading level="h2">
        <x-slot name="title">
            {{ __('Perbarui Data Kritik dan Saran') }}
        </x-slot>

        <x-slot name="description">
            {{ __('Perbarui Data Kriitk dan Saran, dan pastikan data yang dikirim benar') }}
        </x-slot>
    </x-heading>

    <form action="{{ route('admins.reviews.update', $review) }}" method="post" class="grid gap-6 lg:grid-cols-2">
        @csrf
        @method('PUT')

        <div class="col-span-full">
            <x-label for="body" :value="__('reviews.body.label')" />
            <x-textarea id="body" name="body" placeholder="{{ __('reviews.body.placeholder') }}"
                value="{{ old('body') ?? $review->body }}" required rows="5" />
            <x-error :value="$errors->get('body')" />
        </div>

        <div class="col-span-full">
            <x-label for="action" :value="__('reviews.action.label')" />
            <x-textarea id="action" name="action" placeholder="{{ __('reviews.action.placeholder') }}"
                value="{{ old('action') ?? $review->action }}" required rows="5" />
            <x-error :value="$errors->get('action')" />
        </div>

        <div class="col-span-full">
            <x-label for="respond" :value="__('reviews.respond.label')" />
            <x-textarea id="respond" name="respond" placeholder="{{ __('reviews.respond.placeholder') }}"
                value="{{ old('respond') ?? $review->respond }}" required rows="5" />
            <x-error :value="$errors->get('respond')" />
        </div>

        <div>
            <x-label for="status" :value="__('reviews.status.label')" />
            <x-select id="status" name="status" required>
                @foreach ($statuses as $item)
                    <option value="{{ $item }}" @if ($item == (old('status') ?? $review->status)) selected @endif>
                        {{ \Illuminate\Support\Str::title($item) }}
                    </option>
                @endforeach
            </x-select>
            <x-error :value="$errors->get('status')" />
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
