<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Suburb;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Category;

class AjaxController extends Controller
{
    //
    public function GetRegionDistrict(Request $request) {
    		$suburb_id = $request->suburb_id;
    		$suburb = Suburb::find($suburb_id);
    		if($suburb) {
    			//$district_name = json_encode($suburb->district->district_name);
    			$suburbdtls = json_encode($suburb->district->district_name.'_'.$suburb->region->region_name);
    			echo $suburbdtls;
    		} else {
    			echo 'Failed';
    		}
    }
    
    //Auto suggestion box Registration page
    public function GetSuburbs(Request $request) {

        $search = $request->searchterm;
       if( $search=="" ) {

            $suburbs = DB::table('suburbs')
                        ->join('districts', 'districts.id', '=', 'suburbs.district_id')
                        ->join('regions', 'regions.id', '=', 'suburbs.region_id')
                        ->select('suburbs.*', 'districts.district_name', 'regions.region_name' ) 
                        ->limit(5)
                        ->get();
        } else {
             // $suburbs = Suburb::orderby("suburb_name", "asc")
             //                        ->select("id", "suburb_name")
             //                        ->where("suburb_name","like", "%".$search."%")
             //                        ->limit(5)
             //                        ->get();
                $suburbs = DB::table('suburbs')
                            ->join('districts', 'districts.id', '=', 'suburbs.district_id')
                            ->join('regions', 'regions.id', '=', 'suburbs.region_id')
                            ->select('suburbs.*', 'districts.district_name', 'regions.region_name' )
                            ->where("suburbs.suburb_name","like", "%".$search."%")
                            ->limit(5)
                            ->get();
        }

        $response =  array();
        foreach($suburbs as $suburb) {
            $response[] = array(
                "value" => $suburb->id,
                "label" => $suburb->suburb_name.', '.$suburb->district_name
            );
        }

        return response()->json($response);
    }
    function GetSubcat(Request $request){
        $categoryId = $request->input('catid');
        $selected = $request->input('selected')??0;
        $category = Category::where('parent_id', $categoryId)->get()->toArray();
        $array=[];
        foreach($category as $cat){
           $array[]=["value"=>$cat['id'], "text" => $cat['title'],"selected" => $cat['id'] == $selected];
            
        }
        usort($array, function($a, $b) {
            return strcmp($a['text'], $b['text']);
        });
        return json_encode($array);
    }
    
}
