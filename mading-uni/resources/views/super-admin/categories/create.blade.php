@extends('layouts.super-admin')

@section('title', 'Tambah Kategori')

@section('content')

    <div class="max-w-2xl">
        <a href="{{ route('super-admin.categories.index') }}"
           class="inline-flex items-center gap-1.5 text-sm text-ink-muted hover:text-ink mb-4">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            Kembali
        </a>

        <h2 class="text-xl font-bold text-ink mb-5">Tambah Kategori</h2>

        @if($errors->any())
            <div class="alert alert-error mb-5">
                <ul class="list-disc list-inside text-sm">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('super-admin.categories.store') }}" class="card p-6 space-y-5">
            @csrf

            <div>
                <label for="name" class="label">Nama Kategori <span class="text-danger">*</span></label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required
                       class="input @error('name') input-error @enderror"
                       placeholder="Contoh: Beasiswa">
                @error('name') <p class="error-text">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="description" class="label">Deskripsi</label>
                <input id="description" type="text" name="description" value="{{ old('description') }}"
                       class="input" placeholder="Deskripsi singkat">
            </div>

            <div>
                <label for="icon" class="label">Icon (Lucide)</label>
                <input id="icon" type="text" name="icon" value="{{ old('icon', 'folder') }}"
                       class="input font-mono" placeholder="folder">
                <p class="help-text">
                    Cari nama icon di
                    <a href="https://lucide.dev/icons/" target="_blank" class="text-brand-700 hover:underline">lucide.dev/icons</a>.
                    Contoh: <code class="text-xs bg-surface-muted px-1.5 py-0.5 rounded">award</code>,
                    <code class="text-xs bg-surface-muted px-1.5 py-0.5 rounded">trophy</code>.
                </p>
            </div>

            <div>
                <label class="inline-flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" @checked(old('is_active', true))
                           class="rounded border-surface-border text-brand-700 focus:ring-brand-500">
                    <span class="text-sm text-ink">Aktifkan kategori ini</span>
                </label>
            </div>

            <div class="flex items-center justify-end gap-3 pt-2">
                <a href="{{ route('super-admin.categories.index') }}" class="btn btn-ghost">Batal</a>
                <button type="submit" class="btn btn-primary">
                    <i data-lucide="save" class="w-4 h-4"></i>
                    Simpan
                </button>
            </div>
        </form>
    </div>

@endsection