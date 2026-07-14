@include('includes/inner-header')

<link href="{{ asset('assets/css/noticeboard_v2.css') }}?v={{ filemtime(public_path('assets/css/noticeboard_v2.css')) }}" rel="stylesheet" type="text/css" />

<div class="mid_body nb-v2-bg">
    <div class="container">
        <div class="nb-v2-container">
            <!-- Header Section -->
            <div class="nb-v2-header text-center">
                <h1 class="nb-v2-title">Latest Notices</h1>
                <p class="nb-v2-subtitle nb-v2-search-results-label font-weight-bold">CONTINUOUS SCROLL</p>
            </div>

            <!-- Search Section -->
            <div class="nb-v2-search-container">
                <form action="{{ route('notices.latest') }}" method="GET" class="nb-v2-search-form" id="latest-notices-form">
                    <div class="nb-v2-search-input-wrap">
                        <i class="fa fa-search nb-v2-search-icon"></i>
                        <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="What are you looking for today?" class="nb-v2-search-input">
                        @if(isset($categoryId))
                            <input type="hidden" name="category" value="{{ $categoryId }}">
                        @endif
                        @if(isset($location))
                            <input type="hidden" name="location" value="{{ $location }}">
                        @endif
                        <button type="submit" class="nb-v2-search-btn">Search</button>
                    </div>
                </form>
            </div>

            <div class="row mt-4">
                <!-- Latest Notices List -->
                <div class="col-lg-12">
                    <div class="notice-search-actions d-flex justify-content-between align-items-center mb-3">
                        <a href="{{ route('notices') }}" class="notice-search-back-btn btn btn-outline-secondary btn-sm">
                            <i class="fa fa-arrow-left mr-1"></i> Back to Noticeboard
                        </a>
                        <a href="{{ route('notice-post', ['category' => $categoryId ?? '']) }}" class="nb-v2-post-btn notice-search-post-btn" style="padding: 10px 20px;">Post a Free Notice ></a>
                    </div>
                    
                    <div class="notice-search-results-header d-flex justify-content-between align-items-center mb-4">
                        <h2 class="nb-v2-section-title">Latest Listings</h2>
                        <span class="notice-search-count text-muted">
                            Found {{ $notices->total() }} {{ Str::plural('notice', $notices->total()) }}
                        </span>
                    </div>

                    <div class="notice-grid" id="latest-notices-container">
                        @include('frontend.partials.notice-grid-items', ['notices' => $notices, 'noticeImages' => $noticeImages, 'noticeCategoryTypes' => $noticeCategoryTypes, 'noticeCategorySlugs' => $noticeCategorySlugs])
                    </div>
                    
                    <!-- Loading Indicator for Infinite Scroll -->
                    <div class="text-center mt-4 mb-4" id="loading-indicator" style="display: none; width: 100%;">
                        <i class="fa fa-spinner fa-spin fa-2x text-primary" style="color: #8FC743 !important;"></i>
                        <p class="mt-2 text-muted font-weight-bold">Loading more notices...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    let page = 1;
    let loading = false;
    let hasMore = {{ $notices->hasMorePages() ? 'true' : 'false' }};
    
    // Initial fetch for view counts
    trackViews();

    window.addEventListener('scroll', function() {
        if (loading || !hasMore) return;
        
        const scrollPosition = window.innerHeight + window.scrollY;
        const documentHeight = document.body.offsetHeight;
        
        // Trigger load when within 500px from the bottom
        if (scrollPosition >= documentHeight - 500) {
            loadMoreNotices();
        }
    });
    
    function loadMoreNotices() {
        loading = true;
        page++;
        document.getElementById('loading-indicator').style.display = 'block';
        
        // Get current URL parameters
        const urlParams = new URLSearchParams(window.location.search);
        urlParams.set('page', page);
        
        const url = '{{ route("notices.latest") }}?' + urlParams.toString();
        
        fetch(url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.text())
        .then(html => {
            if (html.trim() === '') {
                hasMore = false;
                document.getElementById('loading-indicator').style.display = 'none';
                return;
            }
            
            document.getElementById('latest-notices-container').insertAdjacentHTML('beforeend', html);
            document.getElementById('loading-indicator').style.display = 'none';
            loading = false;
            
            trackViews(); // Track views for newly loaded notices
        })
        .catch(error => {
            console.error('Error loading more notices:', error);
            loading = false;
            document.getElementById('loading-indicator').style.display = 'none';
        });
    }

    function trackViews() {
        const notices = document.querySelectorAll('.notice-card:not(.view-tracked)');
        notices.forEach(notice => {
            const noticeId = notice.getAttribute('data-notice-id');
            if (noticeId) {
                fetch('{{ url("/notice/view") }}/' + noticeId);
                notice.classList.add('view-tracked');
            }
        });
    }
});
</script>

@include('includes/footer')
