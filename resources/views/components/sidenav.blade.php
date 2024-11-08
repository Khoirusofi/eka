@props(['open' => false, 'label' => '', 'icon' => ''])

<div class="text-sm text-white" x-data="{
    ref: null,
    arrow: null,
    expanded: $persist(false).as('{{ $label }}'),

    init() {
        this.ref = this.$refs.menu;
        this.arrow = this.$refs.arrow;

        if (this.expanded) {
            this.ref.classList.toggle('hidden');
            this.arrow.classList.toggle('rotate-180');
        }
    },

    toggle() {
        if (!open) open = true;
        this.expanded = !this.expanded;
        this.ref.classList.toggle('hidden');
        this.arrow.classList.toggle('rotate-180');
    }
}">
    <div class="relative flex items-center p-2 mb-4 space-x-4 rounded-md cursor-pointer hover:bg-white/10"
        x-on:click="toggle">
        <i data-lucide="{{ $icon }}" class="flex-none size-5"></i>

        <div x-bind:class="{ 'md:sr-only': !open }" class="flex items-center justify-between w-full md:sr-only">
            <span class="w-4/5 line-clamp-1">{{ $label }}</span>
            <i data-lucide="chevron-down" x-ref="arrow" class="flex-none size-5"></i>
        </div>
    </div>

    <ul class="hidden mb-4 space-y-2 ps-7 [&>*]:px-4 [&>*]:py-2 [&>*]:rounded-md  [&>*:hover]:bg-white/10"
        x-ref="menu" x-show="open">
        {{ $slot }}
    </ul>
</div>
