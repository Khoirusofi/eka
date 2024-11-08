<nav class="py-6">
    <div class="flex items-start justify-between">
        <div>
            <h1 class="text-2xl font-bold text-primary">Assalamualaikum {{ auth()->user()->name }}</h1>
            <span id="datetime" class="text-sm text-tertiary font-medium"></span>

            @push('scripts')
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        function updateDateTime() {
                            const options = {
                                timeZone: 'Asia/Jakarta',
                                hour: '2-digit',
                                minute: '2-digit',
                                weekday: 'long',
                                day: '2-digit',
                                month: 'long',
                                year: 'numeric',
                                hour12: false
                            };
                            const now = new Date();
                            const timeString = now.toLocaleTimeString('id-ID', options).replace(/:/g, ' : ');

                            const datetimeElem = document.getElementById('datetime');
                            if (datetimeElem) {
                                datetimeElem.textContent = timeString;
                            }
                        }

                        updateDateTime();
                        setInterval(updateDateTime, 1000);
                    });
                </script>
            @endpush

        </div>
        <div class="flex items-center space-x-4">
            @if (auth()->check() && (auth()->user()->role == 'admin' || auth()->user()->role == 'bidan'))
                <form action="{{ route('logout') }}" method="POST"
                    class=" px-2 py-2 text-gray-700 hover:bg-gray-100 flex items-center space-x-2">
                    @csrf
                    <button type="submit" class="w-full flex items-center space-x-2 text-red-600">
                        <i class="ri-logout-box-line text-lg"></i>
                        <span>{{ __('Keluar') }}</span>
                    </button>
                </form>
            @endif
        </div>
    </div>
</nav>
