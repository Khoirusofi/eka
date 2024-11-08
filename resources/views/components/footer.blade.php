<footer class="footer max-w-7xl mx-auto py-12 px-4 lg:px-0 mt-8">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 px-4 sm:px-6 lg:px-8">
        <div class="card p-7 flex flex-col gap-y-5">
            <div class="flex flex-col gap-y-2">
                <x-logo variant="color" size="sm" />
                <h1 class="font-base font-semibold">
                    Berlangganan newsletter kami untuk selalu mendapatkan informasi terkini.
                </h1>
                {{-- @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative"
                        role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif --}}
                <div class="bg-[#e6efeb] p-2 flex justify-between items-center text-xs rounded-sm">
                    <form action="{{ route('subscribe.store') }}" method="POST" class="flex w-full items-center">
                        @csrf
                        <x-input type="email" placeholder="Email Anda" id="email" name="email"
                            class="flex-grow p-1 text-sm text-[#565d59] bg-[#e6efeb] border-none outline-none rounded-sm" />
                        <button
                            class="px-4 py-2 bg-[#3e6553] text-white rounded-md font-medium text-sm hover:bg-[#365949] transition duration-300 transform hover:translate-x-1 ml-2">
                            Subscribe<i class="ri-arrow-right-up-line ml-1"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <div class="card p-7 flex flex-col gap-y-5">
            <div class="flex flex-col gap-y-1">
                <h3 class="font-base font-semibold">Alamat Kami</h3>
                <ul class="text-base text-[#565d59]">
                    <li class="footer_information">
                        <div>
                            <a href="https://www.google.com/maps/place/Bidan+Eka+Muzaifa/@-6.4372582,106.7900834,17z/data=!3m1!4b1!4m6!3m5!1s0x2e69e93b150b85ab:0xd11785251f2c1f35!8m2!3d-6.4372582!4d106.7949543!16s%2Fg%2F11fpfqdq1j?entry=ttu"
                                target="_blank">
                                Jl. Masjid Assalafiyah <br> RT.01 RW.03 No.50 Kel. Cipayung Jaya, Kec. Cipayung, Kota
                                Depok, Jawa Barat 16437
                            </a>
                        </div>


                    </li>
                </ul>
            </div>
        </div>
        <div class="card p-7 flex flex-col gap-y-5">
            <div class="flex flex-col gap-y-1">
                <h3 class="font-base font-semibold">Hubungi Kami</h3>
                <ul class="text-base text-[#565d59] ">
                    <li>
                        <a href="tel:+628118471812">+628118471812</a>
                    </li>
                    <div>
                        <a href="https://web.facebook.com/bidanekamuzaifa/?_rdc=1&_rdr" target="_blank"
                            class="text-[#3e6553] text-[1rem] transition-transform duration-300 hover:text-[#365949]">
                            <i class="ri-facebook-fill"></i>
                        </a>
                        <a href="https://wa.me/+628118471812"
                            class="text-[#3e6553] text-[1rem] transition-transform duration-300 hover:text-[#365949] ml-2"
                            target="_blank">
                            <i class="ri-whatsapp-fill"></i>
                        </a>
                        <a href="mailto:bidannatural@gmail.com" target="_blank"
                            class="text-[#3e6553] text-[1rem] transition-transform duration-300 hover:text-[#365949] ml-2">
                            <i class="ri-mail-fill"></i>
                        </a>
                    </div>
                </ul>
            </div>
        </div>
        <div class="card p-7 flex flex-col gap-y-5">
            <div class="flex flex-col gap-y-1">
                <h3 class="font-base font-semibold">Jam Oprasional</h3>
                <ul class="text-base text-[#565d59]">
                    <li class="mt-1 mb-1">Layanan Persalinan <br />24 Jam</li>
                    <li class="footer_information">
                        Praktek Bidan <br />
                        07:00 - 21:00
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <p class="text-base text-[#565d59] text-center mt-8">
        &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved. | Supported by
        <a href="https://khoirusofii.000webhostapp.com" target="_blank"
            class="font-semibold text-[#3e6553] hover:text-[#365949]">Sof.</a>
    </p>
</footer>
