@extends('layouts.super-admin')

@section('title', 'Admin Universitas')

@section('content')

    <div class="page-header">
        <div>
            <h1>Admin Universitas</h1>
            <p>Kelola akun administrator per universitas.</p>
        </div>
        <a href="{{ route('super-admin.admins.create') }}" class="btn btn-primary">
            <i data-lucide="plus" class="w-4 h-4"></i>
            Tambah Admin
        </a>
    </div>

    <form method="GET" class="card p-4 mb-5">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-3">
            <div class="md:col-span-5">
                <div class="relative">
                    <i data-lucide="search" class="w-4 h-4 text-ink-soft absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama atau email..." class="input pl-10">
                </div>
            </div>
            <div class="md:col-span-4">
                <select name="university_id" class="input">
                    <option value="">Semua Universitas</option>
                    @foreach($universities as $univ)
                        <option value="{{ $univ->id }}" @selected(request('university_id') == $univ->id)>
                            {{ $univ->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="md:col-span-3 flex gap-2">
                <button type="submit" class="btn btn-primary flex-1">
                    <i data-lucide="filter" class="w-4 h-4"></i>
                    Filter
                </button>
                @if(request()->hasAny(['q', 'university_id']))
                    <a href="{{ route('super-admin.admins.index') }}" class="btn btn-ghost">
                        <i data-lucide="x" class="w-4 h-4"></i>
                    </a>
                @endif
            </div>
        </div>
    </form>

    <div class="card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="table-modern">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Universitas</th>
                        <th>Status</th>
                        <th class="text-right w-32">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($admins as $admin)
                        <tr>
                            <td>
                                <div class="flex items-center gap-3">
                                    <div class="avatar avatar-sm bg-brand-100 text-brand-700 font-bold">
                                        {{ strtoupper(substr($admin->name, 0, 1)) }}
                                    </div>
                                    <span class="font-medium text-ink">{{ $admin->name }}</span>
                                </div>
                            </td>
                            <td class="text-sm text-ink-muted">{{ $admin->email }}</td>
                            <td class="text-sm">
                                @if($admin->university)
                                    <div class="flex items-center gap-2">
                                        <div class="w-6 h-6 rounded-lg flex items-center justify-center text-white text-[10px] font-bold"
                                             style="background: {{ $admin->university->primary_color }};">
                                            {{ strtoupper(substr($admin->university->name, 0, 1)) }}
                                        </div>
                                        <span class="text-ink">{{ $admin->university->name }}</span>
                                    </div>
                                @else
                                    <span class="text-ink-muted italic">-</span>
                                @endif
                            </td>
                            <td>
                                @if($admin->status->value === 'active')
                                    <span class="badge badge-green">Aktif</span>
                                @else
                                    <span class="badge badge-red">Suspend</span>
                                @endif
                            </td>
                            <td>
                                <div class="flex items-center justify-end gap-1">
                                    <a href="{{ route('super-admin.admins.show', $admin) }}" class="btn-icon btn-icon-primary" title="Lihat">
                                        <i data-lucide="eye" class="w-4 h-4"></i>
                                    </a>
                                    <a href="{{ route('super-admin.admins.edit', $admin) }}" class="btn-icon btn-icon-blue" title="Edit">
                                        <i data-lucide="pencil" class="w-4 h-4"></i>
                                    </a>
                                    <form method="POST" action="{{ route('super-admin.admins.toggle-status', $admin) }}" class="inline">
                                        @csrf
                                        <button type="submit" class="btn-icon btn-icon-yellow" title="Toggle Status">
                                            <i data-lucide="power" class="w-4 h-4"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center py-16 text-ink-muted">Belum ada admin.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($admins->hasPages())
        <div class="mt-6 flex justify-center">{{ $admins->links() }}</div>
    @endif

@endsection