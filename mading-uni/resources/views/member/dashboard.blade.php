@extends('layouts.member')

@section('title', 'Dashboard')
@section('subtitle', 'Selamat datang kembali, ' . auth()->user()->name)

@section('content')

    {{-- Welcome Banner --}}
    <div class="relative overflow-hidden rounded-2xl p-6 lg:p-8 mb-6 bg-brand-gradient text-white">
        <div class="absolute inset-0 pointer-events-none">
            <div class="blob blob-brand w-80 h-80 -top-20 -right-20 opacity-40 animate-blob"></div>
            <div class="blob blob-brand w-60 h-60 -bottom-16 -left-16 opacity-30 animate-blob-delay-2"></div>
        </div>

        <div class="relative z-10 max-w-2xl">
            <div class="text-sm font-medium text-white/80 mb-1">Halo, {{ auth()->user()->name }} 👋</div>
            <h2 class="text-2xl lg:text-3xl font-bold mb-2">Selamat datang di Panel Anggota</h2>
            <p class="text-white/85 text-sm lg:text-base">
                Kelola favorit kamu dan temukan informasi menarik dari kampus-kampus Indonesia.
            </p>
        </div>
    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">

        <div class="card p-5">
            <div class="flex items-center justify-between mb-3">
                <div class="w-11 h-11 rounded-xl bg-brand-50 text-brand-700 flex items-center justify-center">
                    <i data-lucide="bookmark" class="w-5 h-5"></i>
                </div>
                <span class="text-xs font-medium text-ink-muted">Favorit</span>
            </div>
            <div class="text-3xl font-bold text-ink mb-1">{{ $stats['bookmarks'] }}</div>
            <div class="text-sm text-ink-muted">Konten tersimpan</div>
        </div>

        <div class="card p-5">
            <div class="flex items-center justify-between mb-3">
                <div class="w-11 h-11 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                    <i data-lucide="calendar" class="w-5 h-5"></i>
                </div>
                <span class="text-xs font-medium text-ink-muted">Bergabung</span>
            </div>
            <div class="text-3xl font-bold text-ink mb-1">{{ auth()->user()->created_at->format('M Y') }}</div>
            <div class="text-sm text-ink-muted">{{ auth()->user()->created_at->diffForHumans() }}</div>
        </div>

        <div class="card p-5">
            <div class="flex items-center justify-between mb-3">
                <div class="w-11 h-11 rounded-xl bg-green-50 text-green-600 flex items-center justify-center">
                    <i data-lucide="building-2" class="w-5 h-5"></i>
                </div>
                <span class="text-xs font-medium text-ink-muted">Kampus</span>
            </div>
            <div class="text-3xl font-bold text-ink mb-1">{{ $suggestedPosts->count() }}</div>
            <div class="text-sm text-ink-muted">Update terbaru</div>
        </div>

    </div>

    {{-- Recent Bookmarks --}}
    @if($recentBookmarks->isNotEmpty())
        <div class="card p-6 mb-6">
            <div class="flex items-center justify-between mb-5">
                <div>
                    <h3 class="font-bold text-lg text-ink">Favorit Terbaru</h3>
                    <p class="text-sm text-ink-muted">Konten yang kamu simpan.</p>
                </div>
                <a href="{{ route('member.bookmarks') }}" class="link-arrow">
                    Lihat semua
                    <i data-lucide="arrow-right" class="w-4 h-4"></i>
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($recentBookmarks as $post)
                    @if($post)
                        @include('public.partials.post-card', ['post' => $post])
                    @endif
                @endforeach
            </div>
        </div>
    @else
        <div class="card p-12 mb-6 text-center">
            <div class="w-16 h-16 rounded-2xl bg-brand-50 text-brand-700 flex items-center justify-center mx-auto mb-4">
                <i data-lucide="bookmark" class="w-8 h-8"></i>
            </div>
            <h3 class="font-bold text-lg mb-2 text-ink">Belum ada favorit</h3>
            <p class="text-ink-muted text-sm mb-6 max-w-md mx-auto">
                Mulai jelajahi konten dari kampus-kampus Indonesia dan simpan yang kamu suka.
            </p>
            <a href="{{ route('public.universities.index') }}" class="btn btn-primary">
                <i data-lucide="compass" class="w-4 h-4"></i>
                Jelajahi Universitas
            </a>
        </div>
    @endif

    {{-- Suggested Posts --}}
    @if($suggestedPosts->isNotEmpty())
        <div class="card p-6">
            <div class="flex items-center justify-between mb-5">
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

@endsection