@props([
    'name' => null,
    'value' => null,
    'required' => false,
    'placeholder' => null,
])


<div x-data="{
    file: null,
    input: null,
    preview: null,

    init() {
        this.file = null;
        this.input = this.$refs.input;
        this.preview = this.$refs.preview;

        const value = {{ json_encode($value) }};
        if (value) {
            this.file = true;
            this.preview.src = value;
        }
    },
    open() {
        this.input.click();
    },
    upload(e) {
        this.file = e.target.files[0];
        this.preview.src = URL.createObjectURL(this.file);
    },
    remove() {
        this.file = null;
        this.preview.src = null;
    },
}" {!! $attributes->merge([
    'class' =>
        'relative flex items-center justify-center w-full overflow-hidden rounded-lg cursor-pointer aspect-video bg-zinc-50 frame focus:border-accent focus:ring-accent disabled:bg-zinc-100 disabled:text-zinc-400 disabled:cursor-not-allowed',
]) !!} x-on:click="open">

    <div x-show="!file" class="flex items-center justify-center max-w-xs text-center">
        <p class="text-zinc-400">{{ $placeholder }}</p>
    </div>

    <input x-ref="input" type="file" name="{{ $name }}" accept="image/*" class="hidden"
        x-on:change="upload($event)" @if ($required) required @endif />
    <img x-show="file" x-ref="preview" class="object-cover object-center w-full h-full" />

    <div x-show="file" class="absolute top-0 right-0 m-6">
        <x-button variant="accent" size="icon" label="{{ __('Ganti Foto') }}" x-on:click="remove">
            <i data-lucide="upload"></i>
        </x-button>
    </div>
</div>
