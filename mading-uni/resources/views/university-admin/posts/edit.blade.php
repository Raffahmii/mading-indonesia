@extends('layouts.university-admin')

@section('title', 'Edit Konten')

@section('content')

    <div class="max-w-4xl">
        <a href="{{ route('university-admin.posts.show', $post) }}" class="inline-flex items-center gap-1.5 text-sm text-ink-muted hover:text-ink mb-4">
            <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali
        </a>

        <h1 class="text-2xl font-bold text-ink mb-5">Edit Konten</h1>

        @if($errors->any())
            <div class="alert alert-error mb-5">
                <ul class="list-disc list-inside text-sm">
                    @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('university-admin.posts.update', $post) }}" enctype="multipart/form-data" class="space-y-5">
            @csrf
            @method('PUT')

            <div class="card p-6">
                <h3 class="font-bold text-ink mb-5 pb-4 border-b border-surface-border">Informasi Konten</h3>

                <div class="space-y-4">
                    <div>
                        <label class="label">Judul <span class="text-danger">*</span></label>
                        <input type="text" name="title" value="{{ old('title', $post->title) }}" required class="input">
                    </div>

                    <div>
                        <label class="label">Kategori <span class="text-danger">*</span></label>
                        <select name="category_id" required class="input">
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" @selected(old('category_id', $post->category_id) == $cat->id)>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="label">Ringkasan (Excerpt)</label>
                        <textarea name="excerpt" rows="2" class="input">{{ old('excerpt', $post->excerpt) }}</textarea>
                    </div>

                    <div>
                        <label class="label">Isi Konten <span class="text-danger">*</span></label>
                        <textarea name="body" rows="10" required class="input">{{ old('body', $post->body) }}</textarea>
                    </div>
                </div>
            </div>

            <div class="card p-6">
                <h3 class="font-bold text-ink mb-5 pb-4 border-surface-border border-b">Media</h3>
                <div>
                    <label class="label">Cover Image</label>
                    <input type="file" name="cover" accept="image/*" class="input">
                    <p class="help-text">Kosongkan jika tidak diubah. Maks 4MB.</p>

                    @if($post->cover_image_path)
                        <div class="mt-3 flex items-center gap-3 p-3 rounded-xl bg-surface-muted">
                            <img src="{{ $post->cover_url }}" alt="" class="w-16 h-16 rounded-lg object-cover">
                            <div class="text-xs text-ink-muted">Cover saat ini</div>
                        </div>
                    @endif
                </div>
            </div>

            <div class="card p-6">
                <h3 class="font-bold text-ink mb-5 pb-4 border-surface-border border-b">Detail Event (Opsional)</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="label">Tanggal Mulai</label>
                        <input type="datetime-local" name="event_start" value="{{ old('event_start', $post->event_start?->format('Y-m-d\TH:i')) }}" class="input">
                    </div>
                    <div>
                        <label class="label">Tanggal Selesai</label>
                        <input type="datetime-local" name="event_end" value="{{ old('event_end', $post->event_end?->format('Y-m-d\TH:i')) }}" class="input">
                    </div>
                </div>

                <div>
                    <label class="label">Lokasi</label>
                    <input type="text" name="location" value="{{ old('location', $post->location) }}" class="input">
                </div>
            </div>

            <div class="flex items-center justify-end gap-3">
                <a href="{{ route('university-admin.posts.show', $post) }}" class="btn btn-ghost">Batal</a>
                <button type="submit" class="btn btn-univ">
                    <i data-lucide="save" class="w-4 h-4"></i> Simpan Perubahan
                </button>
            </div>

        </form>
    </div>

@endsection