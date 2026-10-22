@extends('layouts.public')

@section('title', $university->name)

@section('content')

    {{-- HERO dengan warna universitas --}}
    <div class="relative overflow-hidden text-white"
         style="background: linear-gradient(135deg, {{ $university->primary_color }} 0%, {{ $university->secondary_color }} 100%);">

        <div class="absolute inset-0 pointer-events-none">
            <div class="blob blob-brand w-[400px] h-[400px] -top-32 -right-32 opacity-25 animate-blob"></div>
            <div class="blob blob-brand w-[300px] h-[300px] -bottom-20 -left-20 opacity-20 animate-blob-delay-2"></div>
        </div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 lg:px-8 py-16 lg:py-24">
            <div class="flex flex-col lg:flex-row items-start gap-6 lg:gap-10">

                {{-- Logo --}}
                <div class="w-24 h-24 lg:w-32 lg:h-32 rounded-3xl bg-white/20 backdrop-blur flex items-center justify-center flex-shrink-0">
                    @if($university->logo_path)
                        <img src="{{ $university->logo_url }}" alt="{{ $university->name }}" class="w-full h-full object-contain p-3">
                    @else
                        <i data-lucide="building-2" class="w-12 h-12"></i>
                    @endif
                </div>

                {{-- Info --}}
                <div class="flex-1 min-w-0">
                    <h1 class="text-3xl lg:text-5xl font-extrabold mb-3">{{ $university->name }}</h1>
                    <p class="text-white/85 text-lg max-w-2xl leading-relaxed mb-6">
                        {{ $university->description ?? 'Universitas terkemuka di Indonesia.' }}
                    </p>

                    <div class="flex flex-wrap gap-4 text-sm">
                        @if($university->city)
                            <div class="flex items-center gap-2">
                                <i data-lucide="map-pin" class="w-4 h-4"></i>
                                {{ $university->city }}
                            </div>
                        @endif
                        @if($university->website)
                            <a href="{{ $university->website }}" target="_blank" class="flex items-center gap-2 hover:underline">
                                <i data-lucide="globe" class="w-4 h-4"></i>
                                Website
                            </a>
                        @endif
                        <div class="flex items-center gap-2">
                            <i data-lucide="file-text" class="w-4 h-4"></i>
                            {{ $university->published_posts_count }} konten
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- Kategori Pills --}}
    @if($categories->isNotEmpty())
        <div class="border-b border-surface-border bg-white">
            <div class="max-w-7xl mx-auto px-4 lg:px-8">
                <div class="flex gap-2 overflow-x-auto py-4">
                    <a href="{{ route('public.universities.show', $university) }}"
                       class="px-4 py-2 rounded-xl text-sm font-medium whitespace-nowrap transition
                              {{ !request('category') ? 'text-white shadow-md' : 'bg-surface-muted text-ink-muted hover:bg-surface-border' }}"
                       @if(!request('category')) style="background: {{ $university->primary_color }};" @endif>
                        Semua
                    </a>
                    @foreach($categories as $cat)
                        <a href="{{ route('public.universities.show', [$university, 'category' => $cat->slug]) }}"
                           class="px-4 py-2 rounded-xl text-sm font-medium whitespace-nowrap transition
                                  {{ request('category') == $cat->slug ? 'text-white shadow-md' : 'bg-surface-muted text-ink-muted hover:bg-surface-border' }}"
                           @if(request('category') == $cat->slug) style="background: {{ $university->primary_color }};" @endif>
                            {{ $cat->name }}
                            <span class="ml-1 text-xs opacity-75">({{ $cat->published_posts_count }})</span>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    {{-- Posts --}}
    <div class="max-w-7xl mx-auto px-4 lg:px-8 py-12 lg:py-16">
        @if($posts->isEmpty())
            <div class="text-center py-20">
                <div class="w-20 h-20 rounded-3xl bg-surface-muted flex items-center justify-center mx-auto mb-4">
                    <i data-lucide="file-text" class="w-10 h-10 text-ink-muted"></i>
                </div>
                <h3 class="text-xl font-bold text-ink mb-2">Belum ada konten</h3>
                <p class="text-ink-muted">Universitas ini belum mempublikasikan konten.</p>
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