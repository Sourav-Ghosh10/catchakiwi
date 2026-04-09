<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NoticeController extends Controller
{
    public function noticeBoard()
    {
        $ads = \App\Models\Ads::where('country', session('CountryCode'))->get();
        $grouped = collect($ads)->groupBy('type');
        $sideData = $grouped->get('side', []);
        return view('frontend/noticeboard', compact('sideData'));
    }

    public function noticeBoardV2()
    {
        $ads = \App\Models\Ads::where('country', session('CountryCode'))->get();
        $grouped = collect($ads)->groupBy('type');
        $sideData = $grouped->get('side', []);

        // Fetch categories with counts
        $categories = \Illuminate\Support\Facades\DB::table('notice_category')
            ->select('notice_category.*', \Illuminate\Support\Facades\DB::raw('(SELECT COUNT(*) FROM notice WHERE notice.category_id = notice_category.id) as notices_count'))
            ->get();

        // Fetch latest notices
        $latestNotices = \Illuminate\Support\Facades\DB::table('notice')
            ->join('notice_category', 'notice_category.id', '=', 'notice.category_id')
            ->select('notice.*', 'notice_category.category as category_name')
            ->orderBy('notice.created_at', 'desc')
            ->limit(4)
            ->get();

        return view('frontend/noticeboard_v2', compact('sideData', 'categories', 'latestNotices'));
    }
}
