@extends('layouts.public')

@section('title', 'Cari')

@section('content')

    <div class="max-w-7xl mx-auto px-4 lg:px-8 py-10 lg:py-16">

        <h1 class="text-3xl lg:text-4xl font-bold text-ink mb-6">Cari Konten</h1>

        {{-- Search Form --}}
        <form method="GET" class="card p-4 mb-8">
            <div class="flex gap-3">
                <div class="relative flex-1">
                    <i data-lucide="search" class="w-4 h-4 text-ink-soft absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                    <input type="text" name="q" value="{{ $q }}" placeholder="Cari universitas, event, lomba, beasiswa..." class="input pl-10">
                </div>
                <button type="submit" class="btn btn-primary">Cari</button>
            </div>
        </form>

        @if($q)
            {{-- Hasil Universitas --}}
            @if($universities->isNotEmpty())
                <div class="mb-10">
                    <h2 class="text-xl font-bold text-ink mb-4 flex items-center gap-2">
                        <i data-lucide="building-2" class="w-5 h-5 text-brand-700"></i>
                        Universitas
                    </h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                        @foreach($universities as $university)
                            @include('public.partials.university-card', ['university' => $university])
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Hasil Konten --}}
            @if($posts->isNotEmpty())
                <div>
                    <h2 class="text-xl font-bold text-ink mb-4 flex items-center gap-2">
                        <i data-lucide="file-text" class="w-5 h-5 text-brand-700"></i>
                        Konten
                    </h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($posts as $post)
                            @include('public.partials.post-card', ['post' => $post])
                        @endforeach
                    </div>
                    @if($posts->hasPages())
                        <div class="mt-8 flex justify-center">{{ $posts->links() }}</div>
                    @endif
                </div>
            @endif

            {{-- Tidak ada hasil --}}
            @if($universities->isEmpty() && $posts->isEmpty())
                <div class="text-center py-16">
                    <div class="w-16 h-16 rounded-2xl bg-surface-muted flex items-center justify-center mx-auto mb-4">
                        <i data-lucide="search-x" class="w-8 h-8 text-ink-muted"></i>
                    </div>
                    <h3 class="text-xl font-bold text-ink mb-2">Tidak ada hasil</h3>
                    <p class="text-ink-muted">Coba kata kunci lain.</p>
                </div>
            @endif
        @else
            <div class="text-center py-16 text-ink-muted">
                <i data-lucide="search" class="w-12 h-12 mx-auto mb-3 opacity-30"></i>
                <p>Masukkan kata kunci untuk mulai mencari.</p>
            </div>
        @endif

    </div>

@endsection