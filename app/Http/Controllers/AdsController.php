<?php

namespace App\Http\Controllers;

use App\Models\Ads;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdsController extends Controller
{
    public function index()
    {
        $ads = Ads::all();
        return view("admin/ads",compact('ads'));
    }

    public function create()
    {
        // Logic for showing the create form
    }

    public function store(Request $request)
    {
        // Logic to store a new user
    }

    public function show(User $user)
    {
        // Logic to show a specific user
    }

    public function edit($id)
    {
        $ads = Ads::find($id);
        //dd($id);
        return view("admin.ads-form",compact('ads'));
    }

    public function update(Request $request, $id)
    {
        $adsimg = $request->file('adsimg');
        $base64image = $request->input('base64image');
        $link = $request->input('link');

        try {
            $data = [
                'link' => $link,
                'updated_at' => Carbon::now()
            ];

            if ($adsimg && $base64image) {
                // Remove header if present
                if (strpos($base64image, ',') !== false) {
                    $base64_data = substr($base64image, strpos($base64image, ',') + 1);
                } else {
                    $base64_data = $base64image;
                }

                $binaryImageData = base64_decode($base64_data);
                
                if ($binaryImageData === false) {
                    throw new \Exception('Base64 decode failed');
                }

                $img_ext = strtolower($adsimg->getClientOriginalExtension());
                $fileName = uniqid() . rand(1111, 1111111111) . '.' . $img_ext;
                
                // Use public_path() for physical writing
                $physicalPath = public_path('assets/ads/' . $fileName);
                
                if (file_put_contents($physicalPath, $binaryImageData, LOCK_EX | FILE_BINARY) === false) {
                    throw new \Exception("Failed to write file to $physicalPath");
                }
                
                // Store path relative to public so asset() helper works
                $data['ads_image'] = 'assets/ads/' . $fileName;
            }

            Ads::find($id)->update($data);

            return redirect()->back()->with('success', 'Ad updated successfully');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['msg' => 'Error: ' . $e->getMessage()]);
        }
    }


    public function destroy(User $user)
    {
        // Logic to delete a user
    }
}