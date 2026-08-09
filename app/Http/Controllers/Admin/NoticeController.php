<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Notice;
use App\Models\NoticeCategory;
use App\Models\NoticeImg;
use Carbon\Carbon;
use Illuminate\Http\Request;

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

    public function upgrade($id)
    {
        $notice = Notice::findOrFail($id);
        $notice->noticetype = 'feature';
        $notice->notice_EXPIRE = Carbon::now()->addDays(28);
        $notice->expire_at = Carbon::now()->addDays(28);
        $notice->save();

        return redirect()->back()->with('success', 'Notice upgraded to Feature successfully.');
    }

    public function edit($id)
    {
        $notice = Notice::findOrFail($id);
        $category = NoticeCategory::where('is_active', 1)->get();
        $country = Country::where('status', '1')->get()->toArray();

        // Retrieve images associated with the notice
        $noticeImages = NoticeImg::where('notice_id', $id)->orderBy('id', 'asc')->get();

        return view('admin.notices.edit', compact('notice', 'category', 'country', 'noticeImages'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'category_id' => 'required',
            'noticetype' => 'required|in:standard,feature',
            'notice_title' => 'required|string|max:35',
            'notice_body' => 'required|string|max:300',
            'town_suburb' => 'nullable|string',
            'looking_for' => 'nullable|string',
            'job_location' => 'nullable|string',
            'start_date' => 'nullable|string',
            'budget' => 'nullable|string',
            'message_text' => 'nullable|string',
            'item_type' => 'nullable|string',
        ]);

        $notice = Notice::findOrFail($id);
        $category_id = $request->input('category_id');

        $selectedNoticeCategory = NoticeCategory::find($category_id);
        $selectedNoticeCategoryName = strtolower($selectedNoticeCategory->category ?? '');
        $selectedNoticeCategorySlug = $selectedNoticeCategory->slug ?? '';
        $isItemsCategory = in_array($selectedNoticeCategorySlug, ['items-for-sale', 'items-for-sale-or-wanted'])
            || in_array($selectedNoticeCategoryName, ['items for sale', 'items for sale or wanted']);
        $noticeLookingFor = $isItemsCategory ? $request->input('item_type') : $request->input('looking_for');

        $notice->category_id = $category_id;
        $notice->noticetype = $request->input('noticetype');
        $notice->heading = $request->input('notice_title');
        $notice->content = $request->input('notice_body');
        $notice->town_suburb = $request->input('town_suburb');
        $notice->looking_for = $noticeLookingFor;
        $notice->job_location = $request->input('job_location');
        $notice->start_date = $request->input('start_date');
        $notice->budget = $request->input('budget');
        $notice->message_text = $request->input('message_text');

        $notice->save();

        $noticeimgbase64 = $request->input('noticeimgbase64');
        if ($noticeimgbase64 && is_array($noticeimgbase64)) {
            NoticeImg::where('notice_id', $id)->delete();
            $maxImages = $notice->noticetype === 'feature' ? 6 : 3;
            foreach (array_slice($noticeimgbase64, 0, $maxImages) as $imgData) {
                if ($imgData) {
                    if (strpos($imgData, 'data:image/') === 0) {
                        $base64_data = preg_replace('#^data:image/\w+;base64,#i', '', $imgData);
                        $binaryImageData = base64_decode($base64_data);

                        $dirPath = 'assets/notice';
                        $physicalDir = public_path($dirPath);
                        if (! file_exists($physicalDir)) {
                            mkdir($physicalDir, 0777, true);
                        }

                        $fileName = uniqid().rand(1111, 1111111111).'.jpg';
                        $physicalPath = $physicalDir.'/'.$fileName;
                        file_put_contents($physicalPath, $binaryImageData, LOCK_EX | FILE_BINARY);

                        $noticeImgObj = new NoticeImg;
                        $noticeImgObj->notice_id = $notice->id;
                        $noticeImgObj->img_path = $dirPath.'/'.$fileName;
                        $noticeImgObj->created_at = Carbon::now();
                        $noticeImgObj->save();
                    } elseif (strpos($imgData, 'assets/notice/') === 0) {
                        $noticeImgObj = new NoticeImg;
                        $noticeImgObj->notice_id = $notice->id;
                        $noticeImgObj->img_path = $imgData;
                        $noticeImgObj->created_at = Carbon::now();
                        $noticeImgObj->save();
                    }
                }
            }
        }

        return redirect()->route('admin.notices.index')->with('success', 'Notice updated successfully.');
    }
}
