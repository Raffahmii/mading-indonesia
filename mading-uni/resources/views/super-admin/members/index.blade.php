@extends('layouts.super-admin')

@section('title', 'Anggota')

@section('content')

    <div class="mb-5">
        <h2 class="text-xl font-bold text-ink mb-1">Anggota</h2>
        <p class="text-ink-muted text-sm">Kelola semua anggota platform.</p>
    </div>

    {{-- Filter --}}
    <form method="GET" class="card p-4 mb-5">
        <div class="flex gap-3">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama atau email..." class="input flex-1">
            <button type="submit" class="btn btn-primary">
                <i data-lucide="search" class="w-4 h-4"></i>
            </button>
        </div>
    </form>

    {{-- Table --}}
    <div class="card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="table-modern">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Bergabung</th>
                        <th class="text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($members as $member)
                        <tr>
                            <td>
                                <div class="flex items-center gap-3">
                                    <div class="avatar avatar-sm bg-brand-100 text-brand-700 font-bold">
                                        {{ strtoupper(substr($member->name, 0, 1)) }}
                                    </div>
                                    <span class="font-medium text-ink">{{ $member->name }}</span>
                                </div>
                            </td>
                            <td class="text-sm text-ink-muted">{{ $member->email }}</td>
                            <td>
                                @if($member->status->value === 'active')
                                    <span class="badge badge-green">Aktif</span>
                                @else
                                    <span class="badge badge-red">Suspend</span>
                                @endif
                            </td>
                            <td class="text-sm text-ink-muted">{{ $member->created_at->format('d M Y') }}</td>
                            <td>
                                <div class="flex items-center justify-end gap-1">
                                    <a href="{{ route('super-admin.members.show', $member) }}"
                                       class="p-2 rounded-lg text-ink-muted hover:text-brand-700 hover:bg-brand-50 transition">
                                        <i data-lucide="eye" class="w-4 h-4"></i>
                                    </a>
                                    <form method="POST" action="{{ route('super-admin.members.toggle-status', $member) }}" class="inline">
                                        @csrf
                                        <button type="submit"
                                                class="p-2 rounded-lg text-ink-muted hover:text-yellow-600 hover:bg-yellow-50 transition"
                                                title="Toggle status">
                                            <i data-lucide="power" class="w-4 h-4"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-12 text-ink-muted">Belum ada anggota.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($members->hasPages())
        <div class="mt-5 flex justify-center">{{ $members->links() }}</div>
    @endif

@endsection