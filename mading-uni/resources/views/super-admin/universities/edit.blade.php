@extends('layouts.super-admin')

@section('title', 'Edit Universitas')

@section('content')

    <div class="max-w-3xl">
        <div class="mb-6">
            <a href="{{ route('super-admin.universities.show', $university) }}"
               class="inline-flex items-center gap-1.5 text-sm text-ink-muted hover:text-ink mb-3">
                <i data-lucide="arrow-left" class="w-4 h-4"></i>
                Kembali
            </a>
            <h2 class="text-xl font-bold text-ink mb-1">Edit Universitas</h2>
            <p class="text-ink-muted text-sm">Perbarui informasi universitas.</p>
        </div>

        @if($errors->any())
            <div class="alert alert-error mb-5">
                <strong class="block mb-1">Ada masalah:</strong>
                <ul class="list-disc list-inside text-sm space-y-0.5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('super-admin.universities.update', $university) }}" class="space-y-5">
            @csrf
            @method('PUT')

            <div class="card p-6">
                <h3 class="font-bold text-ink mb-5 pb-4 border-b border-surface-border">Informasi Universitas</h3>

                <div class="space-y-4">
                    <div>
                        <label for="name" class="label">Nama Universitas <span class="text-danger">*</span></label>
                        <input id="name" type="text" name="name" value="{{ old('name', $university->name) }}" required
                               class="input @error('name') input-error @enderror">
                        @error('name') <p class="error-text">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="city" class="label">Kota</label>
                            <input id="city" type="text" name="city" value="{{ old('city', $university->city) }}" class="input">
                        </div>
                        <div>
                            <label for="phone" class="label">Telepon</label>
                            <input id="phone" type="text" name="phone" value="{{ old('phone', $university->phone) }}" class="input">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="email" class="label">Email</label>
                            <input id="email" type="email" name="email" value="{{ old('email', $university->email) }}" class="input">
                        </div>
                        <div>
                            <label for="website" class="label">Website</label>
                            <input id="website" type="url" name="website" value="{{ old('website', $university->website) }}" class="input">
                        </div>
                    </div>

                    <div>
                        <label for="address" class="label">Alamat</label>
                        <input id="address" type="text" name="address" value="{{ old('address', $university->address) }}" class="input">
                    </div>

                    <div>
                        <label for="description" class="label">Deskripsi</label>
                        <textarea id="description" name="description" rows="3" class="input">{{ old('description', $university->description) }}</textarea>
                    </div>
                </div>
            </div>

            {{-- Branding --}}
            <div class="card p-6">
                <h3 class="font-bold text-ink mb-5 pb-4 border-b border-surface-border">Branding</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="primary_color" class="label">Warna Primer <span class="text-danger">*</span></label>
                        <div class="flex items-center gap-2">
                            <input type="color"
                                   x-data
                                   x-model="$el.nextElementSibling.value"
                                   @input="$el.nextElementSibling.value = $event.target.value"
                                   value="{{ old('primary_color', $university->primary_color) }}"
                                   class="w-12 h-11 rounded-lg border border-surface-border cursor-pointer">
                            <input id="primary_color"
                                   type="text"
                                   name="primary_color"
                                   value="{{ old('primary_color', $university->primary_color) }}"
                                   required
                                   pattern="^#?[0-9A-Fa-f]{6}$"
                                   class="input font-mono"
                                   x-on:input="$el.previousElementSibling.value = $event.target.value">
                        </div>
                        @error('primary_color') <p class="error-text">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="secondary_color" class="label">Warna Sekunder <span class="text-danger">*</span></label>
                        <div class="flex items-center gap-2">
                            <input type="color"
                                   value="{{ old('secondary_color', $university->secondary_color) }}"
                                   x-on:input="$el.nextElementSibling.value = $event.target.value"
                                   class="w-12 h-11 rounded-lg border border-surface-border cursor-pointer">
                            <input id="secondary_color"
                                   type="text"
                                   name="secondary_color"
                                   value="{{ old('secondary_color', $university->secondary_color) }}"
                                   required
                                   pattern="^#?[0-9A-Fa-f]{6}$"
                                   class="input font-mono"
                                   x-on:input="$el.previousElementSibling.value = $event.target.value">
                        </div>
                        @error('secondary_color') <p class="error-text">{{ $message }}</p> @enderror
                    </div>
                </div>

                {{-- Preview --}}
                <div class="mt-5 rounded-2xl p-5 text-white"
                     style="background: linear-gradient(135deg, {{ $university->primary_color }} 0%, {{ $university->secondary_color }} 100%);">
                    <div class="text-sm font-medium opacity-90 mb-1">Preview Branding</div>
                    <div class="font-bold text-lg">{{ $university->name }}</div>
                </div>
            </div>

            {{-- Actions --}}
            <div class="flex items-center justify-between">
                <form method="POST" action="{{ route('super-admin.universities.destroy', $university) }}"
                      onsubmit="return confirm('Yakin ingin menghapus universitas ini? Tindakan ini tidak bisa dibatalkan.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-ghost text-danger hover:bg-red-50">
                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                        Hapus
                    </button>
                </form>

                <div class="flex gap-3">
                    <a href="{{ route('super-admin.universities.show', $university) }}" class="btn btn-ghost">Batal</a>
                    <button type="submit" class="btn btn-primary">
                        <i data-lucide="save" class="w-4 h-4"></i>
                        Simpan Perubahan
                    </button>
                </div>
            </div>

        </form>
    </div>

@endsection