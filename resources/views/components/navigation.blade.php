<nav id="navbar" class="nav__menu bg-zinc-50 w-full top-0 z-20">
    <div class="items-center justify-between w-content px-4 max-w-screen-xl mx-auto md:px-8 lg:flex">
        <div class="flex items-center justify-between py-3 lg:py-4 lg:block">
            <div class="flex items-center">
                <a href="{{ route('welcome') }}">
                    <x-logo variant="color" size="sm" />
                </a>
            </div>
            <div class="lg:hidden">
                <button id="mobile-menu-button"
                    class="text-[#3e6553] outline-none p-2 rounded-md focus:border-[#365949] focus:border">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path id="menu-icon" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 8h16M4 16h16" />
                        <path id="close-icon" class="hidden" stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
        <div id="mobile-menu"
            class="hidden max-h-screen overflow-y-auto flex-1 justify-between items-center flex-row-reverse lg:overflow-visible lg:flex lg:pb-0 lg:pr-0 lg:h-auto pb-20 pr-4">
            <div>
                <ul class="items-center text-center gap-x-4 lg:flex">
                    <li><a href="{{ route('welcome') }}" class="x-nav-link">{{ __('Home') }}</a></li>
                    <li><a href="{{ route('articles.index') }}" class="x-nav-link">{{ __('Artikel') }}</a></li>
                    <li><a href="{{ route('services.index') }}" class="x-nav-link">{{ __('Layanan') }}</a></li>
                    <li><a href="{{ route('testimonials.index') }}" class="x-nav-link">{{ __('Testimoni') }}</a></li>
                    @auth
                        <div class="relative flex items-start space-x-4 mt-2 justify-center">
                            <div x-data="{ open: false }" @click.away="open = false" class="relative">
                                <button @click="open = !open"
                                    class="text-sm font-semibold text-gray-700 focus:outline-none">
                                    <x-avatar value="{{ auth()->user()->name }}" size="sm" expand />
                                </button>
                                <div x-show="open"
                                    class="absolute left-0 mt-2 w-48 bg-white border rounded-lg shadow-lg py-2 z-50"
                                    style="transform: translateX(0);">
                                    <a href="{{ route('patients.profile.edit') }}"
                                        class=" px-4 py-2 text-green-700 hover:bg-gray-100 flex items-center space-x-2">
                                        <i class="ri-user-line text-lg"></i>
                                        <span>{{ __('Profile') }}</span>
                                    </a>
                                    <a href="{{ route('dashboard') }}"
                                        class=" px-4 py-2 text-green-700 hover:bg-gray-100 flex items-center space-x-2">
                                        <i class="ri-dashboard-line text-lg"></i>
                                        <span>{{ __('Dashboard') }}</span>
                                    </a>
                                    <form action="{{ route('logout') }}" method="POST"
                                        class=" px-2 py-2 text-red-700 hover:bg-red-100 flex items-center space-x-2">
                                        @csrf
                                        <button type="submit" class="w-full flex items-center space-x-2">
                                            <i class="ri-logout-box-line text-lg"></i>
                                            <span>{{ __('Keluar') }}</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="x-nav-link">
                            <x-button label="{{ __('Login') }}">
                                {{ __('Login') }}
                            </x-button>
                        </a>
                    @endauth
                </ul>
            </div>
        </div>
    </div>
</nav>
