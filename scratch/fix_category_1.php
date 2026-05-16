<?php

use Illuminate\Support\Facades\DB;

// Specific update for $5 Service Deal
DB::table('notice_category')->where('id', 1)->update([
    'subtitle' => 'Try a $5 starter service',
    'icon' => 'assets/images/notice/nb-icon-1.png',
    'color' => '#f0f9eb',
    'type' => 'deals',
    'is_active' => 1,
    'is_new' => 0,
]);

echo "Category 1 updated successfully!\n";
