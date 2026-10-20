@extends('layouts.public')

@section('title', 'Favorit Saya')

@section('content')
    <div class="max-w-7xl mx-auto px-4 lg:px-8 py-12">
        <div class="mb-8">
            <h1 class="text-3xl lg:text-4xl font-bold mb-2 text-ink">Favorit Saya</h1>
            <p class="text-ink-muted">Konten yang kamu bookmark.</p>
        </div>

        @if($bookmarks->isEmpty())
            <div class="card p-12 text-center">
                <div class="w-16 h-16 rounded-2xl bg-brand-50 text-brand-700 flex items-center justify-center mx-auto mb-4">
                    <i data-lucide="bookmark" class="w-8 h-8"></i>
                </div>
                <h3 class="font-bold text-lg mb-2 text-ink">Belum ada favorit</h3>
                <p class="text-ink-muted text-sm mb-6 max-w-md mx-auto">
                    Mulai jelajahi konten dan simpan yang kamu suka.
                </p>
                <a href="{{ route('public.universities.index') }}" class="btn btn-primary">
                    <i data-lucide="compass" class="w-4 h-4"></i>
                    Jelajahi Universitas
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                @foreach($bookmarks as $bookmark)
                    @if($bookmark->post)
                        @include('public.partials.post-card', ['post' => $bookmark->post])
                    @endif
                @endforeach
            </div>

            @if($bookmarks->hasPages())
                <div class="mt-8 flex justify-center">
                    {{ $bookmarks->links() }}
                </div>
            @endif
        @endif
    </div>
@endsection