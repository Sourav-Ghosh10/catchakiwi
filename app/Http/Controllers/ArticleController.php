<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ads;

use App\Models\Article;
use App\Models\ArticleCategory;
use App\Models\ArticleComment;
use Illuminate\Support\Str;
use Auth;

class ArticleController extends Controller
{
    public function list(Request $request)
    {
        $query = Article::with(['user', 'category'])->published();

        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'like', '%' . $searchTerm . '%')
                  ->orWhere('content', 'like', '%' . $searchTerm . '%');
            });
        }

        $articles = $query->latest()->paginate(10);
        $categories = ArticleCategory::all();
        
        $ads = Ads::where('country', session('CountryCode'))->get();
        $grouped = collect($ads)->groupBy('type');
        $sideData = $grouped->get('side', []);

        $country_name = strtolower(session('CountryCode', 'NZ'));
        return view('frontend/artical/list', compact('articles', 'categories', 'sideData', 'country_name'));
    }

    public function categoryList(Request $request, $slug)
    {
        $category = ArticleCategory::where('slug', $slug)->firstOrFail();
        $query = Article::with(['user', 'category'])->where('category_id', $category->id)->published();

        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'like', '%' . $searchTerm . '%')
                  ->orWhere('content', 'like', '%' . $searchTerm . '%');
            });
        }

        if ($slug === 'start-here') {
            $articles = $query->oldest()->paginate(10);
        } else {
            $articles = $query->latest()->paginate(10);
        }
        $categories = ArticleCategory::all();
        
        $ads = Ads::where('country', session('CountryCode'))->get();
        $grouped = collect($ads)->groupBy('type');
        $sideData = $grouped->get('side', []);

        $country_name = strtolower(session('CountryCode', 'NZ'));
        return view('frontend/artical/list', compact('articles', 'categories', 'category', 'sideData', 'country_name'));
    }

    public function details($slug)
    {
        $article = Article::with(['user', 'category', 'comments.user'])->where('slug', $slug)->firstOrFail();
        $categories = ArticleCategory::all();
        
        // Track view
        $article->increment('views');

        $ads = Ads::where('country', session('CountryCode'))->get();
        $grouped = collect($ads)->groupBy('type');
        $sideData = $grouped->get('side', []);

        $country_name = strtolower(session('CountryCode', 'NZ'));
        return view('frontend/artical/details', compact('article', 'categories', 'sideData', 'country_name'));
    }

    public function add()
    {
        $categories = ArticleCategory::all();
        $ads = Ads::where('country', session('CountryCode'))->get();
        $grouped = collect($ads)->groupBy('type');
        $sideData = $grouped->get('side', []);

        $country_name = strtolower(session('CountryCode', 'NZ'));
        return view('frontend/artical/add', compact('categories', 'sideData', 'country_name'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:article_categories,id',
            'content' => 'required',
            'imageUpload' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:10240',
        ]);

        $article = new Article($request->all());
        $article->user_id = Auth::id();
        $article->status = 'pending';
        $article->slug = Str::slug($request->title) . '-' . uniqid();

        if ($request->hasFile('imageUpload') && $request->input('base64image')) {
            $base64_data = preg_replace('#^data:image/\w+;base64,#i', '', $request->input('base64image'));
            $binaryImageData = base64_decode($base64_data);
            $extension = $request->file('imageUpload')->getClientOriginalExtension();
            $imageName = uniqid() . '-' . time() . '.' . $extension;
            
            // Ensure directory exists
            if (!file_exists(public_path('images/articles'))) {
                mkdir(public_path('images/articles'), 0777, true);
            }

            $filePath = 'images/articles/' . $imageName;
            file_put_contents(public_path($filePath), $binaryImageData);
            $article->image = $filePath;
        }

        $article->save();

        return redirect('profile#parentHorizontalTab2')->with('success', 'Article submitted for review.');
    }

    public function postComment(Request $request, $article_id)
    {
        $request->validate(['content' => 'required']);
        
        ArticleComment::create([
            'article_id' => $article_id,
            'user_id' => Auth::id(),
            'content' => $request->content,
        ]);

        return redirect()->back()->with('success', 'Comment posted.');
    }

    public function myArticles()
    {
        $articles = Article::where('user_id', Auth::id())->latest()->get();
        return view('frontend/artical/my_articles', compact('articles'));
    }

    public function userEdit($id)
    {
        $article = Article::where('user_id', Auth::id())->findOrFail($id);
        $categories = ArticleCategory::all();
        return view('frontend/artical/user_edit', compact('article', 'categories'));
    }

    public function userUpdate(Request $request, $id)
    {
        $article = Article::where('user_id', Auth::id())->findOrFail($id);
        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:article_categories,id',
            'content' => 'required',
            'imageUpload' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:10240',
        ]);

        $article->update($request->only(['title', 'category_id', 'content']));
        $article->status = 'pending'; // Re-submit for review on edit

        // Handle image removal
        if ($request->input('remove_image') == '1') {
            if ($article->image && file_exists(public_path($article->image))) {
                unlink(public_path($article->image));
            }
            $article->image = null;
        }

        if ($request->hasFile('imageUpload') && $request->input('base64image')) {
            $base64_data = preg_replace('#^data:image/\w+;base64,#i', '', $request->input('base64image'));
            $binaryImageData = base64_decode($base64_data);
            $extension = $request->file('imageUpload')->getClientOriginalExtension();
            $imageName = uniqid() . '-' . time() . '.' . $extension;

            // Ensure directory exists
            if (!file_exists(public_path('images/articles'))) {
                mkdir(public_path('images/articles'), 0777, true);
            }

            $filePath = 'images/articles/' . $imageName;
            file_put_contents(public_path($filePath), $binaryImageData);
            $article->image = $filePath;
        }

        $article->save();

        return redirect('profile#parentHorizontalTab2')->with('success', 'Article updated and submitted for review.');
    }

    public function userDelete($id)
    {
        $article = Article::where('user_id', Auth::id())->findOrFail($id);
        
        // Delete the article image if it exists
        if ($article->image && file_exists(public_path($article->image))) {
            unlink(public_path($article->image));
        }
        
        // Delete associated comments
        $article->comments()->delete();
        
        // Delete the article
        $article->delete();

        return redirect('profile#parentHorizontalTab2')->with('success', 'Article deleted successfully.');
    }
}

