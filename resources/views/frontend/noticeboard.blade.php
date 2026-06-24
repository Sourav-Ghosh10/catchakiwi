@include('includes/inner-header')

<link href="{{ asset('assets/css/noticeboard.css') }}?v={{ filemtime(public_path('assets/css/noticeboard.css')) }}" rel="stylesheet" type="text/css" />

<div class="mid_body">
    <!-- Search Section -->
    <div class="nb-v2-search-container">
        <form action="{{ route('notice-board') }}" method="GET" class="nb-v2-search-form">
            <div class="nb-v2-search-input-wrap">
                <i class="fa fa-search nb-v2-search-icon"></i>
                <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="What are you looking for today?"
                    class="nb-v2-search-input">
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
                                <a href="{{ route('notice-post') }}" class="postfree_button">Post a Free Notice</a>
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
                                                       style="{{ (isset($activeCategory) && $activeCategory->id == $cat->id) ? 'font-weight:bold; color:#729b0f;' : '' }}">
                                                        {{ $cat->category }} ({{ str_pad($cat->notices_count, 2, '0', STR_PAD_LEFT) }})
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="notice_grid_v2">
                        @forelse($notices as $notice)
                            <div class="notice_boxes">
                                <div class="card_image_container">
                                    @if(isset($notice->is_featured) && $notice->is_featured)
                                        <span class="featured_tag">Featured listing</span>
                                    @endif
                                    
                                    @if(isset($noticeImages[$notice->id]) && count($noticeImages[$notice->id]) > 0)
                                        <img src="{{ asset($noticeImages[$notice->id][0]->img_path) }}" alt="{{ $notice->heading }}">
                                    @else
                                        <img src="{{ asset('assets/images/notice_logoimg.png') }}" style="object-fit: contain; padding: 20px; background: #f8f9fa;">
                                    @endif
                                </div>

                                <div class="card_body_v2">
                                    <div class="price_tag_v2">
                                        {{ $notice->budget > 0 ? '$'.number_format($notice->budget) : 'FREE' }}
                                    </div>
                                    <h3>{{ $notice->heading }}</h3>
                                    
                                    <div class="card_footer_v2">
                                        <div class="location_v2">
                                            <i class="fa fa-map-marker-alt" style="color: #f7941d;"></i> 
                                            {{ $notice->town_suburb ?? 'Wellington' }}
                                        </div>
                                        <a href="{{ url('/profile#parentHorizontalTab3') }}" class="chat_btn_v3" title="Chat with seller">
                                            <img src="{{ asset('assets/images/notice_chaticon.png') }}" alt="Message">
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="alert alert-info">No notices found in this category.</div>
                            </div>
                        @endforelse
                    </div>

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