@extends('layouts.member')

@section('title', 'Favorit Saya')
@section('subtitle', 'Konten yang kamu simpan')

@section('content')

    <div class="mb-6">
        <h2 class="text-xl font-bold text-ink mb-1">Favorit Saya</h2>
        <p class="text-ink-muted text-sm">Konten yang kamu bookmark untuk dibaca nanti.</p>
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
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 mb-6">
            @foreach($bookmarks as $bookmark)
                @if($bookmark->post)
                    <div class="relative group">
                        @include('public.partials.post-card', ['post' => $bookmark->post])

                        <form method="POST"
                              action="{{ route('public.bookmarks.toggle', $bookmark->post) }}"
                              class="absolute top-3 right-3 opacity-0 group-hover:opacity-100 transition">
                            @csrf
                            <button type="submit"
                                    class="w-9 h-9 rounded-full bg-white/95 backdrop-blur shadow-md flex items-center justify-center text-danger hover:bg-danger hover:text-white transition"
                                    title="Hapus dari favorit">
                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                            </button>
                        </form>
                    </div>
                @endif
            @endforeach
        </div>

        @if($bookmarks->hasPages())
            <div class="flex justify-center">{{ $bookmarks->links() }}</div>
        @endif
    @endif

@endsection