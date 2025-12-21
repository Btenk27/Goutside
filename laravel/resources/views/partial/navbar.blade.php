<nav class="sticky top-0 z-50
bg-gradient-to-b from-emerald-700/90 to-emerald-700/80
backdrop-blur-xl
border-b border-white/10
shadow-[0_8px_30px_rgba(0,0,0,0.12)]
animate-navbar-in">
    <div class="mx-auto max-w-7xl px-3 sm:px-6 lg:px-8">
        <div class="relative flex h-16 items-center justify-between">
            {{-- LEFT: Logo + Brand --}}
            <div class="flex flex-1 items-center justify-start gap-3">
                <a href="{{ route('landing') }}" class="flex items-center gap-2 group">
    <img src="{{ asset('images/logo1.png') }}"
         alt="Logo"
         class="h-8 w-auto transition-transform duration-300 group-hover:scale-110" />
    <div class="leading-tight">
        <p class="text-sm font-bold text-white tracking-wide">
            Goutside
        </p>
        <p class="text-[11px] text-emerald-200/90">
            Ready to Summit
        </p>
    </div>
</a>


                {{-- DESKTOP NAV LINKS --}}
                <div class="hidden sm:ml-6 sm:flex sm:space-x-2">
                    <a href="{{ route('landing') }}"
   class="nav-link px-3 py-2 rounded-md text-sm font-medium
   {{ request()->routeIs('landing')
   ? 'active text-white'
   : 'text-emerald-100 hover:text-white' }}">
   Home
</a>


                    <a href="{{ route('katalog.index') }}"
                       class="nav-link px-3 py-2 rounded-md text-sm font-medium
   {{ request()->routeIs('katalog.*')
   ? 'active text-white'
   : 'text-emerald-100 hover:text-white' }}">
                        Katalog
                    </a>

                    <a href="{{ route('reservasi.index') }}"
                       class="nav-link px-3 py-2 rounded-md text-sm font-medium
   {{ request()->routeIs('reservasi.*')
   ? 'active text-white'
   : 'text-emerald-100 hover:text-white' }}">
                        Reservasi
                    </a>

                    {{-- TOMBOL ADMIN HANYA UNTUK ROLE admin --}}
                    @auth
                        @if(auth()->user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}"
                               class="nav-link px-3 py-2 rounded-md text-sm font-medium
                                      {{ request()->routeIs('admin.produk.*') ? 'bg-white text-emerald-700 shadow-sm' : 'text-amber-200 hover:bg-emerald-600/60 hover:text-white' }}">
                                Admin
                            </a>
                        @endif
                    @endauth
                </div>
            </div>

            {{-- RIGHT: Auth --}}
            <div class="hidden sm:flex sm:items-center sm:space-x-3">
               @auth
<a href="{{ route('keranjang.index') }}"  class="relative text-emerald-100 hover:text-white cart-icon
          hover:drop-shadow-[0_0_10px_rgba(255,255,255,0.35)]">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
  <circle cx="9" cy="21" r="1"></circle>
  <circle cx="20" cy="21" r="1"></circle>
  <path d="M1 1h4l2.68 13.39a1 1 0 001 .79h9.72a1 1 0 001-.79L23 6H6"></path>
</svg>


    {{-- Badge Jumlah --}}
    @if(session('cart_count'))
        <span class="absolute -top-2 -right-2 bg-red-500 text-white
text-[10px] font-bold px-1.5 py-0.5 rounded-full cart-badge">
            {{ session('cart_count') }}
        </span>
    @endif
</a>
@endauth


                @guest
                    <a href="{{ route('login') }}"
                       class="btn-soft text-xs font-medium text-emerald-100
border border-emerald-300/60 px-3 py-1 rounded-full relative">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}"
                       class="text-xs font-medium text-emerald-800 bg-emerald-100 px-3 py-1 rounded-full hover:bg-white hover:shadow-lg transition">
                        Daftar
                    </a>
                @else
                    <span class="text-xs text-emerald-100">
                        Hai, <span class="font-semibold">{{ auth()->user()->name }}</span>
                    </span>

                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button class="btn-soft text-xs font-medium text-emerald-100
border border-emerald-300/60 px-3 py-1 rounded-full relative">
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
<div id="mobile-menu"
class="sm:hidden hidden
border-t border-emerald-800/60
bg-emerald-700/95 backdrop-blur-xl
animate-mobile-menu">
    <div class="space-y-1 px-2 pt-2 pb-3">
        <!-- Home -->
        <a href="{{ route('landing') }}"
           class="flex items-center gap-2 rounded-md px-3 py-2 text-base font-medium
                  {{ request()->routeIs('landing') ? 'bg-white text-emerald-700 shadow-sm' : 'text-emerald-100 hover:bg-emerald-600/60 hover:text-white' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 9l9-7 9 7v11a2 2 0 01-2 2h-4a2 2 0 01-2-2v-5H9v5a2 2 0 01-2 2H3a2 2 0 01-2-2V9z"/>
            </svg>
            Home
        </a>

        <!-- Katalog (folder/box icon) -->
        <a href="{{ route('katalog.index') }}"
           class="flex items-center gap-2 rounded-md px-3 py-2 text-base font-medium
                  {{ request()->routeIs('katalog.*') ? 'bg-white text-emerald-700 shadow-sm' : 'text-emerald-100 hover:bg-emerald-600/60 hover:text-white' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 7v12a2 2 0 002 2h14a2 2 0 002-2V7a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
            </svg>
            Katalog
        </a>

        <!-- Reservasi -->
        <a href="{{ route('reservasi.index') }}"
           class="flex items-center gap-2 rounded-md px-3 py-2 text-base font-medium
                  {{ request()->routeIs('reservasi.*') ? 'bg-white text-emerald-700 shadow-sm' : 'text-emerald-100 hover:bg-emerald-600/60 hover:text-white' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7H3v12a2 2 0 002 2z"/>
            </svg>
            Reservasi
        </a>

        <!-- Keranjang -->
        @auth
        <a href="{{ route('keranjang.index') }}"
           class="flex items-center gap-2 w-full text-left rounded-md px-3 py-2 text-base font-medium text-emerald-100 hover:bg-emerald-600/60 hover:text-white">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <circle cx="9" cy="21" r="1"/>
                <circle cx="20" cy="21" r="1"/>
                <path d="M1 1h4l2.68 13.39a1 1 0 001 .79h9.72a1 1 0 001-.79L23 6H6"/>
            </svg>
            Keranjang
        </a>
        @endauth

        <!-- Logout -->
        @auth
        <form action="{{ route('logout') }}" method="POST" class="mt-2 px-2">
            @csrf
            <button type="submit"
                    class="flex items-center gap-2 w-full text-left rounded-md px-3 py-2 text-base font-medium text-emerald-100 hover:bg-emerald-600/60 hover:text-white">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 -ml-2.5  " fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H7a2 2 0 01-2-2V7a2 2 0 012-2h4a2 2 0 012 2v1"/>
                </svg>
                Logout
            </button>
        </form>
        @endauth

        <!-- Guest: Login & Register -->
        @guest
        <a href="{{ route('login') }}" class="btn-soft text-xs font-medium text-emerald-100
border border-emerald-300/60 px-3 py-1 rounded-full relative">
        <a href="{{ route('register') }}" class="btn-soft text-xs font-medium text-emerald-100
border border-emerald-300/60 px-3 py-1 rounded-full relative">Daftar</a>
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
