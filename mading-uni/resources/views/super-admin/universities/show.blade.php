@extends('layouts.super-admin')

@section('title', $university->name)

@section('content')

    {{-- Back --}}
    <a href="{{ route('super-admin.universities.index') }}"
       class="inline-flex items-center gap-1.5 text-sm text-ink-muted hover:text-ink mb-4">
        <i data-lucide="arrow-left" class="w-4 h-4"></i>
        Kembali ke daftar
    </a>

    {{-- Hero Card --}}
    <div class="relative overflow-hidden rounded-2xl p-6 lg:p-8 mb-6 text-white"
         style="background: linear-gradient(135deg, {{ $university->primary_color }} 0%, {{ $university->secondary_color }} 100%);">

        <div class="absolute inset-0 pointer-events-none">
            <div class="blob blob-brand w-64 h-64 -top-16 -right-16 opacity-40 animate-blob"></div>
        </div>

        <div class="relative z-10 flex items-start justify-between gap-4 flex-wrap">
            <div class="flex items-center gap-5">
                <div class="w-16 h-16 rounded-2xl bg-white/20 backdrop-blur flex items-center justify-center flex-shrink-0">
                    @if($university->logo_path)
                        <img src="{{ $university->logo_url }}" alt="" class="w-full h-full object-contain p-2">
                    @else
                        <i data-lucide="building-2" class="w-8 h-8"></i>
                    @endif
                </div>
                <div>
                    <h2 class="text-2xl lg:text-3xl font-bold mb-1">{{ $university->name }}</h2>
                    <div class="flex items-center gap-3 text-sm text-white/85 flex-wrap">
                        <span class="inline-flex items-center gap-1">
                            <i data-lucide="map-pin" class="w-4 h-4"></i>
                            {{ $university->city ?? 'Indonesia' }}
                        </span>
                        @if($university->status->value === 'active')
                            <span class="px-2 py-0.5 rounded-full bg-white/20 text-xs">Aktif</span>
                        @else
                            <span class="px-2 py-0.5 rounded-full bg-black/20 text-xs">Nonaktif</span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-2">
                <a href="{{ route('super-admin.universities.edit', $university) }}"
                   class="btn btn-sm bg-white/20 text-white hover:bg-white/30 backdrop-blur">
                    <i data-lucide="pencil" class="w-4 h-4"></i>
                    Edit
                </a>
                <a href="{{ route('public.universities.show', $university) }}" target="_blank"
                   class="btn btn-sm bg-white text-gray-900 hover:bg-white/90">
                    <i data-lucide="external-link" class="w-4 h-4"></i>
                    Lihat Publik
                </a>
            </div>
        </div>
    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="card p-5">
            <div class="text-3xl font-bold text-ink mb-1">{{ $university->posts_count }}</div>
            <div class="text-sm text-ink-muted">Total Konten</div>
        </div>
        <div class="card p-5">
            <div class="text-3xl font-bold text-ink mb-1">{{ $university->admins_count }}</div>
            <div class="text-sm text-ink-muted">Admin</div>
        </div>
        <div class="card p-5">
            <div class="text-3xl font-bold text-ink mb-1">{{ $university->created_at->format('M Y') }}</div>
            <div class="text-sm text-ink-muted">Bergabung</div>
        </div>
        <div class="card p-5">
            <div class="text-3xl font-bold text-ink mb-1">{{ $university->slug }}</div>
            <div class="text-sm text-ink-muted">Slug URL</div>
        </div>
    </div>

    {{-- Info & Admins --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">

        {{-- Info --}}
        <div class="card p-6">
            <h3 class="font-bold text-lg mb-4 text-ink">Informasi</h3>
            <dl class="space-y-3 text-sm">
                @if($university->email)
                    <div class="flex justify-between gap-4">
                        <dt class="text-ink-muted">Email</dt>
                        <dd class="text-ink font-medium text-right">{{ $university->email }}</dd>
                    </div>
                @endif
                @if($university->phone)
                    <div class="flex justify-between gap-4">
                        <dt class="text-ink-muted">Telepon</dt>
                        <dd class="text-ink font-medium text-right">{{ $university->phone }}</dd>
                    </div>
                @endif
                @if($university->website)
                    <div class="flex justify-between gap-4">
                        <dt class="text-ink-muted">Website</dt>
                        <dd class="text-right">
                            <a href="{{ $university->website }}" target="_blank" class="text-brand-700 hover:underline font-medium">
                                {{ $university->website }}
                            </a>
                        </dd>
                    </div>
                @endif
                @if($university->address)
                    <div class="flex justify-between gap-4">
                        <dt class="text-ink-muted flex-shrink-0">Alamat</dt>
                        <dd class="text-ink font-medium text-right">{{ $university->address }}</dd>
                    </div>
                @endif
            </dl>

            @if($university->description)
                <div class="mt-5 pt-5 border-t border-surface-border">
                    <div class="text-ink-muted text-xs uppercase font-semibold mb-2">Deskripsi</div>
                    <p class="text-sm text-ink leading-relaxed">{{ $university->description }}</p>
                </div>
            @endif
        </div>

        {{-- Admins --}}
        <div class="card p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-bold text-lg text-ink">Admin</h3>
                <a href="{{ route('super-admin.admins.create') }}" class="btn btn-sm btn-outline">
                    <i data-lucide="plus" class="w-3.5 h-3.5"></i>
                    Tambah
                </a>
            </div>

            <div class="space-y-2">
                @forelse($university->admins as $admin)
                    <a href="{{ route('super-admin.admins.show', $admin) }}"
                       class="flex items-center gap-3 p-3 rounded-xl hover:bg-surface-muted transition">
                        <div class="avatar avatar-sm bg-brand-100 text-brand-700 font-bold">
                            {{ strtoupper(substr($admin->name, 0, 1)) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="font-medium text-sm text-ink truncate">{{ $admin->name }}</div>
                            <div class="text-xs text-ink-muted truncate">{{ $admin->email }}</div>
                        </div>
                        @if($admin->status->value === 'active')
                            <span class="badge badge-green text-xs">Aktif</span>
                        @else
                            <span class="badge badge-red text-xs">Suspend</span>
                        @endif
                    </a>
                @empty
                    <div class="text-center py-8 text-ink-muted text-sm">
                        Belum ada admin.
                    </div>
                @endforelse
            </div>
        </div>

    </div>

    {{-- Recent Posts --}}
    <div class="card">
        <div class="p-5 border-b border-surface-border flex items-center justify-between">
            <h3 class="font-bold text-lg text-ink">Konten Terbaru</h3>
            <a href="{{ route('super-admin.posts.index', ['university_id' => $university->id]) }}" class="link-arrow">
                Lihat semua
                <i data-lucide="arrow-right" class="w-4 h-4"></i>
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="table-modern">
                <thead>
                    <tr>
                        <th>Judul</th>
                        <th>Kategori</th>
                        <th>Status</th>
                        <th class="text-right">Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentPosts as $post)
                        <tr>
                            <td>
                                <a href="{{ route('super-admin.posts.show', $post) }}"
                                   class="font-medium text-ink hover:text-brand-700 line-clamp-1">
                                    {{ $post->title }}
                                </a>
                            </td>
                            <td class="text-sm text-ink-muted">{{ $post->category->name }}</td>
                            <td>
                                <span class="badge badge-{{ $post->status->color() }}">
                                    {{ $post->status->label() }}
                                </span>
                            </td>
                            <td class="text-right text-sm text-ink-muted">
                                {{ $post->created_at->format('d M Y') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-8 text-ink-muted">Belum ada konten.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection