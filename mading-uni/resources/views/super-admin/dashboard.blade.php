@extends('layouts.super-admin')

@section('title', 'Dashboard')

@section('content')

    {{-- PAGE HEADER --}}
    <div class="page-header">
        <div>
            <h1>Selamat datang, {{ explode(' ', auth()->user()->name)[0] }}</h1>
            <p>Ringkasan platform Mading Indonesia hari ini.</p>
        </div>
        <div class="flex items-center gap-2">
            <span class="inline-flex items-center gap-2 px-3 py-2 rounded-xl bg-white border border-surface-border text-xs font-medium text-ink-muted">
                <span class="w-1.5 h-1.5 rounded-full bg-success animate-pulse"></span>
                Sistem Online
            </span>
        </div>
    </div>

    {{-- STATS UTAMA --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">

        <div class="stat-card">
            <div class="flex items-start justify-between mb-4">
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-brand-500 to-brand-700 flex items-center justify-center shadow-lg shadow-brand-500/25">
                    <i data-lucide="building-2" class="w-6 h-6 text-white"></i>
                </div>
                <span class="text-xs font-medium text-ink-muted">Total</span>
            </div>
            <div class="text-4xl font-extrabold text-ink tracking-tight mb-1">{{ $stats['universities'] }}</div>
            <div class="text-sm text-ink-muted">Universitas</div>
        </div>

        <div class="stat-card">
            <div class="flex items-start justify-between mb-4">
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-blue-500 to-blue-700 flex items-center justify-center shadow-lg shadow-blue-500/25">
                    <i data-lucide="user-cog" class="w-6 h-6 text-white"></i>
                </div>
                <span class="text-xs font-medium text-ink-muted">Aktif</span>
            </div>
            <div class="text-4xl font-extrabold text-ink tracking-tight mb-1">{{ $stats['admins'] }}</div>
            <div class="text-sm text-ink-muted">Admin Universitas</div>
        </div>

        <div class="stat-card">
            <div class="flex items-start justify-between mb-4">
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-emerald-500 to-green-700 flex items-center justify-center shadow-lg shadow-green-500/25">
                    <i data-lucide="users" class="w-6 h-6 text-white"></i>
                </div>
                <span class="text-xs font-medium text-ink-muted">Terdaftar</span>
            </div>
            <div class="text-4xl font-extrabold text-ink tracking-tight mb-1">{{ $stats['members'] }}</div>
            <div class="text-sm text-ink-muted">Anggota</div>
        </div>

        <div class="stat-card">
            <div class="flex items-start justify-between mb-4">
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-purple-500 to-purple-700 flex items-center justify-center shadow-lg shadow-purple-500/25">
                    <i data-lucide="file-text" class="w-6 h-6 text-white"></i>
                </div>
                <span class="text-xs font-medium text-ink-muted">Semua</span>
            </div>
            <div class="text-4xl font-extrabold text-ink tracking-tight mb-1">{{ $stats['posts_total'] }}</div>
            <div class="text-sm text-ink-muted">Total Konten</div>
        </div>

    </div>

    {{-- STATS KONTEN --}}
    <div class="grid grid-cols-3 gap-4 mb-8">

        <div class="card p-5">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-amber-50 flex items-center justify-center flex-shrink-0">
                    <i data-lucide="clock" class="w-6 h-6 text-amber-600"></i>
                </div>
                <div class="min-w-0">
                    <div class="text-2xl font-bold text-ink">{{ $stats['posts_pending'] }}</div>
                    <div class="text-xs text-ink-muted">Pending Review</div>
                </div>
            </div>
        </div>

        <div class="card p-5">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-green-50 flex items-center justify-center flex-shrink-0">
                    <i data-lucide="check-circle-2" class="w-6 h-6 text-green-600"></i>
                </div>
                <div class="min-w-0">
                    <div class="text-2xl font-bold text-ink">{{ $stats['posts_published'] }}</div>
                    <div class="text-xs text-ink-muted">Published</div>
                </div>
            </div>
        </div>

        <div class="card p-5">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-slate-100 flex items-center justify-center flex-shrink-0">
                    <i data-lucide="file" class="w-6 h-6 text-slate-600"></i>
                </div>
                <div class="min-w-0">
                    <div class="text-2xl font-bold text-ink">{{ $stats['posts_draft'] }}</div>
                    <div class="text-xs text-ink-muted">Draft</div>
                </div>
            </div>
        </div>

    </div>

    {{-- MAIN GRID --}}
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

        {{-- Pending Approvals --}}
        <div class="xl:col-span-2 card overflow-hidden">
            <div class="p-5 border-b border-surface-border flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-amber-50 flex items-center justify-center">
                        <i data-lucide="inbox" class="w-5 h-5 text-amber-600"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-base text-ink">Menunggu Approval</h3>
                        <p class="text-xs text-ink-muted">Konten yang butuh review kamu.</p>
                    </div>
                </div>
                <a href="{{ route('super-admin.approvals.index') }}" class="btn btn-sm btn-outline">
                    Lihat Semua
                </a>
            </div>

            <div class="divide-y divide-surface-border">
                @forelse($pendingPosts as $post)
                    <a href="{{ route('super-admin.approvals.show', $post) }}"
                       class="flex items-center gap-4 p-4 hover:bg-surface-muted/50 transition group">
                        <div class="w-11 h-11 rounded-xl flex items-center justify-center flex-shrink-0 text-white text-sm font-bold shadow-md"
                             style="background: {{ $post->university->primary_color }};">
                            {{ strtoupper(substr($post->university->name, 0, 1)) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="font-semibold text-sm line-clamp-1 group-hover:text-brand-700 transition text-ink mb-1">
                                {{ $post->title }}
                            </div>
                            <div class="flex items-center gap-2 text-xs text-ink-muted">
                                <span class="truncate">{{ $post->university->name }}</span>
                                <span class="w-1 h-1 rounded-full bg-ink-soft"></span>
                                <span class="truncate">{{ $post->category->name }}</span>
                                <span class="w-1 h-1 rounded-full bg-ink-soft"></span>
                                <span class="whitespace-nowrap">{{ $post->submitted_at?->diffForHumans() }}</span>
                            </div>
                        </div>
                        <div class="flex-shrink-0 flex items-center gap-1">
                            <span class="badge badge-yellow">Pending</span>
                            <i data-lucide="chevron-right" class="w-4 h-4 text-ink-soft group-hover:text-brand-700 group-hover:translate-x-0.5 transition"></i>
                        </div>
                    </a>
                @empty
                    <div class="p-12 text-center">
                        <div class="w-14 h-14 rounded-2xl bg-green-50 flex items-center justify-center mx-auto mb-3">
                            <i data-lucide="check-circle-2" class="w-7 h-7 text-green-600"></i>
                        </div>
                        <div class="font-semibold text-ink mb-1">Semua bersih!</div>
                        <p class="text-sm text-ink-muted">Tidak ada konten yang menunggu approval.</p>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Recent Posts --}}
        <div class="card overflow-hidden">
            <div class="p-5 border-b border-surface-border flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-brand-50 flex items-center justify-center">
                    <i data-lucide="sparkles" class="w-5 h-5 text-brand-700"></i>
                </div>
                <div>
                    <h3 class="font-bold text-base text-ink">Konten Terbaru</h3>
                    <p class="text-xs text-ink-muted">Update terakhir platform.</p>
                </div>
            </div>

            <div class="divide-y divide-surface-border">
                @forelse($recentPosts as $post)
                    <a href="{{ route('super-admin.posts.show', $post) }}"
                       class="block p-4 hover:bg-surface-muted/50 transition group">
                        <div class="font-medium text-sm line-clamp-2 group-hover:text-brand-700 transition text-ink mb-2">
                            {{ $post->title }}
                        </div>
                        <div class="flex items-center justify-between gap-2">
                            <div class="text-xs text-ink-muted truncate">{{ $post->university->name }}</div>
                            <span class="badge badge-{{ $post->status->color() }} text-[10px] flex-shrink-0">
                                {{ $post->status->label() }}
                            </span>
                        </div>
                    </a>
                @empty
                    <div class="p-8 text-center text-sm text-ink-muted">Belum ada konten.</div>
                @endforelse
            </div>
        </div>

    </div>

@endsection