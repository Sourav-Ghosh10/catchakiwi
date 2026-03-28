<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NoticeController extends Controller
{
    public function noticeBoard(){
        $ads = \App\Models\Ads::where('country', session('CountryCode'))->get();
        $grouped = collect($ads)->groupBy('type');
        $sideData = $grouped->get('side', []);
        return view('frontend/noticeboard', compact('sideData'));
    }
}
