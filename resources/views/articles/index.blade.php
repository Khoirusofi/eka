<x-landing-layout>
    @section('title', 'Artikel - ' . config('app.name'))
    <section id="hero" class="grid items-center gap-8 py-20">
        <x-heading level="h1">
            <x-slot name="title">
                {{ __('Dapatkan informasi tentang tips kesehatan') }}
            </x-slot>

            <x-slot name="description">
                {{ __('Kami menyediakan artikel yang berkualitas tinggi, yang dapat membantu Anda membuat Janji yang lebih efektif.') }}
            </x-slot>

            <a href="{{ route('register') }}" class="block animate-bounce">
                <x-button variant="accent" label="Daftar">
                    {{ __('Daftar') }}
                </x-button>
            </a>
        </x-heading>
    </section>

    <section id="article" class="py-4">
        <div class="grid gap-8 lg:grid-cols-3">
            @foreach ($articles as $article)
                <div class="bg-white rounded-lg shadow-lg overflow-hidden relative">
                    <a href="{{ route('articles.show', $article->slug) }}">
                        <!-- Image Section -->
                        <div class="relative w-full h-48 overflow-hidden">
                            <img src="{{ asset('media/articles/' . $article->photo) }}" alt="{{ $article->title }}"
                                class="absolute inset-0 w-full h-full object-cover">
                        </div>

                        <!-- Dropdown Positioned in the Top Right -->
                        <div class="absolute top-2 right-2">
                            <div class="relative">
                                <button type="button" id="dropdownButton"
                                    data-dropdown-toggle="dropdown-{{ $loop->index }}"
                                    data-dropdown-placement="bottom-end"
                                    class="focus:outline-none flex items-center space-x-1">
                                    <i
                                        class="ri-share-line text-white text-xl hover:text-[#3e6553] transition p-1 "></i>
                                </button>
                                <!-- Dropdown Menu -->
                                <div id="dropdown-{{ $loop->index }}"
                                    class="hidden z-10 w-48 bg-white divide-y divide-gray-100 rounded-lg shadow">
                                    <ul class="py-2 text-sm text-gray-700">
                                        <!-- Facebook -->
                                        <li>
                                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}"
                                                target="_blank" class="block px-4 py-2 hover:bg-gray-100">
                                                <i class="ri-facebook-fill text-blue-600 text-xl"></i> Facebook
                                            </a>
                                        </li>

                                        <!-- WhatsApp -->
                                        <li>
                                            <a href="https://api.whatsapp.com/send?text={{ urlencode($article->title . ' ' . url()->current()) }}"
                                                target="_blank" class="block px-4 py-2 hover:bg-gray-100">
                                                <i class="ri-whatsapp-fill text-green-400 text-xl"></i> WhatsApp
                                            </a>
                                        </li>

                                        <!-- Email -->
                                        <li>
                                            <a href="mailto:?subject={{ urlencode($article->title) }}&body={{ urlencode($article->title . ' ' . url()->current()) }}"
                                                target="_blank" class="block px-4 py-2 hover:bg-gray-100">
                                                <i class="ri-mail-fill text-red-500 text-xl"></i> Email
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="p-6">
                            @if ($article->category)
                                <p
                                    class="inline-block px-3 py-1 mb-1 text-xs font-semibold text-white bg-[#3e6553] rounded-full shadow-md hover:bg-[#2a4c42] transition-colors duration-300">
                                    {{ $article->category->name }}
                                </p>
                            @endif
                            <a href="{{ route('articles.show', $article->slug) }}"
                                class="block text-xl font-semibold text-[#252826] hover:text-[#3e6553] transition-colors duration-300 line-clamp-2">
                                {{ Str::limit($article->title, 40, '...') }}
                            </a>
                            <p class="text-[#565d59] mt-3 line-clamp-3">
                                {{ $article->excerpt }}
                            </p>
                            <p class="text-[#565d59] mt-3 text-sm">
                                <i class="ri-heart-line text-gray-500"></i>
                                {{ $article->likes->count() }}
                                <i class="ri-time-line text-gray-400"></i>
                                {{ $article->created_at->diffForHumans() }}
                            </p>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </section>

    {{ $articles->links() }}

</x-landing-layout>
