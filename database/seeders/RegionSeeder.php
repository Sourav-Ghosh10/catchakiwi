<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RegionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('regions')->insert([
			[
                'region_name' => 'Northland',
                'created_at' => Carbon::now()->toDateTimeString()
            ],
            [
                'region_name' => 'Auckland',
                'created_at' => Carbon::now()->toDateTimeString()
            ],
            [
                'region_name' => 'Waikato',
                'created_at' => Carbon::now()->toDateTimeString()
            ],
            [
                'region_name' => 'Bay of Plenty',
                'created_at' => Carbon::now()->toDateTimeString()
            ],
            [
                'region_name' => 'Gisbourne',
                'created_at' => Carbon::now()->toDateTimeString()
            ],
            [
                'region_name' => 'Hawkes Bay',
                'created_at' => Carbon::now()->toDateTimeString()
            ],
            [
                'region_name' => 'Taranaki',
                'created_at' => Carbon::now()->toDateTimeString()
            ],
            [
                'region_name' => 'Central North Island',
                'created_at' => Carbon::now()->toDateTimeString()
            ],
            [
                'region_name' => 'Manawatu / Wanganui',
                'created_at' => Carbon::now()->toDateTimeString()
            ],
            [
                'region_name' => 'Wellington',
                'created_at' => Carbon::now()->toDateTimeString()
            ],
            [
                'region_name' => 'Tasman',
                'created_at' => Carbon::now()->toDateTimeString()
            ],
            [
                'region_name' => 'Nelson',
                'created_at' => Carbon::now()->toDateTimeString()
            ],
            [
                'region_name' => 'Marlborough',
                'created_at' => Carbon::now()->toDateTimeString()
            ],
            [
                'region_name' => 'West Coast',
                'created_at' => Carbon::now()->toDateTimeString()
            ],
             [
                'region_name' => 'Canterbury',
                'created_at' => Carbon::now()->toDateTimeString()
            ],
             [
                'region_name' => 'Otago',
                'created_at' => Carbon::now()->toDateTimeString()
            ],
            [
                'region_name' => 'Southland',
                'created_at' => Carbon::now()->toDateTimeString()
            ]
		]);
    }
}
