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
                <a href="{{ route('notice-post', ['category' => $categoryId]) }}" class="nb-v2-post-btn">Post a Free Notice ></a>
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
                        <a href="#" class="nb-v2-view-more">View More Posts</a>
                    @endif
                </div>
                <div class="notice-grid">
                    @forelse($latestNotices as $notice)
                        <div class="notice-card {{ $notice->noticetype == 'feature' ? 'featured-card' : '' }}">
                            <div class="notice-card-image-wrapper">
                                @if($notice->noticetype == 'feature')
                                    <div class="featured-badge">Featured listing</div>
                                @endif
                                
                                @if(isset($noticeImages[$notice->id]) && count($noticeImages[$notice->id]) > 0)
                                    <img src="{{ asset($noticeImages[$notice->id][0]->img_path) }}" alt="{{ $notice->heading }}" class="notice-card-img">
                                @else
                                    <div class="notice-card-placeholder" style="background: linear-gradient(135deg, #a3d900 0%, #8ebd00 100%);">
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
                                <p class="notice-card-desc">{{ Str::limit($notice->content, 120) }}</p>
                                
                                @if($notice->town_suburb)
                                    <div class="notice-card-location">
                                        <i class="fa fa-map-marker"></i> {{ $notice->town_suburb }}
                                    </div>
                                @endif
                            </div>
                            <div class="notice-card-footer">
                                <div class="notice-card-user">
                                    <img src="{{ asset('assets/images/notice_logoimg.png')}}" alt="" class="notice-card-user-logo">
                                    <span>{{ $notice->user_name ?? 'Catchakiwi' }}</span>
                                </div>
                                <div class="notice-card-meta">
                                    <span class="notice-card-views"><i class="fa fa-eye"></i> {{ $notice->views ?? 0 }}</span>
                                    <a href="{{ url('/profile#parentHorizontalTab3') }}" class="notice-card-chat-btn">
                                        <img src="{{ asset('assets/images/notice_chaticon.png')}}" alt="Message" class="notice-card-chat-icon">
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="alert alert-info" style="grid-column: 1 / -1; width: 100%;">No notices found matching your criteria.</div>
                    @endforelse
                </div>
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