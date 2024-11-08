@props(['status', 'timeout' => 5000])

@if ($status)
    <div {{ $attributes->merge([
        'class' =>
            'fixed px-4 py-2 border rounded-md text-sm font-semibold transition-transform transform bg-green-100 text-green-800 border-green-300 shadow-md',
        'role' => 'alert',
    ]) }}
        x-data="{
            timeout: null,
            init() {
                this.timeout = setTimeout(() => {
                    this.$el.classList.add('opacity-0', 'translate-y-4');
                }, {{ $timeout }});
            }
        }">
        {{ $status }}
    </div>
@endif
