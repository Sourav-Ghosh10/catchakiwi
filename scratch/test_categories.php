<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

$now = Carbon::now();
$countryCode = 'NZ';

$categories = DB::table('notice_category')
    ->select('notice_category.*', DB::raw("(
        SELECT COUNT(*) FROM notice 
        LEFT JOIN users ON users.id = notice.user_id 
        LEFT JOIN cities as c0 ON c0.id = users.suburb_id AND users.country_status = '0'
        LEFT JOIN towns as t1 ON t1.id = users.suburb_id AND users.country_status = '1'
        LEFT JOIN cities as c1 ON c1.id = t1.city_id
        LEFT JOIN states as s0 ON s0.id = c0.state_id
        LEFT JOIN states as s1 ON s1.id = c1.state_id
        LEFT JOIN countries as co0 ON co0.id = s0.country_id
        LEFT JOIN countries as co1 ON co1.id = s1.country_id
        WHERE notice.category_id = notice_category.id 
            AND notice.status = '1' 
            AND notice.notice_EXPIRE >= '".$now."'
            AND notice.country = '".$countryCode."'
    ) as notices_count"))
    ->get();

foreach ($categories as $c) {
    echo $c->category.': '.$c->notices_count."\n";
}
