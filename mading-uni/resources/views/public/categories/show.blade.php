@extends('layouts.public')

@section('title', $category->name)

@section('content')

    {{-- Header --}}
    <div class="bg-white border-b border-surface-border">
        <div class="max-w-7xl mx-auto px-4 lg:px-8 py-12 lg:py-16">
            <div class="flex items-center gap-4 mb-4">
                <div class="w-14 h-14 rounded-2xl bg-brand-50 text-brand-700 flex items-center justify-center">
                    <i data-lucide="{{ $category->icon ?? 'folder' }}" class="w-7 h-7"></i>
                </div>
                <div>
                    <h1 class="text-3xl lg:text-4xl font-bold text-ink">{{ $category->name }}</h1>
                    <p class="text-ink-muted">{{ $category->description ?? 'Konten dalam kategori ini.' }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Content --}}
    <div class="max-w-7xl mx-auto px-4 lg:px-8 py-12 lg:py-16">
        @if($posts->isEmpty())
            <div class="text-center py-16">
                <h3 class="text-xl font-bold text-ink mb-2">Belum ada konten</h3>
                <p class="text-ink-muted">Kategori ini masih kosong.</p>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($posts as $post)
                    @include('public.partials.post-card', ['post' => $post])
                @endforeach
            </div>
            @if($posts->hasPages())
                <div class="mt-12 flex justify-center">{{ $posts->links() }}</div>
            @endif
        @endif
    </div>

@endsection