<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(): View
    {
        return view('admin.categories.index', [
            'categories' => Category::withCount('games')->orderBy('name')->paginate(10),
        ]);
    }

    public function create(): View
    {
        return view('admin.categories.create', ['category' => new Category]);
    }

    public function store(CategoryRequest $request): RedirectResponse
    {
        $category = Category::create($request->validated());

        return redirect()
            ->route('admin.categories.index')
            ->with('status', $category->name.' berhasil ditambahkan.');
    }

    public function edit(Category $category): View
    {
        return view('admin.categories.edit', ['category' => $category]);
    }

    public function update(CategoryRequest $request, Category $category): RedirectResponse
    {
        $category->update($request->validated());

        return redirect()
            ->route('admin.categories.index')
            ->with('status', $category->name.' berhasil diperbarui.');
    }

    public function destroy(Category $category): RedirectResponse
    {
        if ($category->games()->exists()) {
            return redirect()
                ->route('admin.categories.index')
                ->with('error', $category->name.' masih dipakai oleh game dan tidak bisa dihapus.');
        }

        $category->delete();

        return redirect()
            ->route('admin.categories.index')
            ->with('status', $category->name.' berhasil dihapus.');
    }
}
