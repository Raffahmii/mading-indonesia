@extends('layouts.super-admin')

@section('title', $admin->name)

@section('content')

    <div class="max-w-3xl">
        <a href="{{ route('super-admin.admins.index') }}" class="inline-flex items-center gap-1.5 text-sm text-ink-muted hover:text-ink mb-4">
            <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali
        </a>

        <div class="card p-6 mb-6">
            <div class="flex items-center gap-5 mb-6">
                <div class="w-16 h-16 rounded-2xl bg-brand-gradient flex items-center justify-center text-white text-2xl font-bold">
                    {{ strtoupper(substr($admin->name, 0, 1)) }}
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-ink">{{ $admin->name }}</h2>
                    <div class="text-ink-muted">{{ $admin->email }}</div>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="p-4 rounded-xl bg-surface-muted">
                    <div class="text-xs text-ink-muted mb-1">Universitas</div>
                    <div class="font-medium text-ink">{{ $admin->university->name ?? '-' }}</div>
                </div>
                <div class="p-4 rounded-xl bg-surface-muted">
                    <div class="text-xs text-ink-muted mb-1">Status</div>
                    @if($admin->status->value === 'active')
                        <span class="badge badge-green">Aktif</span>
                    @else
                        <span class="badge badge-red">Suspend</span>
                    @endif
                </div>
            </div>
        </div>

        <div class="card p-6">
            <h3 class="font-bold text-lg mb-4">Aksi</h3>
            <form method="POST" action="{{ route('super-admin.admins.toggle-status', $admin) }}">
                @csrf
                <button type="submit" class="btn btn-outline">
                    <i data-lucide="power" class="w-4 h-4"></i>
                    {{ $admin->status->value === 'active' ? 'Suspend Akun' : 'Aktifkan Akun' }}
                </button>
            </form>
        </div>
    </div>

@endsection