@extends('layouts.university-admin')

@section('title', 'Buat Konten')

@section('content')

    <div class="max-w-4xl">
        <a href="{{ route('university-admin.posts.index') }}" class="inline-flex items-center gap-1.5 text-sm text-ink-muted hover:text-ink mb-4">
            <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali
        </a>

        <h1 class="text-2xl font-bold text-ink mb-5">Buat Konten Baru</h1>

        @if($errors->any())
            <div class="alert alert-error mb-5">
                <ul class="list-disc list-inside text-sm">
                    @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('university-admin.posts.store') }}" enctype="multipart/form-data" class="space-y-5">
            @csrf

            {{-- Info Konten --}}
            <div class="card p-6">
                <h3 class="font-bold text-ink mb-5 pb-4 border-b border-surface-border">Informasi Konten</h3>

                <div class="space-y-4">
                    <div>
                        <label class="label">Judul <span class="text-danger">*</span></label>
                        <input type="text" name="title" value="{{ old('title') }}" required class="input @error('title') input-error @enderror" placeholder="Judul konten...">
                        @error('title') <p class="error-text">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="label">Kategori <span class="text-danger">*</span></label>
                        <select name="category_id" required class="input @error('category_id') input-error @enderror">
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" @selected(old('category_id') == $cat->id)>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id') <p class="error-text">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="label">Ringkasan (Excerpt)</label>
                        <textarea name="excerpt" rows="2" class="input" placeholder="Ringkasan singkat konten...">{{ old('excerpt') }}</textarea>
                    </div>

                    <div>
                        <label class="label">Isi Konten <span class="text-danger">*</span></label>
                        <textarea name="body" rows="10" required class="input @error('body') input-error @enderror" placeholder="Tulis isi konten di sini...">{{ old('body') }}</textarea>
                        @error('body') <p class="error-text">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            {{-- Media --}}
            <div class="card p-6">
                <h3 class="font-bold text-ink mb-5 pb-4 border-surface-border border-b">Media</h3>
                <div>
                    <label class="label">Cover Image</label>
                    <input type="file" name="cover" accept="image/*" class="input">
                    <p class="help-text">Format: JPG, PNG, WebP. Maks 4MB.</p>
                </div>
            </div>

            {{-- Event Detail (Opsional) --}}
            <div class="card p-6">
                <h3 class="font-bold text-ink mb-5 pb-4 border-surface-border border-b">Detail Event (Opsional)</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="label">Tanggal Mulai</label>
                        <input type="datetime-local" name="event_start" value="{{ old('event_start') }}" class="input">
                    </div>
                    <div>
                        <label class="label">Tanggal Selesai</label>
                        <input type="datetime-local" name="event_end" value="{{ old('event_end') }}" class="input">
                    </div>
                </div>

                <div>
                    <label class="label">Lokasi</label>
                    <input type="text" name="location" value="{{ old('location') }}" class="input" placeholder="Contoh: Auditorium Kampus">
                </div>
            </div>

            <div class="flex items-center justify-end gap-3">
                <a href="{{ route('university-admin.posts.index') }}" class="btn btn-ghost">Batal</a>
                <button type="submit" class="btn btn-univ">
                    <i data-lucide="save" class="w-4 h-4"></i> Simpan sebagai Draft
                </button>
            </div>

        </form>
    </div>

@endsection