@extends('layouts.public')

@section('title', $post->title)
@section('description', $post->excerpt)

@section('content')

    {{-- Breadcrumb --}}
    <div class="border-b border-surface-border bg-white">
        <div class="max-w-4xl mx-auto px-4 lg:px-8 py-3">
            <div class="flex items-center gap-2 text-sm text-ink-muted overflow-x-auto">
                <a href="{{ route('public.home') }}" class="hover:text-brand-700">Beranda</a>
                <i data-lucide="chevron-right" class="w-3.5 h-3.5 flex-shrink-0"></i>
                <a href="{{ route('public.universities.show', $university) }}" class="hover:text-brand-700 whitespace-nowrap">
                    {{ $university->name }}
                </a>
                <i data-lucide="chevron-right" class="w-3.5 h-3.5 flex-shrink-0"></i>
                <span class="text-ink font-medium truncate">{{ Str::limit($post->title, 40) }}</span>
            </div>
        </div>
    </div>

    {{-- Article --}}
    <article class="max-w-4xl mx-auto px-4 lg:px-8 py-10 lg:py-16">

        {{-- Meta --}}
        <div class="flex items-center gap-2 mb-4 flex-wrap">
            <span class="badge" style="background: {{ $university->primary_color }}20; color: {{ $university->primary_color }};">
                {{ $post->category->name }}
            </span>
            <span class="text-sm text-ink-muted">
                {{ $post->published_at?->format('d M Y') }}
            </span>
        </div>

        {{-- Title --}}
        <h1 class="text-3xl lg:text-5xl font-extrabold text-ink leading-tight mb-6">
            {{ $post->title }}
        </h1>

        {{-- Author --}}
        <div class="flex items-center gap-3 pb-6 mb-6 border-b border-surface-border">
            <div class="w-10 h-10 rounded-full flex items-center justify-center text-white font-bold"
                 style="background: {{ $university->primary_color }};">
                {{ strtoupper(substr($university->name, 0, 1)) }}
            </div>
            <div>
                <div class="font-medium text-ink">{{ $university->name }}</div>
                <div class="text-xs text-ink-muted">Oleh {{ $post->author->name }}</div>
            </div>

            {{-- Bookmark --}}
            @auth
                @if(auth()->user()->isMember())
                    @php
                        $isBookmarked = auth()->user()->bookmarks()->where('post_id', $post->id)->exists();
                    @endphp
                    <form method="POST" action="{{ route('public.bookmarks.toggle', $post) }}" class="ml-auto">
                        @csrf
                        <button type="submit"
                                class="flex items-center gap-2 px-3 py-2 rounded-xl border border-surface-border hover:border-brand-300 hover:bg-brand-50 transition text-sm"
                                style="{{ $isBookmarked ? 'color: var(--brand-700); border-color: var(--brand-300); background: var(--brand-50);' : 'color: var(--ink-muted);' }}">
                            <i data-lucide="{{ $isBookmarked ? 'bookmark-check' : 'bookmark' }}" class="w-4 h-4"></i>
                            {{ $isBookmarked ? 'Tersimpan' : 'Simpan' }}
                        </button>
                    </form>
                @endif
            @endauth
        </div>

        {{-- Cover --}}
        @if($post->cover_image_path)
            <div class="aspect-video rounded-2xl overflow-hidden mb-8 bg-brand-50">
                <img src="{{ $post->cover_url }}" alt="{{ $post->title }}" class="w-full h-full object-cover">
            </div>
        @endif

        {{-- Event Info --}}
        @if($post->event_start)
            <div class="flex flex-wrap gap-4 p-5 rounded-2xl mb-8 border"
                 style="background: {{ $university->primary_color }}10; border-color: {{ $university->primary_color }}30;">
                <div class="flex items-center gap-2 text-sm">
                    <i data-lucide="calendar" class="w-4 h-4" style="color: {{ $university->primary_color }};"></i>
                    <span class="font-medium text-ink">{{ $post->event_start->format('d M Y H:i') }}</span>
                </div>
                @if($post->location)
                    <div class="flex items-center gap-2 text-sm">
                        <i data-lucide="map-pin" class="w-4 h-4" style="color: {{ $university->primary_color }};"></i>
                        <span class="font-medium text-ink">{{ $post->location }}</span>
                    </div>
                @endif
            </div>
        @endif

        {{-- Body --}}
        <div class="prose-content text-lg leading-relaxed">
            {!! nl2br(e($post->body)) !!}
        </div>

        {{-- Back --}}
        <div class="mt-12 pt-6 border-t border-surface-border">
            <a href="{{ route('public.universities.show', $university) }}" class="link-arrow">
                <i data-lucide="arrow-left" class="w-4 h-4"></i>
                Kembali ke {{ $university->name }}
            </a>
        </div>

    </article>

    {{-- Related --}}
    @if($relatedPosts->isNotEmpty())
        <section class="bg-white border-t border-surface-border">
            <div class="max-w-7xl mx-auto px-4 lg:px-8 py-12 lg:py-16">
                <h2 class="text-2xl font-bold text-ink mb-6">Konten Serupa</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($relatedPosts as $related)
                        @include('public.partials.post-card', ['post' => $related])
                    @endforeach
                </div>
            </div>
        </section>
    @endif

@endsection