<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\ArticleCategory;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $sortBy = $request->get('sort', 'created_at');
        $sortOrder = $request->get('order', 'desc');

        $query = Article::with(['user', 'category']);

        // Handle sorting
        if ($sortBy == 'writer') {
            $query->join('users', 'articles.user_id', '=', 'users.id')
                  ->select('articles.*')
                  ->orderBy('users.name', $sortOrder);
        } elseif ($sortBy == 'category') {
            $query->join('article_categories', 'articles.category_id', '=', 'article_categories.id')
                  ->select('articles.*')
                  ->orderBy('article_categories.title', $sortOrder);
        } elseif (in_array($sortBy, ['title', 'status', 'views', 'published_at', 'created_at'])) {
            $query->orderBy($sortBy, $sortOrder);
        } else {
            $query->latest();
        }

        $articles = $query->get();
        return view('admin.articles.index', compact('articles', 'sortBy', 'sortOrder'));
    }

    public function edit($id)
    {
        $article = Article::findOrFail($id);
        $categories = ArticleCategory::all();
        return view('admin.articles.edit', compact('article', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $article = Article::findOrFail($id);
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'category_id' => 'required|exists:article_categories,id',
            'status' => 'required|in:pending,published,hidden',
        ]);

        $article->update($request->all());

        if ($request->status == 'published' && !$article->published_at) {
            $article->update(['published_at' => now()]);
        }

        return redirect()->route('admin.articles.index')->with('success', 'Article updated successfully');
    }

    public function changeStatus($id, $status)
    {
        $article = Article::findOrFail($id);
        if (in_array($status, ['published', 'hidden', 'pending'])) {
            $updateData = ['status' => $status];
            if ($status == 'published' && !$article->published_at) {
                $updateData['published_at'] = now();
            }
            $article->update($updateData);
        }
        return redirect()->back()->with('success', 'Status updated successfully');
    }
}
