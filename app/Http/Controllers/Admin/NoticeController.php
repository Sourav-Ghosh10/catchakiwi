<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notice;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class NoticeController extends Controller
{
    public function index()
    {
        $notices = Notice::with(['noticecategory', 'images'])
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
            ->select(
                'notice.*', 
                'users.name as user_name', 
                'users.email as user_email',
                DB::raw('COALESCE(co0.name, co1.name) as country_name')
            )
            ->orderBy('notice.created_at', 'desc')
            ->get();

        return view('admin.notices.index', compact('notices'));
    }

    public function approve($id)
    {
        $notice = Notice::findOrFail($id);
        $notice->status = '1';
        
        if ($notice->noticetype === 'feature') {
            $notice->notice_EXPIRE = Carbon::now()->addDays(28);
            $notice->expire_at = Carbon::now()->addDays(28);
        } else {
            $notice->notice_EXPIRE = Carbon::now()->addDays(7);
            $notice->expire_at = Carbon::now()->addDays(7);
        }
        
        $notice->save();

        return redirect()->back()->with('success', 'Notice approved and published successfully.');
    }

    public function reject($id)
    {
        $notice = Notice::findOrFail($id);
        $notice->status = '0';
        $notice->save();

        return redirect()->back()->with('success', 'Notice status updated to pending/rejected.');
    }
}
