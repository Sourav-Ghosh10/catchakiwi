@include('includes/inner-header')

<style>
    .mid_body {
        background-color: #f7f9fc;
        padding-top: 40px;
    }
    .left_notice_header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 30px;
        gap: 20px;
    }
    .left_notice h2 {
        font-size: 30px;
        font-weight: 800;
        color: #2d3748;
        line-height: 1.2;
        margin: 0;
        flex: 1;
    }
    .left_notice h2 span {
        font-size: 15px;
        font-weight: 400;
        color: #718096;
        display: block;
        margin-top: 5px;
    }
    .notice_refineresults {
        background: #fff;
        border-radius: 12px;
        padding: 25px;
        border: 1px solid #e2e8f0;
        margin-bottom: 30px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.03);
    }
    .notice_refineresults h3 {
        font-size: 18px;
        font-weight: 800;
        color: #1a202c;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 2px solid #f7f9fc;
    }
    .notice_refineresults ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    .notice_refineresults a {
        display: flex;
        align-items: center;
        padding: 8px 0;
        color: #4a5568;
        font-size: 14px;
        text-decoration: none !important;
        transition: color 0.2s;
    }
    .notice_refineresults a::before {
        content: '\f105';
        font-family: FontAwesome;
        margin-right: 10px;
        color: #f7941d;
        font-weight: 900;
    }
    .notice_refineresults a:hover {
        color: #a3d900;
    }
    .notice_boxes {
        background: #fff;
        border-radius: 15px;
        padding: 25px;
        margin-bottom: 25px;
        border: 1px solid #edf2f7;
        box-shadow: 0 5px 15px rgba(0,0,0,0.02);
        position: relative;
    }
    .sale_strip {
        display: inline-block;
        background: #a3d900;
        color: #fff;
        padding: 4px 12px;
        font-size: 11px;
        font-weight: 800;
        border-radius: 5px;
        margin-bottom: 15px;
        text-transform: uppercase;
    }
    .notice_boxes h3 {
        font-size: 22px;
        font-weight: 800;
        color: #2d3748;
        margin-bottom: 12px;
    }
    .notice_des {
        font-size: 15px;
        color: #4a5568;
        line-height: 1.6;
        margin-bottom: 15px;
    }
    .location_txt {
        font-size: 13px;
        color: #718096;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
    }
    .location_txt::before {
        content: '\f041';
        font-family: FontAwesome;
        margin-right: 8px;
        color: #f7941d;
    }
    .notice_thum {
        display: flex;
        gap: 10px;
        margin-bottom: 20px;
    }
    .notice_thum img {
        width: 100px;
        height: 80px;
        object-fit: cover;
        border-radius: 8px;
        border: 1px solid #eee;
    }
    .notice_bottompan {
        border-top: 1px solid #f1f3f5;
        padding-top: 15px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .notice_logo {
        width: 35px;
        height: 35px;
        border-radius: 50%;
        margin-right: 12px;
    }
    .notice_bottompan p {
        margin: 0;
        font-weight: 700;
        color: #2d3748;
        display: flex;
        align-items: center;
        flex: 1;
    }
    .not_date {
        margin-left: 15px;
        font-weight: 400;
        color: #a0aec0;
        font-size: 13px;
    }
    .getquote_button, .postfree_button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        height: 42px;
        padding: 0 20px;
        border-radius: 8px;
        font-weight: 700;
        font-size: 13px;
        text-decoration: none !important;
        transition: all 0.3s;
        text-align: center;
        white-space: nowrap;
        margin: 0 !important;
    }
    .getquote_button {
        background: #f7941d;
        color: #fff;
        margin-right: 10px;
        box-shadow: 0 4px 12px rgba(247, 148, 29, 0.2);
    }
    .postfree_button {
        background: #f7941d;
        color: #fff;
        box-shadow: 0 4px 12px rgba(247, 148, 29, 0.2);
    }
    .left_notice_actions {
        display: flex;
        gap: 12px;
        align-items: center;
        flex-shrink: 0;
    }
    .pagination {
        margin-top: 40px;
        display: flex;
        justify-content: center;
        gap: 8px;
    }
    .pagination li a {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        border: 1px solid #e2e8f0;
        color: #718096;
        text-decoration: none !important;
        font-weight: 700;
    }
    .pagination li a.active {
        background: #a3d900;
        color: #fff;
        border-color: #a3d900;
    }
    .right_advertisesec img {
        width: 100%;
        border-radius: 12px;
        margin-bottom: 20px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    }
