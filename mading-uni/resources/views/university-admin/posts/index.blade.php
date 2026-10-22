@extends('layouts.university-admin')

@section('title', 'Konten Saya')

@section('content')

    <div class="page-header">
        <div>
            <h1>Konten Saya</h1>
            <p>Kelola semua konten universitas kamu.</p>
        </div>
        <a href="{{ route('university-admin.posts.create') }}" class="btn btn-univ">
            <i data-lucide="plus" class="w-4 h-4"></i>
            Buat Konten
        </a>
    </div>

    {{-- Stats Tabs --}}
    <div class="flex items-center gap-2 mb-6 overflow-x-auto pb-2">
        @php
            $tabs = [
                ['key' => '',          'label' => 'Semua',     'count' => $stats['all']],
                ['key' => 'draft',     'label' => 'Draft',     'count' => $stats['draft']],
                ['key' => 'pending',   'label' => 'Pending',   'count' => $stats['pending']],
                ['key' => 'published', 'label' => 'Published', 'count' => $stats['published']],
                ['key' => 'rejected',  'label' => 'Rejected',  'count' => $stats['rejected']],
            ];
        @endphp
        @foreach($tabs as $tab)
            @php $isActive = request('status') === $tab['key'] || (empty(request('status')) && $tab['key'] === ''); @endphp
            <a href="{{ route('university-admin.posts.index', array_filter(['status' => $tab['key']])) }}"
               class="flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-medium transition whitespace-nowrap
                      {{ $isActive ? 'text-white shadow-md' : 'bg-white text-ink-muted hover:bg-surface-muted border border-surface-border' }}"
               @if($isActive) style="background: var(--university-primary);" @endif>
                {{ $tab['label'] }}
                <span class="px-1.5 py-0.5 rounded-full text-[10px] font-bold {{ $isActive ? 'bg-white/20' : 'bg-surface-muted text-ink' }}">
                    {{ $tab['count'] }}
                </span>
            </a>
        @endforeach
    </div>

    {{-- Filter Search --}}
    <form method="GET" class="card p-4 mb-5">
        <div class="flex gap-3">
            @if(request('status'))
                <input type="hidden" name="status" value="{{ request('status') }}">
            @endif
            <div class="relative flex-1">
                <i data-lucide="search" class="w-4 h-4 text-ink-soft absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari judul konten..." class="input pl-10">
            </div>
            <button type="submit" class="btn btn-outline">Cari</button>
        </div>
    </form>

    {{-- Table --}}
    <div class="card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="table-modern">
                <thead>
                    <tr>
                        <th>Judul</th>
                        <th>Kategori</th>
                        <th>Status</th>
                        <th class="text-right">Tanggal</th>
                        <th class="text-right w-32">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($posts as $post)
                        <tr>
                            <td>
                                <div class="font-medium text-ink line-clamp-1">{{ $post->title }}</div>
                                @if($post->event_start)
                                    <div class="text-xs text-ink-muted mt-0.5 flex items-center gap-1">
                                        <i data-lucide="calendar" class="w-3 h-3"></i>
                                        {{ $post->event_start->format('d M Y') }}
                                    </div>
                                @endif
                            </td>
                            <td class="text-sm text-ink-muted">{{ $post->category->name }}</td>
                            <td><span class="badge badge-{{ $post->status->color() }}">{{ $post->status->label() }}</span></td>
                            <td class="text-right text-sm text-ink-muted whitespace-nowrap">{{ $post->created_at->format('d M Y') }}</td>
                            <td>
                                <div class="flex items-center justify-end gap-1">
                                    <a href="{{ route('university-admin.posts.show', $post) }}" class="btn-icon btn-icon-primary" title="Lihat">
                                        <i data-lucide="eye" class="w-4 h-4"></i>
                                    </a>
                                    @if($post->status->isEditable())
                                        <a href="{{ route('university-admin.posts.edit', $post) }}" class="btn-icon btn-icon-blue" title="Edit">
                                            <i data-lucide="pencil" class="w-4 h-4"></i>
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-16">
                                <div class="w-16 h-16 rounded-2xl bg-surface-muted flex items-center justify-center mx-auto mb-4">
                                    <i data-lucide="file-text" class="w-8 h-8 text-ink-muted"></i>
                                </div>
                                <div class="font-semibold text-ink mb-1">Belum ada konten</div>
                                <p class="text-sm text-ink-muted mb-5">Mulai buat konten pertama kamu.</p>
                                <a href="{{ route('university-admin.posts.create') }}" class="btn btn-univ">
                                    <i data-lucide="plus" class="w-4 h-4"></i> Buat Konten
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($posts->hasPages())
        <div class="mt-6 flex justify-center">{{ $posts->links() }}</div>
    @endif

@endsection