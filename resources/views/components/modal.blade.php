@props(['name'])

<div x-data="{
    show: null,
    form: null,
    name: @js($name),

    init() {
        this.form = this.$refs.form;
        this.$watch('show', value => {
            if (value) {
                document.body.classList.add('overflow-y-hidden');
            } else {
                document.body.classList.remove('overflow-y-hidden');
            }
        });
    },

    display(detail) {
        if (this.name !== detail.name)
            return;
        this.show = true;
        this.form.action = detail.action;
    },

    hide() {
        this.show = false;
        this.form.action = null;
    },
}" x-on:modal.window="display($event.detail)" x-on:close.stop="hide()"
    x-on:keydown.escape.window="hide()" x-on:keydown.escape.window="hide()" x-bind:class="{ 'hidden': !show }"
    class="fixed inset-0 z-50 hidden mt-0 overflow-y-auto sm:px-0">

    <div x-show="show" class="fixed inset-0 transition-all transform" x-on:click="show = false"
        x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
        <div class="absolute inset-0 bg-black opacity-50">
            {{-- backdrop --}}
        </div>
    </div>

    <div class="absolute w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2">
        <div x-show="show"
            class="w-full max-w-md overflow-hidden transition-all transform bg-white border rounded-xl sm:mx-auto border-neutral-200"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">

            <div class="relative p-8 space-y-6">
                <div class="space-y-4 text-center">
                    <div class="inline-flex p-2 rounded-full bg-accent/50">
                        <div class="flex items-center justify-center w-10 h-10 text-white rounded-full bg-accent">
                            <i data-lucide="trash-2" class="size-5"></i>
                        </div>
                    </div>

                    <x-heading level="h3">
                        <x-slot name="title">
                            {{ __('Konfirmasi Perubahan') }}
                        </x-slot>

                        <x-slot name="description">
                            {{ __('Anda akan menghapus data berikut? apakah Anda yakin detailnya sudah akurat?') }}
                        </x-slot>
                    </x-heading>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <x-button variant="accent" x-on:click="$dispatch('close')">
                        {{ __('Batal') }}
                    </x-button>

                    <form method="post" x-ref="form">
                        @csrf
                        @method('DELETE')

                        <x-button type="submit" variant="outline" class="w-full">
                            {{ __('Hapus') }}
                        </x-button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
