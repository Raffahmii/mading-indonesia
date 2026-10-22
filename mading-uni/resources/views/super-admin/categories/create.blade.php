@extends('layouts.super-admin')

@section('title', 'Tambah Kategori')

@section('content')

    <div class="max-w-2xl">
        <a href="{{ route('super-admin.categories.index') }}" class="inline-flex items-center gap-1.5 text-sm text-ink-muted hover:text-ink mb-4">
            <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali
        </a>

        <h1 class="text-2xl font-bold text-ink mb-5">Tambah Kategori</h1>

        @if($errors->any())
            <div class="alert alert-error mb-5">
                <ul class="list-disc list-inside text-sm">
                    @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('super-admin.categories.store') }}" class="card p-6 space-y-5">
            @csrf

            <div>
                <label class="label">Nama <span class="text-danger">*</span></label>
                <input type="text" name="name" value="{{ old('name') }}" required class="input" placeholder="Contoh: Beasiswa">
            </div>

            <div>
                <label class="label">Deskripsi</label>
                <input type="text" name="description" value="{{ old('description') }}" class="input">
            </div>

            <div>
                <label class="label">Icon (Lucide)</label>
                <input type="text" name="icon" value="{{ old('icon', 'folder') }}" class="input font-mono" placeholder="folder">
                <p class="help-text">
                    Cari icon di <a href="https://lucide.dev/icons/" target="_blank" class="text-brand-700 hover:underline">lucide.dev/icons</a>.
                    Contoh: <code class="bg-surface-muted px-1.5 py-0.5 rounded">award</code>, <code class="bg-surface-muted px-1.5 py-0.5 rounded">trophy</code>.
                </p>
            </div>

            <label class="inline-flex items-center gap-2 cursor-pointer">
                <input type="checkbox" name="is_active" value="1" @checked(old('is_active', true)) class="rounded border-surface-border text-brand-700 focus:ring-brand-500">
                <span class="text-sm text-ink">Aktifkan kategori ini</span>
            </label>

            <div class="flex items-center justify-end gap-3 pt-2">
                <a href="{{ route('super-admin.categories.index') }}" class="btn btn-ghost">Batal</a>
                <button type="submit" class="btn btn-primary">
                    <i data-lucide="save" class="w-4 h-4"></i> Simpan
                </button>
            </div>
        </form>
    </div>

@endsection