<x-landing-layout>
    <section class="hero max-w-6xl mx-auto p-4 mt-12" id="hero">
        @php
            $hero = App\Models\Hero::latest()->first();
        @endphp
        @if ($hero)
            <div class="flex flex-col md:flex-row items-center justify-between">
                <div class="flex flex-col gap-y-10 md:w-1/2">
                    <div class="flex justify-between">
                        <div
                            class="w-fit gap-x-2 px-5 py-1 small-badge flex flex-row font-semibold bg-[#e6efeb] rounded-full">
                            <p class="text-base text-[#252826] flex items-center">
                                <i class="ri-health-book-line mr-1"></i>
                                {{ $hero->title }}
                            </p>
                        </div>
                    </div>
                    <div class="flex gap-y-2 flex-col">
                        <h1 class="text-[#252826] text-3xl sm:text-5xl md:text-6xl leading-none font-semibold">
                            {{ $hero->description }}
                        </h1>
                        <p class="text-base leading-loose text-[#565d59]">
                            {{ $hero->button_text }}
                        </p>
                    </div>
                    <div class="flex flex-row gap-x-4 items-center">
                        <a href="{{ route('register') }}"
                            class="block px-4 py-2 bg-[#3e6553] text-white rounded-md font-medium text-sm hover:bg-[#365949] transition duration-300 transform hover:translate-x-1">
                            <i class="ri-user-add-fill mr-1"></i>
                            {{ __('Daftar') }}
                        </a>
                    </div>
                </div>

                <div class="relative w-full md:w-1/2 mt-8 lg:mt-0">
                    <div
                        class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-[70vw] h-[70vw] max-w-[400px] max-h-[400px] bg-[#e6efeb] rounded-full">
                    </div>
                    <img src="{{ asset('media/hero/' . $hero->background_hero) }}" alt="Hero"
                        class="relative object-cover w-full h-full max-w-sm mx-auto lg:max-w-sm">
                    <a href="{{ route('patients.appointments.create') }}"
                        class="absolute right-0 flex items-center justify-center p-2 space-x-2 bg-[#e6efeb] rounded-full bottom-10 frame pe-5 animate-bounce">
                        <x-button variant="accent" size="icon" label="{{ __('Buat Janji') }}">
                            <i class="ri-calendar-schedule-line"></i>
                        </x-button>
                        <p class="text-base text-[#252826] font-medium">
                            {{ __('Buat Janji') }}
                        </p>
                    </a>
                    <div
                        class="absolute left-1/2 transform -translate-x-1/2 w-64 bottom-2 px-5 py-1 small-badge flex flex-row font-semibold bg-[#e6efeb] rounded-full">
                        <p class="text-base text-[#252826] flex items-center">
                            <i class="ri-stethoscope-fill mr-1"></i>
                            {{ __('Eka Muzaifa, Amd, Keb.') }}
                        </p>
                    </div>
                </div>
        @endif

        <div class="hidden md:flex flex-row items-center mt-4 md:mt-0">
            <div class="absolute right-4 md:right-12 lg:right-18 x-6 grid justify-items-center gap-y-14">
                <span
                    class="relative text-[#3e6553] font-medium rotate-90 after:content-['|'] after:rotate-90 after:absolute after:text-center after:w-4 after:h-[2px] after:-right-[45%] after:top-2/4">
                    Follow Us
                </span>
                <div class="inline-flex flex-col gap-y-1">
                    <a href="https://web.facebook.com/bidanekamuzaifa/?_rdc=1&_rdr" target="_blank"
                        class="text-[#3e6553] text-[1rem] transition-transform duration-300 hover:translate-x-1 hover:text-[#365949]">
                        <i class="ri-facebook-fill"></i>
                    </a>
                    <a href="https://wa.me/+628118471812" target="_blank"
                        class="text-[#3e6553] text-[1rem] transition-transform duration-300 hover:translate-x-1 hover:text-[#365949]">
                        <i class="ri-whatsapp-fill"></i>
                    </a>
                    <a href="mailto:bidannatural@gmail.com" target="_blank"
                        class="text-[#3e6553] text-[1rem] transition-transform duration-300 hover:translate-x-1 hover:text-[#365949]">
                        <i class="ri-mail-fill"></i>
                    </a>
                </div>
            </div>
        </div>
        </div>
    </section>

    <style>
        .no-scrollbar::-webkit-scrollbar {
            width: 0.4rem;
            background: #FAFAFA;
            width: 4px;
            height: 4px;
        }

        .no-scrollbar::-webkit-scrollbar-thumb {
            background: #365949;
            border-radius: 0.3rem;
        }

        .feature,
        .testimonial,
        {
        position: relative;
        }
    </style>
    <section class="feature max-w-6xl mx-auto py-12 mt-8" id="feature">
        <h1 class="text-2xl font-semibold leading-none text-center text-[#252826] sm:text-3xl lg:text-3xl">Layanan</h1>
        <p class="w-full mx-auto mt-2 mb-6 text-center text-base leading-loose text-[#565d59]">Kami berkomitmen
            memberikan pelayanan kesehatan terbaik kepada ibu dan anak dengan teknologi
            modern. Kami menyadari pentingnya akses mudah ke layanan kesehatan serta informasi dan
            edukasi yang akurat. Untuk itu, kami menyediakan fitur-fitur unggulan yang dirancang untuk memenuhi
            kebutuhan kesehatan Anda secara komprehensif. </p>
        <div class="flex overflow-x-scroll gap-8 mx-4 py-2 no-scrollbar" id="scrollContainer">
            @foreach ($services as $service)
                <div
                    class="card bg-[#e6efeb] rounded-2xl p-7 flex flex-col gap-y-5 transition duration-300 transform hover:-translate-y-1 min-w-[300px]">
                    <div class="relative w-full h-48">
                        <img src="{{ asset('media/services/' . $service->photo) }}" alt="{{ $service->title }}"
                            class="absolute inset-0 w-full h-full object-contain rounded-t-2xl">
                    </div>
                    <div class="flex flex-col gap-y-1">
                        <h3 class="font-semibold text-base">{{ $service->title }}</h3>
                        <p class="text-sm leading-relaxed text-[#565d59] line-clamp-3">{{ $service->description }}</p>
                        {{-- <p class="font-semibold text-base">
                            <x-currency value="{{ $service->price }}" />
                        </p> --}}
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <section class="about max-w-6xl mx-auto py-12 px-4 lg:px-0" id="about">
        <div class="flex flex-col lg:flex-row items-center justify-between">
            @php
                $hero = App\Models\Hero::latest()->first();
            @endphp
            @if ($hero)
                <div class="flex items-center mb-8 lg:mb-0">
                    <img src="{{ asset('media/hero/' . $hero->background_hero) }}" alt=""
                        class="w-full lg:w-[700px] h-auto" />
                </div>
                <div class="flex flex-col gap-y-8 lg:ml-12">
                    <div class="flex gap-y-2 flex-col">
                        <h1 class="text-[#252826] text-2xl lg:text-3xl leading-tight font-semibold">
                            {{ $hero->description }}
                        </h1>
                        <p class="text-base leading-loose text-[#565d59]">
                            {{ $hero->button_text }}
                        </p>
                    </div>
            @endif
            <div class="flex flex-col gap-y-4">
                <div class="flex flex-row bg-[#e6efeb] rounded-2xl items-start p-4 space-x-3">
                    <i class="ri-hearts-line text-2xl text-[#3e6553]"></i>
                    <div class="flex flex-col">
                        <h3 class="font-semibold text-base">Pendekatan Alami dan Islami</h3>
                        <p class="text-sm leading-relaxed text-[#565d59]">
                            Kami menerapkan pendekatan persalinan yang alami dan sesuai dengan nilai-nilai Islami,
                            memberikan ketenangan dan kenyamanan bagi ibu dan bayi.
                        </p>
                    </div>
                </div>
                <div class="flex flex-row bg-[#e6efeb] rounded-2xl items-start p-4 space-x-3">
                    <i class="ri-first-aid-kit-line text-2xl text-[#3e6553]"></i>
                    <div class="flex flex-col">
                        <h3 class="font-semibold text-base">Pelayanan Pribadi dan Hangat</h3>
                        <p class="text-sm leading-relaxed text-[#565d59]">
                            Setiap pasien diperlakukan dengan perhatian pribadi dan hangat, memastikan pengalaman
                            yang mendukung dan positif.
                        </p>
                    </div>
                </div>
                <div class="flex flex-row bg-[#e6efeb] rounded-2xl items-start p-4 space-x-3">
                    <i class="ri-aed-electrodes-line text-2xl text-[#3e6553]"></i>
                    <div class="flex flex-col">
                        <h3 class="font-semibold text-base">Pengalaman dan Keahlian</h3>
                        <p class="text-sm leading-relaxed text-[#565d59]">
                            Bidan Eka Muzaifa memiliki pengalaman dan keahlian yang luas dalam menangani berbagai
                            jenis persalinan, termasuk praktek mandiri yang terpercaya.
                        </p>
                    </div>
                </div>
            </div>
            <div class="flex flex-row gap-x-4 items-center justify-center lg:justify-start">
                <a href="{{ route('register') }}"
                    class="px-4 py-2 bg-[#3e6553] text-white rounded-md font-medium text-sm hover:bg-[#365949] transition duration-300 transform hover:translate-x-1 frame pe-5 animate-bounce">
                    Buat Janji
                    <i class="ri-calendar-schedule-line ml-1"></i>
                </a>
            </div>
        </div>
        </div>
    </section>

    <section class="galeri max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8 lg:py-16" id="galeri">
        <div class="max-w-5xl px-4 mx-auto sm:px-6 lg:px-8">
            <div class="max-w-2xl mx-auto text-center">
                <h1 class="text-2xl font-semibold leading-none text-[#252826] sm:text-3xl lg:text-3xl">Galeri</h1>
                <p class="max-w-xl mx-auto mt-2 mb-6 text-center text-base leading-loose text-[#565d59]">Memperlihatkan
                    fasilitas klinik, memberikan
                    gambaran hangat dan profesional dari pelayanan.</p>
            </div>
            <div class="flex flex-wrap -mx-2 mt-4">
                <div class="w-full p-2">
                    <video class="h-full w-full rounded-lg" controls>
                        <source src="{{ asset('video/video.mp4') }}" type="video/mp4" />
                        Your browser does not support the video tag.
                    </video>
                </div>

                @php
                    $photosArray = $photos->keyBy('id'); // Convert collection to associative array with IDs as keys
                @endphp

                @php
                    $photoOrder = [1, 2, 3, 4, 5, 6]; // Define the desired order of IDs
                @endphp

                @foreach (array_chunk($photoOrder, 6) as $chunk)
                    <div class="w-full md:w-1/2 flex flex-wrap">
                        @foreach ([1, 2, 3] as $id)
                            @php
                                $photo = $photosArray->get($id); // Get the photo by ID or null if not found
                            @endphp
                            @if ($photo)
                                @if ($id == 1 || $id == 2)
                                    <div class="w-1/2 p-2">
                                        <img class="block h-full w-full rounded-lg object-cover object-center cursor-pointer"
                                            src="{{ asset('media/photo/' . $photo->photo) }}"
                                            alt="{{ $photo->title ?? 'Default Title' }}" />
                                    </div>
                                @elseif ($id == 3)
                                    <div class="w-full p-2">
                                        <img class="block h-full w-full rounded-lg object-cover object-center cursor-pointer"
                                            src="{{ asset('media/photo/' . $photo->photo) }}"
                                            alt="{{ $photo->title ?? 'Default Title' }}" />
                                    </div>
                                @endif
                            @endif
                        @endforeach
                    </div>

                    <div class="w-full md:w-1/2 flex flex-wrap">
                        @foreach ([4, 5, 6] as $id)
                            @php
                                $photo = $photosArray->get($id);
                            @endphp
                            @if ($photo)
                                @if ($id == 4)
                                    <div class="w-full p-2">
                                        <img class="block h-full w-full rounded-lg object-cover object-center cursor-pointer"
                                            src="{{ asset('media/photo/' . $photo->photo) }}"
                                            alt="{{ $photo->title ?? 'Default Title' }}" />
                                    </div>
                                @elseif ($id == 5 || $id == 6)
                                    <div class="w-1/2 p-2">
                                        <img class="block h-full w-full rounded-lg object-cover object-center cursor-pointer"
                                            src="{{ asset('media/photo/' . $photo->photo) }}"
                                            alt="{{ $photo->title ?? 'Default Title' }}" />
                                    </div>
                                @endif
                            @endif
                        @endforeach
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="article max-w-6xl mx-auto"id="article">
        <div class="px-5 sm:px-10 md:px-12 lg:px-5 space-y-10">
            <div class="flex flex-col md:flex-row gap-y-8 md:justify-center">
                <div class="space-y-6 max-w-2xl mx-auto md:mx-0 text-center md:text-left">
                    <h1 class="text-2xl font-semibold leading-none text-center text-[#252826] sm:text-3xl lg:text-3xl">
                        Edukasi dan Informasi Kesehatan</h1>
                    <p class="w-full mx-auto mt-2 mb-6 text-center text-base leading-loose text-[#565d59]">Menyediakan
                        artikel, dan materi edukasi mengenai kesehatan ibu dan anak, perawatan kehamilan,
                        persalinan, serta perawatan bayi untuk meningkatkan pengetahuan dan kesadaran pasien tentang
                        kesehatan mereka.
                    </p>
                </div>

            </div>
            <div class="grid sm:grid-cols-2 md:grid-cols-3 gap-6 lg:gap-8">
                @foreach ($articles as $article)
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                        <a href="{{ route('articles.show', $article->slug) }}">
                            <div class="relative w-full h-48">
                                <img src="{{ asset('media/articles/' . $article->photo) }}"
                                    alt="{{ $article->title }}" class="absolute inset-0 w-full h-full object-cover">
                            </div>
                        </a>
                        <div class="p-6">
                            <!-- Tambahkan kategori di sini -->
                            @if ($article->category)
                                <p
                                    class="inline-block px-3 py-1 mb-1 text-xs font-semibold text-white bg-[#3e6553] rounded-full shadow-md hover:bg-[#2a4c42] transition-colors duration-300">
                                    {{ $article->category->name }}
                                </p>
                            @endif

                            <a href="{{ route('articles.show', $article->slug) }}"
                                class="block text-xl font-semibold text-[#252826] hover:text-[#3e6553] transition-colors duration-300 line-clamp-2 mt-2">
                                {{ Str::limit($article->title, 30, '...') }}
                            </a>
                            <p class="text-[#565d59] mt-3 line-clamp-3">
                                {{ $article->excerpt }}
                            </p>
                            <p class="text-[#565d59] mt-3 text-sm">
                                {{ $article->created_at->diffForHumans() }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="flex justify-center items-center md:justify-center">
                <a href="{{ route('articles.index') }}"
                    class="px-4 py-2 bg-[#3e6553] text-white rounded-md font-medium text-sm hover:bg-[#365949] transition duration-300 transform hover:translate-x-1">
                    {{ __('Lihat lebih banyak') }}
                    <i class="ri-arrow-right-line ml-1"></i>
                </a>
            </div>
            {{-- <div class="flex flex-col md:flex-row gap-y-8 md:justify-center">
                <div class="space-y-6 max-w-2xl mx-auto md:mx-0 text-center md:text-left">
                    <h1 class="text-2xl font-semibold leading-none text-center text-[#252826] sm:text-3xl lg:text-5xl">
                        Latest Articles</h1>
                    <p class="max-w-xl mx-auto mt-2 mb-6 text-center text-base leading-loose text-[#565d59]">Articles
                        Lorem ipsum dolor sit, amet consectetur adipisicing elit. Fugit perferendis eos amet eum
                        repudiandae aspernatur mollitia quos consectetur voluptatibus pariatur.</p>
                </div>
            </div>
            <div class="grid sm:grid-cols-2 md:grid-cols-3 gap-6 lg:gap-8">
                @foreach ($latestPosts as $post)
                    <x-posts.post-card :post="$post" class="md:col-span-1 col-span-3" />
                @endforeach
            </div>
            <div class="flex justify-center items-center md:justify-center">
                <a href="{{ route('posts.index') }}"
                    class="px-4 py-2 bg-[#3e6553] text-white rounded-md font-medium text-sm hover:bg-[#365949] transition duration-300 transform hover:translate-x-1">
                    {{ __('See More') }}
                    <i class="ri-arrow-right-line ml-1"></i>
                </a>
            </div> --}}
        </div>
    </section>

    <section id="testimonial" class=" testimonial max-w-6xl mx-auto">
        <div class="mx-auto max-w-screen-xl px-4 py-12 sm:px-6 lg:px-8 lg:py-16">
            <div class="max-w-2xl mx-auto text-center">
                <h1 class="text-2xl font-semibold leading-none text-[#252826] sm:text-3xl lg:text-3xl">Testimoni</h1>
                <p class="max-w-xl mx-auto mt-2 mb-6 text-center text-base leading-loose text-[#565d59]">
                    Ulasan ini mencerminkan kualitas pelayanan, membantu calon pasien merasa lebih yakin dan nyaman
                    dalam memilih layanan Bidan Eka Muzaifa.
                </p>
            </div>

            @php
                $uniqueReviews = $reviews->groupBy('user_id')->map(function ($group) {
                    return $group->first();
                });
            @endphp

            <div class="flex overflow-x-scroll gap-8 mx-4 py-2 no-scrollbar" id="scrollContainer">
                @foreach ($uniqueReviews as $review)
                    <a href="{{ route('testimonials.index') }}"
                        class="p-6 space-y-4 bg-white rounded-xl shadow-lg min-w-[300px] block hover:shadow-xl transition-shadow duration-200">
                        <div class="flex items-center gap-4">
                            <x-avatar value="{{ $review->user->name }}" size="md" expand />
                        </div>
                        <p class="text-zinc-600">
                            {{ $review->action }}
                        </p>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <section class="contact max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12 items-center" id="contact">
        <div class="grid grid-cols-1 gap-y-6 lg:grid-cols-2 lg:gap-8">
            <div class="gap-y-8">
                <h1 class="text-[#252826] text-lg leading-none font-semibold mt-4 mb-4 gap-y-4">
                    Hubungi kami
                </h1>
                <div class="grid gap-y-4">
                    <div>
                        <p class="mb-1">
                            Butuh bantuan cepat? Telepon kami</p>
                        <span
                            class="inline-flex items-center gap-2 text-[#3e6553] transition-transform duration-300 hover:text-[#365949]">
                            <i class="ri-whatsapp-fill text-xl"></i>
                            <a href="https://wa.me/+628118471812" class="text-[#252826]">+628118471812</a>
                        </span>
                    </div>

                    <div>
                        <p class="mb-1">Atau, kirim email ke:</p>
                        <span
                            class="inline-flex items-center gap-2 text-[#3e6553] transition-transform duration-300 hover:text-[#365949]">
                            <i class="ri-mail-fill text-xl"></i>
                            <a href="mailto:bidannatural@gmail.com" class="text-[#252826]">bidannatural@gmail.com</a>
                        </span>
                    </div>
                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative"
                            role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif
                </div>
            </div>

            <form action="{{ route('contact.store') }}" method="POST" class="max-w-full">
                @csrf
                <div class="grid gap-y-6">
                    <div class="relative mt-8">
                        <x-input type="email" placeholder="" id="email" name="email"
                            class="w-full text-sm bg-transparent text-[#565d59] border-b border-gray-300 focus:outline-none focus:border-[#3e6553]" />
                        <x-label for="email" :value="__('Email')"
                            class="absolute -top-6 left-0 text-sm text-gray-600 transition-all duration-300">Email</x-label>
                    </div>

                    <div class="relative mt-2 mb-2">
                        <x-input type="text" placeholder=" " id="subject" name="subject"
                            class="w-full text-sm bg-transparent text-[#565d59] border-b border-gray-300 focus:outline-none focus:border-[#3e6553]" />
                        <x-label for="subject" :value="__('Subject')"
                            class="absolute -top-6 left-0 text-sm text-gray-600 transition-all duration-300">Subject</x-label>
                    </div>

                    <div class="relative">
                        <textarea name="message" placeholder=" " id="message"
                            class="w-full text-sm h-18 bg-transparent text-[#565d59] focus:ring-[#365949] rounded-md shadow-sm border-b border-gray-300 focus:outline-none focus:border-[#3e6553]"></textarea>
                        <x-label for="message" :value="__('Message')"
                            class="absolute -top-6 left-0 text-sm text-gray-600 transition-all duration-300">Message</x-label>
                    </div>
                </div>
                <button
                    class="px-4 py-2 bg-[#3e6553] text-white rounded-md font-medium text-sm hover:bg-[#365949] transition duration-300 transform hover:translate-x-1 mt-4">
                    Kirim Pesan
                    <i class="ri-arrow-right-up-line ml-1"></i>
                </button>
            </form>
        </div>
    </section>
</x-landing-layout>
