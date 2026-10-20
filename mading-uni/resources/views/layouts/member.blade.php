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
</head>
<body class="min-h-screen bg-surface-muted antialiased"
      x-data="{ sidebarOpen: false }">

<div class="min-h-screen flex">

    {{-- ============================================================
         SIDEBAR
         ============================================================ --}}
    <aside class="fixed lg:sticky top-0 left-0 z-50 w-64 h-screen bg-white border-r border-surface-border flex flex-col transition-transform duration-300 lg:translate-x-0"
           :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'">

        {{-- Brand --}}
        <div class="p-5 border-b border-surface-border">
            <a href="{{ route('public.home') }}" class="flex items-center justify-between group">
                <span class="font-extrabold text-lg text-brand-gradient">
                    Mading Indonesia
                </span>
                <i data-lucide="arrow-up-right" class="w-4 h-4 text-ink-soft group-hover:text-brand-700 transition"></i>
            </a>
            <div class="text-xs text-ink-muted mt-1">Panel Anggota</div>
        </div>

        {{-- Nav --}}
        <nav class="flex-1 overflow-y-auto p-3 space-y-1">
            @php
                $navItems = [
                    ['route' => 'member.dashboard',  'pattern' => 'member.dashboard',      'icon' => 'layout-dashboard', 'label' => 'Dashboard'],
                    ['route' => 'member.bookmarks',  'pattern' => 'member.bookmarks',      'icon' => 'bookmark',         'label' => 'Favorit Saya'],
                    ['route' => 'member.profile',    'pattern' => 'member.profile',        'icon' => 'user',             'label' => 'Profil'],
                    ['route' => 'member.password',   'pattern' => 'member.password',       'icon' => 'lock',             'label' => 'Password'],
                ];
            @endphp

            @foreach($navItems as $item)
                <a href="{{ route($item['route']) }}"
                   class="sidebar-link {{ request()->routeIs($item['pattern']) ? 'active' : '' }}">
                    <i data-lucide="{{ $item['icon'] }}" class="w-5 h-5"></i>
                    <span>{{ $item['label'] }}</span>
                </a>
            @endforeach
        </nav>

        {{-- User Profile Footer --}}
        <div class="p-3 border-t border-surface-border">
            <div class="flex items-center gap-3 p-2 rounded-xl bg-surface-muted">
                <div class="avatar avatar-sm bg-brand-100 text-brand-700 font-bold">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <div class="text-sm font-medium truncate text-ink">{{ auth()->user()->name }}</div>
                    <div class="text-xs text-ink-muted truncate">{{ auth()->user()->email }}</div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="p-1.5 rounded-lg text-ink-muted hover:text-danger hover:bg-red-50 transition" title="Keluar">
                        <i data-lucide="log-out" class="w-4 h-4"></i>
                    </button>
                </form>
            </div>
        </div>

    </aside>

    {{-- Overlay mobile --}}
    <div x-show="sidebarOpen" x-cloak @click="sidebarOpen = false"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-ink/50 backdrop-blur-sm z-40 lg:hidden"></div>

    {{-- ============================================================
         MAIN CONTENT
         ============================================================ --}}
    <div class="flex-1 min-w-0 flex flex-col">

        {{-- Topbar --}}
        <header class="sticky top-0 z-30 bg-white/95 backdrop-blur-lg border-b border-surface-border">
            <div class="flex items-center justify-between px-4 lg:px-6 h-16">
                <div class="flex items-center gap-3">
                    <button @click="sidebarOpen = true" class="lg:hidden p-2 rounded-lg text-ink-muted hover:bg-surface-muted transition">
                        <i data-lucide="menu" class="w-5 h-5"></i>
                    </button>
                    <div>
                        <h1 class="text-lg font-bold text-ink">@yield('title', 'Dashboard')</h1>
                        <p class="text-xs text-ink-muted hidden sm:block">@yield('subtitle', 'Panel Anggota')</p>
                    </div>
                </div>

                <a href="{{ route('public.home') }}" class="btn btn-sm btn-outline">
                    <i data-lucide="home" class="w-4 h-4"></i>
                    <span class="hidden sm:inline">Beranda</span>
                </a>
            </div>
        </header>

        {{-- Flash Messages --}}
        @if(session('success') || session('error'))
            <div class="px-4 lg:px-6 pt-4">
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

        {{-- Content --}}
        <main class="flex-1 p-4 lg:p-6">
            @yield('content')
        </main>

    </div>

</div>

</body>
</html>