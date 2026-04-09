@include('includes/inner-header')

<link href="{{ asset('assets/css/noticeboard_v2.css') }}" rel="stylesheet" type="text/css" />

<div class="mid_body nb-v2-bg">
    <div class="container">
        <div class="nb-v2-container">
            <!-- Header Section -->
            <div class="nb-v2-header text-center">
                <h1 class="nb-v2-title">Catchakiwi Noticeboard</h1>
                <p class="nb-v2-subtitle">Connect, Share, Discover</p>
            </div>

            <!-- Search Section -->
            <div class="nb-v2-search-container">
                <form action="#" method="GET" class="nb-v2-search-form">
                    <div class="nb-v2-search-input-wrap">
                        <i class="fa fa-search nb-v2-search-icon"></i>
                        <input type="text" name="search" placeholder="What are you looking for today?" class="nb-v2-search-input">
                        <button type="submit" class="nb-v2-search-btn">Search</button>
                    </div>
                </form>
            </div>

            <!-- Spotlight Section -->
            <div class="nb-v2-spotlight">
                <div class="nb-v2-spotlight-inner">
                    <span class="nb-v2-spotlight-badge">
                        Spotlight!
                    </span>
                    <span class="nb-v2-spotlight-text">
                        ⭐ <span class="nb-v2-deal-link">$5 Deal of the Day:</span> $5 Lawn Mowing - First 5 Customers Only!
                    </span>
                    <i class="fa fa-chevron-right nb-v2-spotlight-arrow"></i>
                </div>
            </div>

            <!-- Post Button -->
            <div class="text-right mb-4">
                <a href="{{ route('notice-post') }}" class="nb-v2-post-btn">Post a Free Notice ></a>
            </div>

            <!-- Categories Grid -->
            <div class="row nb-v2-grid">
                @php
                    $displayCategories = [
                        ['title' => '$5 Service Deals', 'subtitle' => 'Try a $5 starter service', 'icon_class' => 'nb-icon-1', 'color' => '#f0f9eb', 'id' => 1, 'type' => 'deals'],
                        ['title' => 'Catch-a-Ride', 'subtitle' => 'Share a ride or item', 'icon_class' => 'nb-icon-2', 'color' => '#ebf5ff', 'id' => 2, 'type' => 'rides'],
                        ['title' => 'Garage Sales', 'subtitle' => 'Local Garage sales', 'icon_class' => 'nb-icon-3', 'color' => '#fff9eb', 'id' => 6, 'type' => 'sales'],
                        ['title' => 'Vehicle Sales', 'subtitle' => 'Cars, vans, bikes for sale', 'icon_class' => 'nb-icon-4', 'color' => '#f5f7fa', 'id' => 3, 'type' => 'vehicles'],
                        ['title' => 'Property & House Sales', 'subtitle' => 'Homes and rentals', 'icon_class' => 'nb-icon-5', 'color' => '#fff5f5', 'id' => 12, 'type' => 'property'],
                        ['title' => 'Jobs & Help Wanted', 'subtitle' => 'Local work offers', 'icon_class' => 'nb-icon-6', 'color' => '#f5f5ff', 'id' => 8, 'type' => 'jobs', 'new' => true],
                        ['title' => 'Services Offered', 'subtitle' => 'Skills & small jobs offered', 'icon_class' => 'nb-icon-7', 'color' => '#f0fff4', 'id' => 13, 'type' => 'services'],
                        ['title' => 'Items For Sale', 'subtitle' => 'Furniture, gadgets & more', 'icon_class' => 'nb-icon-8', 'color' => '#fffaf0', 'id' => 7, 'type' => 'items', 'new' => true],
                        ['title' => 'Community Events', 'subtitle' => 'Local gatherings & fundraisers', 'icon_class' => 'nb-icon-9', 'color' => '#fff5f7', 'id' => 10, 'type' => 'events', 'new' => true],
                    ];
                @endphp

                @foreach($displayCategories as $catInfo)
                    @php
                        $dbCat = $categories->firstWhere('id', $catInfo['id']);
                        $count = $dbCat ? $dbCat->notices_count : 0;
                    @endphp
                    <div class="col-lg-4 col-md-6 mb-4">
                        <a href="{{ route('notice-board', ['category' => $catInfo['id']]) }}" class="nb-v2-card" data-type="{{ $catInfo['type'] }}">
                            @if(isset($catInfo['new']) && $catInfo['new'])
                                <span class="nb-v2-new-badge">New!</span>
                            @endif
                            <div class="nb-v2-card-icon-wrap" style="background-color: {{ $catInfo['color'] }}">
                                <div class="nb-v2-card-img-icon {{ $catInfo['icon_class'] }}"></div>
                            </div>
                            <div class="nb-v2-card-body">
                                <h3 class="nb-v2-card-title">{{ $catInfo['title'] }}</h3>
                                <p class="nb-v2-card-subtitle">{{ $catInfo['subtitle'] }} <strong>({{ str_pad($count, 2, '0', STR_PAD_LEFT) }})</strong></p>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="nb-v2-pagination text-center mt-4">
                <span class="nb-v2-page-arrow"><</span>
                <span class="nb-v2-page-num active">01</span>
                <span class="nb-v2-page-num">02</span>
                <span class="nb-v2-page-num">03</span>
                <span class="nb-v2-page-num">04</span>
                <span class="nb-v2-page-arrow">></span>
            </div>

            <!-- Latest Posts -->
            <div class="nb-v2-latest-section mt-5">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h2 class="nb-v2-section-title">Latest Posts</h2>
                    <a href="#" class="nb-v2-view-more">View More Posts</a>
                </div>
                <div class="nb-v2-latest-list">
                    @forelse($latestNotices as $notice)
                        <div class="nb-v2-latest-item">
                            <i class="fa fa-bullhorn nb-v2-latest-icon"></i>
                            <span class="nb-v2-latest-text">{{ $notice->heading }} </span>
                            @if(\Carbon\Carbon::parse($notice->created_at)->isToday())
                                <span class="nb-v2-new-tag">New!</span>
                            @endif
                        </div>
                    @empty
                        <div class="nb-v2-latest-item">No recent notices found.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

@include('includes/footer')
