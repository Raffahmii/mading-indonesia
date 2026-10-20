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
    </style>
</head>
<body class="min-h-screen bg-surface-muted antialiased"
      x-data="{ sidebarOpen: false }">

{{-- WRAPPER --}}
<div class="min-h-screen">

    {{-- ============================================================
         SIDEBAR (fixed di mobile, sticky di desktop)
         ============================================================ --}}
    <aside class="fixed top-0 left-0 z-50 w-72 h-screen
                  flex flex-col
                  bg-gradient-to-b from-ink to-[#1a1220] text-white
                  transition-transform duration-300
                  -translate-x-full lg:translate-x-0
                  shadow-2xl shadow-black/20"
           :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'">

        {{-- Brand --}}
        <div class="p-6 border-b border-white/5 flex-shrink-0">
            <a href="{{ route('super-admin.dashboard') }}" class="flex items-center gap-3 group">
                <div class="w-11 h-11 rounded-2xl bg-brand-gradient flex items-center justify-center shadow-lg shadow-brand-700/40 group-hover:scale-105 transition-transform">
                    <i data-lucide="shield" class="w-5 h-5 text-white"></i>
                </div>
                <div class="leading-tight">
                    <div class="font-bold text-base text-white">{{ config('mading.app_name') }}</div>
                    <div class="text-[10px] text-white/50 font-bold tracking-widest uppercase">Super Admin</div>
                </div>
            </a>
        </div>

        {{-- Nav (scrollable) --}}
        <nav class="flex-1 overflow-y-auto p-4 space-y-6 min-h-0">
            @php
                $navGroups = [
                    'Utama' => [
                        ['route' => 'super-admin.dashboard', 'pattern' => 'super-admin.dashboard', 'icon' => 'layout-dashboard', 'label' => 'Dashboard'],
                    ],
                    'Manajemen' => [
                        ['route' => 'super-admin.universities.index', 'pattern' => 'super-admin.universities.*', 'icon' => 'building-2', 'label' => 'Universitas'],
                        ['route' => 'super-admin.admins.index', 'pattern' => 'super-admin.admins.*', 'icon' => 'user-cog', 'label' => 'Admin Universitas'],
                        ['route' => 'super-admin.members.index', 'pattern' => 'super-admin.members.*', 'icon' => 'users', 'label' => 'Anggota'],
                    ],
                    'Konten' => [
                        ['route' => 'super-admin.posts.index', 'pattern' => 'super-admin.posts.*', 'icon' => 'file-text', 'label' => 'Semua Konten'],
                        ['route' => 'super-admin.approvals.index', 'pattern' => 'super-admin.approvals.*', 'icon' => 'check-circle-2', 'label' => 'Approval', 'badge' => \App\Models\Post::withoutGlobalScopes()->where('status', \App\Enums\PostStatus::PENDING)->count()],
                        ['route' => 'super-admin.categories.index', 'pattern' => 'super-admin.categories.*', 'icon' => 'folder', 'label' => 'Kategori'],
                    ],
                    'Sistem' => [
                        ['route' => 'super-admin.activity-logs.index', 'pattern' => 'super-admin.activity-logs.*', 'icon' => 'activity', 'label' => 'Activity Log'],
                        ['route' => 'super-admin.settings.index', 'pattern' => 'super-admin.settings.*', 'icon' => 'settings', 'label' => 'Pengaturan'],
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
                                @if(!empty($item['badge']) && $item['badge'] > 0)
                                    <span class="min-w-[20px] h-5 px-1.5 rounded-full bg-brand-gradient text-[10px] font-bold flex items-center justify-center text-white">
                                        {{ $item['badge'] }}
                                    </span>
                                @endif
                            </a>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </nav>

        {{-- User Footer --}}
        <div class="p-4 border-t border-white/5 flex-shrink-0">
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open"
                        class="w-full flex items-center gap-3 p-2.5 rounded-xl hover:bg-white/5 transition">
                    <div class="w-9 h-9 rounded-xl bg-brand-gradient flex items-center justify-center font-bold text-sm flex-shrink-0">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div class="flex-1 min-w-0 text-left">
                        <div class="text-sm font-semibold text-white truncate">{{ auth()->user()->name }}</div>
                        <div class="text-xs text-white/50 truncate">{{ auth()->user()->email }}</div>
                    </div>
                    <i data-lucide="chevrons-up-down" class="w-4 h-4 text-white/40 flex-shrink-0"></i>
                </button>

                <div x-show="open" x-cloak @click.outside="open = false"
                     x-transition:enter="transition ease-out duration-150"
                     x-transition:enter-start="opacity-0 translate-y-2"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     class="absolute bottom-full left-0 right-0 mb-2 bg-[#2a1f30] rounded-xl border border-white/10 py-1.5 shadow-2xl">
                    <a href="{{ route('public.home') }}" target="_blank"
                       class="flex items-center gap-2.5 px-4 py-2 text-sm text-white/70 hover:text-white hover:bg-white/5">
                        <i data-lucide="external-link" class="w-4 h-4"></i>
                        Lihat Situs
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                                class="w-full flex items-center gap-2.5 px-4 py-2 text-sm text-red-400 hover:text-red-300 hover:bg-red-500/10 transition">
                            <i data-lucide="log-out" class="w-4 h-4"></i>
                            Keluar
                        </button>
                    </form>
                </div>
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
         class="fixed inset-0 bg-ink/60 backdrop-blur-sm z-40 lg:hidden"></div>

    {{-- ============================================================
         MAIN AREA (offset kiri 72 = 18rem dari sidebar)
         ============================================================ --}}
    <div class="lg:pl-72 flex flex-col min-h-screen">

        {{-- TOPBAR --}}
        <header class="sticky top-0 z-30 bg-white/80 backdrop-blur-xl border-b border-surface-border">
            <div class="flex items-center justify-between px-4 lg:px-8 h-16">

                <div class="flex items-center gap-3">
                    <button @click="sidebarOpen = true"
                            class="lg:hidden p-2 rounded-xl text-ink-muted hover:bg-surface-muted transition">
                        <i data-lucide="menu" class="w-5 h-5"></i>
                    </button>

                    <div class="flex items-center gap-2 text-sm">
                        <a href="{{ route('super-admin.dashboard') }}" class="text-ink-muted hover:text-brand-700 transition hidden sm:inline">
                            Super Admin
                        </a>
                        <i data-lucide="chevron-right" class="w-3.5 h-3.5 text-ink-soft hidden sm:inline"></i>
                        <span class="font-semibold text-ink">@yield('title', 'Dashboard')</span>
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    @php $pendingCount = \App\Models\Post::withoutGlobalScopes()->where('status', \App\Enums\PostStatus::PENDING)->count(); @endphp
                    @if($pendingCount > 0)
                        <a href="{{ route('super-admin.approvals.index') }}"
                           class="relative p-2.5 rounded-xl text-ink-muted hover:text-brand-700 hover:bg-brand-50 transition">
                            <i data-lucide="bell" class="w-5 h-5"></i>
                            <span class="absolute top-1.5 right-1.5 w-2 h-2 rounded-full bg-danger animate-pulse"></span>
                        </a>
                    @endif

                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open"
                                class="flex items-center gap-2 p-1 pr-2.5 rounded-xl hover:bg-surface-muted transition">
                            <div class="w-8 h-8 rounded-lg bg-brand-gradient flex items-center justify-center text-white text-xs font-bold">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                            <span class="hidden sm:inline text-sm font-medium text-ink">{{ auth()->user()->name }}</span>
                            <i data-lucide="chevron-down" class="w-3.5 h-3.5 text-ink-muted hidden sm:inline"></i>
                        </button>

                        <div x-show="open" x-cloak @click.outside="open = false"
                             x-transition:enter="transition ease-out duration-150"
                             x-transition:enter-start="opacity-0 scale-95 -translate-y-2"
                             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                             class="absolute right-0 mt-2 w-56 bg-white rounded-2xl shadow-dropdown border border-surface-border py-1.5">
                            <div class="px-4 py-3 border-b border-surface-border">
                                <div class="text-sm font-semibold text-ink truncate">{{ auth()->user()->name }}</div>
                                <div class="text-xs text-ink-muted truncate">{{ auth()->user()->email }}</div>
                            </div>
                            <a href="{{ route('public.home') }}" target="_blank"
                               class="flex items-center gap-2.5 px-4 py-2.5 text-sm text-ink hover:bg-surface-muted">
                                <i data-lucide="external-link" class="w-4 h-4 text-ink-muted"></i>
                                Lihat Situs
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                        class="w-full flex items-center gap-2.5 px-4 py-2.5 text-sm text-danger hover:bg-red-50 transition">
                                    <i data-lucide="log-out" class="w-4 h-4"></i>
                                    Keluar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        {{-- FLASH --}}
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

        {{-- CONTENT --}}
        <main class="flex-1 p-4 lg:p-8">
            <div class="max-w-[1400px] mx-auto">
                @yield('content')
            </div>
        </main>

    </div>

</div>

</body>
</html>