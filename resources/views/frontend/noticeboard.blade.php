@include('includes/inner-header')

<link href="{{ asset('assets/css/noticeboard.css') }}" rel="stylesheet" type="text/css" />

<div class="mid_body">
    <!-- Search Section -->
    <div class="nb-v2-search-container">
        <form action="#" method="GET" class="nb-v2-search-form">
            <div class="nb-v2-search-input-wrap">
                <i class="fa fa-search nb-v2-search-icon"></i>
                <input type="text" name="search" placeholder="What are you looking for today?"
                    class="nb-v2-search-input">
                <button type="submit" class="nb-v2-search-btn">Search</button>
            </div>
    </div>
    <div class="container">
        <div class="full_midpan">
            <div class="row">
                <div class="col-lg-8 col-md-8 col-sm-12">
                    <div class="left_notice">
                        <div class="left_notice_header">
                            <h2>$5 Service Deals<br>
                                <span>Try a new local service for $5 and help a small business get started.</span>
                            </h2>
                            <div class="left_notice_actions">
                                <!-- <a href="#" class="getquote_button">Get a Quote</a> -->
                                <a href="#" class="postfree_button">Post a Free Notice</a>
                            </div>
                        </div>
                        <!-- <div class="notice_refineresults">
                            <h3>Refine Results:</h3>
                            <div class="row">
                                <div class="col-md-4">
                                    <ul>
                                        <li><a href="#">$5 Service Deal</a></li>
                                        <li><a href="#">CAR-CatchARide</a></li>
                                        <li><a href="#">Cars and Vehicles (2)</a></li>
                                        <li><a href="#">Found</a></li>
                                        <li><a href="#">Free</a></li>
                                    </ul>
                                </div>
                                <div class="col-md-4">
                                    <ul>
                                        <li><a href="#">Garage Sales (106)</a></li>
                                        <li><a href="#">Goods to Sell, Buy or Trade</a></li>
                                        <li><a href="#">Help a Kiwi - Volunteer</a></li>
                                        <li><a href="#">House for Rent</a></li>
                                        <li><a href="#">Local Events</a></li>
                                    </ul>
                                </div>
                                <div class="col-md-4">
                                    <ul>
                                        <li><a href="#">Pets and Animals</a></li>
                                        <li><a href="#">Real Estate</a></li>
                                        <li><a href="#">Services (1)</a></li>
                                        <li><a href="#">Thanking People</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div> -->
                    </div>

                    <!-- Notice Box 1 -->
                    <div class="notice_boxes">
                        <!-- <span class="sale_strip">Window</span> -->
                        <h3>Window Cleaning Sample Listing</h3>
                        <p class="notice_des">Add your window cleaning here. FREE Map placement, photo with internal
                            messaging. Window cleaning listings are removed on Sunday night</p>
                        <p class="location_txt">40 Bowen Street, Wellington</p>
                        <div class="notice_thum">
                            <img src="{{ asset('assets/images/notice_thum.png')}}" alt="">
                            <img src="{{ asset('assets/images/notice_thum.png')}}" alt="">
                            <img src="{{ asset('assets/images/notice_thum.png')}}" alt="">
                        </div>
                        <div class="notice_bottompan">
                            <img src="{{ asset('assets/images/notice_logoimg.png')}}" alt="" class="notice_logo">
                            <p>Catchakiwi <span class="not_date">23/12/17</span></p>
                            <img src="{{ asset('assets/images/notice_chaticon.png')}}" alt="" class="notice_chat">
                        </div>
                    </div>

                    <!-- Notice Box 2 -->
                    <div class="notice_boxes">
                        <!-- <span class="sale_strip">Door</span> -->
                        <h3>Door Cleaning Sample Listing</h3>
                        <p class="notice_des">Add your door cleaning here. FREE Map placement, photo with internal
                            messaging. Door cleaning listings are removed on Sunday night</p>
                        <p class="location_txt">Domett Street, New Plymouth Airport, Waitara, @ St Johns</p>
                        <div class="notice_thum">
                            <img src="{{ asset('assets/images/notice_thum.png')}}" alt="">
                            <img src="{{ asset('assets/images/notice_thum.png')}}" alt="">
                            <img src="{{ asset('assets/images/notice_thum.png')}}" alt="">
                        </div>
                        <div class="notice_bottompan">
                            <img src="{{ asset('assets/images/notice_logoimg.png')}}" alt="" class="notice_logo">
                            <p>Catchakiwi <span class="not_date">23/12/17</span></p>
                            <img src="{{ asset('assets/images/notice_chaticon.png')}}" alt="" class="notice_chat">
                        </div>
                    </div>

                    <!-- Notice Box 3 -->
                    <div class="notice_boxes">
                        <!-- <span class="sale_strip">Door</span> -->
                        <h3>Glass Cleaning Sample Listing</h3>
                        <p class="notice_des">Add your glass cleaning here. FREE Map placement, photo with internal
                            messaging. Glass cleaning listings are removed on Sunday night</p>
                        <p class="location_txt">Domett Street, New Plymouth Airport, Waitara, @ St Johns</p>
                        <div class="notice_thum">
                            <img src="{{ asset('assets/images/notice_thum.png')}}" alt="">
                            <img src="{{ asset('assets/images/notice_thum.png')}}" alt="">
                            <img src="{{ asset('assets/images/notice_thum.png')}}" alt="">
                        </div>
                        <div class="notice_bottompan">
                            <img src="{{ asset('assets/images/notice_logoimg.png')}}" alt="" class="notice_logo">
                            <p>Catchakiwi <span class="not_date">23/12/17</span></p>
                            <img src="{{ asset('assets/images/notice_chaticon.png')}}" alt="" class="notice_chat">
                        </div>
                    </div>
                    <!-- Notice Box 4 -->
                    <div class="notice_boxes">
                        <!-- <span class="sale_strip">Door</span> -->
                        <h3>Frame Cleaning Sample Listing</h3>
                        <p class="notice_des">Add your frame cleaning here. FREE Map placement, photo with internal
                            messaging. Frame cleaning listings are removed on Sunday night</p>
                        <p class="location_txt">Domett Street, New Plymouth Airport, Waitara, @ St Johns</p>
                        <div class="notice_thum">
                            <img src="{{ asset('assets/images/notice_thum.png')}}" alt="">
                            <img src="{{ asset('assets/images/notice_thum.png')}}" alt="">
                            <img src="{{ asset('assets/images/notice_thum.png')}}" alt="">
                        </div>
                        <div class="notice_bottompan">
                            <img src="{{ asset('assets/images/notice_logoimg.png')}}" alt="" class="notice_logo">
                            <p>Catchakiwi <span class="not_date">23/12/17</span></p>
                            <img src="{{ asset('assets/images/notice_chaticon.png')}}" alt="" class="notice_chat">
                        </div>
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
@include('includes/footer')