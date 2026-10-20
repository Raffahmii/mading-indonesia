@extends('layouts.member')

@section('title', 'Password')
@section('subtitle', 'Ubah password akunmu')

@section('content')

    <div class="max-w-2xl">
        <div class="mb-6">
            <h2 class="text-xl font-bold text-ink mb-1">Ubah Password</h2>
            <p class="text-ink-muted text-sm">Pastikan password baru kamu kuat dan mudah diingat.</p>
        </div>

        <div class="card p-6 lg:p-8">

            <div class="alert alert-warning mb-6 flex items-start gap-2">
                <i data-lucide="alert-triangle" class="w-5 h-5 flex-shrink-0 mt-0.5"></i>
                <div class="text-sm">
                    <strong class="block mb-0.5">Tips password kuat:</strong>
                    Minimal 8 karakter, kombinasikan huruf besar, huruf kecil, angka, dan simbol.
                </div>
            </div>

            <form method="POST" action="{{ route('member.password.update') }}" class="space-y-5">
                @csrf
                @method('PUT')

                <div>
                    <label for="current_password" class="label">Password Saat Ini</label>
                    <input id="current_password"
                           type="password"
                           name="current_password"
                           required
                           autocomplete="current-password"
                           class="input @error('current_password') input-error @enderror">
                    @error('current_password')
                        <p class="error-text">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="label">Password Baru</label>
                    <input id="password"
                           type="password"
                           name="password"
                           required
                           autocomplete="new-password"
                           class="input @error('password') input-error @enderror">
                    <p class="help-text">Minimal 8 karakter.</p>
                    @error('password')
                        <p class="error-text">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="label">Konfirmasi Password Baru</label>
                    <input id="password_confirmation"
                           type="password"
                           name="password_confirmation"
                           required
                           autocomplete="new-password"
                           class="input">
                </div>

                <div class="flex items-center justify-end gap-3 pt-2">
                    <button type="submit" class="btn btn-primary">
                        <i data-lucide="shield-check" class="w-4 h-4"></i>
                        Ubah Password
                    </button>
                </div>
            </form>

        </div>
    </div>

@endsection