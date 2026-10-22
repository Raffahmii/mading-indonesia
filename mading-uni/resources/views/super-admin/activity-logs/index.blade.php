@extends('layouts.super-admin')

@section('title', 'Activity Log')

@section('content')

    <div class="page-header">
        <div>
            <h1>Activity Log</h1>
            <p>Riwayat aktivitas sistem dan pengguna di platform.</p>
        </div>
    </div>

    <div class="card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="table-modern">
                <thead>
                    <tr>
                        <th>Waktu</th>
                        <th>User</th>
                        <th>Aksi</th>
                        <th>Subject</th>
                        <th class="text-right">IP</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $log)
                        <tr>
                            <td class="text-sm text-ink-muted whitespace-nowrap">
                                {{ $log->created_at->format('d M Y H:i') }}
                            </td>
                            <td>
                                @if($log->user)
                                    <div class="flex items-center gap-2">
                                        <div class="w-6 h-6 rounded-full bg-brand-100 text-brand-700 flex items-center justify-center text-[10px] font-bold">
                                            {{ strtoupper(substr($log->user->name, 0, 1)) }}
                                        </div>
                                        <span class="text-sm text-ink">{{ $log->user->name }}</span>
                                    </div>
                                @else
                                    <span class="text-sm text-ink-muted italic">System</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge badge-brand font-mono text-[10px]">{{ $log->action }}</span>
                            </td>
                            <td class="text-sm text-ink-muted">
                                @if($log->subject_type)
                                    {{ class_basename($log->subject_type) }} <span class="text-xs">#{{ $log->subject_id }}</span>
                                @else
                                    -
                                @endif
                            </td>
                            <td class="text-right text-xs text-ink-muted font-mono">{{ $log->ip_address ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center py-16 text-ink-muted">Belum ada aktivitas.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($logs->hasPages())
        <div class="mt-6 flex justify-center">{{ $logs->links() }}</div>
    @endif

@endsection