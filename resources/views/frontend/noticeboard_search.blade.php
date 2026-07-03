@include('includes/inner-header')

<link href="{{ asset('assets/css/noticeboard_v2.css') }}?v={{ filemtime(public_path('assets/css/noticeboard_v2.css')) }}" rel="stylesheet" type="text/css" />

<div class="mid_body nb-v2-bg">
    <div class="container">
        <div class="nb-v2-container">
            <!-- Header Section -->
            <div class="nb-v2-header text-center">
                <h1 class="nb-v2-title">Catchakiwi Noticeboard</h1>
                <p class="nb-v2-subtitle font-weight-bold" style="color: #729b0f; font-size: 16px; letter-spacing: 0.5px;">SEARCH RESULTS</p>
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
            <div class="d-flex justify-content-between align-items-center mb-4 mt-3" style="flex-wrap: wrap; gap: 15px;">
                <a href="{{ route('notices') }}" class="btn btn-outline-secondary btn-sm" style="border-radius: 20px; padding: 6px 18px; font-weight: 600; border-color: #cbd5e0; color: #4a5568; background-color: #fff; box-shadow: 0 2px 4px rgba(0,0,0,0.02); transition: all 0.2s ease;">
                    <i class="fa fa-arrow-left mr-1" style="color: #729b0f;"></i> Back to Noticeboard
                </a>
                <a href="{{ route('notice-post', ['category' => $categoryId]) }}" class="nb-v2-post-btn" style="margin: 0; padding: 8px 20px;">Post a Free Notice ></a>
            </div>

            <!-- Search Results -->
            <div class="nb-v2-latest-section mt-4">
                <div class="d-flex justify-content-between align-items-center mb-4" style="border-bottom: 2px solid #edf2f7; padding-bottom: 12px;">
                    <h2 class="nb-v2-section-title" style="margin: 0; font-size: 20px; color: #2d3748;">
                        @if($search)
                            Search Results for "{{ $search }}"
                        @elseif($activeCategory)
                            Notices in "{{ $activeCategory->category }}"
                        @else
                            All Notices
                        @endif
                    </h2>
                    <span class="text-muted" style="font-size: 14px; font-weight: 600; background: #edf2f7; padding: 4px 12px; border-radius: 20px;">
                        Found {{ count($notices) }} {{ Str::plural('notice', count($notices)) }}
                    </span>
                </div>
                
                <div class="notice-grid">
                    @forelse($notices as $notice)
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
                        <div class="alert alert-info text-center py-5" style="grid-column: 1 / -1; width: 100%; border-radius: 12px; background-color: #f7fafc; border: 1px dashed #cbd5e0; color: #4a5568; margin: 20px 0;">
                            <i class="fa fa-info-circle fa-2x mb-3" style="display: block; color: #a0aec0;"></i>
                            <span style="font-size: 16px; font-weight: 600; display: block; margin-bottom: 5px;">No matching notices found</span>
                            <span class="text-muted" style="font-size: 13px;">Try checking your spelling or adjusting your keywords.</span>
                        </div>
                    @endforelse
                </div>
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
