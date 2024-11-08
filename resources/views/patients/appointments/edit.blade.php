<x-app-layout>
    @section('title', 'Pembayaran Janji Temu - ' . config('app.name'))
    <x-heading level="h2">
        <x-slot name="title">
            {{ __('Pembayaran Janji Temu') }}
        </x-slot>

        <x-slot name="description">
            {{ __('Silahkan lakukan pembayaran dan pastikan data yang dikirim benar') }}
        </x-slot>
    </x-heading>

    <form action="{{ route('patients.appointments.update', $appointment) }}" method="post"
        class="grid gap-6 lg:grid-cols-2" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="col-span-full">
            <x-label for="deadline" :value="__('appointments.deadline.label')" />

            @if (auth()->user()->role == 'patient')
                <div x-data="{
                    datestr: null,
                    timeleft: null,
                
                    init() {
                        this.datestr = {{ json_encode($appointment->created_at->addMinutes($timeout)->toDateTimeString()) }};
                        this.timeleft = this.update();
                
                        setInterval(() => {
                            this.timeleft = this.update();
                        }, 1000);
                    },
                
                    update() {
                        const offset = new Date().getTimezoneOffset() * 60000;
                        const current = new Date();
                        const target = new Date(this.datestr);
                
                        const diff = target - current - offset;
                
                        // Hanya hitung waktu tersisa, tanpa redirect jika waktu sudah habis
                        return humanizeTime(Math.max(0, diff / 1000));
                    },
                }">
                    <span class="font-medium text-accent" x-text="timeleft">test</span>
                    <br>
                    <br>
                    <x-label for="payment_id" :value="__('appointments.payment_id.label')" />
                    <div class="flex items-center">
                        <span class="font-semibold text-accent mr-2">{{ $appointment->payment->account }} -
                            <span id="payment-number">{{ $appointment->payment->number }}</span>
                        </span>

                        <a class="block px-4 py-2 text-[#3e6553]  font-medium text-sm transition duration-300 transform hover:translate-x-1 cursor-pointer"
                            onclick="copyToClipboard()" variant="primary">
                            <i class="ri-file-copy-line"></i> {{ __('Salin') }}
                        </a>
                        <div id="copy-notification" class="ml-2 text-sm text-[#365949] hidden">
                            Nomor rekening berhasil disalin!
                        </div>

                    </div>
                    <script>
                        function copyToClipboard() {
                            // Ambil nomor pembayaran dari elemen dengan id "payment-number"
                            var paymentNumber = document.getElementById("payment-number").textContent;

                            // Membuat elemen input sementara untuk menyalin teks
                            var tempInput = document.createElement("input");
                            tempInput.value = paymentNumber;
                            document.body.appendChild(tempInput);

                            // Salin teks dari input sementara ke clipboard
                            tempInput.select();
                            document.execCommand("copy");

                            // Hapus elemen input sementara setelah disalin
                            document.body.removeChild(tempInput);

                            // Tampilkan notifikasi bahwa nomor telah disalin
                            var notification = document.getElementById("copy-notification");
                            notification.classList.remove("hidden");

                            // Sembunyikan notifikasi setelah 2 detik
                            setTimeout(function() {
                                notification.classList.add("hidden");
                            }, 2000);
                        }
                    </script>
                </div>
            @else
                <span class="font-semibold text-accent">{{ $appointment->payment->account }}
                    - {{ $appointment->payment->number }}</span>
            @endif
        </div>

        <div class="col-span-full">
            <x-label for="name" :value="__('appointments.name.label')" />
            <x-avatar value="{{ $appointment->patient->user->name }}" size="sm" expand />
        </div>

        <div>
            <x-label for="date" :value="__('appointments.date.label')" />
            <x-input id="date" type="text" name="date"
                placeholder="{{ __('appointments.date.placeholder') }}"
                value="{{ \Carbon\Carbon::parse($appointment->date)->translatedFormat('l, d F Y') }}" readonly />
        </div>

        <div>
            <x-label for="time" :value="__('appointments.time.label')" />
            <x-input id="time" type="text" name="time"
                placeholder="{{ __('appointments.time.placeholder') }}"
                value="{{ \Carbon\Carbon::parse($appointment->time)->format('H:i') }} WIB" readonly />
        </div>

        <div class="col-span-full">
            <x-label for="total" :value="__('appointments.total.label')" />
            <div class="flex flex-col gap-2">
                <div class="flex items-center gap-x-4 text-zinc-500">
                    <span class="flex-none">{{ __('appointments.code.label') }}</span>
                    <div class="w-full border-b border-dotted border-zinc-500"></div>
                    <span class="flex-none">
                        <x-currency value="{{ $appointment->code }}" />
                    </span>
                </div>

                <div class="flex items-center gap-x-4 text-zinc-500">
                    <span class="flex-none">{{ __('appointments.price.label') }}</span>
                    <div class="w-full border-b border-dotted border-zinc-500"></div>
                    <span class="flex-none">
                        <x-currency value="{{ $appointment->service->price }}" />
                    </span>
                </div>

                <div class="flex items-center gap-x-4 text-zinc-500">
                    <span class="flex-none">{{ __('appointments.sum.label') }}</span>
                    <div class="w-full border-b border-dotted border-zinc-500"></div>
                    <span class="flex-none font-bold text-accent">
                        <x-currency value="{{ $appointment->service->price + $appointment->code }}" />
                    </span>
                </div>
            </div>
        </div>

        <div class="col-span-full">
            <x-label for="note" :value="__('appointments.note.label')" />
            @if (in_array(auth()->user()->role, ['admin', 'bidan']))
                <p class="text-zinc-500">
                    {{ __('Pastikan jumlah pembayaran yang dikirim benar, kode unik digunakan untuk mengkonfirmasi pembayaran, cek dengan teliti di mutasi bank berdasarkan metode pembayaran pasien') }}
                </p>
            @endif
            @if (in_array(auth()->user()->role, ['patient']))
                <p class="text-zinc-500">
                    {{ __('Pastikan jumlah pembayaran yang dikirim benar, kode unik digunakan untuk mengkonfirmasi pembayaran') }}
                </p>
            @endif
        </div>

        @if (in_array(auth()->user()->role, ['admin', 'bidan']))
            <div>
                <x-label for="status" :value="__('fields.status.label')" />
                <x-select id="status" name="status" x-on:change="$form.submit()">
                    @foreach ($statuses as $item)
                        <option value="{{ $item }}" @if ($item == $status) selected @endif>
                            {{ \Illuminate\Support\Str::title(__('status.' . $item)) }}
                        </option>
                    @endforeach
                </x-select>
            </div>
        @endif


        {{-- <div class="col-span-full">
            <x-label for="receipt" :value="__('appointments.receipt.label')" />
            <p class="text-zinc-500">
                {{ __('Masukkan Bukti Pembayaran, format JPG atau PNG, ukuran maksimal 2MB (Opsional)') }}</p>
            <x-image-upload name="receipt" value="{{ old('receipt') }}"
                placeholder="{{ __('appointments.receipt.placeholder') }}" />
            <x-error :value="$errors->get('receipt')" />
        </div> --}}

        <div class="flex justify-end space-x-2 col-span-full">
            @if (in_array(auth()->user()->role, ['admin', 'bidan']))
                <x-button type="submit" variant="primary">
                    {{ __('Konfirmasi Pembayaran') }}
                </x-button>
            @endif
            @if (in_array(auth()->user()->role, ['patient']))
                <x-button type="submit" variant="primary">
                    {{ __('Sudah Melakukan Pembayaran') }}
                </x-button>
            @endif
        </div>
        @if (in_array(auth()->user()->role, ['admin', 'bidan']))
            <div class="flex flex-col-reverse lg:flex-row lg:justify-end gap-4 col-span-full">
                <x-button type="button" variant="primary"
                    onclick="window.location.href='{{ route('patients.appointments.index', $appointment) }}'">
                    <i data-lucide="arrow-left"></i>
                    {{ __('Kembali') }}
                </x-button>
            </div>
        @endif
    </form>
</x-app-layout>
