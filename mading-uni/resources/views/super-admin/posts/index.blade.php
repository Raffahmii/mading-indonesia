@extends('layouts.super-admin')

@section('title', 'Semua Konten')

@section('content')

    <div class="page-header">
        <div>
            <h1>Semua Konten</h1>
            <p>Lihat semua konten dari seluruh universitas.</p>
        </div>
    </div>

    <form method="GET" class="card p-4 mb-5">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-3">
            <div class="md:col-span-4">
                <div class="relative">
                    <i data-lucide="search" class="w-4 h-4 text-ink-soft absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari judul..." class="input pl-10">
                </div>
            </div>
            <div class="md:col-span-3">
                <select name="status" class="input">
                    <option value="">Semua Status</option>
                    @foreach(\App\Enums\PostStatus::cases() as $status)
                        <option value="{{ $status->value }}" @selected(request('status') === $status->value)>
                            {{ $status->label() }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="md:col-span-3">
                <select name="university_id" class="input">
                    <option value="">Semua Universitas</option>
                    @foreach($universities as $univ)
                        <option value="{{ $univ->id }}" @selected(request('university_id') == $univ->id)>
                            {{ $univ->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="md:col-span-2">
                <button type="submit" class="btn btn-primary w-full">
                    <i data-lucide="filter" class="w-4 h-4"></i> Filter
                </button>
            </div>
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
                                <a href="{{ route('super-admin.posts.show', $post) }}" class="font-semibold text-ink hover:text-brand-700 line-clamp-1 transition">
                                    {{ $post->title }}
                                </a>
                                <div class="text-xs text-ink-muted">oleh {{ $post->author->name }}</div>
                            </td>
                            <td class="text-sm">
                                <div class="flex items-center gap-2">
                                    <div class="w-6 h-6 rounded-lg flex items-center justify-center text-white text-[10px] font-bold"
                                         style="background: {{ $post->university->primary_color }};">
                                        {{ strtoupper(substr($post->university->name, 0, 1)) }}
                                    </div>
                                    <span class="text-ink truncate max-w-[150px]">{{ $post->university->name }}</span>
                                </div>
                            </td>
                            <td class="text-sm text-ink-muted">{{ $post->category->name }}</td>
                            <td>
                                <span class="badge badge-{{ $post->status->color() }}">{{ $post->status->label() }}</span>
                            </td>
                            <td class="text-right text-sm text-ink-muted whitespace-nowrap">{{ $post->created_at->format('d M Y') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center py-16 text-ink-muted">Belum ada konten.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($posts->hasPages())
        <div class="mt-6 flex justify-center">{{ $posts->links() }}</div>
    @endif

@endsection