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
            ->leftJoin('countries', 'countries.shortname', '=', 'notice.country')
            ->select(
                'notice.*', 
                'users.name as user_name', 
                'users.email as user_email',
                'countries.name as country_name'
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

    public function destroy($id)
    {
        $notice = Notice::findOrFail($id);
        
        // Delete associated images if any
        if ($notice->images) {
            foreach ($notice->images as $img) {
                // Delete physical file if exists
                if (file_exists(public_path($img->img_path))) {
                    @unlink(public_path($img->img_path));
                }
                $img->delete();
            }
        }
        
        $notice->delete();

        return redirect()->back()->with('success', 'Notice deleted successfully.');
    }
}
