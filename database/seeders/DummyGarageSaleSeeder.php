<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DummyGarageSaleSeeder extends Seeder
{
    public function run()
    {
        $now = Carbon::now();
        $expire = Carbon::now()->addDays(30);

        $notices = [
            [
                'user_id' => 1,
                'category_id' => 6,
                'country' => 'NZ',
                'noticetype' => 'standard',
                'heading' => 'Huge Garage Sale in Wellington',
                'content' => '<p>Massive clearance! Books, furniture, and electronics. Starts at 9 AM this Saturday.</p>',
                'status' => '1',
                'views' => 0,
                'created_at' => $now,
                'expire_at' => $expire,
                'notice_EXPIRE' => $expire,
                'town_suburb' => 'Wellington Central, Wellington',
                'gs_lat' => '-41.2865',
                'gs_lng' => '174.7762',
                'gs_address' => '123 Fake St, Wellington',
            ],
            [
                'user_id' => 1,
                'category_id' => 6,
                'country' => 'NZ',
                'noticetype' => 'standard',
                'heading' => 'Moving Out Sale Auckland',
                'content' => '<p>Moving overseas. Everything must go! Prices negotiable.</p>',
                'status' => '1',
                'views' => 12,
                'created_at' => $now,
                'expire_at' => $expire,
                'notice_EXPIRE' => $expire,
                'town_suburb' => 'Ponsonby, Auckland',
                'gs_lat' => '-36.8485',
                'gs_lng' => '174.7633',
                'gs_address' => '456 Fake Rd, Auckland',
            ],
            [
                'user_id' => 1,
                'category_id' => 6,
                'country' => 'NZ',
                'noticetype' => 'feature',
                'heading' => 'Weekend Bargains Christchurch',
                'content' => '<p>Come find hidden treasures this weekend! Lots of vintage items.</p>',
                'status' => '1',
                'views' => 5,
                'created_at' => $now,
                'expire_at' => $expire,
                'notice_EXPIRE' => $expire,
                'town_suburb' => 'Riccarton, Christchurch',
                'gs_lat' => '-43.5320',
                'gs_lng' => '172.6362',
                'gs_address' => '789 Fake Ave, Christchurch',
            ],
            [
                'user_id' => 1,
                'category_id' => 6,
                'country' => 'NZ',
                'noticetype' => 'standard',
                'heading' => 'Hamilton Mega Sale',
                'content' => '<p>Kids clothing, toys, and household items. Cash only.</p>',
                'status' => '1',
                'views' => 22,
                'created_at' => $now,
                'expire_at' => $expire,
                'notice_EXPIRE' => $expire,
                'town_suburb' => 'Hamilton East, Hamilton',
                'gs_lat' => '-37.7870',
                'gs_lng' => '175.2793',
                'gs_address' => '101 Fake Lane, Hamilton',
            ]
        ];

        DB::table('notice')->insert($notices);
    }
}