</style>

<div class="mid_body">
    <div class="container">
        <div class="full_midpan">
            <div class="row">
                <div class="col-lg-8 col-md-8 col-sm-12">
                    <div class="left_notice">
                        <div class="left_notice_header">
                            <h2>Notice Board<br>
                                <span>Public messages, items for sale or wanted, announce your events! (Lasts 7 days).</span>
                            </h2>
                            <div class="left_notice_actions">
                                <a href="#" class="getquote_button">Get a Quote</a>
                                <a href="#" class="postfree_button">Post a Free Notice</a>
                            </div>
                        </div>
                        <div class="notice_refineresults">
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
                        </div>
                        </div>
                        
                        <!-- Notice Box 1 -->
                        <div class="notice_boxes">
                            <span class="sale_strip">Garage Sales</span>
                            <h3>Garage Sale Sample Listing</h3>
                            <p class="notice_des">Add your garage sale here. FREE Map placement, photo with internal messaging. Garage sale listings are removed on Sunday night</p>
                            <p class="location_txt">40 Bowen Street, Wellington</p>
                            <div class="notice_thum">
                                <img src="{{ asset('assets/images/notice_thum.png')}}" alt="">
                                <img src="{{ asset('assets/images/notice_thum.png')}}" alt="">
                                <img src="{{ asset('assets/images/notice_thum.png')}}" alt="">
                            </div>
                            <div class="notice_bottompan">
                                <img src="{{ asset('assets/images/notice_logoimg.png')}}" alt="" class="notice_logo">
                                <p>Catchakiwi <span class="not_date">23/12/17</span></p>
                                <img src="{{ asset('assets/images/notice_chaticon.png')}}" alt="" class="notice_chat" style="width: 20px;">
                            </div>
                        </div>

                        <!-- Notice Box 2 -->
                        <div class="notice_boxes">
                            <span class="sale_strip">Garage Sales</span>
                            <h3>Waitara Big Market Day</h3>
                            <p class="notice_des">Most Saturdays, Starting 8:30 to 12 noon. Jewellery, plants, food, wood products, clothing, Produce, kids stuff and heaps more. Stall holders are welcome.</p>
                            <p class="location_txt">Domett Street, New Plymouth Airport, Waitara, @ St Johns</p>
                            <div class="notice_thum">
                                <img src="{{ asset('assets/images/notice_thum.png')}}" alt="">
                                <img src="{{ asset('assets/images/notice_thum.png')}}" alt="">
                                <img src="{{ asset('assets/images/notice_thum.png')}}" alt="">
                            </div>
                            <div class="notice_bottompan">
                                <img src="{{ asset('assets/images/notice_logoimg.png')}}" alt="" class="notice_logo">
                                <p>Catchakiwi <span class="not_date">23/12/17</span></p>
                                <img src="{{ asset('assets/images/notice_chaticon.png')}}" alt="" class="notice_chat" style="width: 20px;">
                            </div>
                        </div>

                        <ul class="pagination">
                            <li><a href="#"><i class="fa fa-angle-left"></i></a></li>
                            <li><a href="#" class="active">01</a></li>
                            <li><a href="#">02</a></li>
                            <li><a href="#">03</a></li>
                            <li><a href="#">04</a></li>
                            <li><a href="#"><i class="fa fa-angle-right"></i></a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12">
                    <div class="right_advertisesec">
                        @if(!empty($sideData))
                        @foreach ($sideData as $ad)
                        @if($ad->ads_image!="")
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
