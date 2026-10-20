@extends('layouts.super-admin')

@section('title', 'Approval Konten')

@section('content')

    <div class="mb-5">
        <h2 class="text-xl font-bold text-ink mb-1">Approval Konten</h2>
        <p class="text-ink-muted text-sm">Review konten yang diajukan admin universitas.</p>
    </div>

    @if($posts->isEmpty())
        <div class="card p-12 text-center">
            <div class="w-16 h-16 rounded-2xl bg-green-50 text-green-600 flex items-center justify-center mx-auto mb-4">
                <i data-lucide="check-circle-2" class="w-8 h-8"></i>
            </div>
            <h3 class="font-bold text-lg mb-2 text-ink">Tidak ada konten menunggu</h3>
            <p class="text-ink-muted text-sm">Semua konten sudah direview.</p>
        </div>
    @else
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
            @foreach($posts as $post)
                <div class="card p-5">
                    <div class="flex items-start gap-4 mb-4">
                        <div class="w-11 h-11 rounded-xl flex items-center justify-center text-white font-bold flex-shrink-0"
                             style="background: {{ $post->university->primary_color }};">
                            {{ strtoupper(substr($post->university->name, 0, 1)) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="text-xs font-medium mb-1" style="color: {{ $post->university->primary_color }};">
                                {{ $post->university->name }}
                            </div>
                            <h3 class="font-bold text-ink line-clamp-2 mb-1">{{ $post->title }}</h3>
                            <div class="text-xs text-ink-muted flex items-center gap-2 flex-wrap">
                                <span class="badge badge-brand">{{ $post->category->name }}</span>
                                <span>•</span>
                                <span>{{ $post->submitted_at?->diffForHumans() }}</span>
                            </div>
                        </div>
                    </div>

                    @if($post->excerpt)
                        <p class="text-sm text-ink-muted leading-relaxed line-clamp-3 mb-4">
                            {{ $post->excerpt }}
                        </p>
                    @endif

                    <div class="flex items-center gap-2 pt-4 border-t border-surface-border">
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
            @endforeach
        </div>

        @if($posts->hasPages())
            <div class="mt-6 flex justify-center">
                {{ $posts->links() }}
            </div>
        @endif
    @endif

@endsection