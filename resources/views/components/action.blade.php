@props([
    'edit' => null,
    'delete' => null,
])

<div class="flex items-center gap-2" x-data>
    @if ($edit)
        <a href="{{ $edit }}" class="inline-flex">
            <x-button variant="outline" size="icon" label="{{ __('Edit') }}">
                <i data-lucide="settings-2" class="size-5"></i>
            </x-button>
        </a>
    @endif

    @if ($delete)
        <x-button class="block" variant="outline" size="icon" label="{{ __('Hapus') }}"
            x-on:click="$dispatch('modal', {
            name: 'delete-modal',
            action: '{{ $delete }}'
        })">
            <i data-lucide="trash-2" class="size-5"></i>
        </x-button>
    @endif
</div>
