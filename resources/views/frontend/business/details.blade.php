@include('includes/inner-header')

<!--<div class="top_search nomob_search">-->
<!--   <div class="container">-->
<!--      <div class="logo">-->
<!--         <h1><a href="{{ URL::to('/') }}"><img src="{{ asset('assets/images/logo-inner.png') }}" alt="" /></a></h1>-->
<!--      </div>-->
<!--   </div>-->
<!--   <div class="container">-->
<!--      <div class="home_midbody">-->
<!--         <div class="home_searchsec">-->
<!--            <form action="" method="post">-->
<!--               <input name="" type="text" placeholder="Services I’m looking for" />-->
<!--               <input name="" type="text" placeholder="Enter your location" class="location" />-->
<!--               <input name="" type="submit" value="Search" />-->
<!--            </form>-->
<!--         </div>-->
<!--      </div>-->
<!--   </div>-->
<!--</div>-->
<!-- Header start end-->
<style>
    .review-container {
        /*max-width: 700px;*/
        margin: auto;
        background-color: #fff;
        padding: 20px;
        border: 1px solid #ddd;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    
    .add-review-btn {
        display: inline-block;
        background-color: #ff9800;
        color: white;
        border: none;
        padding: 10px 20px;
        font-size: 16px;
        border-radius: 3px;
        cursor: pointer;
        margin-bottom: 20px;
    }
    
    .add-review-btn span {
        font-size: 20px;
        font-weight: bold;
        margin-left: 5px;
    }
    
    .review-form {
        background-color: #f9f9f9;
        padding: 15px;
        border-radius: 5px;
    }
    
    /*p {*/
    /*    font-size: 18px;*/
    /*    margin-bottom: 10px;*/
    /*}*/
    
    .rating-section {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px;
        margin-bottom: 20px;
    }
    
    .rating-category {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .rating-category label {
        font-size: 16px;
    }
    
    .star-rating {
        direction: rtl;
    }
    
    .star-rating input {
        display: none;
    }
    
    .star-rating label {
        font-size: 20px;
        color: #ddd;
        cursor: pointer;
        padding: 0 2px;
    }
    
    .star-rating input:checked ~ label {
        color: #ff9800;
    }
    
    .star-rating label:hover,
    .star-rating label:hover ~ label {
        color: #ff9800;
    }
    
    .review-textarea {
        width: 100%;
        height: 100px;
        padding: 10px;
        margin-bottom: 15px;
        border-radius: 5px;
        border: 1px solid #ddd;
        font-size: 16px;
    }
    
    .save-review-btn {
        background-color: #f8981d;
        color: white;
        border: none;
        padding: 10px 20px;
        font-size: 16px;
        border-radius: 3px;
        cursor: pointer;
    }
    
    .save-review-btn:hover {
        background-color: #45a049;
    }
    .rev_showdtls {
        display: inline-block;
        background-color: #007bff;
        color: #fff;
        /*padding: 8px 12px;*/
        text-decoration: none;
        border-radius: 4px;
        margin-bottom: 10px;
        transition: background-color 0.3s ease;
    }
    
    .rev_showdtls:hover {
        background-color: #0056b3;
    }
    
    /* Styling for the details section */
    .revshow_details {
        background-color: #f9f9f9;
        padding: 15px;
        border: 1px solid #ddd;
        border-radius: 4px;
        margin-top: 10px;
    }
    
    .revshow_details ul {
        list-style: none;
        padding-left: 0;
    }
    
    .revshow_details li {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 8px 0;
        border-bottom: 1px solid #ddd;
    }
    
    .revshow_details label {
        font-weight: bold;
        color: #555;
    }
    
    .revshow_details span {
        display: flex;
        align-items: center;
    }
    
    .revshow_details img {
        height: 20px;
        margin-left: 10px;
    }
    
    /* Adding transitions for smooth toggle effect */
    .revshow_details {
        display: none;
        transition: opacity 0.4s ease;
    }
    
    .revshow_details.open {
        display: block;
        opacity: 1;
    }
    .popover-content a{
        font-size: 14px !important;
        font-weight: bold !important;
        color: #000 !important;
        background: #fff !important;
        vertical-align: inherit !important;
    }
    .popover-content{
        width:215px;
    }
</style>
   <!-- body start-->
   @if(session('success'))
        <script>
            alert("{{ session('success') }}");
        </script>
    @endif
   <div class="mid_body">
      <div class="container">
         <div class="full_midpan">
            <div class="full_businessdtls">
               <div class="brad_cam">
                  <ul>
                     <li><a href="{{ URL::to($country.'/business')}}">Top Business</a></li>
                     <li><a href="{{ URL::to($country.'/business/'.$business->title_url)}}"><?= $business->title ?></a></li>
                     <li class="active"><a href="{{ URL::to($country.'/business/'.$business->title_url."/".$business->sec_title_url)}}"><?= $business->sec_title ?></a></li>
                  </ul> 
                  <?php
                  $user_id = (Auth::user())?Auth::user()->id:0;
                  ?>
                  @if($business->user_id == $user_id)
                     <a href="{{ route('business.list.edit', $business->id) }}" class="edityour_button">Edit Your Listing</a>
                  @endif
                  <br class="clr" /> </div>
               <div class="busdtls_profile">
                  <div class="row">
                    <div class="col-lg-4 col-md-4 col-sm-12 bus_profilepic">
                        @if($business->select_image) 
                            <img src="<?= asset($business->select_image) ?>" alt="">
                         @else 
                            <!--<img src="{{ asset('assets/images/cam_img.png') }}" alt="">-->
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(preg_replace('/[^A-Za-z0-9 ]/', '', $business->display_name)) }}&color=7F9CF5&background=EBF4FF" alt="">

                         @endif
                    </div>
                    @php
                        $ratingavg = 0;
                    @endphp
                    @if(!empty($rating))
                        @php
                            //Ranking avarage echo here
                            $ratingavg = round(array_sum(array_column($rating, 'rating')) / count($rating));
                            //echo array_sum(array_column($rating, 'rating')) / count($rating)
                        @endphp
                    @endif
                    
                     <div class="col-lg-8 col-md-8 col-sm-12">
                        <div class="busin_profdtlsrgt">
                           <h3>{{ $business->display_name }}</h3>
                                <div class="location_txt">
                                    <img src="{{ asset('assets/images/location_icon.png') }}" alt="">
                                    <?= (($business->display_address == "yes")?$business->address.", ":"") . $business->region ?>
                                </div>
                           <div class="rating_txt"><img src="{{ asset('assets/images/'.$ratingavg.'rate.png') }}" alt="">({{ count($rating) }}) Member Rating </div>
                           <?php
                           if($business->homebased_business == "yes"){
                           ?>
                                <div class="homebasedbus_option">This is a Home-Based Business</div>
                           <?php
                           }
                           ?>
                           <div class="mobweb_txt">
                              <ul>
                                 <li>
                                    <img src="{{ asset('assets/images/phone_icon.png') }}" alt="Phone Icon"> 
                                    <span class="spntoggle" 
                                          data-toggle="popover" 
                                          data-html="true" 
                                          data-placement="bottom" 
                                          data-content="
                                            1. <a href='tel:{{ $business->main_phone }}'>{{ $business->main_phone }}</a>
                                            @if($business->secondary_phone)
                                                <br>2. <a style='font-size: 14px !important; font-weight: bold !important; color: #007bff !important;' href='tel:{{ $business->secondary_phone }}'>{{ $business->secondary_phone }}</a>
                                            @endif">
                                        Telephone
                                    </span>
                                </li>
                                
                                <li>
                                    <img src="{{ asset('assets/images/email_icon.png') }}" alt="Email Icon">
                                   <!-- <span  class="spntoggle" data-placement="bottom" data-html="true" data-toggle="popover" 
                                          data-content="<a href='mailto:{{ $business->email_address }}'>{{ $business->email_address }}</a>">Message</span> -->
                                  <span class="spntoggle msgtap" data-userid='{{ $business->user_id }}' data-username='{{ $business->name }}'>Message</span>
                                </li>
                                
                                <li>
                                    <img src="{{ asset('assets/images/location_icon.png') }}" alt="Location Icon"> 
                                    <span class="maptar" target="#maploc">Map / Location</span>
                                </li>
                                @if($business->website_url!="")
                                	@php
                                    	$website = $business->website_url;
                                    	$url = preg_match('/^https?:\/\//', $website) ? $website : 'https://' . $website;
                                    @endphp
                                    <li>
                                        <img src="{{ asset('assets/images/globe_iconblk.png') }}" alt="Globe Icon"> 
                                        <span  class="spntoggle" data-placement="bottom" data-html="true" data-toggle="popover" 
                                              data-content="<a target='_blank' href='{{ $url }}'>{{ $business->website_url }}</a>">Website</span>
                                    </li>
                                @endif
                                <br class="clr" />
                                 <li><img src="{{ asset('assets/images/user_icon.png') }}" alt=""><span class="bsnsuser">User Profile</span></li>
                                 <li><img src="{{ asset('assets/images/review_icon.png') }}" alt="">Reviews ({{ count($rating) }})</li>
                                 <li><img src="{{ asset('assets/images/print_icon.png') }}" alt=""><span class="bsnspnt">Print</span></li>
                              </ul>
                           </div>
                           <div class="busprofile_social">
                              <!--<p class="social">-->
                                 <!--<a href="#"><img src="{{ asset('assets/images/footer_fb.png') }}" alt=""></a>-->
                                 <!--<a href="#"><img src="{{ asset('assets/images/footer_instagram.png') }}" alt=""></a>-->
                                 <!--<a href="#"><img src="{{ asset('assets/images/footer_twitter.png') }}" alt=""></a>-->
                                 <!--<a href="#"><img src="{{ asset('assets/images/footer_linkdin.png') }}" alt=""></a>-->
                              <!--</p> -->
                              <!--<a href="#" class="addriview add_revaccbutton">Add Reviews +</a>-->
                              @if(Auth::user())
                                <a href="#" class="addriview add_revaccbutton_top">Add Review +</a>
                              @else
                                <a href="{{ URL::to('/login?redirect='.$country.'/business/'.$business->slug) }}" class="addriview">Add Review +</a>
                              @endif
                              @if($business->facebook!="")
                                <a href="{{ $business->facebook }}" target="_blank"><img src="{{ asset('assets/images/wh_fb.png') }}" alt=""> <span>Share</span></a>
                              @endif
                              @if($business->twitter!="")
                                <a href="{{ $business->twitter }}" target="_blank"><img src="{{ asset('assets/images/wh_twitter.png') }}" alt=""> <span>Share</span></a>
                              @endif
                              @if($business->linkedIn!="")
                                <a href="{{ $business->linkedIn }}" target="_blank"><img src="{{ asset('assets/images/wp_linkedin.png') }}" alt=""> <span>Share</span></a>
                              @endif
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="busidtls_description">
                  <h4><img src="{{ asset('assets/images/description_icon.png') }}" alt=""> Description</h4>
                  <p><?= $business->business_description ?></p>
                <!--  <p><a href="#"><?= $business->title ?></a> / <a href="#" class="active"><?= $business->sec_title ?></a> </p> -->
               </div>
               <div class="busidtls_location" id="maploc">
                  <h4><img src="{{ asset('assets/images/location_icon.png') }}" alt=""> Map / Location</h4>
                  <p><?= (($business->display_address == "yes")?$business->address.", ":"") . $business->region ?></p>
                  @if($business->display_address == "yes" && $business->map)
                        {!! $business->map !!}
                  @endif
                  <!--<img src="{{ asset('assets/images/map_pic.png') }}" alt="" class="map"> </div>-->
               <div class="busidtls_reviewpan">
                  <h4><img src="{{ asset('assets/images/review_icon.png') }}" alt="">Reviews ({{ count($rating) }})</h4>
                  @php
                  $is_userrev = ($business->user_id == Auth::id()) ? 1 : 0;
                  @endphp
                  @if(!empty($rating))
                    @foreach($rating as $rate)
                    @php
                        $createdDt = \Carbon\Carbon::parse($rate['created_at'])->format('jS M Y');
                        
                        $is_userrev = ($rate['user_id'] == Auth::id()) ? 1 : 0;
                    @endphp
                    
                    
                      <div class="review_grypan">
                         <h2>
                            @if($rate['image']=="")
                                <img src="{{ asset('assets/images/blnkuser_img.png') }}" alt="">
                            @else
                                <img src="{{ asset($rate['image']) }}" alt="" style="width: 50px;border-radius: 39px;height: 50px;">
                            @endif
                            
                            
                        <span class="rev_name">Reviewed by <strong>{{ $rate['name'] }}</strong>
                        <img src="{{ asset('assets/images/' . $rate['rating'].'rate.png') }}" alt=""> </span>
                        <span class="rev_date">{{ $createdDt }}</span>
                        </h2>
                         <p>{{ $rate['review'] }}</p> <a class="rev_showdtls">Show Details</a>
                         <div class="revshow_details" style="display:none;">
                            <div class="col-sm-6">
                                <ul>
                                    <li>
                                      <label>Initial impression</label> <span><img src="{{ asset('assets/images/'. $rate['initial_rate'].'rate.png') }}" alt=""></span></li>
                                    <li>
                                      <label>Value</label> <span><img src="{{ asset('assets/images/'. $rate['value_rate'].'rate.png') }}" alt=""></span></li>
                                    <li>
                                      <label>Quality</label> <span><img src="{{ asset('assets/images/'. $rate['quality_rate'].'rate.png') }}" alt=""></span></li>
                                </ul>
                            </div>
                            <div class="col-sm-6">
                                <ul>
                                   <li>
                                      <label>Overall opinion</label> <span><img src="{{ asset('assets/images/'. $rate['overall_opinion_rate'].'rate.png') }}" alt=""></span></li>
                                   <li>
                                      <label>Punctuality</label> <span><img src="{{ asset('assets/images/'. $rate['punctuality_rate'].'rate.png') }}" alt=""></span></li>
                                   <li>
                                      <label>Cleanliness</label> <span><img src="{{ asset('assets/images/'. $rate['cleanliness_rate'].'rate.png') }}" alt=""></span></li>
                                </ul>
                            </div>
                         </div>
                      </div>
                    @endforeach
                  @endif
                  @if(Auth::user())
                    @if($is_userrev == 0)
                        <a href="#" class="add_revaccbutton">Add Review +</a>
                    @endif
                  @else
                    <a href="{{ URL::to('/login?redirect='.$country.'/business/'.$business->slug) }}" class="add_revaccbutton">Add Review +</a>
                  @endif
                  <!--<a class="add_revaccbutton">Add Review +</a>-->
                  
                  <div class="review-container reviewsec" style="display:none">
                    <!--<button class="add-review-btn">Add Review <span>+</span></button>-->
                    <form class="review-form" action="{{ route('business.reviewsub') }}" method="post" id="reviewform">
                        @csrf
                        <p>Please Rate:</p>
                        
                        <input type="hidden" name="business_id" value="{{ $business->id }}">
                       
                        <div class="rating-section">
                            <!-- Rating Categories with clickable stars -->
                            <div class="rating-category">
                                <label>Initial impression</label>
                                <div class="star-rating">
                                    <input type="radio" id="initial-5" name="initial-impression" value="5"><label for="initial-5" title="5 stars">★</label>
                                    <input type="radio" id="initial-4" name="initial-impression" value="4"><label for="initial-4" title="4 stars">★</label>
                                    <input type="radio" id="initial-3" name="initial-impression" value="3"><label for="initial-3" title="3 stars"></label>
                                    <input type="radio" id="initial-2" name="initial-impression" value="2"><label for="initial-2" title="2 stars">★</label>
                                    <input type="radio" id="initial-1" name="initial-impression" value="1"><label for="initial-1" title="1 star"></label>
                                </div>
                            </div>
                            <div class="rating-category">
                                <label>Cleanliness</label>
                                <div class="star-rating">
                                    <input type="radio" id="clean-5" name="cleanliness" value="5"><label for="clean-5" title="5 stars"></label>
                                    <input type="radio" id="clean-4" name="cleanliness" value="4"><label for="clean-4" title="4 stars">★</label>
                                    <input type="radio" id="clean-3" name="cleanliness" value="3"><label for="clean-3" title="3 stars">★</label>
                                    <input type="radio" id="clean-2" name="cleanliness" value="2"><label for="clean-2" title="2 stars"></label>
                                    <input type="radio" id="clean-1" name="cleanliness" value="1"><label for="clean-1" title="1 star">★</label>
                                </div>
                            </div>
                            <div class="rating-category">
                                <label>Value</label>
                                <div class="star-rating">
                                    <input type="radio" id="value-5" name="value" value="5"><label for="value-5" title="5 stars"></label>
                                    <input type="radio" id="value-4" name="value" value="4"><label for="value-4" title="4 stars">★</label>
                                    <input type="radio" id="value-3" name="value" value="3"><label for="value-3" title="3 stars">★</label>
                                    <input type="radio" id="value-2" name="value" value="2"><label for="value-2" title="2 stars">★</label>
                                    <input type="radio" id="value-1" name="value" value="1"><label for="value-1" title="1 star"></label>
                                </div>
                            </div>
                            <div class="rating-category">
                                <label>Punctuality</label>
                                <div class="star-rating">
                                    <input type="radio" id="punctual-5" name="punctuality" value="5"><label for="punctual-5" title="5 stars">★</label>
                                    <input type="radio" id="punctual-4" name="punctuality" value="4"><label for="punctual-4" title="4 stars">★</label>
                                    <input type="radio" id="punctual-3" name="punctuality" value="3"><label for="punctual-3" title="3 stars"></label>
                                    <input type="radio" id="punctual-2" name="punctuality" value="2"><label for="punctual-2" title="2 stars">★</label>
                                    <input type="radio" id="punctual-1" name="punctuality" value="1"><label for="punctual-1" title="1 star">★</label>
                                </div>
                            </div>
                            <div class="rating-category">
                                <label>Quality</label>
                                <div class="star-rating">
                                    <input type="radio" id="quality-5" name="quality" value="5"><label for="quality-5" title="5 stars">★</label>
                                    <input type="radio" id="quality-4" name="quality" value="4"><label for="quality-4" title="4 stars">★</label>
                                    <input type="radio" id="quality-3" name="quality" value="3"><label for="quality-3" title="3 stars"></label>
                                    <input type="radio" id="quality-2" name="quality" value="2"><label for="quality-2" title="2 stars"></label>
                                    <input type="radio" id="quality-1" name="quality" value="1"><label for="quality-1" title="1 star"></label>
                                </div>
                            </div>
                            <div class="rating-category">
                                <label>Overall opinion</label>
                                <div class="star-rating">
                                    <input type="radio" id="opinion-5" name="overall-opinion" value="5"><label for="opinion-5" title="5 stars">★</label>
                                    <input type="radio" id="opinion-4" name="overall-opinion" value="4"><label for="opinion-4" title="4 stars">★</label>
                                    <input type="radio" id="opinion-3" name="overall-opinion" value="3"><label for="opinion-3" title="3 stars">★</label>
                                    <input type="radio" id="opinion-2" name="overall-opinion" value="2"><label for="opinion-2" title="2 stars">★</label>
                                    <input type="radio" id="opinion-1" name="overall-opinion" value="1"><label for="opinion-1" title="1 star"></label>
                                </div>
                            </div>
                        </div>
            
                        <textarea class="review-textarea" name="review" placeholder="Enter your review below, Ensure you are specific about the details of your review."></textarea>
                        <button type="submit" class="save-review-btn">Save Review</button>
                    </form>
                </div>
               </div>
               <div class="busidtls_contactpan">
                  <h4><img src="{{ asset('assets/images/contact_handicon.png') }}" alt="">Contact</h4> <a class="email_accbutton">Email Member</a>
                  <div class="contact_grypandd" style="display:none;">
                     <form action="" method="get">
                        <textarea name="" cols="" rows="" placeholder="Enter your message below."></textarea>
                        <input name="" type="submit" value="Send Message"> </form>
                     <br class="clr" /> </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   </div>
 <div class="msgpopinvisual">
                                    <div class="innermsgpop">
                                      <img src="{{ asset('assets/images/close1.png') }}" alt="" class="closemsg">
                                      <h3>Message(<span class="usernm"></span>)</h3>
                                       <form method="post" id="quickMessageForm">
                                         @csrf
            							<input type="hidden" name="receiver_id" id="msguserid" value="">
                                      <textarea id="quickMsgText">Enter Your Message</textarea>
                                      <input type="submit" value="Send"/>
                                    </form>
                                    </div>
                                   
                                  </div>
   <!-- body start end-->
     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    @if($is_userrev == 1)
        <script>
            $('.add_revaccbutton,.add_revaccbutton_top').remove();
        </script>
    @endif
     <script>
        $(document).ready(function() {
            // Initialize popovers for elements with the 'spntoggle' class
            $('[data-toggle="popover"]').popover();
            
            // Hide popover if clicking outside the popover or toggle
            $(document).on('click', function(e) {
                if (!$(e.target).closest('.spntoggle, .popover').length) {
                    $('[data-toggle="popover"]').popover('hide');
                }
            });
            
            // Prevent the popover from hiding when clicking inside it or the toggle button
            $('.spntoggle, .popover').on('click', function(e) {
                e.stopPropagation();
            });
        });

        //==========================
         $(document).on("click",".maptar",function(){
             var target = $(this).attr("target"); // Get the href attribute value
            $('html, body').animate({
              scrollTop: $(target).offset().top
            }, 1000);
             
         })
         $(document).on("click",".bsnspnt", function(){
             window.location.href=window.location.href+"/print";
         })
         $(document).on("click",".bsnsuser", function(){
             window.location.href="https://catchakiwi.com/<?= $country ?>/profile/<?= Crypt::encryptString($business->user_id) ?>";
         })
         $(document).on('click','.add_revaccbutton,.add_revaccbutton_top', function(){
             $(".reviewsec").show();
             $('html, body').animate({
              scrollTop: $(".reviewsec").offset().top
            }, 1000);
         })
         $(document).on('click','.weblink', function(){
             let link = "<?= $business->website_url ?>";
             if(link != ""){
                 window.open(link, '_blank');
             }
         })
         $(document).on("click",".rev_showdtls", function(){
             let text = $(this).text();
             if(text=="Show Details"){
                 $(this).text("Show Less");
             }else{
                 $(this).text("Show Details");
             }
             $(this).next(".revshow_details").toggle();
         })
     </script>
