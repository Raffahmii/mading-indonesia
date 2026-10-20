<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('mading.app_name')) — {{ config('mading.app_name') }}</title>
    <meta name="description" content="@yield('description', 'Pusat informasi dan mading antar-universitas Indonesia.')">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('head')
</head>
<body class="min-h-screen bg-surface-muted flex flex-col antialiased"
      x-data="{
          loginOpen: {{ $errors->has('email') && !session('status') && !request()->routeIs('register') ? 'true' : 'false' }},
          registerOpen: {{ request()->routeIs('register') && $errors->any() ? 'true' : 'false' }},
          searchOpen: false,
          mobileMenuOpen: false,
          scrolled: false
      }"
      @scroll.window="scrolled = window.scrollY > 20">

    {{-- NAVBAR --}}
    <header class="sticky top-0 z-40 transition-all duration-300"
            :class="scrolled ? 'bg-white/95 backdrop-blur-lg shadow-sm border-b border-surface-border' : 'bg-transparent'">

        <div class="max-w-7xl mx-auto px-4 lg:px-8">
            <div class="flex items-center justify-between h-16 lg:h-20">

                {{-- LOGO (teks saja) --}}
                <a href="{{ route('public.home') }}" class="flex-shrink-0">
                    <span class="font-extrabold text-xl lg:text-2xl tracking-tight text-brand-gradient">
                        Mading Indonesia
                    </span>
                </a>

                {{-- NAV Desktop (smooth scroll ke section) --}}
                @if(request()->routeIs('public.home'))
                    <nav class="hidden md:flex items-center gap-1">
                        <a href="#beranda" class="nav-link">Beranda</a>
                        <a href="#universitas" class="nav-link">Universitas</a>
                        <a href="#kategori" class="nav-link">Kategori</a>
                        <a href="#informasi" class="nav-link">Informasi</a>
                    </nav>
                @else
                    <nav class="hidden md:flex items-center gap-1">
                        <a href="{{ route('public.home') }}" class="nav-link">Beranda</a>
                        <a href="{{ route('public.universities.index') }}" class="nav-link">Universitas</a>
                    </nav>
                @endif

                {{-- RIGHT ACTIONS --}}
                <div class="flex items-center gap-2">

                    {{-- SEARCH BUTTON --}}
                    <button type="button"
                            @click="searchOpen = true"
                            class="p-2.5 rounded-xl text-ink-muted hover:text-brand-700 hover:bg-brand-50 transition"
                            title="Cari">
                        <i data-lucide="search" class="w-5 h-5"></i>
                    </button>

                    @auth
                        {{-- Bookmark --}}
                        <a href="{{ route('public.bookmarks.index') }}"
                           class="hidden sm:inline-flex p-2.5 rounded-xl text-ink-muted hover:text-brand-700 hover:bg-brand-50 transition"
                           title="Favorit Saya">
                            <i data-lucide="bookmark" class="w-5 h-5"></i>
                        </a>

                        {{-- Dashboard --}}
                        @if(auth()->user()->isSuperAdmin())
                            <a href="{{ route('super-admin.dashboard') }}" class="btn btn-sm btn-outline hidden sm:inline-flex">
                                <i data-lucide="layout-dashboard" class="w-4 h-4"></i>
                                Dashboard
                            </a>
                        @elseif(auth()->user()->isUniversityAdmin())
                            <a href="{{ route('university-admin.dashboard') }}" class="btn btn-sm btn-outline hidden sm:inline-flex">
                                <i data-lucide="layout-dashboard" class="w-4 h-4"></i>
                                Dashboard
                            </a>
                        @endif

                        {{-- User Dropdown --}}
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open"
                                    class="flex items-center gap-2 p-1 pr-2 rounded-xl hover:bg-surface-muted transition">
                                <div class="avatar avatar-sm bg-brand-100 text-brand-700 font-bold">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </div>
                                <i data-lucide="chevron-down" class="w-4 h-4 text-ink-muted hidden sm:inline"></i>
                            </button>

                            <div x-show="open" x-cloak @click.outside="open = false"
                                 x-transition:enter="transition ease-out duration-150"
                                 x-transition:enter-start="opacity-0 scale-95 -translate-y-2"
                                 x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                                 x-transition:leave="transition ease-in duration-100"
                                 x-transition:leave-start="opacity-100 scale-100"
                                 x-transition:leave-end="opacity-0 scale-95"
                                 class="absolute right-0 mt-2 w-60 bg-white rounded-2xl shadow-dropdown border border-surface-border py-2 z-50">
                                <div class="px-4 py-2 border-b border-surface-border mb-1">
                                    <div class="text-sm font-semibold truncate text-ink">{{ auth()->user()->name }}</div>
                                    <div class="text-xs text-ink-muted truncate">{{ auth()->user()->email }}</div>
                                </div>
                                <a href="{{ route('public.bookmarks.index') }}"
                                   class="flex items-center gap-3 px-4 py-2.5 text-sm text-ink hover:bg-surface-muted transition">
                                    <i data-lucide="bookmark" class="w-4 h-4 text-ink-muted"></i>
                                    Favorit Saya
                                </a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                            class="w-full flex items-center gap-3 px-4 py-2.5 text-sm text-danger hover:bg-red-50 transition">
                                        <i data-lucide="log-out" class="w-4 h-4"></i>
                                        Keluar
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <button @click="loginOpen = true" class="btn btn-sm btn-ghost hidden sm:inline-flex">
                            Masuk
                        </button>
                        <button @click="registerOpen = true" class="btn btn-sm btn-primary">
                            Daftar
                        </button>
                    @endauth

                    {{-- Mobile Menu Button --}}
                    <button type="button" @click="mobileMenuOpen = !mobileMenuOpen"
                            class="md:hidden p-2.5 rounded-xl text-ink-muted hover:bg-surface-muted transition">
                        <i data-lucide="menu" x-show="!mobileMenuOpen" class="w-5 h-5"></i>
                        <i data-lucide="x" x-show="mobileMenuOpen" x-cloak class="w-5 h-5"></i>
                    </button>
                </div>

            </div>

            {{-- MOBILE MENU --}}
            <div x-show="mobileMenuOpen" x-cloak
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 -translate-y-4"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 translate-y-0"
                 x-transition:leave-end="opacity-0 -translate-y-4"
                 class="md:hidden border-t border-surface-border py-3 space-y-1 bg-white rounded-b-2xl">

                @if(request()->routeIs('public.home'))
                    <a href="#beranda" @click="mobileMenuOpen = false" class="block px-4 py-3 rounded-xl text-sm font-medium text-ink-muted hover:bg-brand-50 hover:text-brand-700 transition">Beranda</a>
                    <a href="#universitas" @click="mobileMenuOpen = false" class="block px-4 py-3 rounded-xl text-sm font-medium text-ink-muted hover:bg-brand-50 hover:text-brand-700 transition">Universitas</a>
                    <a href="#kategori" @click="mobileMenuOpen = false" class="block px-4 py-3 rounded-xl text-sm font-medium text-ink-muted hover:bg-brand-50 hover:text-brand-700 transition">Kategori</a>
                    <a href="#informasi" @click="mobileMenuOpen = false" class="block px-4 py-3 rounded-xl text-sm font-medium text-ink-muted hover:bg-brand-50 hover:text-brand-700 transition">Informasi</a>
                @else
                    <a href="{{ route('public.home') }}" class="block px-4 py-3 rounded-xl text-sm font-medium text-ink-muted hover:bg-brand-50 hover:text-brand-700 transition">Beranda</a>
                    <a href="{{ route('public.universities.index') }}" class="block px-4 py-3 rounded-xl text-sm font-medium text-ink-muted hover:bg-brand-50 hover:text-brand-700 transition">Universitas</a>
                @endif

                @auth
                    <a href="{{ route('public.bookmarks.index') }}" class="block px-4 py-3 rounded-xl text-sm font-medium text-ink-muted hover:bg-brand-50 hover:text-brand-700 transition">Favorit Saya</a>
                @else
                    <div class="pt-2 border-t border-surface-border mt-2 flex gap-2">
                        <button @click="mobileMenuOpen = false; loginOpen = true" class="btn btn-sm btn-outline flex-1">Masuk</button>
                        <button @click="mobileMenuOpen = false; registerOpen = true" class="btn btn-sm btn-primary flex-1">Daftar</button>
                    </div>
                @endauth
            </div>

        </div>
    </header>

    {{-- FLASH --}}
    @if(session('success') || session('error'))
        <div class="max-w-7xl mx-auto px-4 lg:px-8 pt-4 w-full">
            @if(session('success'))
                <div class="alert alert-success flex items-start gap-2">
                    <i data-lucide="check-circle-2" class="w-5 h-5 flex-shrink-0 mt-0.5"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-error flex items-start gap-2">
                    <i data-lucide="alert-circle" class="w-5 h-5 flex-shrink-0 mt-0.5"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif
        </div>
    @endif

    {{-- MAIN --}}
    <main class="flex-1">
        @yield('content')
    </main>

    {{-- FOOTER --}}
    <footer class="bg-ink text-white/90 mt-20">
        <div class="max-w-7xl mx-auto px-4 lg:px-8 py-14">
            <div class="grid md:grid-cols-12 gap-8 lg:gap-12">

                <div class="md:col-span-5">
                    <div class="text-2xl font-extrabold text-white mb-4">Mading Indonesia</div>
                    <p class="text-sm text-white/60 max-w-md leading-relaxed">
                        Platform digital mading dan pusat informasi antar-universitas Indonesia. Temukan pengumuman, event, lomba, beasiswa, dan prestasi dari kampus seluruh Indonesia dalam satu tempat.
                    </p>
                </div>

                <div class="md:col-span-2">
                    <h4 class="font-semibold mb-4 text-sm text-white">Navigasi</h4>
                    <ul class="space-y-2.5 text-sm text-white/60">
                        <li><a href="{{ route('public.home') }}" class="hover:text-white transition">Beranda</a></li>
                        <li><a href="{{ route('public.universities.index') }}" class="hover:text-white transition">Universitas</a></li>
                        <li><a href="{{ route('public.search') }}" class="hover:text-white transition">Cari</a></li>
                    </ul>
                </div>

                <div class="md:col-span-2">
                    <h4 class="font-semibold mb-4 text-sm text-white">Akun</h4>
                    <ul class="space-y-2.5 text-sm text-white/60">
                        @auth
                            <li><a href="{{ route('public.bookmarks.index') }}" class="hover:text-white transition">Favorit Saya</a></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="hover:text-white transition">Keluar</button>
                                </form>
                            </li>
                        @else
                            <li><button @click="loginOpen = true" class="hover:text-white transition">Masuk</button></li>
                            <li><button @click="registerOpen = true" class="hover:text-white transition">Daftar</button></li>
                        @endauth
                    </ul>
                </div>

                <div class="md:col-span-3">
                    <h4 class="font-semibold mb-4 text-sm text-white">Kontak</h4>
                    <ul class="space-y-2.5 text-sm text-white/60">
                        <li class="flex items-center gap-2">
                            <i data-lucide="mail" class="w-4 h-4"></i>
                            hello@mading.id
                        </li>
                        <li class="flex items-center gap-2">
                            <i data-lucide="globe" class="w-4 h-4"></i>
                            www.mading.id
                        </li>
                    </ul>
                </div>

            </div>

            <div class="border-t border-white/10 mt-10 pt-6 flex flex-col sm:flex-row justify-between items-center gap-4 text-sm text-white/50">
                <div>© {{ date('Y') }} Mading Indonesia. All rights reserved.</div>
                <div class="flex gap-4">
                    <a href="#" class="hover:text-white transition">Syarat & Ketentuan</a>
                    <a href="#" class="hover:text-white transition">Kebijakan Privasi</a>
                </div>
            </div>
        </div>
    </footer>

    {{-- MODAL SEARCH --}}
    <div x-show="searchOpen" x-cloak
         @keydown.escape.window="searchOpen = false"
         class="fixed inset-0 z-[100] flex items-start justify-center p-4 pt-20 sm:pt-32">

        <div x-show="searchOpen"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="searchOpen = false"
             class="absolute inset-0 bg-ink/60 backdrop-blur-sm"></div>

        <div x-show="searchOpen"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95 -translate-y-4"
             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95"
             @click.outside="searchOpen = false"
             class="relative bg-white rounded-3xl shadow-2xl w-full max-w-2xl overflow-hidden">

            {{-- Header --}}
            <div class="flex items-center gap-3 p-2 pl-5 border-b border-surface-border">
                <i data-lucide="search" class="w-5 h-5 text-ink-muted flex-shrink-0"></i>

                @auth
                    <form action="{{ route('public.search') }}" method="GET" class="flex-1 flex items-center gap-2">
                        <input type="text"
                               name="q"
                               autofocus
                               x-ref="searchInput"
                               x-init="$watch('searchOpen', value => { if (value) $nextTick(() => $refs.searchInput.focus()) })"
                               placeholder="Cari universitas, event, lomba, beasiswa..."
                               class="w-full py-3 text-ink placeholder:text-ink-soft focus:outline-none bg-transparent">
                        <button type="submit" class="btn btn-primary btn-sm flex-shrink-0">
                            Cari
                        </button>
                    </form>
                @else
                    <input type="text"
                           readonly
                           @click="searchOpen = false; loginOpen = true"
                           placeholder="Login dulu untuk mencari"
                           class="flex-1 py-3 text-ink-muted placeholder:text-ink-soft focus:outline-none bg-transparent cursor-pointer">
                    <button @click="searchOpen = false; loginOpen = true" class="btn btn-primary btn-sm flex-shrink-0">
                        Login
                    </button>
                @endauth

                <button @click="searchOpen = false"
                        class="p-2 rounded-lg text-ink-muted hover:bg-surface-muted transition flex-shrink-0">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            {{-- Hint --}}
            <div class="p-5 bg-surface-muted/50">
                @auth
                    <div class="text-xs font-semibold text-ink-muted uppercase tracking-wider mb-3">
                        Cari Cepat
                    </div>
                    <div class="flex flex-wrap gap-2">
                        @foreach(['Beasiswa', 'Lomba', 'Seminar', 'Event', 'Pengumuman'] as $tag)
                            <a href="{{ route('public.search', ['q' => $tag]) }}"
                               class="px-3 py-1.5 rounded-full bg-white border border-surface-border text-sm text-ink-muted hover:border-brand-300 hover:text-brand-700 transition">
                                {{ $tag }}
                            </a>
                        @endforeach
                    </div>
                @else
                    <div class="flex items-start gap-3 p-4 rounded-xl bg-brand-50 border border-brand-100">
                        <i data-lucide="info" class="w-5 h-5 text-brand-700 flex-shrink-0 mt-0.5"></i>
                        <div class="text-sm">
                            <div class="font-semibold text-brand-800 mb-0.5">Login diperlukan</div>
                            <div class="text-brand-700/80">
                                Untuk mencari konten, kamu perlu login dulu.
                                <button @click="searchOpen = false; loginOpen = true" class="font-semibold underline hover:no-underline">Masuk sekarang</button> atau
                                <button @click="searchOpen = false; registerOpen = true" class="font-semibold underline hover:no-underline">daftar gratis</button>.
                            </div>
                        </div>
                    </div>
                @endauth
            </div>

        </div>
    </div>

    @guest
        @include('public.partials.auth-modals')
    @endguest

    @stack('scripts')
</body>
</html>