<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use App\Models\Suburb;

use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\Towns;
use App\Models\Ads;
use App\Models\NoticeCategory;
use App\Models\Notice;
//use App\Models\Business;
use App\Models\NoticeImg;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Models\Business;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Article;
class UserController extends Controller
{
    //
    public function Home(){
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
        //dd($states);
        return view('frontend/home', compact('category','states'));
    }
    public function search(Request $request, $country = null){
      $category = Category::where('parent_id',0)->orderBy('title','asc')->get();
        //$catearray = [];
        if(!empty($category)){
            foreach($category as $key => $cate){
                $subcategory = Category::where('parent_id',$cate->id)->get();
                $category[$key]->subcat = $subcategory;
                
            }
        }
        //dd($category);
        $countryCode = $country ? strtoupper($country) : session('CountryCode');
        $country_id_obj = Country::where('shortname', $countryCode)->first();
        $country_id = $country_id_obj ? $country_id_obj->id : 0;
        //dd($country_id);
        if($countryCode=="NZ"){
            // $city = City::whereHas('state.country.cities.towns', function($query) {
            //     $query->where('shortname', session('CountryCode'));
            // })->with('state.country')->get();
            $states = State::with('cities.towns')->where('country_id',$country_id)->get()->toArray();
        }else{
            // $city = City::whereHas('state.country.cities', function($query) {
            //     $query->where('shortname', session('CountryCode'));
            // })->with('state.country')->get();
            $states = State::with('cities')->where('country_id',$country_id)->get()->toArray();
        }
        $service= $request->input('service');
        $location= $request->input('location');
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
        //dd($categories);
        $ads = Ads::where('country', $countryCode)->get();
        $grouped = collect($ads)->groupBy('type');
        $sideData=[];
        if ($grouped->has('side')) {
            $sideData = $grouped->get('side');
        }
        $user_id = Auth::user()->id ?? null;
        if($user_id){
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
        }else{
            $country_obj = Country::where('shortname', $countryCode)->first();
            $country_id = $country_obj->id??0;
            $country_name = strtolower($countryCode);
        }

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
        ->leftJoin('categories as cat1', 'cat1.id', '=', 'business.primary_category')
        ->leftJoin('categories as cat2', 'cat2.id', '=', 'business.secondary_category')
        ->where('business.status', "1")
        ->where('business.country', $country_id); 

        if($service) {
            $services = explode(",",$service);
            if (count($services) > 1) {
                // This is a formal selection (subcat_url,cat_url)
                $query->where(function($q) use ($services) {
                    $q->whereIn('cat1.title_url', $services)
                      ->orWhereIn('cat2.title_url', $services);
                });
            } else {
                // This is a raw keyword search from typing
                $query->where(function($q) use ($service) {
                    $q->where('business.display_name', 'LIKE', '%' . $service . '%')
                      ->orWhere('business.business_description', 'LIKE', '%' . $service . '%')
                      ->orWhere('cat1.title', 'LIKE', '%' . $service . '%')
                      ->orWhere('cat2.title', 'LIKE', '%' . $service . '%');
                });
            }
        }
        
        if($location) {
            $query->where('business.region', 'LIKE', "%$location%");
        }

        $searchQuery = $request->input('search');
        if($searchQuery) {
            $searchTerms = explode(' ', $searchQuery);
            foreach ($searchTerms as $term) {
                $query->where(function ($subQuery) use ($term) {
                    $subQuery->where('business.display_name', 'LIKE', '%' . $term . '%')
                        ->orWhere('business.business_description', 'LIKE', '%' . $term . '%')
                        ->orWhere('business.region', 'LIKE', '%' . $term . '%')
                        ->orWhere('cat1.title', 'LIKE', '%' . $term . '%')
                        ->orWhere('cat2.title', 'LIKE', '%' . $term . '%');
                });
            }
        } else {
            $service = $request->input('service');
            $location = $request->input('location');
            
            if ($service || $location) {
                $terms = [];
                if ($service) {
                    $serviceParts = explode(',', $service);
                    $subcatUrl = $serviceParts[0];
                    $found = false;
                    foreach ($category as $cat) {
                        if (!empty($cat->subcat)) {
                            foreach ($cat->subcat as $sub) {
                                if ($sub->title_url == $subcatUrl) {
                                    $terms[] = $sub->title;
                                    $found = true;
                                    break;
                                }
                            }
                        }
                        if ($found) break;
                    }
                    if (!$found) {
                        $terms[] = ucwords(str_replace('-', ' ', $subcatUrl));
                    }
                }
                if ($location) {
                    $terms[] = $location;
                }
                $searchQuery = implode(' in ', $terms);
            }
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
            'cat2.title', 
            'cat2.title_url' 
        ])
        ->orderBy('average_rating', 'desc');

