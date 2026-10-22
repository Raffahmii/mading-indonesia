@extends('layouts.super-admin')

@section('title', 'Edit Admin')

@section('content')

    <div class="max-w-2xl">
        <a href="{{ route('super-admin.admins.index') }}" class="inline-flex items-center gap-1.5 text-sm text-ink-muted hover:text-ink mb-4">
            <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali
        </a>

        <h1 class="text-2xl font-bold text-ink mb-5">Edit Admin</h1>

        @if($errors->any())
            <div class="alert alert-error mb-5">
                <ul class="list-disc list-inside text-sm">
                    @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('super-admin.admins.update', $admin) }}" class="card p-6 space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label class="label">Universitas <span class="text-danger">*</span></label>
                <select name="university_id" required class="input">
                    @foreach($universities as $univ)
                        <option value="{{ $univ->id }}" @selected(old('university_id', $admin->university_id) == $univ->id)>{{ $univ->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="label">Nama <span class="text-danger">*</span></label>
                <input type="text" name="name" value="{{ old('name', $admin->name) }}" required class="input">
            </div>

            <div>
                <label class="label">Email <span class="text-danger">*</span></label>
                <input type="email" name="email" value="{{ old('email', $admin->email) }}" required class="input">
            </div>

            <div>
                <label class="label">Password Baru</label>
                <input type="text" name="password" minlength="8" class="input font-mono" placeholder="Kosongkan jika tidak diubah">
            </div>

            <div class="flex items-center justify-between pt-2">
                <form method="POST" action="{{ route('super-admin.admins.destroy', $admin) }}" onsubmit="return confirm('Hapus admin ini?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-ghost text-danger hover:bg-red-50">
                        <i data-lucide="trash-2" class="w-4 h-4"></i> Hapus
                    </button>
                </form>
                <div class="flex gap-3">
                    <a href="{{ route('super-admin.admins.index') }}" class="btn btn-ghost">Batal</a>
                    <button type="submit" class="btn btn-primary">
                        <i data-lucide="save" class="w-4 h-4"></i> Simpan
                    </button>
                </div>
            </div>
        </form>
    </div>

@endsection