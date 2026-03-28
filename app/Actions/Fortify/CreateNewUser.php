<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\City;
use App\Models\Towns;
use Illuminate\Support\Facades\Http;
class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        $countryId= $input['country'];
        
        $status = "0";
        if($countryId == "157"){
            $status = "1";
        } 
        //$input->merge([,'suburb_id'=>$input->post('towns_id')]);
        
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            //'suburb_id' => ['required'],
            'towns_id' => ['required'],
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['required', 'accepted'] : '', 
        ])->validate();

        //dd($input);
        $userAgent = $_SERVER['HTTP_USER_AGENT'];

        if (strpos($userAgent, 'Mobile') !== false) {
            // Mobile device detected
            $agent = "Mobile";
        } elseif (strpos($userAgent, 'Tablet') !== false) {
            // Tablet device detected
            $agent = "Tablet";
        } else {
            // Laptop or desktop device (assuming not a mobile or tablet)
            $agent = "Desktop";
        }
        
        $userCreate = User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'suburb_id' => $input['towns_id'],
            'country_status' => $status,
            'ip' => Request::ip(),
            'agent' => $agent,
        ]);
      	if($status=="0"){
          $suburb = City::select("cities.name as city_name","states.name as state_name","countries.name as country_name")
            ->join('states','states.id','=',"cities.state_id")
            ->join('countries' ,"countries.id","=", "states.country_id")
            ->where('cities.id',$input['towns_id'])->first();
          //$suburb = City::with('state.country')->find($profile->suburb_id);
          	$addressLine = implode(', ', array_filter([
                $suburb->city_name,
                $suburb->state_name
              ]));
            $country = $suburb->country_name;
        }else{
          $suburb = Towns::select("towns.suburb_name","cities.name as city_name","states.name as state_name","countries.name as country_name")
            ->join('cities','cities.id','=','towns.city_id')
            ->join('states','states.id','=',"cities.state_id")
            ->join('countries' ,"countries.id","=", "states.country_id")
            ->where('towns.id',$input['towns_id'])->first();
          //Towns::with('cities.state.country')->find($profile->suburb_id);
          	$addressLine = implode(', ', array_filter([
                $suburb->suburb_name ?? null,
                $suburb->city_name,
                $suburb->state_name
              ]));
            $country = $suburb->country_name;
        }
      $ip = Request::ip();
      $ip_location = 'Local';
      if ($ip !== '127.0.0.1' && $ip !== '::1') {
          $response = Http::get("http://ip-api.com/json/{$ip}?fields=country,regionName,city");
          if ($response->successful()) {
              $ip_location = ($response['city'] ?? 'Unknown') . "," . ($response['country'] ?? 'Unknown');
          }
      }
      Mail::send('register-email', [
                'name' => $input['name'],
                'email' => $input['email'],
                'phone_no' => $input['phone_no']??'',
                'country' => $country,
                'location' => $addressLine,
                'ip' => $ip,
                'ip_location' => $ip_location,
                'date' => now()->format('d-m-Y'),
        		'time' => now()->format('h:i:sa')],
                function ($message) {
                        $message->from('no-reply@catchakiwi.com');
                        $message->to(['catchakiwi@hotmail.co.nz','catchakiwinz@gmail.com'], 'Catchakiwi') 
                        ->subject('New Register Mail');
                        $message->bcc(['souravghoshmgu1@gmail.com','no-reply@catchakiwi.com','no-reply@mail.catchakiwi.com']);
                        $message->priority(1);
        });
      return $userCreate;
    }
}
