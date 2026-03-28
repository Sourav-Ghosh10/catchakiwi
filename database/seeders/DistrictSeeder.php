<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('districts')->insert([
        	[
        		'region_id'		=> 1,
        		'district_name'	=> 'Far North District'
        	],
        	[
        		'region_id'		=> 1,
        		'district_name'	=> 'Whangarei District'
        	],
        	[
        		'region_id'		=> 1,
        		'district_name'	=> 'Kaipara Districtt'
        	],
        	[
        		'region_id'		=> 2,
        		'district_name'	=> 'Auckland City'
        	],
        	[
        		'region_id'		=> 2,
        		'district_name'	=> 'Franklin'
        	],
        	[
        		'region_id'		=> 2,
        		'district_name'	=> 'Hauraki Gulf Islands'
        	],
        	[
        		'region_id'		=> 2,
        		'district_name'	=> 'Manukau City'
        	],
        	[
        		'region_id'		=> 2,
        		'district_name'	=> 'North Shore City'
        	],
        	[
        		'region_id'		=> 2,
        		'district_name'	=> 'Papakura District'
        	],
        	[
        		'region_id'		=> 2,
        		'district_name'	=> 'Rodney'
        	],
        	[
        		'region_id'		=> 2,
        		'district_name'	=> 'Waiheke Island'
        	],
        	[
        		'region_id'		=> 2,
        		'district_name'	=> 'Waitakere City'
        	],
        	[
        		'region_id'		=> 3,
        		'district_name'	=> 'Coromandel'
        	],
        	[
        		'region_id'		=> 3,
        		'district_name'	=> 'Hauraki District'
        	],
        	[
        		'region_id'		=> 3,
        		'district_name'	=> 'Waikato District'
        	],
        	[
        		'region_id'		=> 3,
        		'district_name'	=> 'Matamata-Piako District'
        	],
        	[
        		'region_id'		=> 3,
        		'district_name'	=> 'Hamilton City'
        	],
        	[
        		'region_id'		=> 3,
        		'district_name'	=> 'Waipa District'
        	],
        	[
        		'region_id'		=> 3,
        		'district_name'	=> 'Otorohanga District'
        	],
        ]);
    }
}