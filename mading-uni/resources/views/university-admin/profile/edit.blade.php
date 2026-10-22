@extends('layouts.university-admin')

@section('title', 'Profil Universitas')

@section('content')

    <div class="max-w-3xl">
        <div class="page-header">
            <div>
                <h1>Profil Universitas</h1>
                <p>Perbarui informasi dan branding universitas kamu.</p>
            </div>
        </div>

        @if($errors->any())
            <div class="alert alert-error mb-5">
                <strong class="block mb-1">Ada masalah:</strong>
                <ul class="list-disc list-inside text-sm">
                    @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('university-admin.profile.update') }}" enctype="multipart/form-data" class="space-y-5">
            @csrf
            @method('PUT')

            {{-- Info --}}
            <div class="card p-6">
                <div class="flex items-center gap-2 mb-5 pb-4 border-b border-surface-border">
                    <div class="w-9 h-9 rounded-xl flex items-center justify-center"
                         style="background: color-mix(in srgb, var(--university-primary) 10%, transparent); color: var(--university-primary);">
                        <i data-lucide="building-2" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-ink">Informasi Universitas</h3>
                        <p class="text-xs text-ink-muted">Data dasar universitas.</p>
                    </div>
                </div>

                <div class="space-y-4">
                    <div>
                        <label class="label">Nama Universitas <span class="text-danger">*</span></label>
                        <input type="text" name="name" value="{{ old('name', $university->name) }}" required class="input">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="label">Kota</label>
                            <input type="text" name="city" value="{{ old('city', $university->city) }}" class="input">
                        </div>
                        <div>
                            <label class="label">Telepon</label>
                            <input type="text" name="phone" value="{{ old('phone', $university->phone) }}" class="input">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="label">Email</label>
                            <input type="email" name="email" value="{{ old('email', $university->email) }}" class="input">
                        </div>
                        <div>
                            <label class="label">Website</label>
                            <input type="url" name="website" value="{{ old('website', $university->website) }}" class="input">
                        </div>
                    </div>

                    <div>
                        <label class="label">Alamat</label>
                        <input type="text" name="address" value="{{ old('address', $university->address) }}" class="input">
                    </div>

                    <div>
                        <label class="label">Deskripsi</label>
                        <textarea name="description" rows="4" class="input">{{ old('description', $university->description) }}</textarea>
                    </div>
                </div>
            </div>

            {{-- Branding --}}
            <div class="card p-6">
                <div class="flex items-center gap-2 mb-5 pb-4 border-b border-surface-border">
                    <div class="w-9 h-9 rounded-xl flex items-center justify-center"
                         style="background: color-mix(in srgb, var(--university-primary) 10%, transparent); color: var(--university-primary);">
                        <i data-lucide="palette" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-ink">Branding</h3>
                        <p class="text-xs text-ink-muted">Warna identitas universitas.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="label">Warna Primer <span class="text-danger">*</span></label>
                        <div class="flex items-center gap-2">
                            <input type="color" value="{{ old('primary_color', $university->primary_color) }}"
                                   oninput="document.getElementById('primary_color').value = this.value"
                                   class="w-12 h-11 rounded-lg border border-surface-border cursor-pointer">
                            <input id="primary_color" type="text" name="primary_color" value="{{ old('primary_color', $university->primary_color) }}"
                                   required pattern="^#?[0-9A-Fa-f]{6}$" class="input font-mono">
                        </div>
                    </div>

                    <div>
                        <label class="label">Warna Sekunder <span class="text-danger">*</span></label>
                        <div class="flex items-center gap-2">
                            <input type="color" value="{{ old('secondary_color', $university->secondary_color) }}"
                                   oninput="document.getElementById('secondary_color').value = this.value"
                                   class="w-12 h-11 rounded-lg border border-surface-border cursor-pointer">
                            <input id="secondary_color" type="text" name="secondary_color" value="{{ old('secondary_color', $university->secondary_color) }}"
                                   required pattern="^#?[0-9A-Fa-f]{6}$" class="input font-mono">
                        </div>
                    </div>
                </div>

                <div class="mt-5">
                    <label class="label">Logo Universitas</label>
                    <input type="file" name="logo" accept="image/*" class="input">
                    <p class="help-text">Format: JPG, PNG, WebP, SVG. Maks 2MB.</p>

                    @if($university->logo_path)
                        <div class="mt-3 flex items-center gap-3 p-3 rounded-xl bg-surface-muted">
                            <img src="{{ $university->logo_url }}" alt="" class="w-12 h-12 rounded-lg object-contain bg-white p-1">
                            <div class="text-xs text-ink-muted">Logo saat ini</div>
                        </div>
                    @endif
                </div>
            </div>

            <div class="flex items-center justify-end gap-3">
                <button type="submit" class="btn btn-univ">
                    <i data-lucide="save" class="w-4 h-4"></i>
                    Simpan Perubahan
                </button>
            </div>

        </form>
    </div>

@endsection