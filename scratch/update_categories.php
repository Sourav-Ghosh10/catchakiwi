<?php

use Illuminate\Support\Facades\DB;

$categories = [
    ['title' => '$5 Service Deals', 'subtitle' => 'Try a $5 starter service', 'icon' => 'assets/images/notice/nb-icon-1.png', 'color' => '#f0f9eb', 'type' => 'deals', 'active' => 1, 'is_new' => 0],
    ['title' => 'Get a Quote', 'subtitle' => 'Local work offers', 'icon' => 'assets/images/notice/nb-icon-6.png', 'color' => '#f5f5ff', 'type' => 'jobs', 'active' => 1, 'is_new' => 1],
    ['title' => 'Catch-a-Ride', 'subtitle' => 'Share a ride or item', 'icon' => 'assets/images/notice/nb-icon-2.png', 'color' => '#ebf5ff', 'type' => 'rides', 'active' => 0, 'is_new' => 0],
    ['title' => 'Garage Sales', 'subtitle' => 'Local Garage sales', 'icon' => 'assets/images/notice/nb-icon-3.png', 'color' => '#fff9eb', 'type' => 'sales', 'active' => 0, 'is_new' => 0],
    ['title' => 'Vehicle Sales', 'subtitle' => 'Cars, vans, bikes for sale', 'icon' => 'assets/images/notice/nb-icon-4.png', 'color' => '#f5f7fa', 'type' => 'vehicles', 'active' => 0, 'is_new' => 0],
    ['title' => 'Property & House Sales', 'subtitle' => 'Homes and rentals', 'icon' => 'assets/images/notice/nb-icon-5.png', 'color' => '#fff5f5', 'type' => 'property', 'active' => 0, 'is_new' => 0],
    ['title' => 'Services Offered', 'subtitle' => 'Skills & small jobs offered', 'icon' => 'assets/images/notice/nb-icon-7.png', 'color' => '#f0fff4', 'type' => 'services', 'active' => 0, 'is_new' => 0],
    ['title' => 'Items For Sale', 'subtitle' => 'Furniture, gadgets & more', 'icon' => 'assets/images/notice/nb-icon-8.png', 'color' => '#fffaf0', 'type' => 'items', 'active' => 0, 'is_new' => 1],
    ['title' => 'Community Events', 'subtitle' => 'Local gatherings & fundraisers', 'icon' => 'assets/images/notice/nb-icon-9.png', 'color' => '#fff5f7', 'type' => 'events', 'active' => 0, 'is_new' => 1],
];

foreach ($categories as $cat) {
    DB::table('notice_category')->where('category', 'like', '%'.$cat['title'].'%')->update([
        'subtitle' => $cat['subtitle'],
        'icon' => $cat['icon'],
        'color' => $cat['color'],
        'type' => $cat['type'],
        'is_active' => $cat['active'],
        'is_new' => $cat['is_new'],
    ]);
}

echo "Notice categories updated successfully!\n";
