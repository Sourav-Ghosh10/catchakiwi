<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\Towns;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function index()
    {
        $countries = Country::where('status', '1')->get(); 

        return view('admin.locations.index', compact('countries'));
    }

    public function getStatesByCountry($countryId)
    {
        $states = State::where('country_id', $countryId)->orderBy('name')->get();
        
        return response()->json($states);
    }
    public function getCitiesByState($stateId)
    {
        $cities = City::where('state_id', $stateId)->orderBy('name')->get();
        
        return response()->json($cities);
    }
    public function getTownsByCity($cityId)
    {
        $towns = Towns::where('city_id', $cityId)->orderBy('suburb_name')->get();
        
        return response()->json($towns);
    }
    public function update(Request $request)
    {
        //dd($_POST);
        if($request->state_id){
            $state = State::find($request->state_id);
            if ($state) {
                $state->update(['name' => $request->state_name,'lat'=>$request->lat,'longitude'=>$request->long,'zoom_level'=>$request->zoomlevel]);
            } else { 
                return response()->json(['message' => 'State not found.'], 404);
            }
        }
        // Update City Name
        if($request->city_id){
            $city = City::find($request->city_id);
            if ($city) {
                $city->update(['name' => $request->city_name,'lat'=>$request->lat,'longitude'=>$request->long,'zoom_level'=>$request->zoomlevel]);
            } else {
                return response()->json(['message' => 'City not found.'], 404);
            }
        }
    
        // Update Town Name (if provided)
        if ($request->town_id) {
            $town = Towns::find($request->town_id);
            if ($town) {
                $town->update(['suburb_name' => $request->town_name,'lat'=>$request->lat,'longitude'=>$request->long,'zoom_level'=>$request->zoomlevel]); // Assuming the town name is stored in `suburb_name`
            } else {
                return response()->json(['message' => 'Town not found.'], 404);
            }
        }
    
        return response()->json(['message' => 'Location names updated successfully!']);
    }
    public function add(Request $request){
        if($request->type=="state"){
            State::create([
                'name' => $request->locname,
                'lat' => $request->lat,
                'longitude' => $request->long,
                'country_id' => $request->id,
                'zoom_level'=>$request->zoomlevel
            ]);
        }elseif($request->type=="town"){
            Towns::create([
                'suburb_name' => $request->locname,
                'lat' => $request->lat,
                'longitude' => $request->long,
                'city_id' => $request->id,
                'zoom_level'=>$request->zoomlevel
            ]);
        }elseif($request->type=="city"){
            City::create([
                'name' => $request->locname,
                'lat' => $request->lat,
                'longitude' => $request->long,
                'state_id' => $request->id,
                'zoom_level'=>$request->zoomlevel
            ]);
        }
    
        return response()->json(['message' => 'Location created successfully']);
    }
    public function Delete(Request $request){
        $cityid = $request->cityid;
        $townid = $request->townid;
        $stateid = $request->stateid;
        $type = $request->type;
        if($stateid!=""){
            $state = State::find($stateid);
            if ($state) {
                $state->delete();
                return response()->json(['message' => 'Record deleted successfully.']);
            }
        }
        if($cityid!=""){
            $city = City::find($cityid);
            if ($city) {
                $city->delete();
                return response()->json(['message' => 'Record deleted successfully.']);
            }
        }
        if($townid!=""){
            $town = Towns::find($townid);
            if ($town) {
                $town->delete();
                return response()->json(['message' => 'Record deleted successfully.']);
            }
        }
        
    }

}
