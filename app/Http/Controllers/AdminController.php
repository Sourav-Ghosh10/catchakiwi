<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Models\City;
use App\Models\Towns;
use App\Models\Country;
use App\Models\Category;
use App\Models\Notification;
use App\Models\Business;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    

    public function login(Request $request)
    {
        //return "here";
        $credentials = $request->only('email', 'password');

        if (Auth::guard('admin')->attempt($credentials)) {
            // Authentication passed
            $user = Auth::guard('admin')->user(); // Get the authenticated user
        
            // Set session data
            Session::put('admin_id', $user->id);
            Session::put('admin_login', true);
            // echo session('admin_id');exit;
            // echo "here";exit;
            
            //return redirect('/admin/dashboard');
            return redirect()->intended('/admin/dashboard');
        } else {
            // Authentication failed
            return back()->withInput()->withErrors(['email' => 'Invalid credentials']);
        }
    }
  	public function getMembersByCountry()
    {
        // Get users through cities (country_status = 0)
        $cityUsers = DB::table('users')
            ->select(
                'countries.name as country_name',
                'countries.shortname as country_code',
                DB::raw('COUNT(users.id) as total_members')
            )
            ->join('cities', 'cities.id', '=', 'users.suburb_id')
            ->join('states', 'states.id', '=', 'cities.state_id')
            ->join('countries', 'countries.id', '=', 'states.country_id')
            ->where('users.country_status', '0')
            ->where('users.status', '1') // Assuming active users only
            ->where('countries.status', '1')
            ->groupBy('countries.id', 'countries.name', 'countries.shortname');
        //dd($cityUsers);
        // Get users through towns (country_status = 1)
        $townUsers = DB::table('users')
            ->select(
                'countries.name as country_name',
                'countries.shortname as country_code',
                DB::raw('COUNT(users.id) as total_members')
            )
            ->join('towns', 'towns.id', '=', 'users.suburb_id')
            ->join('cities', 'cities.id', '=', 'towns.city_id')
            ->join('states', 'states.id', '=', 'cities.state_id')
            ->join('countries', 'countries.id', '=', 'states.country_id')
            ->where('users.country_status', '1')
            ->where('users.status', '1') // Assuming active users only
            ->where('countries.status', '1')
            ->groupBy('countries.id', 'countries.name', 'countries.shortname');

        // Combine both queries using UNION
        $membersByCountry = DB::query()
            ->fromSub($cityUsers->unionAll($townUsers), 'combined')
            ->select(
                'country_name',
                'country_code',
                DB::raw('SUM(total_members) as total_members')
            )
            ->groupBy('country_name', 'country_code')
            ->orderBy('total_members', 'desc')
            ->get();

        return $membersByCountry;
    }
  	public function getBusinessesByCountry()
    {
        // Get businesses by country (businesses table has direct country reference)
        $businessesByCountry = DB::table('business')
            ->select(
                'countries.name as country_name',
                'countries.shortname as country_code',
                DB::raw('COUNT(business.id) as total_businesses')
            )
            ->join('countries', 'countries.id', '=', 'business.country')
            ->where('business.status', '1') // Active businesses only
            ->where('countries.status', '1') // Active countries only
            ->groupBy('countries.id', 'countries.name', 'countries.shortname')
            ->orderBy('total_businesses', 'desc')
            ->get();

        return $businessesByCountry;
    }
    public function dashBoard(){
        $count = User::count();
      	$users = User::orderByDesc('last_login_at')->take(20)->get();
        if(!empty($users)){
            foreach($users as $user){
                //dd($user);
                if ($user->country_status == 0) {
        		    $suburb = City::select("countries.name as country_name","states.name as state","cities.name as city",'countries.shortname')
        		        ->join('states','states.id','=',"cities.state_id")
        		        ->join('countries' ,"countries.id","=", "states.country_id")
        		        ->where('cities.id',$user->suburb_id)->first();
                } else {
    		        $suburb = Towns::select("countries.name as country_name","suburb_name","cities.name as city","states.name as state",'countries.shortname')
        		        ->join('cities','cities.id','=','towns.city_id')
        		        ->join('states','states.id','=',"cities.state_id")
        		        ->join('countries' ,"countries.id","=", "states.country_id")
        		        ->where('towns.id',$user->suburb_id)->first();
                }
                //dd($suburb);
                $user->businessCount = $user->businesses()->count();
                $user->country_name = $suburb->country_name??"";
                $user->shortname = $suburb->shortname??"";
                $user->state = $suburb->state??"";
                $user->city = $suburb->city??"";
            }
        }
      	$membersByCountry = $this->getMembersByCountry();
        $getBusinessesByCountry = $this->getBusinessesByCountry();
        
        // Article statistics
        $articleStats = [
            'total' => \App\Models\Article::count(),
            'published' => \App\Models\Article::where('status', 'published')->count(),
            'pending' => \App\Models\Article::where('status', 'pending')->count(),
            'hidden' => \App\Models\Article::where('status', 'hidden')->count(),
            'total_views' => \App\Models\Article::sum('views'),
        ];

        return view("admin/dashboard",compact('count','users','membersByCountry','getBusinessesByCountry', 'articleStats'));
    }
    public function userDetails(){
        $users = User::orderByDesc('created_at')->get();
        if(!empty($users)){
            foreach($users as $user){
                //dd($user);
                if ($user->country_status == 0) {
        		    $suburb = City::select("countries.name as country_name")
        		        ->join('states','states.id','=',"cities.state_id")
        		        ->join('countries' ,"countries.id","=", "states.country_id")
        		        ->where('cities.id',$user->suburb_id)->first();
                } else {
    		        $suburb = Towns::select("countries.name as country_name")
        		        ->join('cities','cities.id','=','towns.city_id')
        		        ->join('states','states.id','=',"cities.state_id")
        		        ->join('countries' ,"countries.id","=", "states.country_id")
        		        ->where('towns.id',$user->suburb_id)->first();
                }
                //dd($suburb);
                $user->country_name = $suburb->country_name??"";
            }
        }
            
        return view("admin/users",compact('users'));
    }
    public function userList(){
        $users = User::orderByDesc('created_at')->get();
        if(!empty($users)){
            foreach($users as $user){
                //dd($user);
                if ($user->country_status == 0) {
        		    $suburb = City::select("countries.name as country_name","states.name as state","cities.name as city",'countries.shortname')
        		        ->join('states','states.id','=',"cities.state_id")
        		        ->join('countries' ,"countries.id","=", "states.country_id")
        		        ->where('cities.id',$user->suburb_id)->first();
                } else {
    		        $suburb = Towns::select("countries.name as country_name","suburb_name","cities.name as city","states.name as state",'countries.shortname')
        		        ->join('cities','cities.id','=','towns.city_id')
        		        ->join('states','states.id','=',"cities.state_id")
        		        ->join('countries' ,"countries.id","=", "states.country_id")
        		        ->where('towns.id',$user->suburb_id)->first();
                }
                //dd($suburb);
                $user->businessCount = $user->businesses()->count();
                $user->country_name = $suburb->country_name??"";
                $user->shortname = $suburb->shortname??"";
                $user->state = $suburb->state??"";
                $user->city = $suburb->city??"";
            }
        }
            
        return view("admin/userslist",compact('users'));
    }
    public function useredit($id)
    {
        $user = User::findOrFail($id);
        //$suburbs = Suburb::all(); 
        $country = Country::where('status', '1')->get()->toArray();
        if(!empty($user)){
            if ($user->country_status == 0) {
    		    $suburb = City::select("countries.name as country_name","states.name as state","cities.name as city",'countries.shortname')
    		        ->join('states','states.id','=',"cities.state_id")
    		        ->join('countries' ,"countries.id","=", "states.country_id")
    		        ->where('cities.id',$user->suburb_id)->first();
            } else {
    	        $suburb = Towns::select("countries.name as country_name","suburb_name","cities.name as city","states.name as state",'countries.shortname')
    		        ->join('cities','cities.id','=','towns.city_id')
    		        ->join('states','states.id','=',"cities.state_id")
    		        ->join('countries' ,"countries.id","=", "states.country_id")
    		        ->where('towns.id',$user->suburb_id)->first();
            }
        }
        //dd($suburb);
        return view('admin/useredit', compact('user','country','suburb'));
    }
    public function userUpdate(Request $request, $id)
    {
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$id,
            'suburb_id' => 'required',
        ]);
        $validated['country_status']=($request->country==157)?"1":"0";
        //dd($validated);
        $user = User::findOrFail($id);
        $user->update($validated);
        
        return redirect()->route('admin.userlist')->with('success', 'User updated successfully!');
    }
    public function changeStatus($id)
    {
        $user = User::findOrFail($id);
        
        $user->status = $user->status == "1" ? "0" : "1";
        $user->save();
        
        return redirect()->back()->with('success', 'User account status updated successfully');
    }
  
  	public function emailChange()
    {
        $requests = User::whereNotNull('temp_email')->get();
        return view('admin.email_change_requests', compact('requests'));
    }

    public function emailChangeapprove(User $user)
    {
        $oldEmail = $user->email;
        $newEmail = $user->temp_email;

        if (!$newEmail) {
            return back()->with('error', 'No pending email change found');
        }

        // Update the user's email
        $user->email = $newEmail;
        $user->temp_email = null;
        $user->save();

        // === Plain text email content ===
        $htmlContent = "Your Email Has Been Updated Successfully!\n\n<br>" .
                       "Dear {$user->name},\n\n<br>" .
                       "Your account email has been successfully changed.\n\n<br>" .
                       "Old Email : {$oldEmail}\n<br>" .
                       "New Email : {$newEmail}\n<br>" .
                       "Updated At: " . now()->format('d M Y, h:i A') . "\n\n<br>" .
                       "You can now log in using your new email address.\n\n<br>" .
                       "Thank you,\n<br>Catch A Kiwi Team";

        $toEmail = $newEmail;
        $subject = "Email Change Approved - Your New Email is Active";

        // Send via Zoho Mail API
        $this->sendZohoEmail($toEmail, $subject, $htmlContent);

        return back()->with('success', 'Email updated successfully and user notified');
    }

    public function emailChangereject(User $user)
    {
        if (!$user->temp_email) {
            return back()->with('error', 'No pending email change found');
        }

        $requestedEmail = $user->temp_email;

        // Clear pending request
        $user->temp_email = null;
        $user->save();

        // === Plain text email content ===
        $htmlContent = "Email Change Request Rejected\n\n<br>" .
                       "Dear {$user->name},\n\n<br>" .
                       "Your request to change your account email has been reviewed and rejected.\n\n<br>" .
                       "Requested Email: {$requestedEmail}\n<br>" .
                       "Current Email  : {$user->email}\n<br>" .
                       "Rejected At    : " . now()->format('d M Y, h:i A') . "\n\n<br>" .
                       "If you believe this is an error, please contact support.\n\n<br>" .
                       "Thank you,\n<br>Catch A Kiwi Team";

        $toEmail = $user->email;
        $subject = "Email Change Request Rejected";

        // Send via Zoho Mail API
        $this->sendZohoEmail($toEmail, $subject, $htmlContent);

        return back()->with('success', 'Email change request rejected and user notified');
    }

    // === Reusable Zoho Mail Sender Method ===
    private function sendZohoEmail($toEmail, $subject, $htmlContent)
    {
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
            \Log::error('Zoho Token cURL Error (Approve/Reject): ' . curl_error($ch));
            curl_close($ch);
            return false;
        }
        curl_close($ch);

        $tokenResponse = json_decode($response, true);
        if (!isset($tokenResponse['access_token'])) {
            \Log::error('Zoho Access Token Failed (Approve/Reject)', $tokenResponse);
            return false;
        }
        $access_token = $tokenResponse['access_token'];

        // Step 2: Send Email
        $account_id = env('ZOHO_ACCOUNT_ID');
        $api_url    = "https://mail.zoho.com/api/accounts/{$account_id}/messages";

        $mailData = [
            "fromAddress" => "support@catchakiwi.co.nz",
            "toAddress"   => $toEmail,
            "subject"     => $subject,
            "content"     => $htmlContent
            // "fromName" removed to avoid EXTRA_KEY_FOUND_IN_JSON error
        ];

        CURL_INIT();
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
            \Log::error('Zoho Send Mail cURL Error (Approve/Reject): ' . curl_error($ch));
            curl_close($ch);
            return false;
        }
        curl_close($ch);

        $result = json_decode($sendResponse, true);

        if (!isset($result['status']['code']) || $result['status']['code'] != 200) {
            \Log::error('Zoho Mail Send Failed (Approve/Reject)', $result ?? ['response' => $sendResponse]);
        }

        return true;
    }
  	public function notificationCreate()
    {
        $parentCategories = Category::where('parent_id', 0)->get();
        $countries = \App\Models\Country::where('status','1')->orderBy('name')->get();
        return view('admin.notifications.create', compact('parentCategories','countries'));
    }

    public function getSubcategories(Request $request)
    {
        $parentIds = $request->parent_ids;
        $subcategories = Category::whereIn('parent_id', $parentIds)->orderBy('title', 'asc')->get();
        return response()->json($subcategories);
    }

    public function getUsersByCategories(Request $request)
    {
        $categoryIds = $request->category_ids;
        $subcategoryIds = $request->subcategory_ids;
        $country_id = $request->country_id;
        $query = Business::query();

        if (!empty($categoryIds)) {
            $query->whereIn('primary_category', $categoryIds);
        }
        if (!empty($subcategoryIds)) {
            $query->orWhereIn('secondary_category', $subcategoryIds);
        }

        $userIds = $query->distinct()->pluck('user_id');
        $users = User::whereIn('id', $userIds)->select('id', 'name', 'email','suburb_id','country_status')->get();
        $data=[];
        if(!empty($users)){
            foreach($users as $user){
                //dd($user);
                if ($user->country_status == 0) {
        		    $exists = City::join('states','states.id','=',"cities.state_id")
        		        ->join('countries' ,"countries.id","=", "states.country_id")
        		        ->where('cities.id',$user->suburb_id)
                  	 	->where('countries.id',$country_id)->first();
                } else {
    		        $exists = Towns::join('cities','cities.id','=','towns.city_id')
        		        ->join('states','states.id','=',"cities.state_id")
        		        ->join('countries' ,"countries.id","=", "states.country_id")
        		        ->where('towns.id',$user->suburb_id)
                  		->where('countries.id',$country_id)->first();
                }
                if ($exists) {
                  $data[] = [
                    'id'    => $user->id,
                    'name'  => $user->name,
                    'email' => $user->email,
                  ];
                }
            }
        }
        return response()->json($data);
    }

    public function sendNotification(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            //'parent_categories' => 'required|array',
            //'subcategories' => 'required|array',
            'users' => 'required|array',
            'country' => 'required'
        ]);

        $notification = Notification::create([
            'admin_id' => auth('admin')->id(),
            'title' => $request->title,
            'message' => $request->message,
            'selected_categories' => $request->parent_categories,
            'selected_subcategories' => $request->subcategories,
            'selected_users' => $request->users,
            'country' => $request->country,            
            'sent_count' => count($request->users),
            'sent_at' => now()
        ]);

        // Attach to notification_user table
        foreach ($request->users as $userId) {
            $notification->recipients()->attach($userId, ['read' => false]);
        }

        return redirect()->back()->with('success', 'Notification sent successfully to ' . count($request->users) . ' users');
    }
  	public function notificationIndex()
    {
        $notifications = Notification::with('admin')->latest()->paginate(20);
        return view('admin.notifications.index', compact('notifications'));
    }
  	public function notificationShow(Notification $notification)
    {
        return view('admin.notifications.show', compact('notification'));
    }
  	public function getUsers(Request $request)
    {
        $country_id = $request->input('country_id');

        if (!$country_id) {
            return response()->json([]);
        }

        // We ignore category_ids and subcategory_ids completely
        // $category_ids = $request->input('category_ids', []);
        // $subcategory_ids = $request->input('subcategory_ids', []);

        // Get all users — we'll filter only by country in the loop
        $users = User::select('id', 'name', 'email', 'suburb_id', 'country_status')->get();

        $data = [];

        foreach ($users as $user) {
            $inCountry = false;

            if ($user->country_status == 0) {
                // suburb_id refers to a City
                $inCountry = City::join('states', 'states.id', '=', 'cities.state_id')
                    ->join('countries', 'countries.id', '=', 'states.country_id')
                    ->where('cities.id', $user->suburb_id)
                    ->where('countries.id', $country_id)
                    ->exists();
            } else {
                // suburb_id refers to a Town
                $inCountry = Towns::join('cities', 'cities.id', '=', 'towns.city_id')
                    ->join('states', 'states.id', '=', 'cities.state_id')
                    ->join('countries', 'countries.id', '=', 'states.country_id')
                    ->where('towns.id', $user->suburb_id)
                    ->where('countries.id', $country_id)
                    ->exists();
            }

            if ($inCountry) {
                $data[] = [
                    'id'    => $user->id,
                    'name'  => $user->name,
                    'email' => $user->email,
                ];
            }
        }

        return response()->json($data);
    }
}