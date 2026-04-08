<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ads;
use App\Models\Country;
use Auth;
use App\Models\User;
use App\Models\Category;
use App\Models\Business;
use Illuminate\Support\Str;
use App\Models\Towns;
use App\Models\Notice;
use App\Models\NoticeImg;
use App\Models\City;
use App\Models\BusinessReview;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\State;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Carbon\Carbon;
use App\Models\Article;
use App\Models\ArticleCategory;

class BusinessController extends Controller
{
    //
    public function list($country) { 
        //$categories = Category::with(['subcategories'])->withCount('subcategories')->where('parent_id', 0)->orderBy("title","ASC")->get()->toArray(); 
      	$category = Category::where('parent_id',0)->orderBy('title','asc')->get();
        //$catearray = [];
        if(!empty($category)){
            foreach($category as $key => $cate){
                $subcategory = Category::where('parent_id',$cate->id)->get();
                $category[$key]->subcat = $subcategory;
                
            }
        }
        //dd($category);
        $country_id = Country::where('shortname', session('CountryCode'))->first();
        //dd($country_id);
        if(session('CountryCode')=="NZ"){
            // $city = City::whereHas('state.country.cities.towns', function($query) {
            //     $query->where('shortname', session('CountryCode'));
            // })->with('state.country')->get();
            $states = State::with(['cities' => function($query) {
                $query->orderBy('name', 'asc')->with(['towns' => function($query) {
                    $query->orderBy('suburb_name', 'asc');
                }]);
            }])->where('country_id',$country_id->id)->orderBy('name', 'asc')->get()->toArray();
        }else{
            // $city = City::whereHas('state.country.cities', function($query) {
            //     $query->where('shortname', session('CountryCode'));
            // })->with('state.country')->get();
            $states = State::with(['cities' => function($query) {
                $query->orderBy('name', 'asc');
            }])->where('country_id',$country_id->id??0)->orderBy('name', 'asc')->get()->toArray();
        }
      
        //$categories = Category::withCount('parent_businesses') 
          //  ->with(['subcategories' => function($query) {
          //      $query->withCount('businesses');
            //}])
            //->where('parent_id', 0) 
            //->orderBy('title', 'ASC')
            //->get();
        //dd($categories);
        $ads = Ads::where('country', session('CountryCode'))->get();
        $grouped = collect($ads)->groupBy('type');
        $sideData=[];
        if ($grouped->has('side')) {
            $sideData = $grouped->get('side');
        }
        $user_id = Auth::user()->id ?? null;
        if (!session()->has('CountryCode')) {
            $profile =  User::find($user_id);
            if($profile->country_status=="0"){
		        $suburb = City::select("countries.id","cities.name as city_name","states.name as state_name","countries.name as country_name","countries.shortname")
		        ->join('states','states.id','=',"cities.state_id")
		        ->join('countries' ,"countries.id","=", "states.country_id")
		        ->where('cities.id',$profile->suburb_id)->first();
		    }else{
		        $suburb = Towns::select("countries.id","towns.suburb_name","cities.name as city_name","states.name as state_name","countries.name as country_name","countries.shortname")
		        ->join('cities','cities.id','=','towns.city_id')
		        ->join('states','states.id','=',"cities.state_id")
		        ->join('countries' ,"countries.id","=", "states.country_id")
		        ->where('towns.id',$profile->suburb_id)->first();
		    }
		    $country_id = $suburb->id??0;
		    $country_name = strtolower($suburb->shortname??"");
          	if($country_id===0){
              	$country = Country::where('shortname', session('CountryCode'))->first();
            	$country_id = $country->id??0;
            	$country_name = strtolower(session('CountryCode'));
            }
        }else{
            $country = Country::where('shortname', session('CountryCode'))->first();
            $country_id = $country->id??0;
            $country_name = strtolower(session('CountryCode'));
        }
		
      	$categories = Category::withCount([
            'parent_businesses' => function ($q) use ($country_id) {
                $q->where('country', $country_id)->where('status', '1');
            }
        ])
        ->with([
            'subcategories' => function ($query) use ($country_id) {
                $query->withCount([
                    'businesses' => function ($q) use ($country_id) {
                        $q->where('country', $country_id)->where('status', '1');
                    }
                ]);
            }
        ])
        ->where('parent_id', 0)
        ->orderBy('title', 'ASC')
        ->get();
        //echo $country_id;exit;
        $latestBusiness = Business::select('business.*', 'cat1.title', 'cat1.title_url', 'cat2.title as sec_title', 'cat2.title_url as sec_title_url')
            ->join('categories as cat1', 'cat1.id', '=', 'business.primary_category')
            ->join('categories as cat2', 'cat2.id', '=', 'business.secondary_category')
            ->where('business.country', "$country_id")
          	->where('business.status', "1")
            ->orderby('business.created_at','desc')
            ->limit(4)
            ->get();
            
        $topratedBusiness = Business::select(
            'business.id',
            'business.user_id',
            'business.slug',
            'business.company_name',
            'business.display_name',
            'business.primary_category',
            'business.secondary_category',
            'business.country',
            'business.select_image',
          	'business.business_description',
          	'business.display_address',
          	'business.address',
            'business.created_at',
            'business.updated_at',
          	'business.homebased_business',
          	'business.homebased_business',
            // Include additional columns if needed

            'cat1.title',
            'cat1.title_url',
            'cat2.title as sec_title',
            'cat2.title_url as sec_title_url',
			'users.name',
            DB::raw('MAX(business_review.rating) as highest_rating'),
            DB::raw('AVG(business_review.rating) as average_rating'),
            DB::raw('COUNT(business_review.rating) as rating_count')
        )
        ->join('categories as cat1', 'cat1.id', '=', 'business.primary_category')
        ->join('categories as cat2', 'cat2.id', '=', 'business.secondary_category')
        ->join('users', 'users.id', '=', 'business.user_id')
        ->leftJoin('business_review', 'business_review.business_id', '=', 'business.id')
        ->where('business.country', $country_id)
        ->where('business.status', "1")
        ->groupBy(
            'business.id',
            'business.user_id',
            'business.slug',
            'business.company_name',
            'business.display_name',
          	'business.display_address',
          	'business.business_description',
          	'business.address',
            'business.primary_category',
            'business.secondary_category',
            'business.country',
            'business.created_at',
            'business.updated_at',
			'business.select_image',
          	'business.homebased_business',
          	'business.homebased_business',
            'cat1.title',
            'cat1.title_url',
            'cat2.title',
            'cat2.title_url',
          	'users.name'
        )
        ->orderByDesc('average_rating')
        ->get();
        //dd($topratedBusiness);
        //dd(session()->all());
    	return view('frontend/business/list',compact('categories','sideData','latestBusiness','topratedBusiness','country_name','category','states')); 
    }
//    public function CategoryWiseList($country,$primary="",$secondary=""){
//         $categories = Category::withCount('parent_businesses') 
//             ->with(['subcategories' => function($query) {
//                 $query->withCount('businesses');
//             }])
//             ->where('parent_id', 0) 
//             ->orderBy('title', 'ASC')
//             ->get();
//         //dd($categories);
//         $ads = Ads::where('country', session('CountryCode'))->get();
//         $grouped = collect($ads)->groupBy('type');
//         $sideData=[];
//         if ($grouped->has('side')) {
//             $sideData = $grouped->get('side');
//         }
//         $user_id = Auth::user()->id ?? null;
//         if($user_id){
//             $profile =  User::find($user_id);
//             if($profile->country_status=="0"){
// 		        $suburb = City::select("countries.id","cities.name as city_name","states.name as state_name","countries.name as country_name","countries.shortname")
// 		        ->join('states','states.id','=',"cities.state_id")
// 		        ->join('countries' ,"countries.id","=", "states.country_id")
// 		        ->where('cities.id',$profile->suburb_id)->first();
// 		    }else{
// 		        $suburb = Towns::select("countries.id","towns.suburb_name","cities.name as city_name","states.name as state_name","countries.name as country_name","countries.shortname")
// 		        ->join('cities','cities.id','=','towns.city_id')
// 		        ->join('states','states.id','=',"cities.state_id")
// 		        ->join('countries' ,"countries.id","=", "states.country_id")
// 		        ->where('towns.id',$profile->suburb_id)->first();
// 		    }
// 		    $country_id = $suburb->id;
// 		    $country_name = strtolower($suburb->shortname);
//         }else{
//             $country = Country::where('shortname', session('CountryCode'))->first();
//             $country_id = $country->id??0;
//             $country_name = strtolower(session('CountryCode'));
//         }    
//         $query = Business::select(
//             'business.*', 
//             'cat1.title', 
//             'cat1.title_url', 
//             'cat2.title as sec_title', 
//             'cat2.title_url as sec_title_url', 
//             DB::raw('MAX(business_review.rating) as highest_rating'), 
//             DB::raw('AVG(business_review.rating)  as average_rating'),
//             DB::raw('COUNT(business_review.rating) as rating_count')  
//         )
//         ->join('categories as cat1', 'cat1.id', '=', 'business.primary_category')
//         ->join('categories as cat2', 'cat2.id', '=', 'business.secondary_category')
//         ->leftJoin('business_review', 'business_review.business_id', '=', 'business.id')
//         ->where('business.country', "$country_id");
//         if($primary!=""){
//             $query->where('cat1.title_url', $primary);
//         }
//         if($secondary!=""){
//             $query->where('cat2.title_url', $secondary);
//         }        
//         $topratedBusiness = $query->groupBy('business.id')
//             ->orderBy('average_rating', 'desc') // Order by average rating in descending order
//             ->get();
//         //dd($topratedBusiness);
//         //dd(session()->all());
//     	return view('frontend/business/categorywiselist',compact('categories','sideData','topratedBusiness','country_name','primary','secondary'));        
//     }
  	public function updateCategoryViews($primary = "", $secondary = "")
    {
        // Create unique session keys to prevent multiple updates
        $primarySessionKey = 'viewed_primary_' . $primary;
        $secondarySessionKey = 'viewed_secondary_' . $secondary;

        // Update secondary category views
        if($secondary != "" && !session()->has($secondarySessionKey)){
            $secondaryCategory = Category::where('title_url', $secondary)
                                       ->where('parent_id', '!=', 0)
                                       ->first();
            if($secondaryCategory) {
                $data = [
                    'views' => $secondaryCategory->views + 1,
                ];
                $secondaryCategory->update($data);

                // Mark as viewed in this session
                session()->put($secondarySessionKey, true);
            }
        }

        // Update primary category views
        if($primary != "" && !session()->has($primarySessionKey)){
            $primaryCategory = Category::where('title_url', $primary)
                                    ->where('parent_id', 0)
                                    ->first();
            if($primaryCategory) {
                $data = [
                    'views' => $primaryCategory->views + 1,
                ];
                $primaryCategory->update($data);

                // Mark as viewed in this session
                session()->put($primarySessionKey, true);
            }
        }
    }
      public function CategoryWiseList($country,$primary="",$secondary=""){
        $this->updateCategoryViews($primary, $secondary);
        //$categories = Category::withCount('parent_businesses') 
        //    ->with(['subcategories' => function($query) {
        //        $query->withCount('businesses');
        //    }])
        //    ->where('parent_id', 0) 
        //    ->orderBy('title', 'ASC')
        //    ->get();

        $ads = Ads::where('country', session('CountryCode'))->get();
        $grouped = collect($ads)->groupBy('type');
        $sideData=[];
        if ($grouped->has('side')) {
            $sideData = $grouped->get('side');
        }

        $user_id = Auth::user()->id ?? null;
        if(!session()->has('CountryCode')){
             $profile =  User::find($user_id);
             if($profile->country_status=="0"){
 		        $suburb = City::select("countries.id","cities.name as city_name","states.name as state_name","countries.name as country_name","countries.shortname")
 		        ->join('states','states.id','=',"cities.state_id")
 		        ->join('countries' ,"countries.id","=", "states.country_id")
 		        ->where('cities.id',$profile->suburb_id)->first();
 		    }else{
 		        $suburb = Towns::select("countries.id","towns.suburb_name","cities.name as city_name","states.name as state_name","countries.name as country_name","countries.shortname")
 		        ->join('cities','cities.id','=','towns.city_id')
 		        ->join('states','states.id','=',"cities.state_id")
 		        ->join('countries' ,"countries.id","=", "states.country_id")
 		        ->where('towns.id',$profile->suburb_id)->first();
 		    }
 		    $country_id = $suburb->id??157;
 		    $country_name = strtolower($suburb->shortname??"NZ");
         }else{
             $country = Country::where('shortname', session('CountryCode'))->first();
             $country_id = $country->id??0;
             $country_name = strtolower(session('CountryCode'));
         }    
		
		$categories = Category::withCount([
            'parent_businesses' => function ($q) use ($country_id) {
                $q->where('country', $country_id)->where('status', '1');
            }
        ])
        ->with([
            'subcategories' => function ($query) use ($country_id) {
                $query->withCount([
                    'businesses' => function ($q) use ($country_id) {
                        $q->where('country', $country_id)->where('status', '1');
                    }
                ]);
            }
        ])
        ->where('parent_id', 0)
        ->orderBy('title', 'ASC')
        ->get();
        $query = Business::select(
            'business.id',
            'business.company_name',
            'business.display_name', 
            'business.business_description',
            'business.select_image',
            'business.contact_person',
            'business.email_address',
            'business.main_phone',
            'business.website_url',
            'business.address',
          	'business.slug',
            'business.created_at',
          	'business.homebased_business',
            'cat1.title', 
            'cat1.title_url', 
            'cat2.title as sec_title', 
            'cat2.title_url as sec_title_url', 
            DB::raw('COALESCE(MAX(business_review.rating), 0) as highest_rating'), 
            DB::raw('COALESCE(AVG(business_review.rating), 0) as average_rating'),
            DB::raw('COUNT(business_review.rating) as rating_count')  
        )
        ->join('categories as cat1', 'cat1.id', '=', 'business.primary_category')
        ->join('categories as cat2', 'cat2.id', '=', 'business.secondary_category')
        ->leftJoin('business_review', 'business_review.business_id', '=', 'business.id')
        ->where('business.country', $country_id)
        ->where('business.status', "1");

        if($primary!=""){
            $query->where('cat1.title_url', $primary);
        }
        if($secondary!=""){
            $query->where('cat2.title_url', $secondary);
        }        

        $topratedBusiness = $query->groupBy(
            'business.id',
            'business.company_name',
            'business.display_name', 
            'business.business_description',
            'business.select_image',
            'business.contact_person',
            'business.email_address',
            'business.main_phone',
            'business.website_url',
            'business.address',
            'business.created_at',
            'business.slug',
            'business.homebased_business',
            'cat1.title', 
            'cat1.title_url', 
            'cat2.title', 
            'cat2.title_url'
        )
        ->orderBy('average_rating', 'desc')
        ->get();

        return view('frontend/business/categorywiselist',compact('categories','sideData','topratedBusiness','country_name','primary','secondary'));        
    }
    public function BusinessSearch(Request $request, $country)
    {
        // Get the search query from the request
      	$category = Category::where('parent_id',0)->orderBy('title','asc')->get();
        //$catearray = [];
        if(!empty($category)){
            foreach($category as $key => $cate){
                $subcategory = Category::where('parent_id',$cate->id)->get();
                $category[$key]->subcat = $subcategory;
                
            }
        }
        //dd($category);
        $country_id = Country::where('shortname', session('CountryCode'))->first();
        //dd($country_id);
        if(session('CountryCode')=="NZ"){
            // $city = City::whereHas('state.country.cities.towns', function($query) {
            //     $query->where('shortname', session('CountryCode'));
            // })->with('state.country')->get();
            $states = State::with(['cities' => function($query) {
                $query->orderBy('name', 'asc')->with(['towns' => function($query) {
                    $query->orderBy('suburb_name', 'asc');
                }]);
            }])->where('country_id',$country_id->id)->orderBy('name', 'asc')->get()->toArray();
        }else{
            // $city = City::whereHas('state.country.cities', function($query) {
            //     $query->where('shortname', session('CountryCode'));
            // })->with('state.country')->get();
            $states = State::with(['cities' => function($query) {
                $query->orderBy('name', 'asc');
            }])->where('country_id',$country_id->id??0)->orderBy('name', 'asc')->get()->toArray();
        }
        $searchQuery = $request->input('search');
        $ads = Ads::where('country', session('CountryCode'))->get();
        $grouped = collect($ads)->groupBy('type');
        $sideData = [];

        if ($grouped->has('side')) {
            $sideData = $grouped->get('side');
        }

        // Split the search query into individual words
        $searchTerms = explode(' ', $searchQuery);
        $country = Country::where('shortname', $country)->first();
        $country_id = $country->id ?? 0;

        // Start the query on the `business` model
        $query = Business::select(
            'business.*',
            'cat1.title', 
            'cat1.title_url', 
            'cat2.title as sec_title', 
            'cat2.title_url as sec_title_url',
            DB::raw('COALESCE(MAX(business_review.rating), 0) as highest_rating'),
            DB::raw('COALESCE(AVG(business_review.rating), 0) as average_rating'),
            DB::raw('COUNT(business_review.rating) as rating_count')
        )
        ->leftJoin('business_review', 'business_review.business_id', '=', 'business.id')
        ->join('categories as cat1', 'cat1.id', '=', 'business.primary_category')
        ->join('categories as cat2', 'cat2.id', '=', 'business.secondary_category')
        ->where('business.status', "1")
        ->where('business.country', $country_id); // Fixed: Added table prefix

        // Loop through each search term and add it to the query
        foreach ($searchTerms as $term) {
            $query->where(function ($subQuery) use ($term) {
                $subQuery->where('business.display_name', 'LIKE', '%' . $term . '%') // Fixed: Added table prefix
                    ->orWhere('business.business_description', 'LIKE', '%' . $term . '%') // Fixed: Added table prefix
                    ->orWhere('business.region', 'LIKE', '%' . $term . '%'); // Fixed: Added table prefix
            });
        }

        // Add GROUP BY clause for all business columns that are being selected
        $query->groupBy([
            'business.id',
            'business.user_id',
            'business.homebased_business',
            'business.slug',
            'business.map',
            'business.suits_you',
            'business.company_name',
            'business.display_name',
            'business.primary_category',
            'business.secondary_category',
            'business.business_description',
            'business.contact_person',
            'business.email_address',
            'business.country',
            'business.main_phone',
            'business.website_url',
            'business.secondary_phone',
            'business.address',
            'business.region',
            'business.select_image',
            'business.street',
            'business.town_suburb',
            'business.postal_code',
            'business.city_or_district',
            'business.apartment_number',
            'business.display_address',
            'business.facebook',
            'business.linkedIn',
            'business.twitter',
            'business.created_at',
            'business.updated_at',
            'business.status',
          	'business.view_count',
            'cat1.title', 
            'cat1.title_url', 
            'cat2.title', // Fixed: Removed alias from GROUP BY
            'cat2.title_url' // Fixed: Removed alias from GROUP BY
        ])
        ->orderBy('average_rating', 'desc');

        // Execute the query and get results
        $businesses = $query->get();

        return view('frontend.business.search_results', compact('businesses', 'country', 'searchQuery', 'sideData','category','states'));
    }
    public function details($country,$primary,$secxondary,$slug) {
      	$this->updateCategoryViews($primary, $secxondary);
      	$business_view_count = Business::where('slug', $slug)->firstOrFail();
        // increment view count
        $business_view_count->increment('view_count');
        $business = Business::select('business.*', 'cat1.title', 'cat1.title_url', 'cat2.title as sec_title', 'cat2.title_url as sec_title_url','users.name')
            ->join('categories as cat1', 'cat1.id', '=', 'business.primary_category')
            ->join('categories as cat2', 'cat2.id', '=', 'business.secondary_category')
        	->join('users', 'users.id', '=', 'business.user_id')
            ->where('business.slug', "$slug")
            ->first();
       //dd($business);
       $rating = [];
       if($business){
           $rating = BusinessReview::select('business_review.*','users.name','users.image')->join('users','users.id','=','business_review.user_id')->where(["business_review.business_id"=>$business->id,"business_review.status"=>"1"])->get()->toArray();
       }
       //dd($rating);
        return view('frontend/business/details',compact('business','country','rating'));
    }
    public function businessPrint($country,$cat,$subcat,$slug) {
        $business = Business::select('business.*', 'cat1.title', 'cat1.title_url', 'cat2.title as sec_title', 'cat2.title_url as sec_title_url')
            ->join('categories as cat1', 'cat1.id', '=', 'business.primary_category')
            ->join('categories as cat2', 'cat2.id', '=', 'business.secondary_category')
            ->where('business.slug', "$slug")
            ->first();
        $currentUrl = url()->current();
        $currentUrl = str_replace('/print', '', $currentUrl);

       //dd($business);
    	return view('frontend/business/print',compact('business','currentUrl'));
    }
    public function businessProfile(Request $request, $country, $user_id) {
        try {
    		$user_id = Crypt::decryptString($user_id);
    		if($user_id){
    		    $profile =  User::find($user_id);
    		    if($profile){
        		    $businessList = Business::select('business.*','cat1.title_url', 'cat2.title as sec_title', 'cat2.title_url as sec_title_url')
                        ->join('categories as cat1', 'cat1.id', '=', 'business.primary_category')
                        ->join('categories as cat2', 'cat2.id', '=', 'business.secondary_category')
                        ->join('countries','countries.id','=','business.country')->where("user_id",$user_id)->get();
        		    //echo $profile->suburb->id;
        		    //echo "<pre>";
        		    //print_r($profile);exit;
        		    //dd($businessList);
        		    //$suburb = Suburb::find($profile->suburb->id);
        		    if($profile->country_status=="0"){
        		        $suburb = City::select("cities.name as city_name","states.name as state_name","countries.name as country_name")
        		        ->join('states','states.id','=',"cities.state_id")
        		        ->join('countries' ,"countries.id","=", "states.country_id")
        		        ->where('cities.id',$profile->suburb_id)->first();
                        //$suburb = City::with('state.country')->find($profile->suburb_id);
        		    }else{
        		        $suburb = Towns::select("towns.suburb_name","cities.name as city_name","states.name as state_name","countries.name as country_name")
        		        ->join('cities','cities.id','=','towns.city_id')
        		        ->join('states','states.id','=',"cities.state_id")
        		        ->join('countries' ,"countries.id","=", "states.country_id")
        		        ->where('towns.id',$profile->suburb_id)->first();
        		        //Towns::with('cities.state.country')->find($profile->suburb_id);
        		    }
                    $ads = Ads::where('country', session('CountryCode'))->get();
                    $grouped = collect($ads)->groupBy('type');
                    //dd($suburb);
                    //echo $state = $suburb->state->name;
                    //echo $country = $suburb->state->country->name;
                    $sideData=[];
                    $midData=[];
                    if ($grouped->has('side')) { 
                        $sideData = $grouped->get('side');
                    }
                    if($grouped->has('mid')){
                        $midData = $grouped->get('mid');
                    }
                    $notice = Notice::where('user_id', $user_id)->get();
                    $articles = Article::with('category')->where('user_id', $user_id)->get();
                    //echo "<pre>";
        		    //print_r($grouped['side']);exit;
        		    return view('frontend/business/profile', compact('profile', 'suburb','sideData','midData','country','notice','businessList', 'articles'));    
    		    }else{
    		       return redirect()->back();
    		    }
    		}else{
    		    Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return redirect('https://catchakiwi.com/');
    		}
            } 
        catch (DecryptException $e) {
            // Handle the case where decryption fails
            return redirect('https://catchakiwi.com/');
        }
	}
	public function reviewSub(Request $request) {
	    $validator = Validator::make($request->all(), [
            'business_id' => 'required|exists:business,id',
            'user_id' => 'unique:business_review,user_id,NULL,id,business_id,' . $request->input('business_id')
        ], [
            'user_id.unique' => 'You have already submitted a review for this business.'
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    	$initial = $request->input("initial-impression");
    	$cleanliness = $request->input("cleanliness");
    	$value = $request->input("value");
    	$punctuality = $request->input("punctuality");
    	$quality = $request->input("quality");
    	$overall = $request->input("overall-opinion");
    	$review = $request->input("review");
    	$business_id = $request->input("business_id");
    	$totalrating = ($initial+$cleanliness+$value+$punctuality+$quality+$overall) / 6;
    	BusinessReview::create([
    	    'user_id'=>Auth::user()->id,
    	    'business_id'=>$business_id,
    	    'rating' => round($totalrating),
    	    'initial_rate' => $initial,
    	    'value_rate' => $value,
    	    'quality_rate' => $quality,
    	    'cleanliness_rate' => $cleanliness,
    	    'punctuality_rate' => $punctuality,
    	    'overall_opinion_rate' => $overall,
    	    'status' => ($totalrating>2)?'1':'0',
    	    'review' => $review
    	]);
        return redirect()->back()->with('success', 'Review submitted successfully!');
    }
     public function category() {
    	return view('frontend/business/category');
    }
    public function getaQuote(){
        $ads = Ads::where('country', session('CountryCode'))->get();
        $grouped = collect($ads)->groupBy('type');
        $sideData=[];
        if ($grouped->has('side')) {
            $sideData = $grouped->get('side'); 
        }
        return view('frontend/business/getaquote', compact('sideData'));
    }
    public function addYourBusiness(){
        $country = Country::where('status', '1')->get()->toArray();
        $category = Category::where('parent_id', '0')->orderBy('title','asc')->get()->toArray();
        //print_r($category);exit;
        $user_id = Auth::user()->id ?? null;
	    $profile =  User::find($user_id);
        $ads = Ads::where('country', session('CountryCode'))->get();
        $grouped = collect($ads)->groupBy('type');
        $sideData=[];
        if ($grouped->has('side')) {
            $sideData = $grouped->get('side');
        }
        
        return view('frontend/business/addbusiness', compact('sideData','country','profile','category'));
    }
    public function listInsert(Request $request){
        $validatedData = $request->validate([
            'homebased_business' => 'required|string|in:Yes,No',
            'company_name'       => 'required|string|max:255',
            'display_name'       => 'required|string|max:255|unique:business,display_name',
            'category'           => 'required|exists:categories,id',
            'subcat'             => 'required|exists:categories,id',
            'description'        => 'required|string|min:50',
            'imageUpload'        => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
            'contact_person'     => 'required|string|max:255',
            'email'              => 'required|email|max:255',
            'country'            => 'required|exists:countries,id',
            'phone_no'           => 'required|string|max:20',
            'phone_no_two'       => 'nullable|string|max:20',
            'website_url'        => 'nullable|url|max:255',
            'street_address'     => 'required|string|max:255',
            'appt_number'        => 'nullable|string|max:255',
            'city_id'            => 'required|string|max:255',
            'display_addrs'      => 'required|string|in:yes,no',
            'facebook_prof'      => 'nullable|url|max:255',
            'linkedin'           => 'nullable|url|max:255',
            'twitter'            => 'nullable|url|max:255',
            'map'                => 'nullable|string',
            'bestsuitsyou'       => 'nullable|string|max:255',
        ], [
            'display_name.unique' => 'This display name is already registered.',
            'category.required'    => 'Please select a primary category.',
            'subcat.required'      => 'Please select a secondary category.',
            'city_id.required'     => 'Please select your town/city.',
            'description.min'      => 'Business description must be at least 50 characters.',
        ]);
        // Handle image upload from base64 even if the file object is missing (after redirect)
        $base64coverimage = $request->input('base64image');
        $last_img = "";
        if (!empty($base64coverimage)) {
            $base64_data = preg_replace('#^data:image/\w+;base64,#i', '', $base64coverimage);
            $binaryImageData = base64_decode($base64_data);
            
            // Try to get extension from file input or from base64 string
            $img_ext = 'png'; // default
            if ($request->file('imageUpload')) {
                $img_ext = strtolower($request->file('imageUpload')->getClientOriginalExtension());
            } elseif (preg_match('#^data:image/(\w+);base64,#i', $base64coverimage, $matches)) {
                $img_ext = $matches[1];
            }
            
            // Ensure directory exists
            $dirPath = 'public/assets/business';
            if (!file_exists(base_path($dirPath))) {
                mkdir(base_path($dirPath), 0777, true);
            }
            
            $fileName = uniqid() . rand(1111, 1111111111) . '.' . $img_ext;
            $filePath = $dirPath . '/' . $fileName;
            file_put_contents(base_path($filePath), $binaryImageData, LOCK_EX | FILE_BINARY);
            $last_img = $filePath;
        }
        $slug = Str::slug($validatedData['display_name']);
        $business = Business::create([
            'user_id' => Auth::user()->id, // Assuming you have user authentication and want to save the user ID
            'homebased_business' => $validatedData['homebased_business'],
            'slug' => $slug,
            'map' => $request->input('map'),
            'suits_you'  => $request->input('bestsuitsyou'),
            'company_name' => $validatedData['company_name'],
            'display_name' => $validatedData['display_name'],
            'primary_category' => $request->input('category'),
            'secondary_category' => $request->input('subcat'),
            'business_description' => $validatedData['description'],
            //'select_image' => $path,
            'contact_person' => $validatedData['contact_person'],
            'email_address' => $validatedData['email'],
            'country' => $request->input('country'),
            'main_phone' => $validatedData['phone_no'],
            'secondary_phone' => $request->input('phone_no_two'),
            'website_url' => $request->input('website_url'),
            'address' => $validatedData['street_address'], 
            //'apartment_number' => $validatedData['appt_number'],
            'region' => $validatedData['city_id'],
            // 'town_suburb' => $validatedData['town_id'],
            // 'postal_code' => $validatedData['postal_code'],
            // 'city_or_district' => $validatedData['city_id'],
            'display_address' => $validatedData['display_addrs'],
            'select_image' => $last_img,
            'facebook' => $request->input('facebook_prof'),
            'linkedIn' => $request->input('linkedin'),
            'twitter' => $request->input('twitter')
        ]);
        // return response()->json([
        //     'success' => true,
        //     'message' => 'Business information has been successfully saved.',
        //     'data' => $business,
        // ]);
        return redirect()->back()->with('success', 'Business has been successfully created!');
    }
    public function businessEdit($id)
    {
        // Find the business by ID
        $business = Business::findOrFail($id);
    
        // Fetch country and category data
        $country = Country::where('status', '1')->get()->toArray();
        $category = Category::where('parent_id', '0')->orderBy('title', 'asc')->get()->toArray();
    
        // Get the authenticated user's profile
        $user_id = Auth::user()->id ?? null;
        $profile = User::find($user_id);
    
        // Fetch ads for the side data
        $ads = Ads::where('country', session('CountryCode'))->get();
        $grouped = collect($ads)->groupBy('type');
        $sideData = [];
        if ($grouped->has('side')) {
            $sideData = $grouped->get('side');
        }
        //dd($business);
        // Return the edit view with business data and other necessary information
        return view('frontend/business/edit', compact('business', 'sideData', 'country', 'profile', 'category'));
    }
    public function businessUpdate(Request $request, $id)
    {
        $validatedData = $request->validate([
            'homebased_business' => 'required|string|in:Yes,No',
            'company_name'       => 'required|string|max:255',
            'display_name'       => 'required|string|max:255|unique:business,display_name,' . $id,
            'category'           => 'required|exists:categories,id',
            'subcat'             => 'required|exists:categories,id',
            'description'        => 'required|string|min:50',
            'imageUpload'        => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
            'contact_person'     => 'required|string|max:255',
            'email'              => 'required|email|max:255',
            'country'            => 'required|exists:countries,id',
            'phone_no'           => 'required|string|max:20',
            'phone_no_two'       => 'nullable|string|max:20',
            'website_url'        => 'nullable|url|max:255',
            'street_address'     => 'required|string|max:255',
            'appt_number'        => 'nullable|string|max:255',
            'city_id'            => 'required|string|max:255',
            'display_addrs'      => 'required|string|in:yes,no',
            'facebook_prof'      => 'nullable|url|max:255',
            'linkedin'           => 'nullable|url|max:255',
            'twitter'            => 'nullable|url|max:255',
            'map'                => 'nullable|string',
            'bestsuitsyou'       => 'nullable|string|max:255',
        ], [
            'display_name.unique' => 'This display name is already registered.',
            'category.required'    => 'Please select a primary category.',
            'subcat.required'      => 'Please select a secondary category.',
            'city_id.required'     => 'Please select your town/city.',
            'description.min'      => 'Business description must be at least 50 characters.',
        ]);
    
        // Find the existing business
        $business = Business::findOrFail($id);
        
        // Handle image upload from base64 even if the file object is missing (after redirect)
        $base64coverimage = $request->input('base64image');
        $last_img = $business->select_image; // Keep existing image if no new image is provided
        
        if (!empty($base64coverimage) && (strpos($base64coverimage, 'data:image/') === 0)) {
            $base64_data = preg_replace('#^data:image/\w+;base64,#i', '', $base64coverimage);
            $binaryImageData = base64_decode($base64_data);
            
            // Try to get extension from file input or from base64 string
            $img_ext = 'png'; // default
            if ($request->file('imageUpload')) {
                $img_ext = strtolower($request->file('imageUpload')->getClientOriginalExtension());
            } elseif (preg_match('#^data:image/(\w+);base64,#i', $base64coverimage, $matches)) {
                $img_ext = $matches[1];
            }
            
            // Ensure directory exists
            $dirPath = 'public/assets/business';
            if (!file_exists(base_path($dirPath))) {
                mkdir(base_path($dirPath), 0777, true);
            }
            
            $fileName = uniqid() . rand(1111, 1111111111) . '.' . $img_ext;
            $filePath = $dirPath . '/' . $fileName;
            file_put_contents(base_path($filePath), $binaryImageData, LOCK_EX | FILE_BINARY);
            $last_img = $filePath;
        }
    
        // Update the business information
        $business->update([
            'homebased_business' => $validatedData['homebased_business'],
            'map' => $request->input('map'),
            'suits_you' => $request->input('bestsuitsyou'),
            'company_name' => $validatedData['company_name'],
            'display_name' => $validatedData['display_name'],
            'slug' => Str::slug($validatedData['display_name']),
            'primary_category' => $request->input('category'),
            'secondary_category' => $request->input('subcat'),
            'business_description' => $validatedData['description'],
            'contact_person' => $validatedData['contact_person'],
            'email_address' => $validatedData['email'],
            'country' => $request->input('country'),
            'main_phone' => $validatedData['phone_no'],
            'secondary_phone' => $request->input('phone_no_two'),
            'website_url' => $request->input('website_url'),
            'address' => $validatedData['street_address'],
            'region' => $validatedData['city_id'],
            'display_address' => $validatedData['display_addrs'],
            'select_image' => $last_img,
            'facebook' => $request->input('facebook_prof'),
            'linkedIn' => $request->input('linkedin'),
            'twitter' => $request->input('twitter')
        ]);
    
        return redirect()->back()->with('success', 'Business has been successfully updated!');

    }

    public function changeStatus(Request $request)
    {
        $business = Business::where('id', $request->id)->where('user_id', Auth::user()->id)->first();
        
        if ($business) {
            $business->status = $request->status;
            $business->save();
            return response()->json(['success' => true]);
        }
        
        return response()->json(['success' => false], 404);
    }

    public function businessDelete($id)

    {
        $business = Business::where('id', $id)->where('user_id', Auth::user()->id)->firstOrFail();
        $business->delete();

        return redirect()->back()->with('success', 'Business has been successfully deleted!');
    }
}
