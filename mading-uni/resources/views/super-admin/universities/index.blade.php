@extends('layouts.super-admin')

@section('title', 'Universitas')

@section('content')

    {{-- PAGE HEADER --}}
    <div class="page-header">
        <div>
            <h1>Universitas</h1>
            <p>Kelola semua universitas di platform.</p>
        </div>
        <a href="{{ route('super-admin.universities.create') }}" class="btn btn-primary">
            <i data-lucide="plus" class="w-4 h-4"></i>
            Tambah Universitas
        </a>
    </div>

    {{-- Filter --}}
    <form method="GET" class="card p-4 mb-5">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-3">
            <div class="md:col-span-5">
                <div class="relative">
                    <i data-lucide="search" class="w-4 h-4 text-ink-soft absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                    <input type="text" name="q" value="{{ request('q') }}"
                           placeholder="Cari nama atau kota..."
                           class="input pl-10">
                </div>
            </div>
            <div class="md:col-span-3">
                <select name="status" class="input">
                    <option value="">Semua Status</option>
                    <option value="active" @selected(request('status') === 'active')>Aktif</option>
                    <option value="inactive" @selected(request('status') === 'inactive')>Nonaktif</option>
                </select>
            </div>
            <div class="md:col-span-4 flex gap-2">
                <button type="submit" class="btn btn-primary flex-1">
                    <i data-lucide="filter" class="w-4 h-4"></i>
                    Filter
                </button>
                @if(request()->hasAny(['q', 'status']))
                    <a href="{{ route('super-admin.universities.index') }}" class="btn btn-ghost">
                        <i data-lucide="x" class="w-4 h-4"></i>
                    </a>
                @endif
            </div>
        </div>
    </form>

    {{-- Table --}}
    <div class="card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="table-modern">
                <thead>
                    <tr>
                        <th class="w-16"></th>
                        <th>Nama</th>
                        <th>Kota</th>
                        <th class="text-center">Konten</th>
                        <th class="text-center">Admin</th>
                        <th>Status</th>
                        <th class="text-right w-32">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($universities as $university)
                        <tr>
                            <td>
                                <div class="w-11 h-11 rounded-2xl flex items-center justify-center text-white font-bold text-sm shadow-md"
                                     style="background: linear-gradient(135deg, {{ $university->primary_color }} 0%, {{ $university->secondary_color }} 100%);">
                                    @if($university->logo_path)
                                        <img src="{{ $university->logo_url }}" alt="" class="w-full h-full object-contain p-1">
                                    @else
                                        {{ strtoupper(substr($university->name, 0, 1)) }}
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div class="font-semibold text-ink">{{ $university->name }}</div>
                                <div class="text-xs text-ink-muted font-mono">/{{ $university->slug }}</div>
                            </td>
                            <td class="text-sm text-ink-muted">
                                <div class="flex items-center gap-1.5">
                                    <i data-lucide="map-pin" class="w-3.5 h-3.5"></i>
                                    {{ $university->city ?? '-' }}
                                </div>
                            </td>
                            <td class="text-center">
                                <span class="badge badge-brand">{{ $university->posts_count }}</span>
                            </td>
                            <td class="text-center">
                                <span class="badge badge-blue">{{ $university->admins_count }}</span>
                            </td>
                            <td>
                                @if($university->status->value === 'active')
                                    <span class="inline-flex items-center gap-1.5 badge badge-green">
                                        <span class="w-1.5 h-1.5 rounded-full bg-success"></span>
                                        Aktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 badge badge-gray">
                                        <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span>
                                        Nonaktif
                                    </span>
                                @endif
                            </td>
                            <td>
                                <div class="flex items-center justify-end gap-1">
                                    <a href="{{ route('super-admin.universities.show', $university) }}"
                                       class="btn-icon btn-icon-primary" title="Lihat">
                                        <i data-lucide="eye" class="w-4 h-4"></i>
                                    </a>
                                    <a href="{{ route('super-admin.universities.edit', $university) }}"
                                       class="btn-icon btn-icon-blue" title="Edit">
                                        <i data-lucide="pencil" class="w-4 h-4"></i>
                                    </a>
                                    <form method="POST"
                                          action="{{ route('super-admin.universities.toggle-status', $university) }}"
                                          class="inline">
                                        @csrf
                                        <button type="submit" class="btn-icon btn-icon-yellow" title="Toggle Status">
                                            <i data-lucide="power" class="w-4 h-4"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-16">
                                <div class="w-16 h-16 rounded-2xl bg-surface-muted flex items-center justify-center mx-auto mb-4">
                                    <i data-lucide="building-2" class="w-8 h-8 text-ink-muted"></i>
                                </div>
                                <div class="font-semibold text-ink mb-1">Belum ada universitas</div>
                                <p class="text-ink-muted text-sm mb-5">Mulai tambahkan universitas pertama.</p>
                                <a href="{{ route('super-admin.universities.create') }}" class="btn btn-primary">
                                    <i data-lucide="plus" class="w-4 h-4"></i>
                                    Tambah Universitas
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($universities->hasPages())
        <div class="mt-6 flex justify-center">
            {{ $universities->links() }}
        </div>
    @endif

@endsection