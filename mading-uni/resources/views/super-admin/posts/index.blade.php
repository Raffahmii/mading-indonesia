@extends('layouts.super-admin')

@section('title', 'Semua Konten')

@section('content')

    <div class="mb-5">
        <h2 class="text-xl font-bold text-ink mb-1">Semua Konten</h2>
        <p class="text-ink-muted text-sm">Lihat semua konten dari seluruh universitas.</p>
    </div>

    {{-- Filters --}}
    <form method="GET" class="card p-4 mb-5">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-3">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari judul..." class="input">
            <select name="status" class="input">
                <option value="">Semua Status</option>
                @foreach(\App\Enums\PostStatus::cases() as $status)
                    <option value="{{ $status->value }}" @selected(request('status') === $status->value)>
                        {{ $status->label() }}
                    </option>
                @endforeach
            </select>
            <select name="university_id" class="input">
                <option value="">Semua Universitas</option>
                @foreach($universities as $univ)
                    <option value="{{ $univ->id }}" @selected(request('university_id') == $univ->id)>
                        {{ $univ->name }}
                    </option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-primary">
                <i data-lucide="filter" class="w-4 h-4"></i>
                Filter
            </button>
        </div>
    </form>

    <div class="card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="table-modern">
                <thead>
                    <tr>
                        <th>Judul</th>
                        <th>Universitas</th>
                        <th>Kategori</th>
                        <th>Status</th>
                        <th class="text-right">Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($posts as $post)
                        <tr>
                            <td>
                                <a href="{{ route('super-admin.posts.show', $post) }}" class="font-medium text-ink hover:text-brand-700 line-clamp-1">
                                    {{ $post->title }}
                                </a>
                                <div class="text-xs text-ink-muted">oleh {{ $post->author->name }}</div>
                            </td>
                            <td class="text-sm">
                                <div class="flex items-center gap-2">
                                    <div class="w-6 h-6 rounded flex items-center justify-center text-white text-[10px] font-bold"
                                         style="background: {{ $post->university->primary_color }};">
                                        {{ strtoupper(substr($post->university->name, 0, 1)) }}
                                    </div>
                                    <span class="text-ink">{{ $post->university->name }}</span>
                                </div>
                            </td>
                            <td class="text-sm text-ink-muted">{{ $post->category->name }}</td>
                            <td>
                                <span class="badge badge-{{ $post->status->color() }}">{{ $post->status->label() }}</span>
                            </td>
                            <td class="text-right text-sm text-ink-muted">{{ $post->created_at->format('d M Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-12 text-ink-muted">Belum ada konten.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($posts->hasPages())
        <div class="mt-5 flex justify-center">{{ $posts->links() }}</div>
    @endif

@endsection