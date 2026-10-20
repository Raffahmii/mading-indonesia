@extends('layouts.super-admin')

@section('title', 'Kategori')

@section('content')

    <div class="flex items-center justify-between mb-5 flex-wrap gap-3">
        <div>
            <h2 class="text-xl font-bold text-ink">Kategori Konten</h2>
            <p class="text-ink-muted text-sm">Kelola kategori untuk konten.</p>
        </div>
        <a href="{{ route('super-admin.categories.create') }}" class="btn btn-primary">
            <i data-lucide="plus" class="w-4 h-4"></i>
            Tambah Kategori
        </a>
    </div>

    <div class="card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="table-modern">
                <thead>
                    <tr>
                        <th class="w-16"></th>
                        <th>Nama</th>
                        <th>Slug</th>
                        <th class="text-center">Konten</th>
                        <th>Status</th>
                        <th class="text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                        <tr>
                            <td>
                                <div class="w-10 h-10 rounded-xl bg-brand-50 text-brand-700 flex items-center justify-center">
                                    <i data-lucide="{{ $category->icon ?? 'folder' }}" class="w-5 h-5"></i>
                                </div>
                            </td>
                            <td>
                                <div class="font-medium text-ink">{{ $category->name }}</div>
                                @if($category->description)
                                    <div class="text-xs text-ink-muted line-clamp-1">{{ $category->description }}</div>
                                @endif
                            </td>
                            <td class="text-sm text-ink-muted font-mono">{{ $category->slug }}</td>
                            <td class="text-center">
                                <span class="badge badge-brand">{{ $category->posts_count }}</span>
                            </td>
                            <td>
                                @if($category->is_active)
                                    <span class="badge badge-green">Aktif</span>
                                @else
                                    <span class="badge badge-gray">Nonaktif</span>
                                @endif
                            </td>
                            <td>
                                <div class="flex items-center justify-end gap-1">
                                    <a href="{{ route('super-admin.categories.edit', $category) }}"
                                       class="p-2 rounded-lg text-ink-muted hover:text-blue-600 hover:bg-blue-50 transition">
                                        <i data-lucide="pencil" class="w-4 h-4"></i>
                                    </a>
                                    <form method="POST" action="{{ route('super-admin.categories.destroy', $category) }}"
                                          onsubmit="return confirm('Hapus kategori ini?')" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="p-2 rounded-lg text-ink-muted hover:text-danger hover:bg-red-50 transition">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-12 text-ink-muted">
                                Belum ada kategori.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($categories->hasPages())
        <div class="mt-5 flex justify-center">
            {{ $categories->links() }}
        </div>
    @endif

@endsection