<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('posts')
            ->orderBy('name')
            ->paginate(15);

        return view('super-admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('super-admin.categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100', 'unique:categories,name'],
            'description' => ['nullable', 'string', 'max:255'],
            'icon' => ['nullable', 'string', 'max:50'],
            'is_active' => ['boolean'],
        ]);

        Category::create($validated);

        return redirect()
            ->route('super-admin.categories.index')
            ->with('success', 'Kategori berhasil dibuat.');
    }

    public function show(Category $category)
    {
        $category->loadCount('posts');
        return view('super-admin.categories.show', compact('category'));
    }

    public function edit(Category $category)
    {
        return view('super-admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100', Rule::unique('categories', 'name')->ignore($category->id)],
            'description' => ['nullable', 'string', 'max:255'],
            'icon' => ['nullable', 'string', 'max:50'],
            'is_active' => ['boolean'],
        ]);

        $category->update($validated);

        return redirect()
            ->route('super-admin.categories.index')
            ->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Category $category)
    {
        if ($category->posts()->exists()) {
            return back()->withErrors(['error' => 'Kategori masih dipakai konten. Pindahkan konten dulu.']);
        }

        $category->delete();

        return redirect()
            ->route('super-admin.categories.index')
            ->with('success', 'Kategori berhasil dihapus.');
    }
}