<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class CategoryController extends Controller
{
    
    public function index()
    {
      $categories = Category::with('parent', 'children')
        ->orderBy('parent_id', 'asc')
        ->orderBy('title', 'asc')
        ->get();

      return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        $parentCategories = Category::where('parent_id', 0)->get();
        return view('admin.categories.create', compact('parentCategories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'parent_id' => 'required|integer',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240'
        ]);

        $data = [
            'title' => $request->title,
            'title_url' => Str::slug($request->title),
            'parent_id' => $request->parent_id,
            'created_on' => now(),
            'modified_on' => now(),
            'views' => 0
        ];

        // Handle icon upload
        if ($request->hasFile('icon')) {
            $iconName = time() . '_' . $request->file('icon')->getClientOriginalName();
            $request->file('icon')->move(public_path('assets/images'), $iconName);
            $data['icon'] = $iconName;
        }

        Category::create($data);

        return redirect()->route('admin.categories.index')->with('success', 'Category created successfully!');
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        $parentCategories = Category::where('parent_id', 0)->where('id', '!=', $id)->get();
        return view('admin.categories.edit', compact('category', 'parentCategories'));
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        
        $request->validate([
            'title' => 'required|string|max:255',
            'parent_id' => 'required|integer',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240'
        ]);

        $data = [
            'title' => $request->title,
            'title_url' => Str::slug($request->title),
            'parent_id' => $request->parent_id,
            'modified_on' => now()
        ];

        // Handle icon upload
        if ($request->hasFile('icon')) {
            // Delete old icon if exists
            if ($category->icon && File::exists(public_path('assets/images/' . $category->icon))) {
                File::delete(public_path('assets/images/' . $category->icon));
            }
            
            $iconName = time() . '_' . $request->file('icon')->getClientOriginalName();
            $request->file('icon')->move(public_path('assets/images'), $iconName);
            $data['icon'] = $iconName;
        }

        $category->update($data);

        return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully!');
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        
        // Check if category has children
        $hasChildren = Category::where('parent_id', $id)->exists();
        if ($hasChildren) {
            return redirect()->route('admin.categories.index')->with('error', 'Cannot delete category that has subcategories!');
        }
        
        // Check if category is used in business
        $isUsed = \DB::table('business')
            ->where('primary_category', $id)
            ->orWhere('secondary_category', $id)
            ->exists();
            
        if ($isUsed) {
            return redirect()->route('admin.categories.index')->with('error', 'Cannot delete category that is being used by businesses!');
        }

        // Delete icon file if exists
        if ($category->icon && File::exists(public_path('assets/images/' . $category->icon))) {
            File::delete(public_path('assets/images/' . $category->icon));
        }

        $category->delete();

        return redirect()->route('admin.categories.index')->with('success', 'Category deleted successfully!');
    }
}