<script>
$(document).ready(function () {
    // Close popup
    $(".closemsg, .msgpopinvisual").on('click', function (e) {
        if (e.target === this || $(e.target).hasClass('closemsg')) {
            $(".msgpopinvisual").fadeOut(200);
        }
    });

    // Open popup OR go to login with current URL
    $(".msgtap").on('click', function () {
        @if(auth()->check())
            // LOGGED IN  open popup
            $("#msguserid").val($(this).data('userid'));
            $('#quickMsgText').val('');
      		$('.usernm').text($(this).data('username'));
            $(".msgpopinvisual").fadeIn(200);
        @else
            // NOT LOGGED IN → go to login + remember this page
            const currentUrl = encodeURIComponent(window.location.href);
            window.location.href = "{{ route('login') }}?redirectto=" + currentUrl;
        @endif
    });

    // AUTO-OPEN POPUP AFTER LOGIN (if URL contains ?openmsg=1)
    @if(auth()->check() && request()->has('openmsg'))
        $(function () {
            // Extract user ID from URL (you can pass it like ?openmsg=123)
            const userId = {{ request()->get('openmsg') }};
            if (userId) {
                $("#msguserid").val(userId);
                $('#quickMsgText').val('');
                $(".msgpopinvisual").fadeIn(200);
            }
        });
    @endif
});
  
