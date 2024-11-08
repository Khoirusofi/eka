<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the categories.
     */
    public function index(Request $request)
{
    // Ambil parameter pencarian dari query string
    $search = $request->input('search');

    // Query untuk mencari kategori berdasarkan nama dan menghitung jumlah artikel terkait
    $categories = Category::when($search, function ($query, $search) {
        return $query->where('name', 'like', "%{$search}%");
    })->withCount('articles') // Menghitung jumlah artikel terkait
      ->paginate(10);

    return view('admins.categories.index', [
        'categories' => $categories,
        'search' => $search
    ]);
}

    /**
     * Show the form for creating a new category.
     */
    public function create()
    {
        return view('admins.categories.create');
    }

    /**
     * Store a newly created category in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Category::create($validated);

        return redirect()->route('admins.categories.index')
            ->with('success', __('Kategori berhasil ditambahkan.'));
    }

    /**
     * Show the form for editing the specified category.
     */
    public function edit(Category $category)
    {
        return view('admins.categories.edit', [
            'category' => $category
        ]);
    }

    /**
     * Update the specified category in storage.
     */
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category->update($validated);

        return redirect()->route('admins.categories.index')
            ->with('success', __('Kategori berhasil diperbarui.'));
    }

    /**
     * Remove the specified category from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('admins.categories.index')
            ->with('success', __('Kategori berhasil dihapus.'));
    }
}
