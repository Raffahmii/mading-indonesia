@extends('layouts.university-admin')

@section('title', 'Akun Saya')

@section('content')

    <div class="max-w-2xl space-y-6">

        <div class="page-header">
            <div>
                <h1>Akun Saya</h1>
                <p>Kelola informasi akun dan password kamu.</p>
            </div>
        </div>

        {{-- Profil --}}
        <div class="card p-6">
            <div class="flex items-center gap-2 mb-5 pb-4 border-b border-surface-border">
                <div class="w-9 h-9 rounded-xl flex items-center justify-center"
                     style="background: color-mix(in srgb, var(--university-primary) 10%, transparent); color: var(--university-primary);">
                    <i data-lucide="user" class="w-5 h-5"></i>
                </div>
                <div>
                    <h3 class="font-bold text-ink">Informasi Profil</h3>
                    <p class="text-xs text-ink-muted">Nama dan email akun.</p>
                </div>
            </div>

            <form method="POST" action="{{ route('university-admin.account.update') }}" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="label">Nama Lengkap <span class="text-danger">*</span></label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="input @error('name') input-error @enderror">
                    @error('name') <p class="error-text">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="label">Email <span class="text-danger">*</span></label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="input @error('email') input-error @enderror">
                    @error('email') <p class="error-text">{{ $message }}</p> @enderror
                </div>

                <div class="flex justify-end pt-2">
                    <button type="submit" class="btn btn-univ">
                        <i data-lucide="save" class="w-4 h-4"></i>
                        Simpan Profil
                    </button>
                </div>
            </form>
        </div>

        {{-- Password --}}
        <div class="card p-6">
            <div class="flex items-center gap-2 mb-5 pb-4 border-b border-surface-border">
                <div class="w-9 h-9 rounded-xl flex items-center justify-center bg-red-50 text-red-600">
                    <i data-lucide="lock" class="w-5 h-5"></i>
                </div>
                <div>
                    <h3 class="font-bold text-ink">Ubah Password</h3>
                    <p class="text-xs text-ink-muted">Ganti password secara berkala untuk keamanan.</p>
                </div>
            </div>

            <form method="POST" action="{{ route('university-admin.account.password') }}" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="label">Password Saat Ini <span class="text-danger">*</span></label>
                    <input type="password" name="current_password" required class="input @error('current_password') input-error @enderror">
                    @error('current_password') <p class="error-text">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="label">Password Baru <span class="text-danger">*</span></label>
                    <input type="password" name="password" required minlength="8" class="input @error('password') input-error @enderror">
                    <p class="help-text">Minimal 8 karakter.</p>
                    @error('password') <p class="error-text">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="label">Konfirmasi Password Baru <span class="text-danger">*</span></label>
                    <input type="password" name="password_confirmation" required class="input">
                </div>

                <div class="flex justify-end pt-2">
                    <button type="submit" class="btn btn-univ">
                        <i data-lucide="shield-check" class="w-4 h-4"></i>
                        Ubah Password
                    </button>
                </div>
            </form>
        </div>

    </div>

@endsection