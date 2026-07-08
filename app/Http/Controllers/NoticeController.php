<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NoticeController extends Controller
{
    public function noticeBoard(Request $request, $categoryParam = null)
    {
        $countryCode = session('CountryCode', 'NZ');
        $ads = \App\Models\Ads::where('country', $countryCode)->get();
        $grouped = collect($ads)->groupBy('type');
        $sideData = $grouped->get('side', []);

        if (!$categoryParam) {
            $categoryParam = $request->input('category');
        }
        $search = $request->input('search');

        $categories = \Illuminate\Support\Facades\DB::table('notice_category')
            ->select('notice_category.*', \Illuminate\Support\Facades\DB::raw("(
                SELECT COUNT(*) FROM notice 
                LEFT JOIN users ON users.id = notice.user_id 
                LEFT JOIN cities as c0 ON c0.id = users.suburb_id AND users.country_status = '0'
                LEFT JOIN towns as t1 ON t1.id = users.suburb_id AND users.country_status = '1'
                LEFT JOIN cities as c1 ON c1.id = t1.city_id
                LEFT JOIN states as s0 ON s0.id = c0.state_id
                LEFT JOIN states as s1 ON s1.id = c1.state_id
                LEFT JOIN countries as co0 ON co0.id = s0.country_id
                LEFT JOIN countries as co1 ON co1.id = s1.country_id
                WHERE notice.category_id = notice_category.id 
                  AND notice.status = '1' 
                  AND notice.notice_EXPIRE >= '" . \Carbon\Carbon::now() . "'
                  AND notice.country = '" . $countryCode . "'
            ) as notices_count"))
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
            ->leftJoin('cities as c0', function($join) {
                $join->on('c0.id', '=', 'users.suburb_id')
                     ->where('users.country_status', '=', '0');
            })
            ->leftJoin('towns as t1', function($join) {
                $join->on('t1.id', '=', 'users.suburb_id')
                     ->where('users.country_status', '=', '1');
            })
            ->leftJoin('cities as c1', 'c1.id', '=', 't1.city_id')
            ->leftJoin('states as s0', 's0.id', '=', 'c0.state_id')
            ->leftJoin('states as s1', 's1.id', '=', 'c1.state_id')
            ->leftJoin('countries as co0', 'co0.id', '=', 's0.country_id')
            ->leftJoin('countries as co1', 'co1.id', '=', 's1.country_id')
            ->select('notice.*', 'notice_category.category as category_name', 'users.name as user_name')
            ->where('notice.status', '1')
            ->where('notice.notice_EXPIRE', '>=', \Carbon\Carbon::now())
            ->where('notice.country', $countryCode)
            ->orderByRaw("CASE WHEN notice.noticetype = 'feature' THEN 1 ELSE 2 END ASC")
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
        $countryCode = session('CountryCode', 'NZ');
        $ads = \App\Models\Ads::where('country', $countryCode)->get();
        $grouped = collect($ads)->groupBy('type');
        $sideData = $grouped->get('side', []);

        $search = $request->input('search');
        $categoryParam = $request->input('category');

        // Fetch categories with counts
        $categories = \Illuminate\Support\Facades\DB::table('notice_category')
            ->select('notice_category.*', \Illuminate\Support\Facades\DB::raw("(
                SELECT COUNT(*) FROM notice 
                LEFT JOIN users ON users.id = notice.user_id 
                LEFT JOIN cities as c0 ON c0.id = users.suburb_id AND users.country_status = '0'
                LEFT JOIN towns as t1 ON t1.id = users.suburb_id AND users.country_status = '1'
                LEFT JOIN cities as c1 ON c1.id = t1.city_id
                LEFT JOIN states as s0 ON s0.id = c0.state_id
                LEFT JOIN states as s1 ON s1.id = c1.state_id
                LEFT JOIN countries as co0 ON co0.id = s0.country_id
                LEFT JOIN countries as co1 ON co1.id = s1.country_id
                WHERE notice.category_id = notice_category.id 
                  AND notice.status = '1' 
                  AND notice.notice_EXPIRE >= '" . \Carbon\Carbon::now() . "'
                  AND notice.country = '" . $countryCode . "'
            ) as notices_count"))
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
            ->leftJoin('users', 'users.id', '=', 'notice.user_id')
            ->leftJoin('cities as c0', function($join) {
                $join->on('c0.id', '=', 'users.suburb_id')
                     ->where('users.country_status', '=', '0');
            })
            ->leftJoin('towns as t1', function($join) {
                $join->on('t1.id', '=', 'users.suburb_id')
                     ->where('users.country_status', '=', '1');
            })
            ->leftJoin('cities as c1', 'c1.id', '=', 't1.city_id')
            ->leftJoin('states as s0', 's0.id', '=', 'c0.state_id')
            ->leftJoin('states as s1', 's1.id', '=', 'c1.state_id')
            ->leftJoin('countries as co0', 'co0.id', '=', 's0.country_id')
            ->leftJoin('countries as co1', 'co1.id', '=', 's1.country_id')
            ->select('notice.*', 'notice_category.category as category_name')
            ->where('notice.status', '1')
            ->where('notice.notice_EXPIRE', '>=', \Carbon\Carbon::now())
            ->where('notice.country', $countryCode)
            ->orderByRaw("CASE WHEN notice.noticetype = 'feature' THEN 1 ELSE 2 END ASC")
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

        if ($search || $categoryId) {
            $latestNotices = $latestNoticesQuery->get();
        } else {
            $latestNotices = $latestNoticesQuery->limit(3)->get();
        }

        // Fetch spotlight notice ($5 Service Deal - ID 1)
        $spotlightNotice = \Illuminate\Support\Facades\DB::table('notice')
            ->leftJoin('users', 'users.id', '=', 'notice.user_id')
            ->leftJoin('cities as c0', function($join) {
                $join->on('c0.id', '=', 'users.suburb_id')
                     ->where('users.country_status', '=', '0');
            })
            ->leftJoin('towns as t1', function($join) {
                $join->on('t1.id', '=', 'users.suburb_id')
                     ->where('users.country_status', '=', '1');
            })
            ->leftJoin('cities as c1', 'c1.id', '=', 't1.city_id')
            ->leftJoin('states as s0', 's0.id', '=', 'c0.state_id')
            ->leftJoin('states as s1', 's1.id', '=', 'c1.state_id')
            ->leftJoin('countries as co0', 'co0.id', '=', 's0.country_id')
            ->leftJoin('countries as co1', 'co1.id', '=', 's1.country_id')
            ->select('notice.*')
            ->where('notice.category_id', 1)
            ->where('notice.status', '1')
            ->where('notice.notice_EXPIRE', '>=', \Carbon\Carbon::now())
            ->where('notice.country', $countryCode)
            ->orderBy('notice.created_at', 'desc')
            ->first();

        // Fetch images for these notices
        $noticeIds = $latestNotices->pluck('id');
        $noticeImages = \Illuminate\Support\Facades\DB::table('notice_image')
            ->whereIn('notice_id', $noticeIds)
            ->get()
            ->groupBy('notice_id');

        return view('frontend/noticeboard_v2', compact('sideData', 'categories', 'latestNotices', 'search', 'categoryId', 'noticeImages', 'spotlightNotice'));
    }

    public function searchNotices(Request $request)
    {
        $countryCode = session('CountryCode', 'NZ');
        $ads = \App\Models\Ads::where('country', $countryCode)->get();
        $grouped = collect($ads)->groupBy('type');
        $sideData = $grouped->get('side', []);

        $search = $request->input('search');
        $categoryParam = $request->input('category');

        // Fetch categories with counts
        $categories = \Illuminate\Support\Facades\DB::table('notice_category')
            ->select('notice_category.*', \Illuminate\Support\Facades\DB::raw("(
                SELECT COUNT(*) FROM notice 
                LEFT JOIN users ON users.id = notice.user_id 
                LEFT JOIN cities as c0 ON c0.id = users.suburb_id AND users.country_status = '0'
                LEFT JOIN towns as t1 ON t1.id = users.suburb_id AND users.country_status = '1'
                LEFT JOIN cities as c1 ON c1.id = t1.city_id
                LEFT JOIN states as s0 ON s0.id = c0.state_id
                LEFT JOIN states as s1 ON s1.id = c1.state_id
                LEFT JOIN countries as co0 ON co0.id = s0.country_id
                LEFT JOIN countries as co1 ON co1.id = s1.country_id
                WHERE notice.category_id = notice_category.id 
                  AND notice.status = '1' 
                  AND notice.notice_EXPIRE >= '" . \Carbon\Carbon::now() . "'
                  AND notice.country = '" . $countryCode . "'
            ) as notices_count"))
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

        // Fetch matching notices
        $noticesQuery = \Illuminate\Support\Facades\DB::table('notice')
            ->join('notice_category', 'notice_category.id', '=', 'notice.category_id')
            ->leftJoin('users', 'users.id', '=', 'notice.user_id')
            ->leftJoin('cities as c0', function($join) {
                $join->on('c0.id', '=', 'users.suburb_id')
                     ->where('users.country_status', '=', '0');
            })
            ->leftJoin('towns as t1', function($join) {
                $join->on('t1.id', '=', 'users.suburb_id')
                     ->where('users.country_status', '=', '1');
            })
            ->leftJoin('cities as c1', 'c1.id', '=', 't1.city_id')
            ->leftJoin('states as s0', 's0.id', '=', 'c0.state_id')
            ->leftJoin('states as s1', 's1.id', '=', 'c1.state_id')
            ->leftJoin('countries as co0', 'co0.id', '=', 's0.country_id')
            ->leftJoin('countries as co1', 'co1.id', '=', 's1.country_id')
            ->select('notice.*', 'notice_category.category as category_name', 'users.name as user_name')
            ->where('notice.status', '1')
            ->where('notice.notice_EXPIRE', '>=', \Carbon\Carbon::now())
            ->where('notice.country', $countryCode)
            ->orderByRaw("CASE WHEN notice.noticetype = 'feature' THEN 1 ELSE 2 END ASC")
            ->orderBy('notice.created_at', 'desc');

        if ($search) {
            $noticesQuery->where(function($q) use ($search) {
                $q->where('notice.heading', 'like', "%{$search}%")
                  ->orWhere('notice.content', 'like', "%{$search}%");
            });
        }

        if ($categoryId) {
            $noticesQuery->where('notice.category_id', $categoryId);
        }

        $notices = $noticesQuery->get();

        // Fetch images for these notices
        $noticeIds = $notices->pluck('id');
        $noticeImages = \Illuminate\Support\Facades\DB::table('notice_image')
            ->whereIn('notice_id', $noticeIds)
            ->get()
            ->groupBy('notice_id');

        return view('frontend/noticeboard_search', compact('sideData', 'categories', 'notices', 'search', 'categoryId', 'noticeImages', 'activeCategory'));
    }

    public function incrementView($id)
    {
        \Illuminate\Support\Facades\DB::table('notice')
            ->where('id', $id)
            ->update(['views' => \Illuminate\Support\Facades\DB::raw('COALESCE(views, 0) + 1')]);

        return response()->json(['success' => true]);
    }
}
