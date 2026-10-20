@extends('layouts.super-admin')

@section('title', 'Pengaturan')

@section('content')

    <div class="max-w-3xl">
        <div class="mb-5">
            <h2 class="text-xl font-bold text-ink mb-1">Pengaturan Platform</h2>
            <p class="text-ink-muted text-sm">Konfigurasi umum Mading Indonesia.</p>
        </div>

        <form method="POST" action="{{ route('super-admin.settings.update') }}" class="space-y-5">
            @csrf
            @method('PUT')

            <div class="card p-6">
                <h3 class="font-bold text-ink mb-5 pb-4 border-b border-surface-border">Informasi</h3>

                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                    <div>
                        <dt class="text-ink-muted mb-1">Nama Aplikasi</dt>
                        <dd class="text-ink font-medium">{{ $config['app_name'] }}</dd>
                    </div>
                    <div>
                        <dt class="text-ink-muted mb-1">Warna Primer Default</dt>
                        <dd class="flex items-center gap-2">
                            <span class="w-5 h-5 rounded border border-surface-border" style="background: {{ $config['theme']['default_primary'] }}"></span>
                            <span class="font-mono text-ink">{{ $config['theme']['default_primary'] }}</span>
                        </dd>
                    </div>
                    <div>
                        <dt class="text-ink-muted mb-1">Warna Sekunder Default</dt>
                        <dd class="flex items-center gap-2">
                            <span class="w-5 h-5 rounded border border-surface-border" style="background: {{ $config['theme']['default_secondary'] }}"></span>
                            <span class="font-mono text-ink">{{ $config['theme']['default_secondary'] }}</span>
                        </dd>
                    </div>
                </dl>
            </div>

            <div class="card p-6">
                <h3 class="font-bold text-ink mb-5 pb-4 border-b border-surface-border">Pagination</h3>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 text-sm">
                    <div>
                        <div class="text-ink-muted mb-1">Public</div>
                        <div class="text-ink font-medium">{{ $config['pagination']['public'] }}</div>
                    </div>
                    <div>
                        <div class="text-ink-muted mb-1">Admin</div>
                        <div class="text-ink font-medium">{{ $config['pagination']['admin'] }}</div>
                    </div>
                    <div>
                        <div class="text-ink-muted mb-1">Member</div>
                        <div class="text-ink font-medium">{{ $config['pagination']['member'] }}</div>
                    </div>
                    <div>
                        <div class="text-ink-muted mb-1">Logs</div>
                        <div class="text-ink font-medium">{{ $config['pagination']['logs'] }}</div>
                    </div>
                </div>
            </div>

            <div class="alert alert-info flex items-start gap-2">
                <i data-lucide="info" class="w-5 h-5 flex-shrink-0 mt-0.5"></i>
                <div class="text-sm">
                    <strong class="block mb-0.5">Catatan:</strong>
                    Pengaturan ini masih read-only. Fitur edit settings akan ditambahkan di versi berikutnya.
                </div>
            </div>
        </form>
    </div>

@endsection