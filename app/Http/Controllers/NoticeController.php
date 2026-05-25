<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NoticeController extends Controller
{
    public function noticeBoard(Request $request, $categoryParam = null)
    {
        $ads = \App\Models\Ads::where('country', session('CountryCode'))->get();
        $grouped = collect($ads)->groupBy('type');
        $sideData = $grouped->get('side', []);

        if (!$categoryParam) {
            $categoryParam = $request->input('category');
        }
        $search = $request->input('search');

        $categories = \Illuminate\Support\Facades\DB::table('notice_category')
            ->select('notice_category.*', \Illuminate\Support\Facades\DB::raw('(SELECT COUNT(*) FROM notice WHERE notice.category_id = notice_category.id) as notices_count'))
            ->get();

        $activeCategory = null;
        if ($categoryParam) {
            if (is_numeric($categoryParam)) {
                $activeCategory = $categories->firstWhere('id', $categoryParam);
            } else {
                $activeCategory = $categories->firstWhere('slug', $categoryParam);
            }
        }
        $categoryId = $activeCategory ? $activeCategory->id : null;

        $noticesQuery = \Illuminate\Support\Facades\DB::table('notice')
            ->join('notice_category', 'notice_category.id', '=', 'notice.category_id')
            ->leftJoin('users', 'users.id', '=', 'notice.user_id')
            ->select('notice.*', 'notice_category.category as category_name', 'users.name as user_name')
            ->orderBy('notice.created_at', 'desc');

        if ($categoryId) {
            $noticesQuery->where('notice.category_id', $categoryId);
        }

        if ($search) {
            $noticesQuery->where(function($q) use ($search) {
                $q->where('notice.heading', 'like', "%{$search}%")
                  ->orWhere('notice.content', 'like', "%{$search}%");
            });
        }

        $notices = $noticesQuery->get();

        // Fetch images
        $noticeIds = $notices->pluck('id');
        $noticeImages = \Illuminate\Support\Facades\DB::table('notice_image')
            ->whereIn('notice_id', $noticeIds)
            ->get()
            ->groupBy('notice_id');

        return view('frontend/noticeboard', compact('sideData', 'categories', 'notices', 'noticeImages', 'activeCategory', 'search'));
    }

    public function noticeBoardV2(Request $request)
    {
        $ads = \App\Models\Ads::where('country', session('CountryCode'))->get();
        $grouped = collect($ads)->groupBy('type');
        $sideData = $grouped->get('side', []);

        $search = $request->input('search');
        $categoryParam = $request->input('category');

        // Fetch categories with counts
        $categories = \Illuminate\Support\Facades\DB::table('notice_category')
            ->select('notice_category.*', \Illuminate\Support\Facades\DB::raw('(SELECT COUNT(*) FROM notice WHERE notice.category_id = notice_category.id) as notices_count'))
            ->get();

        $activeCategory = null;
        if ($categoryParam) {
            if (is_numeric($categoryParam)) {
                $activeCategory = $categories->firstWhere('id', $categoryParam);
            } else {
                $activeCategory = $categories->firstWhere('slug', $categoryParam);
            }
        }
        $categoryId = $activeCategory ? $activeCategory->id : null;

        // Fetch latest notices
        $latestNoticesQuery = \Illuminate\Support\Facades\DB::table('notice')
            ->join('notice_category', 'notice_category.id', '=', 'notice.category_id')
            ->select('notice.*', 'notice_category.category as category_name')
            ->orderBy('notice.created_at', 'desc');

        if ($search) {
            $latestNoticesQuery->where(function($q) use ($search) {
                $q->where('notice.heading', 'like', "%{$search}%")
                  ->orWhere('notice.content', 'like', "%{$search}%");
            });
        }

        if ($categoryId) {
            $latestNoticesQuery->where('notice.category_id', $categoryId);
        }

        $latestNotices = $latestNoticesQuery->limit(10)->get();

        // Fetch spotlight notice ($5 Service Deal - ID 1)
        $spotlightNotice = \Illuminate\Support\Facades\DB::table('notice')
            ->where('category_id', 1)
            ->orderBy('created_at', 'desc')
            ->first();

        // Fetch images for these notices
        $noticeIds = $latestNotices->pluck('id');
        $noticeImages = \Illuminate\Support\Facades\DB::table('notice_image')
            ->whereIn('notice_id', $noticeIds)
            ->get()
            ->groupBy('notice_id');

        return view('frontend/noticeboard_v2', compact('sideData', 'categories', 'latestNotices', 'search', 'categoryId', 'noticeImages', 'spotlightNotice'));
    }

    public function incrementView($id)
    {
        \Illuminate\Support\Facades\DB::table('notice')
            ->where('id', $id)
            ->update(['views' => \Illuminate\Support\Facades\DB::raw('COALESCE(views, 0) + 1')]);

        return response()->json(['success' => true]);
    }
}
