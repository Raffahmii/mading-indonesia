@extends('layouts.member')

@section('title', 'Profil')
@section('subtitle', 'Kelola informasi akunmu')

@section('content')

    <div class="max-w-2xl">
        <div class="mb-6">
            <h2 class="text-xl font-bold text-ink mb-1">Profil Saya</h2>
            <p class="text-ink-muted text-sm">Perbarui nama dan email akunmu.</p>
        </div>

        <div class="card p-6 lg:p-8">

            {{-- Avatar Section --}}
            <div class="flex items-center gap-4 pb-6 mb-6 border-b border-surface-border">
                <div class="avatar avatar-lg bg-brand-100 text-brand-700 font-bold text-xl">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <div>
                    <div class="font-semibold text-lg text-ink">{{ $user->name }}</div>
                    <div class="text-sm text-ink-muted">{{ $user->email }}</div>
                    <div class="text-xs text-ink-muted mt-1">
                        Bergabung {{ $user->created_at->diffForHumans() }}
                    </div>
                </div>
            </div>

            {{-- Form --}}
            <form method="POST" action="{{ route('member.profile.update') }}" class="space-y-5">
                @csrf
                @method('PUT')

                <div>
                    <label for="name" class="label">Nama Lengkap</label>
                    <input id="name"
                           type="text"
                           name="name"
                           value="{{ old('name', $user->name) }}"
                           required
                           class="input @error('name') input-error @enderror">
                    @error('name')
                        <p class="error-text">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="label">Email</label>
                    <input id="email"
                           type="email"
                           name="email"
                           value="{{ old('email', $user->email) }}"
                           required
                           class="input @error('email') input-error @enderror">
                    @error('email')
                        <p class="error-text">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-end gap-3 pt-2">
                    <button type="submit" class="btn btn-primary">
                        <i data-lucide="save" class="w-4 h-4"></i>
                        Simpan Perubahan
                    </button>
                </div>
            </form>

        </div>
    </div>

@endsection