@extends('layouts.public')

@section('title', 'Jelajahi Universitas')

@section('content')

    {{-- Header --}}
    <div class="bg-brand-gradient text-white relative overflow-hidden">
        <div class="absolute inset-0 pointer-events-none">
            <div class="blob blob-brand w-96 h-96 -top-32 -left-32 opacity-30 animate-blob"></div>
        </div>
        <div class="relative z-10 max-w-7xl mx-auto px-4 lg:px-8 py-16 lg:py-20">
            <h1 class="text-4xl lg:text-5xl font-extrabold mb-3">Jelajahi Universitas</h1>
            <p class="text-white/80 text-lg max-w-2xl">
                Temukan informasi dari berbagai kampus di seluruh Indonesia.
            </p>
        </div>
    </div>

    {{-- Filter --}}
    <div class="max-w-7xl mx-auto px-4 lg:px-8 -mt-6 relative z-20">
        <form method="GET" class="card p-4 shadow-lg">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-3">
                <div class="md:col-span-7">
                    <div class="relative">
                        <i data-lucide="search" class="w-4 h-4 text-ink-soft absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                        <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari universitas..." class="input pl-10">
                    </div>
                </div>
                <div class="md:col-span-3">
                    <select name="city" class="input">
                        <option value="">Semua Kota</option>
                        @foreach($cities as $city)
                            <option value="{{ $city }}" @selected(request('city') == $city)>{{ $city }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="md:col-span-2">
                    <button type="submit" class="btn btn-primary w-full">
                        Cari
                    </button>
                </div>
            </div>
        </form>
    </div>

    {{-- Grid --}}
    <div class="max-w-7xl mx-auto px-4 lg:px-8 py-12 lg:py-16">
        @if($universities->isEmpty())
            <div class="text-center py-20">
                <div class="w-20 h-20 rounded-3xl bg-brand-50 text-brand-700 flex items-center justify-center mx-auto mb-4">
                    <i data-lucide="building-2" class="w-10 h-10"></i>
                </div>
                <h3 class="text-xl font-bold text-ink mb-2">Tidak ada universitas ditemukan</h3>
                <p class="text-ink-muted">Coba ganti kata kunci atau filter kota.</p>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                @foreach($universities as $university)
                    @include('public.partials.university-card', ['university' => $university])
                @endforeach
            </div>

            @if($universities->hasPages())
                <div class="mt-12 flex justify-center">{{ $universities->links() }}</div>
            @endif
        @endif
    </div>

@endsection