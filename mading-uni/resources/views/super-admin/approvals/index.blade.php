@extends('layouts.super-admin')

@section('title', 'Approval Konten')

@section('content')

    <div class="page-header">
        <div>
            <h1>Approval Konten</h1>
            <p>Review konten yang diajukan admin universitas.</p>
        </div>
        @if($posts->total() > 0)
            <span class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-amber-50 border border-amber-200 text-sm font-semibold text-amber-800">
                <i data-lucide="clock" class="w-4 h-4"></i>
                {{ $posts->total() }} menunggu review
            </span>
        @endif
    </div>

    @if($posts->isEmpty())
        <div class="card p-16 text-center">
            <div class="w-20 h-20 rounded-3xl bg-green-50 flex items-center justify-center mx-auto mb-5">
                <i data-lucide="check-circle-2" class="w-10 h-10 text-green-600"></i>
            </div>
            <h3 class="font-bold text-xl mb-2 text-ink">Semua bersih!</h3>
            <p class="text-ink-muted mb-6">Tidak ada konten yang menunggu approval saat ini.</p>
            <a href="{{ route('super-admin.dashboard') }}" class="btn btn-outline">
                <i data-lucide="arrow-left" class="w-4 h-4"></i>
                Kembali ke Dashboard
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
            @foreach($posts as $post)
                <div class="card overflow-hidden flex flex-col">
                    @if($post->cover_image_path)
                        <div class="aspect-[16/7] bg-brand-50 overflow-hidden">
                            <img src="{{ $post->cover_url }}" alt="" class="w-full h-full object-cover">
                        </div>
                    @else
                        <div class="aspect-[16/7] flex items-center justify-center"
                             style="background: linear-gradient(135deg, {{ $post->university->primary_color }} 0%, {{ $post->university->secondary_color }} 100%);">
                            <i data-lucide="file-text" class="w-12 h-12 text-white/60"></i>
                        </div>
                    @endif

                    <div class="p-5 flex-1 flex flex-col">
                        <div class="flex items-center gap-2 mb-3 flex-wrap">
                            <div class="flex items-center gap-2">
                                <div class="w-6 h-6 rounded-lg flex items-center justify-center text-white text-[10px] font-bold"
                                     style="background: {{ $post->university->primary_color }};">
                                    {{ strtoupper(substr($post->university->name, 0, 1)) }}
                                </div>
                                <span class="text-xs font-medium text-ink">{{ $post->university->name }}</span>
                            </div>
                            <span class="w-1 h-1 rounded-full bg-ink-soft"></span>
                            <span class="badge badge-brand text-[10px]">{{ $post->category->name }}</span>
                        </div>

                        <h3 class="font-bold text-lg text-ink line-clamp-2 mb-2">{{ $post->title }}</h3>

                        @if($post->excerpt)
                            <p class="text-sm text-ink-muted leading-relaxed line-clamp-2 mb-4">{{ $post->excerpt }}</p>
                        @endif

                        <div class="mt-auto pt-4 border-t border-surface-border flex items-center justify-between text-xs text-ink-muted mb-4">
                            <div class="flex items-center gap-1.5">
                                <i data-lucide="user" class="w-3.5 h-3.5"></i>
                                {{ $post->author->name }}
                            </div>
                            <div class="flex items-center gap-1.5">
                                <i data-lucide="clock" class="w-3.5 h-3.5"></i>
                                {{ $post->submitted_at?->diffForHumans() }}
                            </div>
                        </div>

                        <div class="flex items-center gap-2">
                            <a href="{{ route('super-admin.approvals.show', $post) }}" class="btn btn-sm btn-outline flex-1">
                                <i data-lucide="eye" class="w-3.5 h-3.5"></i>
                                Review
                            </a>
                            <form method="POST" action="{{ route('super-admin.approvals.approve', $post) }}" class="flex-1">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-primary w-full">
                                    <i data-lucide="check" class="w-3.5 h-3.5"></i>
                                    Approve
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        @if($posts->hasPages())
            <div class="mt-8 flex justify-center">{{ $posts->links() }}</div>
        @endif
    @endif

@endsection