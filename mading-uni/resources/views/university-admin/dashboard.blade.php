@extends('layouts.university-admin')

@section('title', 'Dashboard')

@section('content')

    {{-- Welcome Banner --}}
    <div class="relative overflow-hidden rounded-2xl p-6 lg:p-8 mb-6 text-white"
         style="background: linear-gradient(135deg, var(--university-primary) 0%, var(--university-secondary) 100%);">

        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute w-64 h-64 rounded-full -top-16 -right-16 opacity-20 animate-blob"
                 style="background: rgba(255,255,255,0.4); filter: blur(60px);"></div>
            <div class="absolute w-56 h-56 rounded-full -bottom-12 -left-12 opacity-15 animate-blob-delay-2"
                 style="background: rgba(255,255,255,0.3); filter: blur(60px);"></div>
        </div>

        <div class="relative z-10 max-w-2xl">
            <div class="text-sm font-medium text-white/80 mb-1">Selamat datang kembali</div>
            <h1 class="text-2xl lg:text-3xl font-bold mb-2">{{ auth()->user()->name }}</h1>
            <p class="text-white/85 text-sm lg:text-base mb-5">
                Kelola konten {{ $theme->name }} dari satu tempat.
            </p>

            <a href="{{ route('university-admin.posts.create') }}"
               class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-white text-sm font-semibold hover:bg-white/90 transition shadow-lg"
               style="color: var(--university-primary);">
                <i data-lucide="plus" class="w-4 h-4"></i>
                Buat Konten Baru
            </a>
        </div>
    </div>

    {{-- STATS --}}
    <div class="grid grid-cols-2 lg:grid-cols-5 gap-4 mb-6">

        <div class="card p-5">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 rounded-xl bg-slate-100 text-slate-600 flex items-center justify-center">
                    <i data-lucide="file-text" class="w-5 h-5"></i>
                </div>
                <span class="text-xs text-ink-muted font-medium">Total</span>
            </div>
            <div class="text-3xl font-extrabold text-ink mb-1">{{ $stats['total'] }}</div>
            <div class="text-xs text-ink-muted">Semua Konten</div>
        </div>

        <div class="card p-5">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 rounded-xl bg-gray-100 text-gray-600 flex items-center justify-center">
                    <i data-lucide="file" class="w-5 h-5"></i>
                </div>
            </div>
            <div class="text-3xl font-extrabold text-ink mb-1">{{ $stats['draft'] }}</div>
            <div class="text-xs text-ink-muted">Draft</div>
        </div>

        <div class="card p-5">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center">
                    <i data-lucide="clock" class="w-5 h-5"></i>
                </div>
            </div>
            <div class="text-3xl font-extrabold text-ink mb-1">{{ $stats['pending'] }}</div>
            <div class="text-xs text-ink-muted">Pending</div>
        </div>

        <div class="card p-5">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 rounded-xl bg-green-50 text-green-600 flex items-center justify-center">
                    <i data-lucide="check-circle-2" class="w-5 h-5"></i>
                </div>
            </div>
            <div class="text-3xl font-extrabold text-ink mb-1">{{ $stats['published'] }}</div>
            <div class="text-xs text-ink-muted">Published</div>
        </div>

        <div class="card p-5">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 rounded-xl bg-red-50 text-red-600 flex items-center justify-center">
                    <i data-lucide="x-circle" class="w-5 h-5"></i>
                </div>
            </div>
            <div class="text-3xl font-extrabold text-ink mb-1">{{ $stats['rejected'] }}</div>
            <div class="text-xs text-ink-muted">Ditolak</div>
        </div>

    </div>

    {{-- MAIN GRID --}}
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

        {{-- Recent Posts --}}
        <div class="xl:col-span-2 card overflow-hidden">
            <div class="p-5 border-b border-surface-border flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center"
                         style="background: color-mix(in srgb, var(--university-primary) 10%, transparent); color: var(--university-primary);">
                        <i data-lucide="file-text" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-base text-ink">Konten Terbaru</h3>
                        <p class="text-xs text-ink-muted">Update terakhir universitas kamu.</p>
                    </div>
                </div>
                <a href="{{ route('university-admin.posts.index') }}" class="btn btn-sm btn-outline">
                    Lihat Semua
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="table-modern">
                    <thead>
                        <tr>
                            <th>Judul</th>
                            <th>Kategori</th>
                            <th>Status</th>
                            <th class="text-right">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentPosts as $post)
                            <tr>
                                <td>
                                    <a href="{{ route('university-admin.posts.show', $post) }}" class="font-medium text-ink hover:text-brand-700 line-clamp-1 transition">
                                        {{ $post->title }}
                                    </a>
                                </td>
                                <td class="text-sm text-ink-muted">{{ $post->category->name }}</td>
                                <td><span class="badge badge-{{ $post->status->color() }}">{{ $post->status->label() }}</span></td>
                                <td class="text-right text-sm text-ink-muted">{{ $post->created_at->format('d M Y') }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-center py-8 text-ink-muted">Belum ada konten.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Rejected Posts --}}
        <div class="card overflow-hidden">
            <div class="p-5 border-b border-surface-border flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-red-50 text-red-600 flex items-center justify-center">
                    <i data-lucide="alert-circle" class="w-5 h-5"></i>
                </div>
                <div>
                    <h3 class="font-bold text-base text-ink">Perlu Revisi</h3>
                    <p class="text-xs text-ink-muted">Konten yang ditolak.</p>
                </div>
            </div>

            <div class="divide-y divide-surface-border">
                @forelse($rejectedPosts as $post)
                    <a href="{{ route('university-admin.posts.show', $post) }}"
                       class="block p-4 hover:bg-red-50/50 transition group">
                        <div class="font-medium text-sm line-clamp-2 group-hover:text-danger transition text-ink mb-1.5">
                            {{ $post->title }}
                        </div>
                        @if($post->reviews->first())
                            <p class="text-xs text-red-700 bg-red-50 p-2 rounded-lg mt-2 line-clamp-2">
                                <strong>Alasan:</strong> {{ $post->reviews->first()->note }}
                            </p>
                        @endif
                    </a>
                @empty
                    <div class="p-8 text-center">
                        <div class="w-12 h-12 rounded-xl bg-green-50 text-green-600 flex items-center justify-center mx-auto mb-2">
                            <i data-lucide="check-circle-2" class="w-6 h-6"></i>
                        </div>
                        <p class="text-sm text-ink-muted">Tidak ada konten yang ditolak.</p>
                    </div>
                @endforelse
            </div>
        </div>

    </div>

@endsection