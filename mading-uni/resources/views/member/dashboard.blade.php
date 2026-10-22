@extends('layouts.member')

@section('title', 'Dashboard')

@section('content')

    {{-- HERO WELCOME --}}
    <div class="relative overflow-hidden rounded-2xl p-6 lg:p-8 mb-6 bg-brand-gradient text-white">
        <div class="absolute inset-0 pointer-events-none">
            <div class="blob blob-brand w-80 h-80 -top-20 -right-20 opacity-40 animate-blob"></div>
            <div class="blob blob-brand w-64 h-64 -bottom-16 -left-16 opacity-30 animate-blob-delay-2"></div>
        </div>

        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="max-w-2xl">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/15 backdrop-blur text-xs font-medium mb-3">
                    <i data-lucide="sparkles" class="w-3.5 h-3.5"></i>
                    Panel Anggota
                </div>
                <h1 class="text-2xl lg:text-3xl font-extrabold mb-2">
                    Halo, {{ explode(' ', auth()->user()->name)[0] }}! 👋
                </h1>
                <p class="text-white/85 text-sm lg:text-base leading-relaxed">
                    Temukan informasi menarik dari kampus-kampus Indonesia. Simpan yang kamu suka biar nggak kelewat.
                </p>
            </div>

            <a href="{{ route('public.universities.index') }}"
               class="inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl bg-white text-brand-700 font-semibold hover:bg-white/90 transition shadow-lg flex-shrink-0">
                <i data-lucide="compass" class="w-4 h-4"></i>
                Jelajahi Universitas
            </a>
        </div>
    </div>

    {{-- STATS GRID --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">

        <div class="stat-card">
            <div class="flex items-start justify-between mb-4">
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-brand-500 to-brand-700 flex items-center justify-center shadow-lg shadow-brand-500/25">
                    <i data-lucide="bookmark" class="w-6 h-6 text-white"></i>
                </div>
                <span class="text-xs font-medium text-ink-muted">Total</span>
            </div>
            <div class="text-4xl font-extrabold text-ink tracking-tight mb-1">{{ $stats['bookmarks'] }}</div>
            <div class="text-sm text-ink-muted">Konten Favorit</div>
        </div>

        <div class="stat-card">
            <div class="flex items-start justify-between mb-4">
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-blue-500 to-blue-700 flex items-center justify-center shadow-lg shadow-blue-500/25">
                    <i data-lucide="calendar" class="w-6 h-6 text-white"></i>
                </div>
                <span class="text-xs font-medium text-ink-muted">Sejak</span>
            </div>
            <div class="text-2xl font-extrabold text-ink tracking-tight mb-1">{{ auth()->user()->created_at->format('M Y') }}</div>
            <div class="text-sm text-ink-muted">{{ auth()->user()->created_at->diffForHumans() }}</div>
        </div>

        <div class="stat-card">
            <div class="flex items-start justify-between mb-4">
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-emerald-500 to-green-700 flex items-center justify-center shadow-lg shadow-green-500/25">
                    <i data-lucide="sparkles" class="w-6 h-6 text-white"></i>
                </div>
                <span class="text-xs font-medium text-ink-muted">Update</span>
            </div>
            <div class="text-4xl font-extrabold text-ink tracking-tight mb-1">{{ $suggestedPosts->count() }}</div>
            <div class="text-sm text-ink-muted">Dari Kampus Favorit</div>
        </div>

    </div>

    {{-- RECENT BOOKMARKS --}}
    @if($recentBookmarks->isNotEmpty())
        <div class="mb-8">
            <div class="flex items-center justify-between mb-5">
                <div>
                    <h2 class="text-xl font-bold text-ink">Favorit Terbaru</h2>
                    <p class="text-ink-muted text-sm">Konten yang baru saja kamu simpan.</p>
                </div>
                <a href="{{ route('member.bookmarks') }}" class="link-arrow">
                    Lihat semua
                    <i data-lucide="arrow-right" class="w-4 h-4"></i>
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                @foreach($recentBookmarks as $post)
                    @if($post)
                        @include('public.partials.post-card', ['post' => $post])
                    @endif
                @endforeach
            </div>
        </div>
    @else
        {{-- EMPTY STATE BOOKMARKS --}}
        <div class="card p-10 mb-8 text-center">
            <div class="w-16 h-16 rounded-2xl bg-brand-50 text-brand-700 flex items-center justify-center mx-auto mb-4">
                <i data-lucide="bookmark" class="w-8 h-8"></i>
            </div>
            <h3 class="font-bold text-lg mb-2 text-ink">Belum ada favorit</h3>
            <p class="text-ink-muted text-sm mb-6 max-w-md mx-auto">
                Mulai jelajahi konten dari kampus-kampus Indonesia dan simpan yang kamu suka. Nanti muncul di sini.
            </p>
            <a href="{{ route('public.universities.index') }}" class="btn btn-primary">
                <i data-lucide="compass" class="w-4 h-4"></i>
                Jelajahi Universitas
            </a>
        </div>
    @endif

    {{-- SUGGESTED POSTS --}}
    @if($suggestedPosts->isNotEmpty())
        <div class="card p-6 mb-6">
            <div class="flex items-center gap-3 mb-5 pb-4 border-b border-surface-border">
                <div class="w-10 h-10 rounded-xl bg-brand-50 flex items-center justify-center">
                    <i data-lucide="sparkles" class="w-5 h-5 text-brand-700"></i>
                </div>
                <div>
                    <h3 class="font-bold text-lg text-ink">Update dari Kampus Favoritmu</h3>
                    <p class="text-sm text-ink-muted">Konten terbaru dari universitas yang kamu ikuti.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($suggestedPosts as $post)
                    @include('public.partials.post-card', ['post' => $post])
                @endforeach
            </div>
        </div>
    @endif

    {{-- QUICK ACTIONS --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

        <a href="{{ route('member.profile') }}"
           class="card card-hover p-6 flex items-center gap-4 group">
            <div class="w-14 h-14 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center flex-shrink-0 group-hover:bg-blue-100 transition">
                <i data-lucide="user" class="w-7 h-7"></i>
            </div>
            <div class="flex-1 min-w-0">
                <div class="font-bold text-ink mb-1">Kelola Profil</div>
                <p class="text-sm text-ink-muted">Update nama dan email kamu.</p>
            </div>
            <i data-lucide="arrow-right" class="w-5 h-5 text-ink-soft group-hover:text-blue-600 group-hover:translate-x-1 transition"></i>
        </a>

        <a href="{{ route('member.password') }}"
           class="card card-hover p-6 flex items-center gap-4 group">
            <div class="w-14 h-14 rounded-2xl bg-red-50 text-red-600 flex items-center justify-center flex-shrink-0 group-hover:bg-red-100 transition">
                <i data-lucide="shield-check" class="w-7 h-7"></i>
            </div>
            <div class="flex-1 min-w-0">
                <div class="font-bold text-ink mb-1">Keamanan Akun</div>
                <p class="text-sm text-ink-muted">Ubah password secara berkala.</p>
            </div>
            <i data-lucide="arrow-right" class="w-5 h-5 text-ink-soft group-hover:text-red-600 group-hover:translate-x-1 transition"></i>
        </a>

    </div>

@endsection