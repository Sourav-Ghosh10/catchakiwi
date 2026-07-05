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
                                <a href="{{ route('notice-post', ['category' => $activeCategory ? $activeCategory->slug : '']) }}" class="postfree_button">Post a Free Notice</a>
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
                    <div class="notice-grid">
                        @forelse($notices as $notice)
                            @php
                                $noticeCategoryType = $noticeCategoryTypes[$notice->category_id] ?? null;
                                $noticeCategorySlug = $noticeCategorySlugs[$notice->category_id] ?? null;
                                $noticeCardTypeClass = $noticeCategoryType ? 'notice-card-type-' . Str::slug($noticeCategoryType) : '';
                                $noticeCardCategoryClass = $noticeCategorySlug ? 'notice-card-category-' . Str::slug($noticeCategorySlug) : '';
                            @endphp
                            <div class="notice-card {{ $notice->noticetype == 'feature' ? 'featured-card' : '' }} {{ $noticeCardTypeClass }} {{ $noticeCardCategoryClass }}" data-notice-id="{{ $notice->id }}" role="button" tabindex="0">
                                <div class="notice-card-image-wrapper">
                                    @if($notice->noticetype == 'feature')
                                        <div class="featured-badge">Featured listing</div>
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
                                        @if($notice->category_name == 'Items for Sale or Wanted' && $notice->noticetype == 'standard')
                                            FREE
                                        @else
                                            {{ strtoupper($notice->category_name) }}
                                        @endif
                                    </div>
                                    <h4 class="notice-card-heading">{{ $notice->heading }}</h4>
                                    @if($notice->town_suburb)
                                        <div class="notice-card-location">
                                            <i class="fa fa-map-marker"></i> {{ $notice->town_suburb }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="alert alert-info notice-grid-empty">No notices found.</div>
                        @endforelse
                    </div>
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
</script>

@include('includes/footer')
