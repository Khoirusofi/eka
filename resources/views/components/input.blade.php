<div class="relative" x-data="{
    ref: null,
    init() {
        this.ref = this.$refs.input;
    },
    show() {
        this.ref.type = 'text';
    },
    hide() {
        this.ref.type = 'password';
    },
}">
    <input {!! $attributes->merge([
        'class' =>
            'w-full px-4 py-2 frame focus:border-accent focus:ring-accent rounded-lg text-sm disabled:bg-zinc-100 disabled:text-zinc-400 disabled:cursor-not-allowed',
    ]) !!} x-ref="input">

    @if ($type === 'password')
        <div class="absolute z-10 -translate-y-1/2 right-4 top-1/2" x-on:mousedown="show" x-on:mouseup="hide">
            <i data-lucide="eye" class="cursor-pointer size-5 text-accent"></i>
        </div>
    @endif
</div>
