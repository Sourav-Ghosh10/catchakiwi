@include('includes/inner-header')

<link href="{{ asset('assets/css/noticeboard_v2.css') }}?v={{ filemtime(public_path('assets/css/noticeboard_v2.css')) }}" rel="stylesheet" type="text/css" />

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
                <form action="{{ route('notices.search') }}" method="GET" class="nb-v2-search-form">
                    <div class="nb-v2-search-input-wrap">
                        <i class="fa fa-search nb-v2-search-icon"></i>
                        <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="What are you looking for today?"
                            class="nb-v2-search-input">
                        <button type="submit" class="nb-v2-search-btn">Search</button>
                    </div>
                </form>
            </div>

            <!-- Spotlight Section -->
            @if($spotlightNotice)
                <a href="{{ route('notice-board', ['category' => 'five-dollar-service-deal', 'search' => $spotlightNotice->heading]) }}" class="nb-v2-spotlight-link">
            @endif
            <div class="nb-v2-spotlight">
                <div class="nb-v2-spotlight-inner">
                    <span class="nb-v2-spotlight-badge">
                        Spotlight!
                    </span>
                    <span class="nb-v2-spotlight-text">
                        @if($spotlightNotice)
                            ⭐ <span class="nb-v2-deal-link">$5 Deal of the Day:</span> {{ $spotlightNotice->heading }}
                        @else
                            ⭐ <span class="nb-v2-deal-link">$5 Deal of the Day:</span> $5 Lawn Mowing - First 5 Customers Only!
                        @endif
                    </span>
                    <i class="fa fa-chevron-right nb-v2-spotlight-arrow"></i>
                </div>
            </div>
            @if($spotlightNotice)
                </a>
            @endif

            <!-- Post Button -->
            <div class="text-right mb-4">
                @if(Auth::user())
                    <a href="{{ route('notice-post', ['category' => $categoryId ?? 1]) }}" class="nb-v2-post-btn">Post a Free Notice ></a>
                @else
                    <a href="{{ URL::to('/login?redirect=' . urlencode('notice-post?category=' . ($categoryId ?? 1))) }}" class="nb-v2-post-btn">Post a Free Notice ></a>
                @endif
            </div>

            <!-- Categories Grid -->
            <div class="row nb-v2-grid">
                @foreach($categories as $catInfo)
                    @php
                        $count = $catInfo->notices_count;
                    @endphp
                    <div class="col-lg-4 col-md-6 mb-4">
                        <a href="{{ ($catInfo->is_active) ? route('notice-board', $catInfo->slug) : '#' }}"
                            class="nb-v2-card {{ ($catInfo->is_active) ? 'active' : '' }} {{ (isset($categoryId) && $categoryId == $catInfo->id) ? 'selected-cat' : '' }}"
                            data-type="{{ $catInfo->type }}">
                            @if($catInfo->is_new)
                                <span class="nb-v2-new-badge">New!</span>
                            @endif
                            <div class="nb-v2-card-icon-wrap">
                                @if($catInfo->icon)
                                    <img src="{{ asset($catInfo->icon) }}"
                                        alt="{{ $catInfo->category }}" class="nb-v2-card-img-icon">
                                @else
                                    <img src="{{ asset('assets/images/notice/nb-icon-default.png') }}"
                                        alt="{{ $catInfo->category }}" class="nb-v2-card-img-icon">
                                @endif
                            </div>
                            <div class="nb-v2-card-body">
                                <h3 class="nb-v2-card-title">{{ $catInfo->category }}</h3>
                                <p class="nb-v2-card-subtitle">{{ $catInfo->subtitle }}
                                    <strong>({{ str_pad($count, 2, '0', STR_PAD_LEFT) }})</strong>
                                </p>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <!-- <div class="nb-v2-pagination text-center mt-4">
                <span class="nb-v2-page-arrow">&lt;</span>
                <span class="nb-v2-page-num active">01</span>
                <span class="nb-v2-page-num">02</span>
                <span class="nb-v2-page-num">03</span>
                <span class="nb-v2-page-num">04</span>
                <span class="nb-v2-page-arrow">&gt;</span>
            </div> -->

            <!-- Latest Posts -->
            <div class="nb-v2-latest-section mt-5">
                @php
                    $noticeCategoryTypes = collect($categories)->mapWithKeys(function ($catInfo) {
                        return [$catInfo->id => $catInfo->type];
                    });
                    $noticeCategorySlugs = collect($categories)->mapWithKeys(function ($catInfo) {
                        return [$catInfo->id => $catInfo->slug ?? Str::slug($catInfo->category)];
                    });
                @endphp
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h2 class="nb-v2-section-title">
                        @if($search)
                            Search Results for "{{ $search }}"
                        @elseif($categoryId)
                            @php $activeCat = collect($categories)->firstWhere('id', $categoryId); @endphp
                            {{ $activeCat ? $activeCat->category : 'Notices' }}
                        @else
                            Latest Posts
                        @endif
                    </h2>
                    @if($search || $categoryId)
                        <a href="{{ route('notices') }}" class="nb-v2-view-more">View All Posts</a>
                    @else
                        <a href="{{ route('notices.latest') }}" class="nb-v2-view-more">View More Posts</a>
                    @endif
                </div>
                <div class="notice-grid">
                    @forelse($latestNotices as $notice)
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
                        <div class="alert alert-info notice-grid-empty">No notices found matching your criteria.</div>
                    @endforelse
                </div>
                @include('frontend.partials.notice-details-modal', ['modalNotices' => $latestNotices, 'noticeImages' => $noticeImages])
            </div>
        </div>
    </div>
</div>

<script>
// Increment view count for each notice visible on this page
document.addEventListener('DOMContentLoaded', function () {
    @foreach($latestNotices as $notice)
    fetch('{{ url("/notice/view") }}/{{ $notice->id }}');
    @endforeach
});
</script>

@include('includes/footer')
