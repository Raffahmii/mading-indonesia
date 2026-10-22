@extends('layouts.public')

@section('title', 'Beranda')

@section('content')

    {{-- ============================================================
         HERO SECTION — FULL WIDTH 1 LAYAR
         ============================================================ --}}
    <section id="beranda" class="hero-bg text-white">

        {{-- Layer 1: Background image --}}
        <div class="hero-bg__image"></div>

        {{-- Layer 2: Overlay gradient --}}
        <div class="hero-bg__overlay"></div>

        {{-- Layer 3: Blob --}}
        <div class="hero-bg__blobs">
            <div class="blob blob-brand w-[400px] h-[400px] -top-32 -left-32 opacity-25 animate-blob"></div>
            <div class="blob blob-brand w-[350px] h-[350px] bottom-0 right-0 opacity-20 animate-blob-delay-2"></div>
            <div class="blob blob-brand w-[300px] h-[300px] top-1/3 left-1/2 opacity-15 animate-blob-delay-4"></div>
        </div>

        {{-- Layer 4: Konten --}}
        <div class="hero-bg__content">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-20">
                <div class="max-w-3xl">

                    {{-- Badge --}}
                    <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full glass text-sm font-medium mb-7 animate-fade-up">
                        <span class="w-1.5 h-1.5 rounded-full bg-white animate-pulse"></span>
                        Platform Mading Antar-Universitas Indonesia
                    </div>

                    {{-- Headline --}}
                    <h1 class="text-4xl sm:text-5xl lg:text-7xl font-extrabold leading-[1.05] mb-6 animate-fade-up-d1">
                        Satu ruang untuk<br>
                        <span class="text-white/95">semua informasi kampus.</span>
                    </h1>

                    {{-- Subheadline --}}
                    <p class="text-lg lg:text-xl text-white/90 leading-relaxed mb-10 max-w-2xl animate-fade-up-d2">
                        Temukan pengumuman, event, lomba, beasiswa, dan prestasi dari berbagai universitas di seluruh Indonesia.
                    </p>

                    {{-- CTAs --}}
                    <div class="flex flex-wrap gap-3 mb-14 animate-fade-up-d3">
                        <a href="#universitas" class="btn btn-white btn-lg">
                            <i data-lucide="compass" class="w-4 h-4"></i>
                            Jelajahi Universitas
                        </a>
                        <button @click="searchOpen = true" class="btn btn-lg glass text-white hover:bg-white/20">
                            <i data-lucide="search" class="w-4 h-4"></i>
                            Cari Konten
                        </button>
                    </div>

                    {{-- Stats --}}
                    <div class="flex flex-wrap gap-x-12 gap-y-6 pt-8 border-t border-white/20 animate-fade-up-d4">
                        <div>
                            <div class="text-4xl lg:text-5xl font-bold text-white">{{ $featuredUniversities->count() }}+</div>
                            <div class="text-sm text-white/70 mt-1.5">Universitas</div>
                        </div>
                        <div>
                            <div class="text-4xl lg:text-5xl font-bold text-white">{{ $latestPosts->count() }}+</div>
                            <div class="text-sm text-white/70 mt-1.5">Konten Published</div>
                        </div>
                        <div>
                            <div class="text-4xl lg:text-5xl font-bold text-white">{{ $categories->count() }}+</div>
                            <div class="text-sm text-white/70 mt-1.5">Kategori</div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        {{-- Scroll indicator --}}
        <div class="absolute bottom-6 left-1/2 -translate-x-1/2 z-10 animate-bounce">
            <a href="#universitas" class="flex flex-col items-center gap-1 text-white/70 hover:text-white transition">
                <i data-lucide="chevron-down" class="w-5 h-5"></i>
            </a>
        </div>

    </section>

    {{-- ============================================================
         FEATURED UNIVERSITIES
         ============================================================ --}}
    @if($featuredUniversities->isNotEmpty())
        <section id="universitas" class="max-w-7xl mx-auto px-4 lg:px-8 py-20 lg:py-24">
            <div class="section-heading reveal">
                <div>
                    <h2>Universitas Unggulan</h2>
                    <p>Universitas paling aktif di Mading Indonesia.</p>
                </div>
                <a href="{{ route('public.universities.index') }}" class="link-arrow">
                    Lihat semua
                    <i data-lucide="arrow-right" class="w-4 h-4"></i>
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                @foreach($featuredUniversities as $i => $university)
                    <div class="reveal reveal-d{{ min($i + 1, 6) }}">
                        @include('public.partials.university-card', ['university' => $university])
                    </div>
                @endforeach
            </div>
        </section>
    @endif

    {{-- ============================================================
         CATEGORIES
         ============================================================ --}}
    @if($categories->isNotEmpty())
        <section id="kategori" class="bg-white border-y border-surface-border">
            <div class="max-w-7xl mx-auto px-4 lg:px-8 py-20 lg:py-24">
                <div class="text-center mb-14 reveal">
                    <h2 class="text-3xl lg:text-4xl font-bold mb-3 text-ink">Jelajahi Kategori</h2>
                    <p class="text-ink-muted max-w-xl mx-auto">Pilih kategori yang kamu minati.</p>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
                    @foreach($categories as $i => $category)
                        <a href="{{ route('public.categories.show', $category) }}"
                           class="reveal reveal-scale reveal-d{{ min($i + 1, 6) }} group p-6 rounded-2xl border border-surface-border bg-surface-muted hover:bg-white hover:border-brand-200 hover:shadow-card-hover transition text-center">
                            <div class="w-14 h-14 mx-auto rounded-2xl bg-white flex items-center justify-center mb-4 group-hover:bg-brand-gradient group-hover:text-white transition-all text-brand-700 shadow-sm">
                                <i data-lucide="{{ $category->icon ?? 'folder' }}" class="w-6 h-6"></i>
                            </div>
                            <div class="font-semibold text-sm mb-1 text-ink">{{ $category->name }}</div>
                            <div class="text-xs text-ink-muted">{{ $category->published_posts_count }} konten</div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- ============================================================
         LATEST POSTS
         ============================================================ --}}
    @if($latestPosts->isNotEmpty())
        <section id="informasi" class="max-w-7xl mx-auto px-4 lg:px-8 py-20 lg:py-24">
            <div class="section-heading reveal">
                <div>
                    <h2>Informasi Terbaru</h2>
                    <p>Update terkini dari kampus-kampus Indonesia.</p>
                </div>
                <a href="{{ route('public.search') }}" class="link-arrow">
                    Lihat semua
                    <i data-lucide="arrow-right" class="w-4 h-4"></i>
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($latestPosts as $i => $post)
                    <div class="reveal reveal-d{{ min($i + 1, 6) }}">
                        @include('public.partials.post-card', ['post' => $post])
                    </div>
                @endforeach
            </div>
        </section>
    @endif

    {{-- ============================================================
         UPCOMING EVENTS
         ============================================================ --}}
    @if($upcomingEvents->isNotEmpty())
        <section class="bg-white border-y border-surface-border">
            <div class="max-w-7xl mx-auto px-4 lg:px-8 py-20 lg:py-24">
                <div class="section-heading reveal">
                    <div>
                        <h2>Event Mendatang</h2>
                        <p>Jangan lewatkan acara penting dari kampus.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    @foreach($upcomingEvents as $i => $event)
                        <a href="{{ route('public.posts.show', [$event->university, $event]) }}"
                           class="reveal reveal-left reveal-d{{ min($i + 1, 4) }} card card-hover group flex gap-4 p-5">
                            <div class="flex-shrink-0 w-16 h-16 rounded-2xl bg-brand-gradient flex flex-col items-center justify-center text-white shadow-md">
                                <span class="text-[10px] font-semibold uppercase tracking-wider">{{ $event->event_start->translatedFormat('M') }}</span>
                                <span class="text-xl font-bold leading-none mt-0.5">{{ $event->event_start->format('d') }}</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="inline-flex items-center gap-1 text-xs font-medium text-brand-700 mb-1.5">
                                    <i data-lucide="tag" class="w-3 h-3"></i>
                                    {{ $event->category->name }}
                                </div>
                                <h3 class="font-bold mb-2 line-clamp-2 group-hover:text-brand-700 transition text-ink">{{ $event->title }}</h3>
                                <div class="text-xs text-ink-muted flex items-center gap-1.5">
                                    <i data-lucide="building-2" class="w-3.5 h-3.5"></i>
                                    <span class="truncate">{{ $event->university->name }}</span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- ============================================================
         HOW IT WORKS
         ============================================================ --}}
    <section class="max-w-7xl mx-auto px-4 lg:px-8 py-20 lg:py-24">
        <div class="text-center mb-14 reveal">
            <h2 class="text-3xl lg:text-4xl font-bold mb-3 text-ink">Bagaimana Cara Kerjanya?</h2>
            <p class="text-ink-muted max-w-xl mx-auto">Tiga langkah mudah untuk mulai menemukan informasi kampus.</p>
        </div>

        <div class="grid md:grid-cols-3 gap-6">
            @php
                $steps = [
                    ['icon' => 'user-plus', 'title' => 'Daftar Akun', 'desc' => 'Cukup dengan email dan password. Gratis, tanpa biaya tersembunyi.'],
                    ['icon' => 'search',    'title' => 'Jelajahi',    'desc' => 'Temukan universitas dan informasi yang kamu minati dari seluruh Indonesia.'],
                    ['icon' => 'bookmark',  'title' => 'Simpan Favorit','desc' => 'Bookmark konten penting biar nggak kelewat, akses kapan saja.'],
                ];
            @endphp

            @foreach($steps as $i => $step)
                <div class="reveal reveal-d{{ $i + 1 }} relative card p-8 text-center">
                    <div class="absolute -top-4 -right-4 w-10 h-10 rounded-full bg-brand-gradient text-white flex items-center justify-center font-bold text-sm shadow-md">
                        {{ $i + 1 }}
                    </div>
                    <div class="w-16 h-16 mx-auto rounded-2xl bg-brand-50 text-brand-700 flex items-center justify-center mb-5">
                        <i data-lucide="{{ $step['icon'] }}" class="w-8 h-8"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-2.5 text-ink">{{ $step['title'] }}</h3>
                    <p class="text-ink-muted text-sm leading-relaxed">{{ $step['desc'] }}</p>
                </div>
            @endforeach
        </div>
    </section>

    {{-- ============================================================
         CTA
         ============================================================ --}}
    <section class="max-w-7xl mx-auto px-4 lg:px-8 pb-20 lg:pb-24">
        <div class="reveal reveal-scale relative overflow-hidden rounded-3xl p-10 lg:p-16 text-white"
             style="background-image: linear-gradient(135deg, #8E1EA2 0%, #C654C3 50%, #ED96D7 100%);">

            <div class="absolute inset-0 pointer-events-none">
                <div class="blob blob-brand w-[500px] h-[500px] -top-32 -right-32 opacity-40 animate-blob"></div>
                <div class="blob blob-brand w-[400px] h-[400px] -bottom-32 -left-32 opacity-30 animate-blob-delay-2"></div>
            </div>

            <div class="relative z-10 max-w-2xl">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/15 backdrop-blur text-xs font-medium mb-5">
                    <i data-lucide="sparkles" class="w-3.5 h-3.5"></i>
                    Bergabung Sekarang
                </div>

                <h2 class="text-3xl lg:text-4xl font-bold mb-4 leading-tight">
                    Siap mulai menjelajah kampus Indonesia?
                </h2>
                <p class="text-white/85 mb-8 text-lg leading-relaxed">
                    Bergabung dengan mahasiswa Indonesia yang udah menemukan informasi penting dari kampus mereka.
                </p>

                <div class="flex flex-wrap gap-3">
                    @auth
                        <a href="{{ route('public.universities.index') }}" class="btn btn-white btn-lg">
                            <i data-lucide="compass" class="w-4 h-4"></i>
                            Jelajahi Universitas
                        </a>
                    @else
                        <button @click="registerOpen = true" class="btn btn-white btn-lg">
                            <i data-lucide="user-plus" class="w-4 h-4"></i>
                            Daftar Gratis
                        </button>
                        <button @click="loginOpen = true" class="btn btn-lg glass text-white hover:bg-white/20">
                            Masuk
                        </button>
                    @endauth
                </div>
            </div>
        </div>
    </section>

@endsection