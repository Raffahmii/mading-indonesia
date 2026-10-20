@extends('layouts.super-admin')

@section('title', $member->name)

@section('content')

    <div class="max-w-3xl">
        <a href="{{ route('super-admin.members.index') }}"
           class="inline-flex items-center gap-1.5 text-sm text-ink-muted hover:text-ink mb-4">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            Kembali
        </a>

        <div class="card p-6 mb-6">
            <div class="flex items-center gap-5 mb-6">
                <div class="avatar avatar-lg bg-brand-100 text-brand-700 font-bold text-2xl">
                    {{ strtoupper(substr($member->name, 0, 1)) }}
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-ink">{{ $member->name }}</h2>
                    <div class="text-ink-muted">{{ $member->email }}</div>
                    <div class="text-xs text-ink-muted mt-1">
                        Bergabung {{ $member->created_at->diffForHumans() }}
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-3 gap-4">
                <div class="p-4 rounded-xl bg-surface-muted text-center">
                    <div class="text-2xl font-bold text-ink">{{ $member->bookmarks_count }}</div>
                    <div class="text-xs text-ink-muted mt-1">Favorit</div>
                </div>
                <div class="p-4 rounded-xl bg-surface-muted text-center">
                    <div class="text-sm font-bold text-ink">{{ $member->created_at->format('M Y') }}</div>
                    <div class="text-xs text-ink-muted mt-1">Bergabung</div>
                </div>
                <div class="p-4 rounded-xl bg-surface-muted text-center">
                    @if($member->status->value === 'active')
                        <span class="badge badge-green">Aktif</span>
                    @else
                        <span class="badge badge-red">Suspend</span>
                    @endif
                </div>
            </div>
        </div>

        <div class="card p-6">
            <h3 class="font-bold text-lg mb-4 text-ink">Aksi</h3>
            <form method="POST" action="{{ route('super-admin.members.toggle-status', $member) }}">
                @csrf
                <button type="submit" class="btn btn-outline">
                    <i data-lucide="power" class="w-4 h-4"></i>
                    {{ $member->status->value === 'active' ? 'Suspend Akun' : 'Aktifkan Akun' }}
                </button>
            </form>
        </div>
    </div>

@endsection