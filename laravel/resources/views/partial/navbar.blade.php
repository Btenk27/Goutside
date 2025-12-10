<nav class="sticky top-0 z-50 bg-emerald-700/95 backdrop-blur border-b border-emerald-900/40" data-slot="navbar">
    <div class="mx-auto max-w-7xl px-3 sm:px-6 lg:px-8">
        <div class="relative flex h-16 items-center justify-between">
            {{-- LEFT: Logo + Brand --}}
            <div class="flex flex-1 items-center justify-start gap-3">
                <a href="{{ route('landing') }}" class="flex items-center gap-2">
                    <img src="{{ asset('images/logo1.png') }}" alt="Logo" class="h-8 w-auto" />
                    <div class="leading-tight">
                        <p class="text-sm font-bold text-white">Hiking Rent</p>
                        <p class="text-[11px] text-emerald-100">Gear for your summit</p>
                    </div>
                </a>

                {{-- DESKTOP NAV LINKS --}}
                <div class="hidden sm:ml-6 sm:flex sm:space-x-2">
                    <a href="{{ route('landing') }}"
                       class="px-3 py-2 rounded-md text-sm font-medium
                              {{ request()->routeIs('landing') ? 'bg-white text-emerald-700 shadow-sm' : 'text-emerald-100 hover:bg-emerald-600/60 hover:text-white' }}">
                        Home
                    </a>

                    <a href="{{ route('katalog.index') }}"
                       class="px-3 py-2 rounded-md text-sm font-medium
                              {{ request()->routeIs('katalog.*') ? 'bg-white text-emerald-700 shadow-sm' : 'text-emerald-100 hover:bg-emerald-600/60 hover:text-white' }}">
                        Katalog
                    </a>

                    <a href="{{ route('reservasi.create') }}"
                       class="px-3 py-2 rounded-md text-sm font-medium
                              {{ request()->routeIs('reservasi.*') ? 'bg-white text-emerald-700 shadow-sm' : 'text-emerald-100 hover:bg-emerald-600/60 hover:text-white' }}">
                        Reservasi
                    </a>

                    {{-- TOMBOL ADMIN HANYA UNTUK ROLE admin --}}
                    @auth
                        @if(auth()->user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}"
                               class="px-3 py-2 rounded-md text-sm font-medium
                                      {{ request()->routeIs('admin.produk.*') ? 'bg-white text-emerald-700 shadow-sm' : 'text-amber-200 hover:bg-emerald-600/60 hover:text-white' }}">
                                Admin
                            </a>
                        @endif
                    @endauth
                </div>
            </div>

            {{-- RIGHT: Auth --}}
            <div class="hidden sm:flex sm:items-center sm:space-x-3">
                @guest
                    <a href="{{ route('login') }}"
                       class="text-xs font-medium text-emerald-100 hover:text-white">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}"
                       class="text-xs font-medium text-emerald-800 bg-emerald-100 px-3 py-1 rounded-full hover:bg-white">
                        Daftar
                    </a>
                @else
                    <span class="text-xs text-emerald-100">
                        Hai, <span class="font-semibold">{{ auth()->user()->name }}</span>
                    </span>

                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit"
                                class="text-xs font-medium text-emerald-100 border border-emerald-300/60 px-3 py-1 rounded-full hover:bg-emerald-600/60 hover:text-white">
                            Logout
                        </button>
                    </form>
                @endguest
            </div>

            {{-- MOBILE MENU BUTTON --}}
            <div class="flex sm:hidden">
                <button id="mobile-menu-toggle"
                        type="button"
                        class="inline-flex items-center justify-center rounded-md p-2 text-emerald-100 hover:bg-emerald-600/70 hover:text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-emerald-700 focus:ring-white">
                    <span class="sr-only">Open main menu</span>
                    {{-- Icon burger --}}
                    <svg id="icon-open" class="block h-6 w-6" viewBox="0 0 24 24" stroke="currentColor" fill="none" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                    {{-- Icon close --}}
                    <svg id="icon-close" class="hidden h-6 w-6" viewBox="0 0 24 24" stroke="currentColor" fill="none" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- MOBILE MENU --}}
    <div id="mobile-menu" class="sm:hidden hidden border-t border-emerald-800/60 bg-emerald-700/95">
        <div class="space-y-1 px-2 pt-2 pb-3">
            <a href="{{ route('landing') }}"
               class="block rounded-md px-3 py-2 text-base font-medium
                      {{ request()->routeIs('landing') ? 'bg-white text-emerald-700 shadow-sm' : 'text-emerald-100 hover:bg-emerald-600/60 hover:text-white' }}">
                Home
            </a>

            <a href="{{ route('katalog.index') }}"
               class="block rounded-md px-3 py-2 text-base font-medium
                      {{ request()->routeIs('katalog.*') ? 'bg-white text-emerald-700 shadow-sm' : 'text-emerald-100 hover:bg-emerald-600/60 hover:text-white' }}">
                Katalog
            </a>

            <a href="{{ route('reservasi.create') }}"
               class="block rounded-md px-3 py-2 text-base font-medium
                      {{ request()->routeIs('reservasi.*') ? 'bg-white text-emerald-700 shadow-sm' : 'text-emerald-100 hover:bg-emerald-600/60 hover:text-white' }}">
                Reservasi
            </a>

            @auth
                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}"
                       class="block rounded-md px-3 py-2 text-base font-medium
                              {{ request()->routeIs('admin.produk.*') ? 'bg-white text-emerald-700 shadow-sm' : 'text-amber-200 hover:bg-emerald-600/60 hover:text-white' }}">
                        Admin
                    </a>
                @endif

                <form action="{{ route('logout') }}" method="POST" class="mt-2 px-2">
                    @csrf
                    <button type="submit"
                            class="w-full text-left rounded-md px-3 py-2 text-base font-medium text-emerald-100 hover:bg-emerald-600/60 hover:text-white">
                        Logout
                    </button>
                </form>
            @endauth

            @guest
                <a href="{{ route('login') }}"
                   class="block rounded-md px-3 py-2 text-base font-medium text-emerald-100 hover:bg-emerald-600/60 hover:text-white">
                    Masuk
                </a>
                <a href="{{ route('register') }}"
                   class="block rounded-md px-3 py-2 text-base font-medium text-emerald-100 hover:bg-emerald-600/60 hover:text-white">
                    Daftar
                </a>
            @endguest
        </div>
    </div>

    {{-- Script kecil untuk toggle mobile menu --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const toggle = document.getElementById('mobile-menu-toggle');
            const menu   = document.getElementById('mobile-menu');
            const iconOpen  = document.getElementById('icon-open');
            const iconClose = document.getElementById('icon-close');

            if (toggle && menu) {
                toggle.addEventListener('click', () => {
                    menu.classList.toggle('hidden');
                    iconOpen.classList.toggle('hidden');
                    iconClose.classList.toggle('hidden');
                });
            }
        });
    </script>
</nav>
