<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Dashboard' }} — {{ $theme->name }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- DYNAMIC THEME INJECTION --}}
    <style>
        :root {
            --university-primary: {{ $theme->primary }};
            --university-secondary: {{ $theme->secondary }};
            --university-accent: {{ $theme->accent }};
            --university-soft: {{ $theme->soft }};
        }
    </style>
</head>
<body class="min-h-screen bg-surface-muted">

<div x-data="{ sidebarOpen: false }" class="min-h-screen flex">

    {{-- SIDEBAR --}}
    <aside class="fixed lg:sticky top-0 left-0 z-50 w-64 h-screen bg-white border-r border-surface-border flex flex-col transition-transform lg:translate-x-0"
           :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'">

        {{-- Brand universitas --}}
        <div class="p-5 border-b border-surface-border">
            <a href="{{ route('university-admin.dashboard') }}" class="flex items-center gap-2">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center text-white bg-university-gradient flex-shrink-0">
                    @if($theme->logo_url)
                        <img src="{{ $theme->logo_url }}" alt="{{ $theme->name }}" class="w-8 h-8 object-contain">
                    @else
                        <i data-lucide="building-2" class="w-5 h-5"></i>
                    @endif
                </div>
                <div class="leading-tight min-w-0">
                    <div class="font-bold text-sm truncate">{{ $theme->name }}</div>
                    <div class="text-xs text-ink-muted">Admin Panel</div>
                </div>
            </a>
        </div>

        {{-- Nav --}}
        <nav class="flex-1 overflow-y-auto p-3 space-y-1">
            @php
                $navItems = [
                    ['route' => 'university-admin.dashboard',       'pattern' => 'university-admin.dashboard',      'icon' => 'layout-dashboard', 'label' => 'Dashboard'],
                    ['route' => 'university-admin.posts.index',     'pattern' => 'university-admin.posts.*',        'icon' => 'file-text',        'label' => 'Konten'],
                    ['route' => 'university-admin.profile.edit',    'pattern' => 'university-admin.profile.*',      'icon' => 'building-2',       'label' => 'Profil Universitas'],
                    ['route' => 'university-admin.account.edit',    'pattern' => 'university-admin.account.*',      'icon' => 'user',             'label' => 'Akun'],
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

        {{-- User --}}
        <div class="p-3 border-t border-surface-border">
            <div class="flex items-center gap-3 p-2 rounded-lg bg-surface-muted">
                <div class="avatar avatar-sm" style="background: color-mix(in srgb, var(--university-primary) 15%, transparent); color: var(--university-primary);">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <div class="text-sm font-medium truncate">{{ auth()->user()->name }}</div>
                    <div class="text-xs text-ink-muted truncate">{{ auth()->user()->email }}</div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="p-1 rounded text-ink-muted hover:text-danger" title="Keluar">
                        <i data-lucide="log-out" class="w-4 h-4"></i>
                    </button>
                </form>
            </div>
        </div>

    </aside>

    {{-- OVERLAY --}}
    <div x-show="sidebarOpen" x-cloak @click="sidebarOpen = false"
         class="fixed inset-0 bg-ink/50 z-40 lg:hidden"></div>

    {{-- MAIN --}}
    <div class="flex-1 min-w-0 flex flex-col">

        {{-- TOPBAR --}}
        <header class="sticky top-0 z-30 bg-white border-b border-surface-border">
            <div class="flex items-center justify-between px-4 lg:px-6 h-16">
                <div class="flex items-center gap-3">
                    <button @click="sidebarOpen = true" class="lg:hidden p-2 rounded-lg hover:bg-surface-muted">
                        <i data-lucide="menu" class="w-5 h-5"></i>
                    </button>
                    <h1 class="text-lg font-bold">{{ $title ?? 'Dashboard' }}</h1>
                </div>

                <a href="{{ route('public.universities.show', $theme->slug) }}" target="_blank" class="btn btn-sm btn-outline">
                    <i data-lucide="external-link" class="w-4 h-4"></i>
                    Lihat Profil Publik
                </a>
            </div>
        </header>

        {{-- FLASH --}}
        @if(session('success') || session('error') || $errors->any())
            <div class="px-4 lg:px-6 pt-4">
                @if(session('success'))
                    <div class="alert alert-success flex items-start gap-2">
                        <i data-lucide="check-circle" class="w-5 h-5 flex-shrink-0 mt-0.5"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-error flex items-start gap-2">
                        <i data-lucide="alert-circle" class="w-5 h-5 flex-shrink-0 mt-0.5"></i>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif
                @if($errors->any())
                    <div class="alert alert-error">
                        <strong class="block mb-1">Ada masalah:</strong>
                        <ul class="list-disc list-inside text-sm space-y-0.5">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        @endif

        {{-- CONTENT --}}
        <main class="flex-1 p-4 lg:p-6">
            {{ $slot }}
        </main>

    </div>

</div>

</body>
</html>