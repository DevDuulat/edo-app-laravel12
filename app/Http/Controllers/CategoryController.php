<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::query()->paginate(10);
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
        ]);

        Category::create($validated);

        return redirect()
            ->route('admin.categories.index')
            ->with('alert', [
                'type' => 'success',
                'message' => __('Категория успешно добавлена')
            ]);
    }

    public function show(Category $category)
    {
        return view('admin.categories.show', compact('category'));
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required',
        ]);

        $category->update($validated);

        return redirect()
            ->route('admin.categories.index')
            ->with('alert', [
                'type' => 'success',
                'message' => __('Категория успешно обновлена')
            ]);
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()
            ->route('admin.categories.index')
            ->with('alert', [
                'type' => 'success',
                'message' => __('Категория успешно удалена')
            ]);
    }


}
