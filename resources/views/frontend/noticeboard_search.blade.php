@include('includes/inner-header')

<link href="{{ asset('assets/css/noticeboard_v2.css') }}?v={{ filemtime(public_path('assets/css/noticeboard_v2.css')) }}" rel="stylesheet" type="text/css" />

<div class="mid_body nb-v2-bg">
    <div class="container">
        <div class="nb-v2-container">
            <!-- Header Section -->
            <div class="nb-v2-header text-center">
                <h1 class="nb-v2-title">Catchakiwi Noticeboard</h1>
                <p class="nb-v2-subtitle nb-v2-search-results-label font-weight-bold">SEARCH RESULTS</p>
            </div>

            <!-- Search Section -->
            <div class="nb-v2-search-container">
                <form action="{{ route('notices.search') }}" method="GET" class="nb-v2-search-form">
                    <div class="nb-v2-search-input-wrap">
                        <i class="fa fa-search nb-v2-search-icon"></i>
                        <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="What are you looking for today?"
                            class="nb-v2-search-input">
                        @if(isset($categoryId))
                            <input type="hidden" name="category" value="{{ $categoryId }}">
                        @endif
                        <button type="submit" class="nb-v2-search-btn">Search</button>
                    </div>
                </form>
            </div>

            <!-- Action buttons: Back to Board & Post Free Notice -->
            <div class="notice-search-actions d-flex justify-content-between align-items-center mb-4 mt-3">
                <a href="{{ route('notices') }}" class="notice-search-back-btn btn btn-outline-secondary btn-sm">
                    <i class="fa fa-arrow-left mr-1"></i> Back to Noticeboard
                </a>
                <a href="{{ route('notice-post', ['category' => $categoryId]) }}" class="nb-v2-post-btn notice-search-post-btn">Post a Free Notice ></a>
            </div>

            <!-- Search Results -->
            <div class="nb-v2-latest-section mt-4">
                @php
                    $noticeCategoryTypes = collect($categories)->mapWithKeys(function ($catInfo) {
                        return [$catInfo->id => $catInfo->type];
                    });
                    $noticeCategorySlugs = collect($categories)->mapWithKeys(function ($catInfo) {
                        return [$catInfo->id => $catInfo->slug ?? Str::slug($catInfo->category)];
                    });
                @endphp
                <div class="notice-search-results-header d-flex justify-content-between align-items-center mb-4">
                    <h2 class="nb-v2-section-title">
                        @if($search)
                            Search Results for "{{ $search }}"
                        @elseif($activeCategory)
                            Notices in "{{ $activeCategory->category }}"
                        @else
                            All Notices
                        @endif
                    </h2>
                    <span class="notice-search-count text-muted">
                        Found {{ count($notices) }} {{ Str::plural('notice', count($notices)) }}
                    </span>
                </div>
                
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
                            $noticeDisplayLocation = $notice->town_suburb ? trim(Str::before($notice->town_suburb, ',')) : null;
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
                        <div class="alert alert-info notice-grid-empty notice-grid-empty-search text-center py-5">
                            <i class="fa fa-info-circle fa-2x mb-3"></i>
                            <span class="notice-grid-empty-title">No matching notices found</span>
                            <span class="notice-grid-empty-help text-muted">Try checking your spelling or adjusting your keywords.</span>
                        </div>
                    @endforelse
                </div>
                @include('frontend.partials.notice-details-modal', ['modalNotices' => $notices, 'noticeImages' => $noticeImages])
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    @foreach($notices as $notice)
    fetch('{{ url("/notice/view") }}/{{ $notice->id }}');
    @endforeach
});
</script>

@include('includes/footer')
