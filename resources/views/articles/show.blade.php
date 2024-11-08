<x-landing-layout>
    @section('title', $article->title . ' - ' . config('app.name'))
    <section id="hero" class="grid items-center gap-8 py-20">
        <x-heading level="h1">
            <x-slot name="title">
                <div class="mb-4">
                    {{ $article->title }}
                    @if ($article->category)
                        <p
                            class="inline-block px-3 py-1 text-xs font-semibold text-white bg-[#3e6553] rounded-full shadow-md hover:bg-[#2a4c42] transition-colors duration-300">
                            {{ $article->category->name }}
                        </p>
                    @endif
                    <div class="flex items-center justify-between text-sm text-gray-600 mt-4">
                        <div class="flex items-center space-x-2">
                            <i class="ri-time-line text-gray-400"></i>
                            <span class=" text-gray-500">{{ $article->created_at->diffForHumans() }}</span>
                            <i class="ri-heart-line text-gray-500"></i>
                            <span class=" text-gray-500">{{ $article->likes->count() }} Menyukai Artikel Ini</span>
                        </div>
                    </div>
                </div>
            </x-slot>


            <x-slot name="description">
                {{ $article->excerpt }}
            </x-slot>


            <figure class="w-full overflow-hidden aspect-video rounded-xl">
                <img src="{{ asset('media/articles/' . $article->photo) }}" alt="{{ $article->title }}"
                    class="object-cover w-full h-full">
            </figure>
            <figcaption class="items-center justify-center text-center text-sm text-zinc-400"> Ilutrasi
                {{ $article->title }}
            </figcaption>

            <div
                class="mx-auto prose prose-headings:font-sans prose-headings:tracking-normal max-w-none prose-p:leading-relaxed prose-pink">
                {!! $article->body !!}
            </div>
        </x-heading>
    </section>




    <section id="comment" class="py-10">
        <div class="px-4 max-w-full">
            <div class="flex flex-col items-start justify-start mb-6">
                <div class="flex justify-between items-center mt-4">
                    @auth
                        <div class="flex items-center space-x-4">
                            <form action="{{ route('likes.toggle', $article->id) }}" method="POST" class="inline"
                                id="like-form">
                                @csrf
                                <button type="submit" class="focus:outline-none flex items-center space-x-1">
                                    @if ($article->likes()->where('user_id', auth()->id())->exists())
                                        <i class="ri-heart-fill text-red-500 text-xl hover:text-red-600 transition"></i>
                                    @else
                                        <i class="ri-heart-line text-gray-500 text-xl hover:text-red-500 transition"></i>
                                    @endif
                                    <span class="text-sm text-gray-600">{{ $article->likes->count() }}</span>
                                </button>
                            </form>

                            <button type="button" id="comment-button"
                                class="focus:outline-none flex items-center space-x-1">
                                <i class="ri-chat-3-line text-gray-500 text-xl hover:text-blue-500 transition"></i>
                                <span class="text-sm text-gray-600">{{ $article->comments->count() }}</span>
                            </button>

                            <button type="button" id="dropdownButton" data-dropdown-toggle="dropdown"
                                class="focus:outline-none flex items-center space-x-1">
                                <i class="ri-share-line text-gray-500 text-xl hover:text-green-500 transition"></i>
                                <span class="text-sm text-gray-600">Bagikan</span>
                            </button>

                            <div id="dropdown"
                                class="hidden z-10 w-48 bg-white divide-y divide-gray-100 rounded-lg shadow dark:bg-gray-800 dark:divide-gray-700">
                                <ul class="py-2 text-sm text-gray-700 dark:text-gray-200">
                                    <li>
                                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}"
                                            target="_blank"
                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                            <i class="ri-facebook-fill text-blue-600 text-xl"></i> Facebook
                                        </a>
                                    </li>

                                    <li>
                                        <a href="https://api.whatsapp.com/send?text={{ urlencode($article->title . ' ' . url()->current()) }}"
                                            target="_blank"
                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                            <i class="ri-whatsapp-fill text-green-400 text-xl"></i> WhatsApp
                                        </a>
                                    </li>

                                    <li>
                                        <a href="mailto:?subject={{ urlencode($article->title) }}&body={{ urlencode($article->title . ' ' . url()->current()) }}"
                                            target="_blank"
                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                            <i class="ri-mail-fill text-red-500 text-xl"></i> Email
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="x-nav-link">
                            <x-button label="{{ __('Login') }}">
                                {{ __('Login') }}
                            </x-button>
                        </a>
                        <div class="ml-2">untuk memberi like atau komentar.</div>
                    @endauth
                </div>

                <h2 class="text-lg lg:text-2xl font-bold text-gray-900 text-left mt-8">Komentar</h2>
                <!-- Flash Messages -->
                @if (session('success'))
                    <div id="success-alert"
                        class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif

                @if (session('error'))
                    <div id="error-alert"
                        class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                        <span class="block sm:inline">{{ session('error') }}</span>
                    </div>
                @endif
            </div>

            @auth
                <form id="comment-form" action="{{ route('comments.store', $article->id) }}" method="POST"
                    class="{{ $article->comments()->where('user_id', auth()->id())->exists() ? '' : 'hidden' }} mb-6">
                    @csrf
                    <div class="py-2 px-4 mb-4 bg-white rounded-lg border border-gray-200">
                        <label for="comment" class="sr-only">Komentar</label>
                        <textarea id="comment" name="content" rows="6"
                            class="px-0 w-full text-sm text-gray-900 border-0 focus:ring-0 focus:outline-none text-left"
                            placeholder="Tulis komentar..." required></textarea>
                    </div>
                    <div class="flex flex-row gap-x-4 items-center justify-start">
                        <button type="submit"
                            class="block px-4 py-2 bg-[#3e6553] text-white rounded-md font-medium text-sm hover:bg-[#365949] transition duration-300 transform hover:translate-x-1">
                            {{ __('Kirim Komentar') }}
                            <i class="ri-send-plane-fill ml-1"></i>
                        </button>
                    </div>
                </form>
            @endauth

            <div class="mt-6">
                @forelse ($article->comments as $comment)
                    <article class="p-6 mb-3 text-base bg-white border-t border-[#3e6553] rounded-lg text-left">
                        <footer class="flex justify-between items-center mb-2">
                            <div class="flex items-center">
                                <x-avatar value="{{ $comment->user->name }}" size="sm" expand />
                                <p class="text-gray-500 text-[12px] ml-2">{{ $comment->created_at->diffForHumans() }}
                                </p>
                            </div>
                            @auth
                                @if ($comment->user_id === auth()->id())
                                    <div class="relative">
                                        <button id="dropdownComment3Button" data-dropdown-toggle="dropdownComment3"
                                            class="inline-flex items-center p-2 text-sm font-medium text-gray-500 bg-white rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-50"
                                            type="button">
                                            <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                fill="currentColor" viewBox="0 0 16 3">
                                                <path
                                                    d="M2 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Zm6.041 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM14 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Z" />
                                            </svg>
                                            <span class="sr-only">Comment settings</span>
                                        </button>
                                        <!-- Dropdown menu -->
                                        <div id="dropdownComment3"
                                            class="hidden absolute right-0 mt-2 w-36 bg-white rounded-lg divide-y divide-gray-100 shadow-lg">
                                            <ul class="py-1 text-sm text-gray-700"
                                                aria-labelledby="dropdownMenuIconHorizontalButton">
                                                <li>
                                                    <form action="{{ route('comments.destroy', $comment) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="flex items-center w-full text-left py-2 px-4 text-[10px] hover:bg-red-50 text-red-500">
                                                            <i class="ri-chat-delete-line mr-1"></i> Hapus Komentar
                                                        </button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                @endif
                            @endauth
                        </footer>
                        <p class="text-gray-500 text-left">{{ $comment->content }}</p>
                    </article>
                @empty
                    <p class="text-left">Belum ada komentar. Jadilah yang pertama untuk memberi komentar!</p>
                @endforelse
            </div>
        </div>
    </section>

    <script>
        document.getElementById('comment-button').addEventListener('click', function() {
            var commentForm = document.getElementById('comment-form');
            commentForm.classList.remove('hidden');
            var textarea = document.getElementById('comment');
            textarea.focus();
        });

        document.addEventListener('DOMContentLoaded', function() {
            // Mengatur timeout untuk menutup alert setelah 5 detik
            setTimeout(function() {
                let successAlert = document.getElementById('success-alert');
                let errorAlert = document.getElementById('error-alert');

                if (successAlert) {
                    successAlert.style.display = 'none';
                }
                if (errorAlert) {
                    errorAlert.style.display = 'none';
                }
            }, 5000); // 5000 ms = 5 detik
        });
    </script>

    <div class="grid sm:grid-cols-2 md:grid-cols-3 gap-6 lg:gap-8">
        @foreach ($articles as $article)
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <a href="{{ route('articles.show', $article->slug) }}" class="block">
                    <div class="relative w-full h-48">
                        <img src="{{ asset('media/articles/' . $article->photo) }}" alt="{{ $article->title }}"
                            class="absolute inset-0 w-full h-full object-cover">
                    </div>
                </a>
                <div class="p-6">
                    @if ($article->category)
                        <p
                            class="inline-block px-3 py-1 text-xs font-semibold text-white bg-[#3e6553] rounded-full shadow-md hover:bg-[#2a4c42] transition-colors duration-300">
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
                        {{ $article->created_at->diffForHumans() }}
                    </p>
                </div>
            </div>
        @endforeach
    </div>

    <div class="flex justify-center items-center md:justify-center mt-4">
        <a href="{{ route('articles.index') }}"
            class="px-4 py-2 bg-[#3e6553] text-white rounded-md font-medium text-sm hover:bg-[#365949] transition duration-300 transform hover:translate-x-1">
            {{ __('Lihat lebih banyak') }}
            <i class="ri-arrow-right-line ml-1"></i>
        </a>
    </div>
</x-landing-layout>
