<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Business;
use App\Models\User;
use App\Models\Category;
use App\Models\Country;
use App\Models\City;
use App\Models\Towns;
use Illuminate\Support\Facades\DB;

class AdminBusinessController extends Controller
{
    /**
     * Display business listing
     */
    public function index(Request $request)
    {
        $query = Business::select([
            'business.*',
            'users.name as user_name',
            'users.email as user_email',
            'countries.name as country_name',
            'countries.shortname as country_shortname',
            'primary_cat.title as primary_category_name',
            'secondary_cat.title as secondary_category_name'
        ])
        ->join('users', 'users.id', '=', 'business.user_id')
        ->join('countries', 'countries.id', '=', 'business.country')
        ->leftJoin('categories as primary_cat', 'primary_cat.id', '=', 'business.primary_category')
        ->leftJoin('categories as secondary_cat', 'secondary_cat.id', '=', 'business.secondary_category');

        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('business.company_name', 'LIKE', "%{$search}%")
                  ->orWhere('business.display_name', 'LIKE', "%{$search}%")
                  ->orWhere('users.name', 'LIKE', "%{$search}%")
                  ->orWhere('users.email', 'LIKE', "%{$search}%");
            });
        }

        // Status filter
        if ($request->has('status') && $request->status != '') {
            $query->where('business.status', $request->status);
        }

        $businesses = $query->orderBy('business.created_at', 'desc')->paginate(20);

        return view('admin.businesses.index', compact('businesses'));
    }

    /**
     * Show business edit form
     */
    public function edit($id)
    {
        $business = Business::with(['user'])->findOrFail($id);

        // Simple location info
        $locationInfo = [
            'country_name' => 'Unknown',
            'city_name' => 'Unknown',
            'state_name' => 'Unknown'
        ];

        // Get categories
        $categories = \DB::table('categories')->where('parent_id', 0)->orderBy('title')->get();

        // Get countries - try direct table query first
        $countries = \DB::table('countries')->orderBy('name')->get();

        // Pass data to view
        return view('admin.businesses.edit', [
            'business' => $business,
            'categories' => $categories,
            'countries' => $countries,
            'locationInfo' => $locationInfo
        ]);
    }
    public function update(Request $request, $id)
    {
        $business = Business::findOrFail($id);
        
        $validatedData = $request->validate([
            'homebased_business' => 'required|in:yes,no',
            'suits_you' => 'nullable|string|max:100',
            'company_name' => 'required|string|max:255',
            'display_name' => 'required|string|max:100|unique:business,display_name,' . $id,
            'primary_category' => 'required|integer|exists:categories,id',
            'secondary_category' => 'nullable|integer|exists:categories,id',
            'business_description' => 'required|string',
            'imageUpload' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:10240',
            'contact_person' => 'required|string|max:100',
            'email_address' => 'required|email|max:200',
            'country' => 'required|integer',
            'main_phone' => 'required|string|max:20',
            'secondary_phone' => 'nullable|string|max:20',
            'website_url' => 'nullable|url|max:255',
            'address' => 'required|string',
            'apartment_number' => 'nullable|string|max:255',
            'region' => 'nullable|string|max:255',
            'map' => 'nullable|string',
            'display_address' => 'required|in:yes,no',
            'facebook' => 'nullable|url|max:255',
            'linkedIn' => 'nullable|url|max:255',
            'twitter' => 'nullable|url|max:255',
            'status' => 'required|in:0,1'
        ]);

        // Handle image upload
        if ($request->hasFile('imageUpload')) {
            // Delete old image if exists
            if ($business->select_image && file_exists(public_path($business->select_image))) {
                unlink(public_path($business->select_image));
            }
            
            $image = $request->file('imageUpload');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/business'), $imageName);
            $validatedData['select_image'] = 'uploads/business/' . $imageName;
        }

        // Map form fields to database columns
        $updateData = [
            'homebased_business' => $validatedData['homebased_business'],
            'suits_you' => $validatedData['suits_you'] ?? null,
            'company_name' => $validatedData['company_name'],
            'display_name' => $validatedData['display_name'],
            'primary_category' => $validatedData['primary_category'],
            'secondary_category' => $validatedData['secondary_category'],
            'business_description' => $validatedData['business_description'],
            'contact_person' => $validatedData['contact_person'],
            'email_address' => $validatedData['email_address'],
            'country' => $validatedData['country'],
            'main_phone' => $validatedData['main_phone'],
            'secondary_phone' => $validatedData['secondary_phone'],
            'website_url' => $validatedData['website_url'],
            'address' => $validatedData['address'],
            'apartment_number' => $validatedData['apartment_number'],
            'region' => $validatedData['region'],
            'map' => $validatedData['map'],
            'display_address' => $validatedData['display_address'],
            'facebook' => $validatedData['facebook'],
            'linkedIn' => $validatedData['linkedIn'],
            'twitter' => $validatedData['twitter'],
            'status' => $validatedData['status']
        ];

        // Add image if uploaded
        if (isset($validatedData['select_image'])) {
            $updateData['select_image'] = $validatedData['select_image'];
        }

        $business->update($updateData);

        return redirect()->route('admin.businesses.index')
                        ->with('success', 'Business updated successfully!');
    }

    /**
     * Change business status
     */
    public function changeStatus($id)
    {
        $business = Business::findOrFail($id);
        $business->status = $business->status == '1' ? '0' : '1';
        $business->save();

        $statusText = $business->status == '1' ? 'activated' : 'deactivated';
        
        return redirect()->back()->with('success', "Business has been {$statusText} successfully!");
    }

    /**
     * Get user location info using your existing logic
     */
    private function getUserLocationInfo($profile)
    {
        if($profile->country_status == "0") {
            $suburb = City::select("countries.id","cities.name as city_name","states.name as state_name","countries.name as country_name","countries.shortname")
            ->join('states','states.id','=',"cities.state_id")
            ->join('countries' ,"countries.id","=", "states.country_id")
            ->where('cities.id',$profile->suburb_id)->first();
        } else {
            $suburb = Towns::select("countries.id","towns.suburb_name","cities.name as city_name","states.name as state_name","countries.name as country_name","countries.shortname")
            ->join('cities','cities.id','=','towns.city_id')
            ->join('states','states.id','=',"cities.state_id")
            ->join('countries' ,"countries.id","=", "states.country_id")
            ->where('towns.id',$profile->suburb_id)->first();
        }

        return [
            'country_id' => $suburb->id ?? 0,
            'country_name' => strtolower($suburb->shortname ?? ""),
            'city_name' => $suburb->city_name ?? "",
            'state_name' => $suburb->state_name ?? "",
            'suburb_name' => $suburb->suburb_name ?? ""
        ];
    }
    public function getUserBusinesses(Request $request)
    {
        try {
            $userId = $request->input('user_id');
            
            if (!$userId) {
                return response()->json([
                    'success' => false,
                    'message' => 'User ID is required'
                ], 400);
            }
            
            // Fetch businesses for the user with category and country information
            $businesses = DB::table('business as b')
                ->leftJoin('countries as c', 'c.id', '=', 'b.country')
                ->leftJoin('categories as pc', 'pc.id', '=', 'b.primary_category')
                ->leftJoin('categories as sc', 'sc.id', '=', 'b.secondary_category')
                ->where('b.user_id', $userId)
                ->select([
                    'b.id',
                    'b.company_name',
                    'b.display_name',
                    'b.email_address',
                    'b.main_phone',
                    'b.slug',
                    'b.status',
                    'b.created_at',
                    'c.shortname as country_shortname',
                    'pc.title_url as primary_category_url',
                    'sc.title_url as secondary_category_url',
                    'pc.title as primary_category_name',
                    'sc.title as secondary_category_name'
                ])
                ->orderBy('b.created_at', 'desc')
                ->get();
            
            return response()->json([
                'success' => true,
                'businesses' => $businesses
            ]);
            
        } catch (\Exception $e) {
            //Log::error('Error fetching user businesses: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error fetching businesses'
            ], 500);
        }
    }
}