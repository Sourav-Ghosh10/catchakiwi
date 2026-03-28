<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ArticleCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ArticleCategoryController extends Controller
{
    public function index()
    {
        $categories = ArticleCategory::all();
        return view('admin.article_categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255|unique:article_categories,title',
            'description' => 'nullable|string',
        ]);

        ArticleCategory::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'description' => $request->description,
        ]);

        return redirect()->back()->with('success', 'Category created successfully');
    }

    public function update(Request $request, $id)
    {
        $category = ArticleCategory::findOrFail($id);
        $request->validate([
            'title' => 'required|string|max:255|unique:article_categories,title,' . $id,
            'description' => 'nullable|string',
        ]);

        $category->update([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'description' => $request->description,
        ]);

        return redirect()->back()->with('success', 'Category updated successfully');
    }

    public function destroy($id)
    {
        $category = ArticleCategory::findOrFail($id);
        $category->delete();
        return redirect()->back()->with('success', 'Category deleted successfully');
    }
}
