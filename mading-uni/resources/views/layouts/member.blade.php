<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') — {{ config('mading.app_name') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        [x-cloak] { display: none !important; }

        .admin-sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 18rem;
            height: 100vh;
            z-index: 50;
            display: flex;
            flex-direction: column;
            transform: translateX(-100%);
            transition: transform 0.3s ease;
        }

        .admin-sidebar.is-open { transform: translateX(0); }

        @media (min-width: 1024px) {
            .admin-sidebar { transform: translateX(0); }
        }

        .admin-main {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        @media (min-width: 1024px) {
            .admin-main { padding-left: 18rem; }
        }

        .admin-overlay {
            position: fixed;
            inset: 0;
            background: rgba(36, 26, 38, 0.6);
            backdrop-filter: blur(4px);
            z-index: 40;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s ease;
        }

        .admin-overlay.is-open {
            opacity: 1;
            pointer-events: auto;
        }

        @media (min-width: 1024px) {
            .admin-overlay { display: none; }
        }

        .admin-sidebar nav::-webkit-scrollbar { width: 4px; }
        .admin-sidebar nav::-webkit-scrollbar-track { background: transparent; }
        .admin-sidebar nav::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 2px;
        }
    </style>
</head>
<body class="min-h-screen bg-surface-muted antialiased">

{{-- SIDEBAR --}}
<aside id="adminSidebar" class="admin-sidebar bg-gradient-to-b from-ink to-[#1a1220] text-white shadow-2xl shadow-black/20">

    {{-- Brand --}}
    <div class="p-6 border-b border-white/5 flex-shrink-0">
        <a href="{{ route('public.home') }}" class="flex items-center gap-3 group">
            <div class="w-11 h-11 rounded-2xl bg-brand-gradient flex items-center justify-center shadow-lg shadow-brand-700/40 group-hover:scale-105 transition-transform">
                <i data-lucide="user" class="w-5 h-5 text-white"></i>
            </div>
            <div class="leading-tight">
                <div class="font-bold text-base text-white">{{ config('mading.app_name') }}</div>
                <div class="text-[10px] text-white/50 font-bold tracking-widest uppercase">Panel Anggota</div>
            </div>
        </a>
    </div>

    {{-- Nav --}}
    <nav class="flex-1 overflow-y-auto p-4 space-y-6 min-h-0">
        @php
            $navGroups = [
                'Utama' => [
                    ['route' => 'member.dashboard', 'pattern' => 'member.dashboard', 'icon' => 'layout-dashboard', 'label' => 'Dashboard'],
                ],
                'Koleksi' => [
                    ['route' => 'member.bookmarks', 'pattern' => 'member.bookmarks', 'icon' => 'bookmark', 'label' => 'Favorit Saya'],
                ],
                'Akun' => [
                    ['route' => 'member.profile', 'pattern' => 'member.profile', 'icon' => 'user', 'label' => 'Profil Saya'],
                    ['route' => 'member.password', 'pattern' => 'member.password', 'icon' => 'lock', 'label' => 'Ubah Password'],
                ],
            ];
        @endphp

        @foreach($navGroups as $groupLabel => $items)
            <div>
                <div class="px-3 mb-2 text-[10px] font-bold text-white/40 uppercase tracking-widest">
                    {{ $groupLabel }}
                </div>
                <div class="space-y-1">
                    @foreach($items as $item)
                        @php $isActive = request()->routeIs($item['pattern']); @endphp
                        <a href="{{ route($item['route']) }}"
                           class="group relative flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all
                                  {{ $isActive ? 'bg-white/10 text-white' : 'text-white/60 hover:text-white hover:bg-white/5' }}">
                            @if($isActive)
                                <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-6 rounded-r-full bg-brand-gradient"></div>
                            @endif
                            <i data-lucide="{{ $item['icon'] }}" class="w-[18px] h-[18px] flex-shrink-0"></i>
                            <span class="flex-1">{{ $item['label'] }}</span>
                        </a>
                    @endforeach
                </div>
            </div>
        @endforeach
    </nav>

    {{-- User Footer --}}
    <div class="p-4 border-t border-white/5 flex-shrink-0">
        <div class="flex items-center gap-3 p-2.5 rounded-xl bg-white/5">
            <div class="w-9 h-9 rounded-xl bg-brand-gradient flex items-center justify-center font-bold text-sm flex-shrink-0">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <div class="flex-1 min-w-0">
                <div class="text-sm font-semibold text-white truncate">{{ auth()->user()->name }}</div>
                <div class="text-xs text-white/50 truncate">{{ auth()->user()->email }}</div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="p-1.5 rounded-lg text-white/60 hover:text-red-400 hover:bg-red-500/10 transition" title="Keluar">
                    <i data-lucide="log-out" class="w-4 h-4"></i>
                </button>
            </form>
        </div>
    </div>

</aside>

{{-- Overlay mobile --}}
<div id="adminOverlay" class="admin-overlay"></div>

{{-- MAIN --}}
<div class="admin-main">

    {{-- Topbar --}}
    <header class="sticky top-0 z-30 bg-white/80 backdrop-blur-xl border-b border-surface-border">
        <div class="flex items-center justify-between px-4 lg:px-8 h-16">
            <div class="flex items-center gap-3">
                <button type="button" onclick="document.getElementById('adminSidebar').classList.add('is-open'); document.getElementById('adminOverlay').classList.add('is-open');"
                        class="lg:hidden p-2 rounded-xl text-ink-muted hover:bg-surface-muted transition">
                    <i data-lucide="menu" class="w-5 h-5"></i>
                </button>

                <div class="flex items-center gap-2 text-sm">
                    <a href="{{ route('public.home') }}" class="text-ink-muted hover:text-brand-700 transition hidden sm:inline">
                        Mading Indonesia
                    </a>
                    <i data-lucide="chevron-right" class="w-3.5 h-3.5 text-ink-soft hidden sm:inline"></i>
                    <span class="font-semibold text-ink">@yield('title', 'Dashboard')</span>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('public.universities.index') }}" class="btn btn-sm btn-outline hidden sm:inline-flex">
                    <i data-lucide="compass" class="w-4 h-4"></i>
                    Jelajahi
                </a>

                <div class="w-8 h-8 rounded-lg bg-brand-gradient flex items-center justify-center text-white text-xs font-bold">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
            </div>
        </div>
    </header>

    {{-- Flash --}}
    @if(session('success') || session('error'))
        <div class="px-4 lg:px-8 pt-5">
            @if(session('success'))
                <div class="alert alert-success flex items-start gap-2.5">
                    <i data-lucide="check-circle-2" class="w-5 h-5 flex-shrink-0 mt-0.5"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-error flex items-start gap-2.5">
                    <i data-lucide="alert-circle" class="w-5 h-5 flex-shrink-0 mt-0.5"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif
        </div>
    @endif

    {{-- Content --}}
    <main class="flex-1 p-4 lg:p-8">
        <div class="max-w-[1400px] mx-auto">
            @yield('content')
        </div>
    </main>

</div>

<script>
    document.getElementById('adminOverlay')?.addEventListener('click', function () {
        document.getElementById('adminSidebar')?.classList.remove('is-open');
        this.classList.remove('is-open');
    });
</script>

</body>
</html>