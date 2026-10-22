@extends('layouts.super-admin')

@section('title', 'Tambah Admin')

@section('content')

    <div class="max-w-2xl">
        <div class="mb-6">
            <a href="{{ route('super-admin.admins.index') }}" class="inline-flex items-center gap-1.5 text-sm text-ink-muted hover:text-ink mb-3">
                <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali
            </a>
            <h1 class="text-2xl font-bold text-ink mb-1">Tambah Admin Universitas</h1>
            <p class="text-ink-muted text-sm">Buat akun admin untuk universitas tertentu.</p>
        </div>

        @if($errors->any())
            <div class="alert alert-error mb-5">
                <ul class="list-disc list-inside text-sm">
                    @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('super-admin.admins.store') }}" class="card p-6 space-y-5">
            @csrf

            <div>
                <label class="label">Universitas <span class="text-danger">*</span></label>
                <select name="university_id" required class="input @error('university_id') input-error @enderror">
                    <option value="">-- Pilih Universitas --</option>
                    @foreach($universities as $univ)
                        <option value="{{ $univ->id }}" @selected(old('university_id') == $univ->id)>{{ $univ->name }}</option>
                    @endforeach
                </select>
                @error('university_id') <p class="error-text">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="label">Nama Admin <span class="text-danger">*</span></label>
                <input type="text" name="name" value="{{ old('name') }}" required class="input @error('name') input-error @enderror" placeholder="Nama lengkap">
                @error('name') <p class="error-text">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="label">Email <span class="text-danger">*</span></label>
                <input type="email" name="email" value="{{ old('email') }}" required class="input @error('email') input-error @enderror" placeholder="admin@kampus.ac.id">
                @error('email') <p class="error-text">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="label">Password <span class="text-danger">*</span></label>
                <input type="text" name="password" value="{{ old('password') }}" required minlength="8" class="input font-mono @error('password') input-error @enderror" placeholder="Minimal 8 karakter">
                <p class="help-text">Catat & beritahu admin.</p>
                @error('password') <p class="error-text">{{ $message }}</p> @enderror
            </div>

            <div class="flex items-center justify-end gap-3 pt-2">
                <a href="{{ route('super-admin.admins.index') }}" class="btn btn-ghost">Batal</a>
                <button type="submit" class="btn btn-primary">
                    <i data-lucide="save" class="w-4 h-4"></i> Simpan
                </button>
            </div>
        </form>
    </div>

@endsection