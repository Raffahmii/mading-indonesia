@extends('layouts.university-admin')

@section('title', $post->title)

@section('content')

    <div class="max-w-4xl">
        <a href="{{ route('university-admin.posts.index') }}" class="inline-flex items-center gap-1.5 text-sm text-ink-muted hover:text-ink mb-4">
            <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali
        </a>

        <div class="card overflow-hidden mb-6">
            @if($post->cover_image_path)
                <div class="aspect-video bg-brand-50 overflow-hidden">
                    <img src="{{ $post->cover_url }}" alt="" class="w-full h-full object-cover">
                </div>
            @endif

            <div class="p-6 lg:p-8">
                <div class="flex items-center gap-3 mb-4 flex-wrap">
                    <span class="badge badge-{{ $post->status->color() }}">{{ $post->status->label() }}</span>
                    <span class="badge badge-brand">{{ $post->category->name }}</span>
                </div>

                <h1 class="text-2xl lg:text-3xl font-bold text-ink mb-4">{{ $post->title }}</h1>

                @if($post->excerpt)
                    <p class="text-ink-muted leading-relaxed italic mb-6 pb-6 border-b border-surface-border">{{ $post->excerpt }}</p>
                @endif

                <div class="prose-content">
                    {!! nl2br(e($post->body)) !!}
                </div>
            </div>
        </div>

        {{-- Action Panel --}}
        <div class="card p-6">
            <h3 class="font-bold text-lg mb-4 text-ink">Aksi</h3>

            <div class="flex flex-wrap gap-2">
                @if($post->status->isEditable())
                    <a href="{{ route('university-admin.posts.edit', $post) }}" class="btn btn-outline">
                        <i data-lucide="pencil" class="w-4 h-4"></i> Edit
                    </a>
                @endif

                @if($post->status->canBeSubmitted())
                    <form method="POST" action="{{ route('university-admin.posts.submit', $post) }}" class="inline">
                        @csrf
                        <button type="submit" class="btn btn-univ">
                            <i data-lucide="send" class="w-4 h-4"></i> Ajukan untuk Review
                        </button>
                    </form>
                @endif

                @if($post->status->value === 'published')
                    <a href="{{ route('public.posts.show', [$post->university, $post]) }}" target="_blank" class="btn btn-outline">
                        <i data-lucide="external-link" class="w-4 h-4"></i> Lihat Publik
                    </a>
                @endif

                @if($post->status->isEditable())
                    <form method="POST" action="{{ route('university-admin.posts.destroy', $post) }}" onsubmit="return confirm('Hapus konten ini?')" class="ml-auto">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-ghost text-danger hover:bg-red-50">
                            <i data-lucide="trash-2" class="w-4 h-4"></i> Hapus
                        </button>
                    </form>
                @endif
            </div>
        </div>

        {{-- Review History --}}
        @if($post->reviews->isNotEmpty())
            <div class="card p-6 mt-6">
                <h3 class="font-bold text-lg mb-4 text-ink">Riwayat Review</h3>
                <div class="space-y-3">
                    @foreach($post->reviews as $review)
                        <div class="flex gap-3 p-3 rounded-xl bg-surface-muted">
                            <div class="w-8 h-8 rounded-full bg-white flex items-center justify-center flex-shrink-0">
                                <i data-lucide="{{ $review->action->icon() }}" class="w-4 h-4"></i>
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center gap-2 flex-wrap mb-1">
                                    <span class="font-medium text-sm text-ink">{{ $review->actor->name }}</span>
                                    <span class="badge badge-{{ $review->action->color() }} text-xs">{{ $review->action->label() }}</span>
                                    <span class="text-xs text-ink-muted">{{ $review->created_at->diffForHumans() }}</span>
                                </div>
                                @if($review->note)
                                    <p class="text-sm text-ink-muted mt-1">{{ $review->note }}</p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

@endsection