        // Execute the query and get results
        $topratedBusiness = $query->get();
        //dd($topratedBusiness);
    	return view('frontend/business/list',compact('categories','sideData','topratedBusiness','country_name','category','states', 'searchQuery'));
    }
	public function profile(Request $request) {
		$user_id = Auth::user()->id ?? null;
		if($user_id){
		    $profile =  User::find($user_id);
		    $businessList = Business::select('business.*','countries.shortname','cat1.title', 
            'cat1.title_url', 
            'cat2.title as sec_title', 
            'cat2.title_url as sec_title_url')
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
            if ($grouped->has('side')) {
                $sideData = $grouped->get('side');
            }
            if($grouped->has('mid')){
                $midData = $grouped->get('mid');
            }
            $notice = Notice::where('user_id', $user_id)->get();
            $country = Country::where('status', '1')->get()->toArray();
           $articles = Article::with('category')->where('user_id', $user_id)->latest()->get();
           //echo "<pre>";
		    //print_r($suburb);exit;
		    return view('profile', compact('profile', 'suburb','sideData','midData','notice','businessList','country', 'articles'));
		}else{
		    Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect('/');
		}
	}

	public function StoreProfileBanner(Request $request) {
		$id = Auth::user()->id;
		//dd($id);

		$profile_banner = $request->file('profile_banner');
		$base64coverimage = $request->input('base64coverimage');
		//exit;
		if($profile_banner) {
            $base64_data = preg_replace('#^data:image/\w+;base64,#i', '', $base64coverimage);
            $binaryImageData = base64_decode($base64_data);
            //exit;
            // Ensure directory exists
            $dirPath = 'public/assets/profile/banners';
            if (!file_exists(base_path($dirPath))) {
                mkdir(base_path($dirPath), 0777, true);
            }
            
            $img_ext = strtolower($profile_banner->getClientOriginalExtension());
            $fileName = uniqid() . rand(1111, 1111111111) . '.' . $img_ext;
            $filePath = $dirPath . '/' . $fileName;
            file_put_contents(base_path($filePath), $binaryImageData, LOCK_EX | FILE_BINARY);
            $last_img = $filePath;
		}

		User::find($id)->update([
			'profile_banner'	=> $last_img,
			'updated_at'		=> Carbon::now()
		]);

		return Redirect()->back();
	}
	
	//public function StoreProfilePic(Request $request) {
	//	$id = Auth::user()->id;
		//dd($id);

	//	$profile_pic = $request->file('imageUpload');
	//	if($profile_pic) {

	//		$name_gen =  hexdec(uniqid());
	//		$img_ext = strtolower($profile_pic->getClientOriginalExtension());
	//		$img_name = $name_gen.'.'.$img_ext;
	//		$up_location = 'public/assets/profile/pict/';
	//		$last_img = $up_location.$img_name;

	//		$profile_pic->move($up_location, $img_name);

			
	//	}

	//	User::find($id)->update([
	//		'image'	=> $last_img,
	//		'updated_at'	=> Carbon::now()
	//	]);

	//	return Redirect()->back();
	//}
  public function StoreProfilePic(Request $request) {
        $id = Auth::user()->id;

        // Get the base64 image data
        $base64_image = $request->input('base64image');

        if($base64_image) {
            // Extract the image data and format from base64 string
            // Expected format: data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQ...
            if (preg_match('/^data:image\/(\w+);base64,/', $base64_image, $type)) {
                // Remove the data URL part
                $base64_image = substr($base64_image, strpos($base64_image, ',') + 1);
                $type = strtolower($type[1]); // jpg, png, gif, etc.

                // Validate image type
                if (!in_array($type, ['jpg', 'jpeg', 'gif', 'png', 'webp'])) {
                    return redirect()->back()->with('error', 'Invalid image type');
                }

                // Decode base64 string
                $image_data = base64_decode($base64_image);

                if ($image_data === false) {
                    return redirect()->back()->with('error', 'Failed to decode image');
                }

                // Generate unique filename
                $name_gen = hexdec(uniqid());
                $img_ext = ($type === 'jpg') ? 'jpeg' : $type;
                $img_name = $name_gen . '.' . $img_ext;
                $up_location = 'public/assets/profile/pict';
                $last_img = $up_location . '/' . $img_name;

                // Create directory if it doesn't exist
                if (!file_exists(base_path($up_location))) {
                    mkdir(base_path($up_location), 0777, true);
                }

                // Save the image file
                if (file_put_contents(base_path($last_img), $image_data)) {
                    // Update user record
                    User::find($id)->update([
                        'image' => $last_img,
                        'updated_at' => Carbon::now()
                    ]);

                    return redirect()->back()->with('success', 'Profile picture updated successfully');
                } else {
                    return redirect()->back()->with('error', 'Failed to save image');
                }
            } else {
                return redirect()->back()->with('error', 'Invalid base64 image format');
            }
        } else {
            return redirect()->back()->with('error', 'No image data received');
        }
    }
	public function Register(){
	    $country = Country::where('status', '1')->get()->toArray();
        // print_r($country);
        // exit;
	    return view('auth.register',compact('country')); 
	}
	public function contactUs(){
	    $country = Country::where('status', '1')->get()->toArray();
        // print_r($country);
        // exit;
	    return view('frontend/contact-us',compact('country')); 
	}
	public function GetCityState(Request $request){
	    $countryId = $request->input('country_id');
        // Logic to fetch cities based on $countryId
        $array = [];
        if($countryId== "13" || $countryId== "44"  || $countryId== "101"  ||  $countryId== "230" ||  $countryId== "231"){
            $cities = State::with('cities')->where('country_id',$countryId)->get()->toArray();
            foreach($cities as $state){
                foreach ($state['cities'] as $city){
                    $array[]=["value"=>$city['id'], "text" => $city['name'].", ".$state['name']];
                }
            }
        }elseif($countryId== "157"){
            $cities = State::with('cities.towns')->where('country_id',$countryId)->get()->toArray();
            foreach($cities as $state){
                foreach ($state['cities'] as $city){
                    foreach ($city['towns'] as $town){
                        $array[]=["value"=>$town['id'], "text" => $town['suburb_name'].", ".$city['name'].", ".$state['name']];
                    }
                }
            }
        }
        //print_r($cities);
         usort($array, function($a, $b) {
            return strcmp($a['text'], $b['text']);
        });
        return json_encode($array);
	}
	public function GetCityStatesameVal(Request $request){
	    $countryId = $request->input('country_id');
	    $selected = $request->input('selected');
        // Logic to fetch cities based on $countryId
        $array = [];
        if($countryId== "13" || $countryId== "44"  || $countryId== "101"  ||  $countryId== "230" ||  $countryId== "231"){
            $cities = State::with('cities')->where('country_id',$countryId)->get()->toArray();
            foreach($cities as $state){
                foreach ($state['cities'] as $city){
                    $array[]=["value"=>$city['name'].", ".$state['name'], "text" => $city['name'].", ".$state['name'],"selected" => ($city['name'].", ".$state['name']) == $selected];
                }
            }
        }elseif($countryId== "157"){
            $cities = State::with('cities.towns')->where('country_id',$countryId)->get()->toArray();
            foreach($cities as $state){
                foreach ($state['cities'] as $city){
                    foreach ($city['towns'] as $town){
                        $array[]=["value"=>$town['suburb_name'].", ".$city['name'].", ".$state['name'], "text" => $town['suburb_name'].", ".$city['name'].", ".$state['name'],"selected" => ($town['suburb_name'].", ".$city['name'].", ".$state['name']) == $selected];
                    }
                }
            }
        }
        //print_r($cities);
        usort($array, function($a, $b) {
            return strcmp($a['text'], $b['text']);
        });
        return json_encode($array);
	}
	public function getCitystateForSelectsize(Request $request){
	    $countryId = $request->input('country_id');
        $cities = State::with('cities')->where('country_id',$countryId)->get()->toArray();
        //print_r($cities);
        $array=[];
        foreach($cities as $state){
            foreach ($state['cities'] as $city){
                 $array[]=["value"=>$city['id'], "text" => $city['name'].", ".$state['name']];
            }
        }
        usort($array, function($a, $b) {
            return strcmp($a['text'], $b['text']);
        });
        return json_encode($array);
	}
	public function getStateForSelectsize(Request $request){
	    $request_for = $request->input('request_for');
	    if($request_for=="state"){
	        $countryId = $request->input('country_id');
    	    $cities = State::where('country_id',$countryId)->get()->toArray();
    	    $array=[];
    	    //dd($cities);
            foreach($cities as $state){
                $array[]=["value"=>$state['id'], "text" => $state['name']];
            } 
            usort($array, function($a, $b) {
                return strcmp($a['text'], $b['text']);
            });
	    }elseif($request_for=="city"){
	        $stateId = $request->input('state_id');
	        $cities = City::where('state_id', $stateId)->get()->toArray();
    	    $array=[];
            foreach($cities as $city){
                $array[]=["value"=>$city['id'], "text" => $city['name']];
            }
            usort($array, function($a, $b) {
                return strcmp($a['text'], $b['text']);
            });
	    }
        return json_encode($array);
	}
	public function Logout(Request $request){
	    Auth::logout();

        $request->session()->invalidate();
    
        $request->session()->regenerateToken();
    
        return redirect('/'); 
	}
	public function changeCountry(Request $request){
	    $countryId = $request->input('country_id');
	    session(['CountryCode' => $countryId]);
	    return true;
	}
	public function StoreAboutusr(Request $request){
	    $id = Auth::user()->id;
	    $aboutus = $request->input('aboutus');
	    User::find($id)->update([
			'aboutus'	=> $aboutus,
			'updated_at'	=> Carbon::now()
		]);
		return Redirect()->back();
	} 
	public function Notice(){
	    $category = NoticeCategory::all();
	    $ads = Ads::where('country', session('CountryCode'))->get();
        $grouped = collect($ads)->groupBy('type');
        $sideData=[];
        if ($grouped->has('side')) {
            $sideData = $grouped->get('side');
        }
        
	    return view('auth.notice-form', compact('category','grouped','sideData'));
	}
	public function NoticePost(Request $request){
	    $validatedData = $request->validate([
            'category_id' => 'required',
            'noticetype' => 'required',
            'notice_title' => 'required|string|max:35',
            'notice_body' => 'required|string|max:155',
        ], [
            'category_id.required' => 'The category id is required.',
            'noticetype.required' => 'The notice type is required.',
            'notice_title.required' => 'The notice title is required.',
            'notice_title.max' => 'The notice title must not exceed 35 characters.',
            'notice_body.required' => 'The notice body is required.',
            'notice_body.max' => 'The notice body must not exceed 155 characters.',
        ]);
        //dd($request);
	    $category_id = $request->input('category_id');
	    $noticetype = $request->input('noticetype');
	    $notice_title = $request->input('notice_title');
	    $notice_body = $request->input('notice_body');
	    $noticeimgbase64 = $request->input('noticeimgbase64');
	    $noticeimg = $request->file('noticeimg');
	    
	    $user_id = Auth::user()->id ?? null;

	    $notice = new Notice();
        $notice->user_id = $user_id;
        $notice->category_id = $category_id;
        $notice->noticetype = $noticetype;
        $notice->heading = $notice_title;
        $notice->content = $notice_body;
        $notice->created_at = Carbon::now();
        $notice->expire_at = Carbon::now();
        //dd($notice);
        $notice->save();
        if($noticeimg){
            $base64_data = preg_replace('#^data:image/\w+;base64,#i', '', $noticeimgbase64);
            $binaryImageData = base64_decode($base64_data);
            //exit;
            $img_ext = strtolower($noticeimg->getClientOriginalExtension());
            $fileName = uniqid() .rand(1111,1111111111). '.'.$img_ext;
            $filePath = 'public/assets/notice/' . $fileName;
            file_put_contents($filePath, $binaryImageData, LOCK_EX | FILE_BINARY);
            
            $noticeimg = new NoticeImg();
            $insertedId = $notice->id; 
            $noticeimg->notice_id = $insertedId;
            $noticeimg->img_path = $filePath;
            $noticeimg->created_at = Carbon::now();
            //dd($noticeimg);
            $noticeimg->save();
        }
        return redirect()->route('notice-post')->with('success', 'Notice created successfully!');

	}
	public function contactUsSub(Request $request){
        $this->validate($request, [
                        'name' => 'required',
                        'email' => 'required|email',
                        'country' => 'required',
                        'message' => 'required'
                ]);

        $suburb = City::with('state.country')->find($request->post('suburb_id'));
        Mail::send('email', [
                'name' => $request->post('name'),
                'email' => $request->post('email'),
                'phone_no' => $request->post('phone_no')??'',
                'country' => ($request->post('country')=="others")?$request->post('otherscoun'):$suburb->name.",".$suburb->state->name.",".$suburb->state->country->name,
                'msg' => $request->post('message'),
                'ip' => $request->ip()],
                function ($message) {
                        $message->from('no-reply@catchakiwi.com');
                        $message->to('catchakiwi@hotmail.co.nz', 'Catchakiwi') 
                        ->subject('Your Website Contact Form');
                        $message->bcc(['souravghoshmgu1@gmail.com']);
                        $message->priority(1);
        });
		
		

        return redirect()->route('contact-us')->with('success', 'Contact Us email sent successfully!');

    }
    public function test(){
        $st = 5000; // Start state id
        $ct = 50000; // Start city id
        
        $states = State::get(); // Retrieve all states
        
        foreach ($states as $state) {
            // Update state id and increment $st
            State::where('id', $state['id'])->update(['id' => $st]);
            
            $cities = City::where('state_id', $state['id'])->get(); // Get cities for this state
            
            foreach ($cities as $city) {
                // Update city id and state_id, then increment $ct
                City::where('id', $city['id'])->update([
                    'id' => $ct,
                    'state_id' => $st
                ]);
        
                // Update towns with the new city_id
                Towns::where('city_id', $city['id'])->update(['city_id' => $ct]);
                
                $ct++; // Increment city id
            }
            
            $st++; // Increment state id
        }
    }
  public function updateProfile(Request $request)
  {
      $user = Auth::user();

      // Define which fields are allowed to be updated and their validation rules
      $allowedFields = [
          'name'               => 'sometimes|required|string|max:255',
          'name_visibility'    => 'sometimes',
          'firstname'         => 'sometimes|required|string',
          'lastname'          => 'sometimes|required|string',
          'fname_visibility'    => 'sometimes',
          'lname_visibility'    => 'sometimes',
          'email'              => 'sometimes|required|email|unique:users,email,' . $user->id,
		  'dob'                => 'sometimes|required',
          'dob_visibility'     => 'sometimes',
          'city_visibility'     => 'sometimes',
          'suburb_visibility'     => 'sometimes',
          'country_id'         => 'sometimes|required|integer|exists:countries,id',
          'suburb_id'          => 'sometimes|required|integer',
          'country_visibility' => 'sometimes',
      ];

      // Only validate fields that are actually sent in the request
      $validated = $request->validate($allowedFields);

      $dataToUpdate = $validated;

      // Special logic: Update country_status based on country_id
      if ($request->has('country_id')) {
          $countryId = (int) $request->country_id;

          $domesticCountries = [13, 44, 101, 230, 231]; // AU, CA, NZ, UK, US

          $dataToUpdate['country_status'] = $countryId === 157 
              ? '1' 
              : (in_array($countryId, $domesticCountries) ? '0' : '1');
      }

      // Update only the fields provided
      $user->update($dataToUpdate);

      return response()->json([
          'success' => true,
          'message' => 'Profile updated successfully.',
          'user'    => $user->only(['id', 'name', 'email', 'suburb_id', 'country_status', 'profile_photo_path'])
      ]);
  }
  public function requestEmailChange(Request $request)
  {
      $request->validate([
          'email' => 'required|email|unique:users,email'
      ]);

      $user = Auth::user();

      // Update only the temp_email related fields for this user
      $user->temp_email                  = $request->email;
      $user->email_change_requested_at = now();
      $user->save();

      // === ZOHO MAIL NOTIFICATION TO ADMIN ===
      $htmlContent = "New Email Change Request\n\n<br><br>" .
                     "User Details:\n<br>" .
                     "----------------\n<br>" .
                     "User ID      : {$user->id}\n<br>" .
                     "Name         : {$user->name}\n<br>" .
                     "Current Email: {$user->email}\n<br>" .
                     "Requested Email: {$user->temp_email}\n<br>" .
                     "Requested At : " . now()->format('d M Y, h:i A') . "\n\n<br>" .
                     "Please review and approve/reject in the admin panel.";

      $toEmail = 'souravghoshmgu1@gmail.com'; // Change to your actual admin email
      $subject = "Email Change Request - User: {$user->name} (ID: {$user->id})";

      // Step 1: Get Access Token
      $client_id     = env('ZOHO_CLIENT_ID');
      $client_secret = env('ZOHO_CLIENT_SECRET');
      $refresh_token = env('ZOHO_REFRESH_TOKEN');
      $token_url     = "https://accounts.zoho.com/oauth/v2/token";

      $tokenData = [
          "refresh_token" => $refresh_token,
          "client_id"     => $client_id,
          "client_secret" => $client_secret,
          "grant_type"    => "refresh_token"
      ];

      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $token_url);
      curl_setopt($ch, CURLOPT_POST, true);
      curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($tokenData));
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
      curl_setopt($ch, CURLOPT_TIMEOUT, 30);

      $response = curl_exec($ch);

      if (curl_error($ch)) {
          curl_close($ch);
          \Log::error('Zoho Token cURL Error: ' . curl_error($ch));
          return response()->json(['success' => false, 'message' => 'Failed to connect to email service'], 500);
      }
      curl_close($ch);

      $tokenResponse = json_decode($response, true);

      if (!isset($tokenResponse['access_token'])) {
          \Log::error('Zoho Access Token Failed', $tokenResponse);
          return response()->json(['success' => false, 'message' => 'Email service authentication failed'], 500);
      }

      $access_token = $tokenResponse['access_token'];
      
      // === Step 2: Send Email via Zoho Mail API ===
      $account_id = env('ZOHO_ACCOUNT_ID');
      $api_url    = "https://mail.zoho.com/api/accounts/{$account_id}/messages";

      $mailData = [
          "fromAddress" => "support@catchakiwi.co.nz",
          "toAddress"   => $toEmail,
          "subject"     => $subject,
          "content"     => $htmlContent
          // Remove "fromName" — this was causing EXTRA_KEY_FOUND_IN_JSON
      ];

      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $api_url);
      curl_setopt($ch, CURLOPT_POST, true);
      curl_setopt($ch, CURLOPT_HTTPHEADER, [
          "Authorization: Zoho-oauthtoken {$access_token}",
          "Content-Type: application/json"
      ]);
      curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($mailData));
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
      curl_setopt($ch, CURLOPT_TIMEOUT, 30);

      $sendResponse = curl_exec($ch);

      if (curl_error($ch)) {
          curl_close($ch);
          \Log::error('Zoho Send Mail cURL Error: ' . curl_error($ch));
          return response()->json(['success' => false, 'message' => 'Failed to send email'], 500);
      }
      curl_close($ch);

      $result = json_decode($sendResponse, true);

      // Success check (Zoho returns status.code = 200 on success)
      if (isset($result['status']['code']) && $result['status']['code'] == 200) {
          return response()->json(['success' => true, 'message' => 'Email change request sent successfully']);
      } else {
          \Log::error('Zoho Mail API Error', $result ?? ['response' => $sendResponse]);
          return response()->json(['success' => false, 'message' => 'Failed to send notification email'], 500);
      }
  }
  public function requestPasswordChange(Request $request)
  {
      $request->validate([
          'password' => 'required|min:8'
      ]);

      $otp = rand(100000, 999999);
      Auth::user()->update([
          'password_otp' => $otp,
          'password_otp_expires_at' => now()->addMinutes(10),
          'pending_password' => Hash::make($request->password)
      ]);

      $content = "Password Change OTP\n\n" .
                 "Your 6-digit OTP: {$otp}\n\n" .
                 "Valid for 10 minutes.\n\n" .
                 "Catch A Kiwi Team";

      $this->sendZohoEmail(Auth::user()->email, "Password Change OTP", $content);

      return response()->json(['success' => true]);
  }

  public function verifyPasswordOtp(Request $request)
  {
      $request->validate(['otp' => 'required|digits:6']);

      $user = Auth::user();

      if ($user->password_otp != $request->otp || now()->gt($user->password_otp_expires_at)) {
          return response()->json(['message' => 'Invalid or expired OTP'], 422);
      }

      $user->password = $user->pending_password;
      $user->password_otp = null;
      $user->password_otp_expires_at = null;
      $user->pending_password = null;
      $user->save();

      return response()->json(['success' => true]);
  }
  private function sendZohoEmail($toEmail, $subject, $content)
  {
      // === Step 1: Get Access Token ===
      $client_id     = env('ZOHO_CLIENT_ID');
      $client_secret = env('ZOHO_CLIENT_SECRET');
      $refresh_token = env('ZOHO_REFRESH_TOKEN');
      $token_url     = "https://accounts.zoho.com/oauth/v2/token";

      $tokenData = [
        "refresh_token" => $refresh_token,
        "client_id"     => $client_id,
        "client_secret" => $client_secret,
        "grant_type"    => "refresh_token"
      ];

      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $token_url);
      curl_setopt($ch, CURLOPT_POST, true);
      curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($tokenData));
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
      curl_setopt($ch, CURLOPT_TIMEOUT, 30);

      $response = curl_exec($ch);

      if (curl_error($ch)) {
        \Log::error('Zoho Token cURL Error: ' . curl_error($ch));
        curl_close($ch);
        return false;
      }
      curl_close($ch);

      $tokenResponse = json_decode($response, true);

      if (!isset($tokenResponse['access_token'])) {
        \Log::error('Zoho Access Token Failed', $tokenResponse);
        return false;
      }

      $access_token = $tokenResponse['access_token'];

      // === Step 2: Send Email via Zoho Mail API ===
      $account_id = env('ZOHO_ACCOUNT_ID');
      $api_url    = "https://mail.zoho.com/api/accounts/{$account_id}/messages";

      $mailData = [
        "fromAddress" => "support@catchakiwi.co.nz",
        "toAddress"   => $toEmail,
        "subject"     => $subject,
        "content"     => $content
        // "fromName" removed intentionally to avoid EXTRA_KEY_FOUND_IN_JSON error
      ];

      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $api_url);
      curl_setopt($ch, CURLOPT_POST, true);
      curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: Zoho-oauthtoken {$access_token}",
        "Content-Type: application/json"
      ]);
      curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($mailData));
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
      curl_setopt($ch, CURLOPT_TIMEOUT, 30);

      $sendResponse = curl_exec($ch);

      if (curl_error($ch)) {
        \Log::error('Zoho Send Mail cURL Error: ' . curl_error($ch));
        curl_close($ch);
        return false;
      }
      curl_close($ch);

      $result = json_decode($sendResponse, true);

      if (isset($result['status']['code']) && $result['status']['code'] == 200) {
        return true;
      } else {
        \Log::error('Zoho Mail Send Failed', $result ?? ['response' => $sendResponse]);
        return false;
    }
  }
  public function markAsRead(Request $request)
  {
      $request->validate(['notification_id' => 'required|exists:notifications,id']);

      auth()->user()->receivedNotifications()
          ->updateExistingPivot($request->notification_id, [
              'read' => true,
              'read_at' => now()
          ]);

      return response()->json(['success' => true]);
  }
}
