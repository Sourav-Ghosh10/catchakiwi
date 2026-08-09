<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NoticeCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class NoticeCategoryController extends Controller
{
    public function index()
    {
        $categories = NoticeCategory::all();

        return view('admin.notice_categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category' => 'required|string|max:255|unique:notice_category,category',
            'subtitle' => 'nullable|string|max:255',
            'color' => 'nullable|string|max:255',
            'type' => 'nullable|string|max:255',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = $request->only(['category', 'subtitle', 'color', 'type']);
        $data['slug'] = Str::slug($request->category);
        $data['is_new'] = $request->has('is_new');
        $data['is_active'] = $request->has('is_active');
        $data['status'] = 1;

        if ($request->hasFile('icon')) {
            $imageName = time().'.'.$request->icon->extension();
            $request->icon->move(public_path('assets/images/notice'), $imageName);
            $data['icon'] = 'assets/images/notice/'.$imageName;
        }

        NoticeCategory::create($data);

        return redirect()->back()->with('success', 'Notice Category created successfully');
    }

    public function update(Request $request, $id)
    {
        $category = NoticeCategory::findOrFail($id);
        $request->validate([
            'category' => 'required|string|max:255|unique:notice_category,category,'.$id,
            'subtitle' => 'nullable|string|max:255',
            'color' => 'nullable|string|max:255',
            'type' => 'nullable|string|max:255',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = $request->only(['category', 'subtitle', 'color', 'type']);
        $data['slug'] = Str::slug($request->category);
        $data['is_new'] = $request->has('is_new');
        $data['is_active'] = $request->has('is_active');

        if ($request->hasFile('icon')) {
            $imageName = time().'.'.$request->icon->extension();
            $request->icon->move(public_path('assets/images/notice'), $imageName);
            $data['icon'] = 'assets/images/notice/'.$imageName;
        }

        $category->update($data);

        return redirect()->back()->with('success', 'Notice Category updated successfully');
    }

    public function destroy($id)
    {
        $category = NoticeCategory::findOrFail($id);
        $category->delete();

        return redirect()->back()->with('success', 'Notice Category deleted successfully');
    }
}
