@extends('layouts.super-admin')

@section('title', 'Dashboard')

@section('content')

    {{-- Welcome Banner --}}
    <div class="relative overflow-hidden rounded-2xl p-6 lg:p-8 mb-6 bg-brand-gradient text-white">
        <div class="absolute inset-0 pointer-events-none">
            <div class="blob blob-brand w-80 h-80 -top-20 -right-20 opacity-40 animate-blob"></div>
            <div class="blob blob-brand w-60 h-60 -bottom-16 -left-16 opacity-30 animate-blob-delay-2"></div>
        </div>

        <div class="relative z-10 max-w-2xl">
            <div class="text-sm font-medium text-white/80 mb-1">Selamat datang kembali</div>
            <h2 class="text-2xl lg:text-3xl font-bold mb-2">{{ auth()->user()->name }}</h2>
            <p class="text-white/85 text-sm lg:text-base">
                Kelola platform Mading Indonesia dari satu tempat.
            </p>
        </div>
    </div>

    {{-- STATS GRID --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">

        <div class="card p-5">
            <div class="flex items-center justify-between mb-3">
                <div class="w-11 h-11 rounded-xl bg-brand-50 text-brand-700 flex items-center justify-center">
                    <i data-lucide="building-2" class="w-5 h-5"></i>
                </div>
            </div>
            <div class="text-3xl font-bold text-ink mb-1">{{ $stats['universities'] }}</div>
            <div class="text-sm text-ink-muted">Universitas</div>
        </div>

        <div class="card p-5">
            <div class="flex items-center justify-between mb-3">
                <div class="w-11 h-11 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                    <i data-lucide="user-cog" class="w-5 h-5"></i>
                </div>
            </div>
            <div class="text-3xl font-bold text-ink mb-1">{{ $stats['admins'] }}</div>
            <div class="text-sm text-ink-muted">Admin Universitas</div>
        </div>

        <div class="card p-5">
            <div class="flex items-center justify-between mb-3">
                <div class="w-11 h-11 rounded-xl bg-green-50 text-green-600 flex items-center justify-center">
                    <i data-lucide="users" class="w-5 h-5"></i>
                </div>
            </div>
            <div class="text-3xl font-bold text-ink mb-1">{{ $stats['members'] }}</div>
            <div class="text-sm text-ink-muted">Anggota</div>
        </div>

        <div class="card p-5">
            <div class="flex items-center justify-between mb-3">
                <div class="w-11 h-11 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center">
                    <i data-lucide="file-text" class="w-5 h-5"></i>
                </div>
            </div>
            <div class="text-3xl font-bold text-ink mb-1">{{ $stats['posts_total'] }}</div>
            <div class="text-sm text-ink-muted">Total Konten</div>
        </div>

    </div>

    {{-- STATS KONTEN --}}
    <div class="grid grid-cols-3 gap-4 mb-6">

        <div class="card p-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-yellow-50 text-yellow-600 flex items-center justify-center flex-shrink-0">
                <i data-lucide="clock" class="w-6 h-6"></i>
            </div>
            <div>
                <div class="text-2xl font-bold text-ink">{{ $stats['posts_pending'] }}</div>
                <div class="text-sm text-ink-muted">Pending Review</div>
            </div>
        </div>

        <div class="card p-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-green-50 text-green-600 flex items-center justify-center flex-shrink-0">
                <i data-lucide="check-circle-2" class="w-6 h-6"></i>
            </div>
            <div>
                <div class="text-2xl font-bold text-ink">{{ $stats['posts_published'] }}</div>
                <div class="text-sm text-ink-muted">Published</div>
            </div>
        </div>

        <div class="card p-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-gray-100 text-gray-600 flex items-center justify-center flex-shrink-0">
                <i data-lucide="file" class="w-6 h-6"></i>
            </div>
            <div>
                <div class="text-2xl font-bold text-ink">{{ $stats['posts_draft'] }}</div>
                <div class="text-sm text-ink-muted">Draft</div>
            </div>
        </div>

    </div>

    {{-- MAIN GRID --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Pending Approval --}}
        <div class="lg:col-span-2 card">
            <div class="p-5 border-b border-surface-border flex items-center justify-between">
                <div>
                    <h3 class="font-bold text-lg text-ink">Menunggu Approval</h3>
                    <p class="text-sm text-ink-muted">Konten yang butuh review.</p>
                </div>
                <a href="{{ route('super-admin.approvals.index') }}" class="link-arrow">
                    Lihat semua
                    <i data-lucide="arrow-right" class="w-4 h-4"></i>
                </a>
            </div>

            <div class="divide-y divide-surface-border">
                @forelse($pendingPosts as $post)
                    <a href="{{ route('super-admin.approvals.show', $post) }}"
                       class="flex items-center gap-4 p-4 hover:bg-surface-muted transition group">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0 text-white text-sm font-bold"
                             style="background: {{ $post->university->primary_color }};">
                            {{ strtoupper(substr($post->university->name, 0, 1)) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="font-medium text-sm line-clamp-1 group-hover:text-brand-700 transition text-ink">
                                {{ $post->title }}
                            </div>
                            <div class="flex items-center gap-2 text-xs text-ink-muted mt-0.5">
                                <span>{{ $post->university->name }}</span>
                                <span>•</span>
                                <span>{{ $post->category->name }}</span>
                                <span>•</span>
                                <span>{{ $post->submitted_at?->diffForHumans() }}</span>
                            </div>
                        </div>
                        <span class="badge badge-yellow flex-shrink-0">Pending</span>
                    </a>
                @empty
                    <div class="p-8 text-center">
                        <div class="w-12 h-12 rounded-xl bg-green-50 text-green-600 flex items-center justify-center mx-auto mb-3">
                            <i data-lucide="check-circle-2" class="w-6 h-6"></i>
                        </div>
                        <p class="text-sm text-ink-muted">Tidak ada konten menunggu approval.</p>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Recent Posts --}}
        <div class="card">
            <div class="p-5 border-b border-surface-border">
                <h3 class="font-bold text-lg text-ink">Konten Terbaru</h3>
                <p class="text-sm text-ink-muted">Update terkini platform.</p>
            </div>

            <div class="divide-y divide-surface-border">
                @foreach($recentPosts as $post)
                    <a href="{{ route('super-admin.posts.show', $post) }}"
                       class="block p-4 hover:bg-surface-muted transition group">
                        <div class="font-medium text-sm line-clamp-2 group-hover:text-brand-700 transition text-ink mb-1.5">
                            {{ $post->title }}
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="text-xs text-ink-muted truncate">{{ $post->university->name }}</div>
                            <span class="badge badge-{{ $post->status->color() }} text-xs flex-shrink-0">
                                {{ $post->status->label() }}
                            </span>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>

    </div>

@endsection 