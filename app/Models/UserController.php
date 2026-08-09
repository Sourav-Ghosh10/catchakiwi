<?php

namespace App\Http\Controllers;

use App\Models\Suburb;
use App\Models\User;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //
    public function profile()
    {

        $user_id = Auth::user()->id;
        $profile = User::find($user_id);
        // dd($profile);
        $suburb = Suburb::find($profile->suburb->id);

        return view('profile', compact('profile', 'suburb'));
    }

    public function StoreProfileBanner(Request $request)
    {
        $id = Auth::user()->id;
        // dd($id);

        $profile_banner = $request->file('profile_banner');
        if ($profile_banner) {

            $name_gen = hexdec(uniqid());
            $img_ext = strtolower($profile_banner->getClientOriginalExtension());
            $img_name = $name_gen.'.'.$img_ext;
            $up_location = 'assets/profile/banners/';
            $last_img = $up_location.$img_name;

            $profile_banner->move($up_location, $img_name);
        }

        User::find($id)->update([
            'profile_banner' => $last_img,
            'updated_at' => Carbon::now(),
        ]);

        return Redirect()->back();
    }
}
