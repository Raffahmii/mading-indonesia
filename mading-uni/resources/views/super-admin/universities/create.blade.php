@extends('layouts.super-admin')

@section('title', 'Tambah Universitas')

@section('content')

    <div class="max-w-3xl">
        <div class="mb-6">
            <a href="{{ route('super-admin.universities.index') }}"
               class="inline-flex items-center gap-1.5 text-sm text-ink-muted hover:text-ink mb-3">
                <i data-lucide="arrow-left" class="w-4 h-4"></i>
                Kembali
            </a>
            <h2 class="text-xl font-bold text-ink mb-1">Tambah Universitas</h2>
            <p class="text-ink-muted text-sm">Buat universitas baru + akun admin awal.</p>
        </div>

        @if($errors->any())
            <div class="alert alert-error mb-5">
                <strong class="block mb-1">Ada beberapa masalah:</strong>
                <ul class="list-disc list-inside text-sm space-y-0.5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('super-admin.universities.store') }}" class="space-y-5">
            @csrf

            {{-- SECTION: Info Universitas --}}
            <div class="card p-6">
                <div class="flex items-center gap-2 mb-5 pb-4 border-b border-surface-border">
                    <div class="w-9 h-9 rounded-xl bg-brand-50 text-brand-700 flex items-center justify-center">
                        <i data-lucide="building-2" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-ink">Informasi Universitas</h3>
                        <p class="text-xs text-ink-muted">Data dasar universitas.</p>
                    </div>
                </div>

                <div class="space-y-4">
                    <div>
                        <label for="name" class="label">Nama Universitas <span class="text-danger">*</span></label>
                        <input id="name" type="text" name="name" value="{{ old('name') }}" required
                               class="input @error('name') input-error @enderror"
                               placeholder="Contoh: Institut Teknologi Bandung">
                        @error('name') <p class="error-text">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="city" class="label">Kota</label>
                            <input id="city" type="text" name="city" value="{{ old('city') }}"
                                   class="input" placeholder="Bandung">
                        </div>
                        <div>
                            <label for="phone" class="label">Telepon</label>
                            <input id="phone" type="text" name="phone" value="{{ old('phone') }}"
                                   class="input" placeholder="+62 22 xxxx">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="email" class="label">Email</label>
                            <input id="email" type="email" name="email" value="{{ old('email') }}"
                                   class="input" placeholder="info@kampus.ac.id">
                        </div>
                        <div>
                            <label for="website" class="label">Website</label>
                            <input id="website" type="url" name="website" value="{{ old('website') }}"
                                   class="input" placeholder="https://kampus.ac.id">
                        </div>
                    </div>

                    <div>
                        <label for="address" class="label">Alamat</label>
                        <input id="address" type="text" name="address" value="{{ old('address') }}"
                               class="input" placeholder="Jl. ...">
                    </div>

                    <div>
                        <label for="description" class="label">Deskripsi</label>
                        <textarea id="description" name="description" rows="3"
                                  class="input" placeholder="Deskripsi singkat universitas...">{{ old('description') }}</textarea>
                    </div>
                </div>
            </div>

            {{-- SECTION: Branding --}}
            <div class="card p-6" x-data="{
                primary: '{{ old('primary_color', '#8E1EA2') }}',
                secondary: '{{ old('secondary_color', '#C654C3') }}'
            }">
                <div class="flex items-center gap-2 mb-5 pb-4 border-b border-surface-border">
                    <div class="w-9 h-9 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center">
                        <i data-lucide="palette" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-ink">Branding</h3>
                        <p class="text-xs text-ink-muted">Warna identitas universitas.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-5">
                    <div>
                        <label for="primary_color" class="label">Warna Primer <span class="text-danger">*</span></label>
                        <div class="flex items-center gap-2">
                            <input type="color" x-model="primary" class="w-12 h-11 rounded-lg border border-surface-border cursor-pointer">
                            <input id="primary_color"
                                   type="text"
                                   name="primary_color"
                                   x-model="primary"
                                   required
                                   pattern="^#?[0-9A-Fa-f]{6}$"
                                   class="input font-mono"
                                   placeholder="#8E1EA2">
                        </div>
                        @error('primary_color') <p class="error-text">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="secondary_color" class="label">Warna Sekunder <span class="text-danger">*</span></label>
                        <div class="flex items-center gap-2">
                            <input type="color" x-model="secondary" class="w-12 h-11 rounded-lg border border-surface-border cursor-pointer">
                            <input id="secondary_color"
                                   type="text"
                                   name="secondary_color"
                                   x-model="secondary"
                                   required
                                   pattern="^#?[0-9A-Fa-f]{6}$"
                                   class="input font-mono"
                                   placeholder="#C654C3">
                        </div>
                        @error('secondary_color') <p class="error-text">{{ $message }}</p> @enderror
                    </div>
                </div>

                {{-- Preview --}}
                <div class="rounded-2xl p-5 text-white"
                     :style="`background: linear-gradient(135deg, ${primary} 0%, ${secondary} 100%)`">
                    <div class="text-sm font-medium opacity-90 mb-1">Preview Branding</div>
                    <div class="font-bold text-lg" x-text="document.getElementById('name')?.value || 'Nama Universitas'"></div>
                    <div class="flex gap-2 mt-3">
                        <span class="px-3 py-1 rounded-full bg-white/20 text-xs">Badge</span>
                        <span class="px-3 py-1 rounded-full bg-white/20 text-xs">Tag</span>
                    </div>
                </div>
            </div>

            {{-- SECTION: Admin Awal --}}
            <div class="card p-6">
                <div class="flex items-center gap-2 mb-5 pb-4 border-b border-surface-border">
                    <div class="w-9 h-9 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                        <i data-lucide="user-cog" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-ink">Akun Admin Awal</h3>
                        <p class="text-xs text-ink-muted">Admin yang akan mengelola konten universitas ini.</p>
                    </div>
                </div>

                <div class="space-y-4">
                    <div>
                        <label for="admin_name" class="label">Nama Admin <span class="text-danger">*</span></label>
                        <input id="admin_name" type="text" name="admin_name" value="{{ old('admin_name') }}" required
                               class="input @error('admin_name') input-error @enderror"
                               placeholder="Nama lengkap admin">
                        @error('admin_name') <p class="error-text">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="admin_email" class="label">Email Admin <span class="text-danger">*</span></label>
                        <input id="admin_email" type="email" name="admin_email" value="{{ old('admin_email') }}" required
                               class="input @error('admin_email') input-error @enderror"
                               placeholder="admin@kampus.ac.id">
                        @error('admin_email') <p class="error-text">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="admin_password" class="label">Password Awal <span class="text-danger">*</span></label>
                        <input id="admin_password" type="text" name="admin_password" value="{{ old('admin_password') }}" required
                               minlength="8"
                               class="input font-mono @error('admin_password') input-error @enderror"
                               placeholder="Minimal 8 karakter">
                        <p class="help-text">Catat & beritahu admin. Password bisa diubah nanti.</p>
                        @error('admin_password') <p class="error-text">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            {{-- Actions --}}
            <div class="flex items-center justify-end gap-3">
                <a href="{{ route('super-admin.universities.index') }}" class="btn btn-ghost">Batal</a>
                <button type="submit" class="btn btn-primary">
                    <i data-lucide="save" class="w-4 h-4"></i>
                    Simpan Universitas
                </button>
            </div>

        </form>
    </div>

@endsection