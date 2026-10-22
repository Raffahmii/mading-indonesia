@extends('layouts.super-admin')

@section('title', 'Kategori')

@section('content')

    <div class="page-header">
        <div>
            <h1>Kategori Konten</h1>
            <p>Kelola kategori untuk konten.</p>
        </div>
        <a href="{{ route('super-admin.categories.create') }}" class="btn btn-primary">
            <i data-lucide="plus" class="w-4 h-4"></i> Tambah Kategori
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
                        <th class="text-right w-24">Aksi</th>
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
                            <td class="text-center"><span class="badge badge-brand">{{ $category->posts_count }}</span></td>
                            <td>
                                @if($category->is_active)
                                    <span class="badge badge-green">Aktif</span>
                                @else
                                    <span class="badge badge-gray">Nonaktif</span>
                                @endif
                            </td>
                            <td>
                                <div class="flex items-center justify-end gap-1">
                                    <a href="{{ route('super-admin.categories.edit', $category) }}" class="btn-icon btn-icon-blue" title="Edit">
                                        <i data-lucide="pencil" class="w-4 h-4"></i>
                                    </a>
                                    <form method="POST" action="{{ route('super-admin.categories.destroy', $category) }}" onsubmit="return confirm('Hapus kategori ini?')" class="inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn-icon btn-icon-danger" title="Hapus">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center py-16 text-ink-muted">Belum ada kategori.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($categories->hasPages())
        <div class="mt-6 flex justify-center">{{ $categories->links() }}</div>
    @endif

@endsection