@extends('layouts.super-admin')

@section('title', 'Edit Kategori')

@section('content')

    <div class="max-w-2xl">
        <a href="{{ route('super-admin.categories.index') }}" class="inline-flex items-center gap-1.5 text-sm text-ink-muted hover:text-ink mb-4">
            <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali
        </a>

        <h1 class="text-2xl font-bold text-ink mb-5">Edit Kategori</h1>

        @if($errors->any())
            <div class="alert alert-error mb-5">
                <ul class="list-disc list-inside text-sm">
                    @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('super-admin.categories.update', $category) }}" class="card p-6 space-y-5">
            @csrf @method('PUT')

            <div>
                <label class="label">Nama <span class="text-danger">*</span></label>
                <input type="text" name="name" value="{{ old('name', $category->name) }}" required class="input">
            </div>

            <div>
                <label class="label">Deskripsi</label>
                <input type="text" name="description" value="{{ old('description', $category->description) }}" class="input">
            </div>

            <div>
                <label class="label">Icon (Lucide)</label>
                <input type="text" name="icon" value="{{ old('icon', $category->icon) }}" class="input font-mono">
            </div>

            <label class="inline-flex items-center gap-2 cursor-pointer">
                <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $category->is_active)) class="rounded border-surface-border text-brand-700 focus:ring-brand-500">
                <span class="text-sm text-ink">Aktifkan kategori ini</span>
            </label>

            <div class="flex items-center justify-between pt-2">
                <form method="POST" action="{{ route('super-admin.categories.destroy', $category) }}" onsubmit="return confirm('Hapus kategori ini?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-ghost text-danger hover:bg-red-50">
                        <i data-lucide="trash-2" class="w-4 h-4"></i> Hapus
                    </button>
                </form>
                <div class="flex gap-3">
                    <a href="{{ route('super-admin.categories.index') }}" class="btn btn-ghost">Batal</a>
                    <button type="submit" class="btn btn-primary">
                        <i data-lucide="save" class="w-4 h-4"></i> Simpan
                    </button>
                </div>
            </div>
        </form>
    </div>

@endsection