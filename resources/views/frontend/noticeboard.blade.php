@include('includes/inner-header')

<link href="{{ asset('assets/css/noticeboard.css') }}?v={{ filemtime(public_path('assets/css/noticeboard.css')) }}"
    rel="stylesheet" type="text/css" />

<div class="mid_body">
    <!-- Search Section -->
    <div class="nb-v2-search-container">
        <form action="{{ route('notices.search') }}" method="GET" class="nb-v2-search-form">
            <div class="nb-v2-search-input-wrap">
                <i class="fa fa-search nb-v2-search-icon"></i>
                <input type="text" name="search" value="{{ $search ?? '' }}"
                    placeholder="What are you looking for today?" class="nb-v2-search-input">
                <button type="submit" class="nb-v2-search-btn">Search</button>
            </div>
        </form>
    </div>
    <div class="container">
        <div class="full_midpan">
            <div class="row">
                <div class="col-lg-8 col-md-8 col-sm-12">
                    <div class="left_notice">
                        <div class="left_notice_header">
                            <h2>{{ $activeCategory ? $activeCategory->category : 'Catchakiwi Noticeboard' }}<br>
                                <span>{{ $activeCategory ? 'Explore notices in ' . $activeCategory->category : 'Connect, Share, Discover local notices' }}</span>
                            </h2>
                            <div class="left_notice_actions">
                                <!-- <a href="#" class="getquote_button">Get a Quote</a> -->
                                @if(Auth::user())
                                    <a href="{{ route('notice-post', ['category' => $activeCategory ? $activeCategory->slug : 1]) }}" class="postfree_button">Post a Free Notice</a>
                                @else
                                    <a href="{{ URL::to('/login?redirect=' . urlencode('notice-post?category=' . ($activeCategory ? $activeCategory->slug : 1))) }}" class="postfree_button">Post a Free Notice</a>
                                @endif
                            </div>
                        </div>
                        <div class="notice_refineresults">
                            <h3>Refine Results:</h3>
                            <div class="row">
                                @php $catsCollection = collect($categories); @endphp
                                @foreach($catsCollection->chunk(ceil($catsCollection->count() / 3)) as $chunk)
                                    <div class="col-md-4">
                                        <ul>
                                            @foreach($chunk as $cat)
                                                <li>
                                                    <a href="{{ route('notice-board', $cat->slug) }}"
                                                        class="{{ (isset($activeCategory) && $activeCategory->id == $cat->id) ? 'active-refine-category' : '' }}">
                                                        {{ $cat->category }}
                                                        ({{ str_pad($cat->notices_count, 2, '0', STR_PAD_LEFT) }})
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    @php
                        $noticeCategoryTypes = collect($categories)->mapWithKeys(function ($catInfo) {
                            return [$catInfo->id => $catInfo->type];
                        });
                        $noticeCategorySlugs = collect($categories)->mapWithKeys(function ($catInfo) {
                            return [$catInfo->id => $catInfo->slug ?? Str::slug($catInfo->category)];
                        });
                    @endphp
                    @if(isset($activeCategory) && $activeCategory->slug === 'garage-sales')
                        <!-- Leaflet Map -->
                        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
                        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
                        <style>
                            .garage-sale-card {
                                border: 1px solid #ddd;
                                height: 100%;
                                cursor: pointer;
                                background: #fff;
                                transition: box-shadow 0.2s ease-in-out;
                                margin-bottom: 20px;
                            }
                            .garage-sale-card:hover {
                                box-shadow: 0 4px 10px rgba(0,0,0,0.1);
                            }
                            .garage-sale-card-header {
                                background-color: #4a86e8;
                                color: white;
                                padding: 8px 12px;
                                font-weight: bold;
                                text-transform: uppercase;
                                font-size: 14px;
                            }
                            .garage-sale-card-body {
                                padding: 15px;
                            }
                            .garage-sale-card-title {
                                margin-top: 0;
                                font-size: 16px;
                                color: #333;
                                font-weight: 600;
                            }
                            .garage-sale-card-location {
                                font-size: 13px;
                                color: #777;
                                margin-bottom: 8px;
                            }
                            .garage-sale-card-desc {
                                margin: 0;
                                font-size: 14px;
                                color: #555;
                                display: -webkit-box;
                                -webkit-line-clamp: 3;
                                -webkit-box-orient: vertical;
                                overflow: hidden;
                                text-overflow: ellipsis;
                            }
                        </style>
                        <div style="border: 2px dashed #e8e8e8; border-radius: 4px; margin-bottom: 20px; padding: 5px; background: #fff;">
                             <div id="garage-sales-map" style="height: 500px; width: 100%;"></div>
                        </div>
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                var map = L.map('garage-sales-map').setView([-40.9006, 174.8860], 5);
                                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                                }).addTo(map);

                                var markers = [];
                                @foreach($notices as $notice)
                                    @if(!empty($notice->gs_lat) && !empty($notice->gs_lng))
                                        (function(id, heading, location) {
                                            var lat = {{ floatval($notice->gs_lat) }};
                                            var lng = {{ floatval($notice->gs_lng) }};
                                            var popupContent = '<div style="cursor:pointer;" onclick="if(typeof openNoticeModal === \'function\') openNoticeModal(' + id + ')">' +
                                                '<strong style="font-size:14px; color:#333; display:block; margin-bottom:4px;">' + heading + '</strong>' +
                                                '<span style="font-size:12px; color:#666;">' + location + '</span>' +
                                                '<div style="margin-top:6px; font-size:11px; color:#9bcd22; font-weight:bold;">Click to view details &rarr;</div>' +
                                                '</div>';
                                            var marker = L.marker([lat, lng]).addTo(map).bindPopup(popupContent);
                                            marker.on('click', function() {
                                                if (typeof openNoticeModal === 'function') {
                                                    openNoticeModal(id);
                                                }
                                            });
                                            markers.push(marker);
                                        })({{ $notice->id }}, {!! json_encode($notice->heading) !!}, {!! json_encode($notice->town_suburb ?? '') !!});
                                    @endif
                                @endforeach

                                if (markers.length > 0) {
                                    var group = new L.featureGroup(markers);
                                    map.fitBounds(group.getBounds().pad(0.1));
                                }
                            });
                        </script>

                        <!-- Garage Sales Cards -->
                        <div class="row">
                            @forelse($notices as $notice)
                                <div class="col-md-4 col-sm-6 mb-4">
                                    <div class="garage-sale-card" onclick="openNoticeModal({{ $notice->id }})">
                                        <div class="garage-sale-card-header">
                                            GARAGE SALES
                                        </div>
                                        <div class="garage-sale-card-body">
                                            <h4 class="garage-sale-card-title">{{ $notice->heading }}</h4>
                                            @php
                                                $parts = $notice->town_suburb ? array_map('trim', explode(',', $notice->town_suburb)) : [];
                                                $noticeDisplayLocation = count($parts) >= 2 ? $parts[1] : ($parts[0] ?? null);
                                            @endphp
                                            @if($noticeDisplayLocation)
                                                <div class="garage-sale-card-location">
                                                    <i class="fa fa-map-marker"></i> {{ $noticeDisplayLocation }}
                                                </div>
                                            @endif
                                            <p class="garage-sale-card-desc">
                                                {{ strip_tags($notice->content) }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-12"><div class="alert alert-info">No notices found.</div></div>
                            @endforelse
                        </div>
                    @else
                        <div class="notice-grid">
                            @forelse($notices as $notice)
                                @php
                                    $noticeCategoryType = $noticeCategoryTypes[$notice->category_id] ?? null;
                                    $noticeCategorySlug = $noticeCategorySlugs[$notice->category_id] ?? null;
                                    $noticeCardTypeClass = $noticeCategoryType ? 'notice-card-type-' . Str::slug($noticeCategoryType) : '';
                                    $noticeCardCategoryClass = $noticeCategorySlug ? 'notice-card-category-' . Str::slug($noticeCategorySlug) : '';
                                    $noticeLookingFor = Str::lower(trim($notice->looking_for ?? ''));
                                    $isWantedNotice = Str::contains($noticeLookingFor, 'wanted');
                                    $isItemsCategory = in_array($noticeCategorySlug, ['items-for-sale', 'items-for-sale-or-wanted'])
                                        || in_array(Str::lower($notice->category_name ?? ''), ['items for sale', 'items for sale or wanted']);
                                    $noticeDisplayCategory = $notice->category_name;
                                    if ($isItemsCategory && $noticeLookingFor !== '') {
                                        $noticeDisplayCategory = $isWantedNotice ? 'Items Wanted' : 'Items for Sale';
                                    }
                                    $parts = $notice->town_suburb ? array_map('trim', explode(',', $notice->town_suburb)) : [];
                                    $noticeDisplayLocation = count($parts) >= 2 ? $parts[1] : ($parts[0] ?? null);
                                @endphp
                                <div class="notice-card {{ $notice->noticetype == 'feature' ? 'featured-card' : '' }} {{ $noticeCardTypeClass }} {{ $noticeCardCategoryClass }}" data-notice-id="{{ $notice->id }}" role="button" tabindex="0">
                                    <div class="notice-card-image-wrapper">
                                        @if($notice->noticetype == 'feature')
                                            <div class="featured-badge">Featured listing</div>
                                        @endif
                                        @if($isWantedNotice)
                                            <div class="wanted-badge">Wanted</div>
                                        @endif
                                        
                                        @if(isset($noticeImages[$notice->id]) && count($noticeImages[$notice->id]) > 0)
                                            <img src="{{ asset($noticeImages[$notice->id][0]->img_path) }}" alt="{{ $notice->heading }}" class="notice-card-img">
                                        @else
                                            <div class="notice-card-placeholder">
                                                <i class="fa fa-bullhorn"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="notice-card-body">
                                        <div class="notice-card-category">
                                            {{ strtoupper($noticeDisplayCategory) }}
                                        </div>
                                        <h4 class="notice-card-heading">{{ $notice->heading }}</h4>
                                        @if($noticeDisplayLocation)
                                            <div class="notice-card-location">
                                                <i class="fa fa-map-marker"></i> {{ $noticeDisplayLocation }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <div class="alert alert-info notice-grid-empty">No notices found.</div>
                            @endforelse
                        </div>
                    @endif
                    @include('frontend.partials.notice-details-modal', ['modalNotices' => $notices, 'noticeImages' => $noticeImages])

                    <!-- <ul class="pagination">
                        <li><a href="#"><i class="fa fa-angle-left"></i></a></li>
                        <li><a href="#" class="active">01</a></li>
                        <li><a href="#">02</a></li>
                        <li><a href="#">03</a></li>
                        <li><a href="#">04</a></li>
                        <li><a href="#"><i class="fa fa-angle-right"></i></a></li>
                    </ul> -->
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12">
                    <div class="support_advertiser">
                        <i class="fa fa-heart"></i>
                        <span>Support our advertisers, catchakiwi exists because of them</span>
                    </div>
                    <div class="right_advertisesec">
                        @if(!empty($sideData))
                            @foreach ($sideData as $ad)
                                @if($ad->ads_image != "")
                                    @if($ad->link)
                                        <a href="{{ $ad->link }}" target="_blank">
                                            <img src="{{ asset($ad->ads_image) }}" alt="">
                                        </a>
                                    @else
                                        <img src="{{ asset($ad->ads_image) }}" alt="">
                                    @endif
                                @endif
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    // Increment view count for each notice visible on this page
    document.addEventListener('DOMContentLoaded', function () {
        @foreach($notices as $notice)
            fetch('{{ url("/notice/view") }}/{{ $notice->id }}');
        @endforeach
});
</script>

@include('includes/footer')