$('#quickMessageForm').on('submit', function (e) {
    e.preventDefault();

    const receiverId = $('#msguserid').val();
    const message    = $('#quickMsgText').val().trim();
    const $btn       = $(this).find('.quick-send-btn');

    if (!message) {
        alert('Please type a message');
        return;
    }

    $btn.prop('disabled', true).val('Sending...');

    sendMessage(receiverId, message)
        .then(() => {
            // Close popup
            $('.msgpopinvisual').fadeOut(200);

            // Reset form
            $btn.prop('disabled', false).val('Send');
            $('#quickMsgText').val('');

            // SHOW SUCCESS TOAST
            showToast('Message sent successfully!', 'success');
        })
        .catch(() => {
            $btn.prop('disabled', false).val('Send');
            showToast('Failed to send message.', 'error');
        });
});
function sendMessage(receiverId, message, csrfToken = null, mobileContainer = null) {
    if (!message.trim()) return Promise.reject('empty');

    // Get CSRF from form if not passed
    if (!csrfToken && document.getElementById('quickMessageForm')) {
        csrfToken = document.querySelector('#quickMessageForm input[name="_token"]')?.value;
    }

    return fetch('/chat/send', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': csrfToken || ''
        },
        body: JSON.stringify({ receiver_id: receiverId, message })
    })
    .then(r => {
        if (!r.ok) throw new Error('Network error');
        return r.json();
    })
    .then(msg => {
        // Optimistic UI
        const div = document.createElement('div');
        div.className = 'msg me';
        div.innerHTML = `${msg.text}<span class="msg-time">${msg.time}</span><span class="seen-icon">Sent</span>`;

        if (window.innerWidth > 768 && typeof desktopMessages !== 'undefined') {
            desktopMessages.appendChild(div);
            desktopMessages.scrollTop = desktopMessages.scrollHeight;
        } else if (mobileContainer) {
            const wrap = mobileContainer.querySelector('.messages');
            wrap.appendChild(div);
            wrap.scrollTop = wrap.scrollHeight;
        }

        if (typeof refreshBadges === 'function') refreshBadges();
        return msg;
    })
    .catch(err => {
        console.error('Send failed:', err);
        throw err;
    });
}
 function showToast(message, type = 'success') {
    // Remove any existing toast
    $('.toast-notification').remove();

    // Create toast
    const toast = $(`
        <div class="toast-notification ${type}">
            <span>${message}</span>
            <span class="toast-close">x</span>
        </div>
    `);

    // Append to body
    $('body').append(toast);

    // Auto position (center bottom)
    toast.css({
        position: 'fixed',
        bottom: '30px',
        left: '50%',
        transform: 'translateX(-50%)',
        background: type === 'success' ? '#28a745' : '#dc3545',
        color: 'white',
        padding: '12px 24px',
        borderRadius: '6px',
        fontSize: '14px',
        boxShadow: '0 4px 12px rgba(0,0,0,0.15)',
        zIndex: 10000,
        display: 'flex',
        alignItems: 'center',
        gap: '10px',
        animation: 'toastSlideIn 0.4s ease'
    });

    // Close button
    toast.find('.toast-close').css({
        cursor: 'pointer',
        fontWeight: 'bold',
        fontSize: '16px'
    }).on('click', () => toast.fadeOut(200, () => toast.remove()));

    // Auto remove after 3 seconds
    setTimeout(() => {
        toast.fadeOut(300, () => toast.remove());
    }, 3000);
}

// Optional: Add slide-in animation
const style = document.createElement('style');
style.textContent = `
    @keyframes toastSlideIn {
        from { transform: translateX(-50%) translateY(100px); opacity: 0; }
        to { transform: translateX(-50%) translateY(0); opacity: 1; }
    }
`;
document.head.appendChild(style);
</script>
@include('includes/footer')