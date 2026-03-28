@include('includes/inner-header')

<div class="mid_body">
  <div class="container">
    <div class="full_midpan">
      <div class="row">
        <div class="col-lg-8 col-md-8 col-sm-12">
          <div class="left_searchresults">
            <h3>Search Results For <span>“{{ $searchQuery }}” ({{ count($businesses)}} hits)</span></h3>
                @if(!empty($businesses))
                    @foreach($businesses as $topBusiness)
                        <div class="search_restspan">
                          <div class="row">
                            <div class="col-lg-4 col-md-4 col-sm-12 search_lftthum">
                                <a href="{{ URL::to(strtolower(session('CountryCode')).'/business/'.$topBusiness->title_url."/".$topBusiness->sec_title_url."/".$topBusiness->slug) }}">
                                  @if(!empty($topBusiness->select_image) && file_exists(base_path($topBusiness->select_image)) && filesize(base_path($topBusiness->select_image)) > 0)
                                  		<img src="{{ asset($topBusiness->select_image) }}" alt="">
                                  @else
                                  		<!--<img src="{{ asset('public/assets/business/default_company.jpg') }}" alt="">-->
                                  		<img src="https://ui-avatars.com/api/?name={{ urlencode(preg_replace('/[^A-Za-z0-9 ]/', '', $topBusiness->display_name)) }}&color=7F9CF5&background=EBF4FF" alt="">

                                  @endif
                                </a>
                            </div>
                            <div class="col-lg-8 col-md-8 col-sm-12 results_rightdtls">
                              <h4><a href="{{ URL::to(strtolower(session('CountryCode')).'/business/'.$topBusiness->title_url."/".$topBusiness->sec_title_url."/".$topBusiness->slug) }}">{{ $topBusiness->display_name }}</a></h4>
                              <div class="location_txt">
                                <img src="{{ asset('assets/images/location_icon.png') }}" alt="" />
                                <?= (($topBusiness->display_address == "yes")?$topBusiness->address.", ":"") . $topBusiness->region ?>
                              </div>
                              
                              <div class="mobweb_txt">
                                <p><?= substr(trim(preg_replace('/<[^>]+>/', ' ',$topBusiness->business_description)), 0, 200); ?>...</p>
                                <ul>
                                  <li><img src="{{ asset('assets/images/phone_icon.png') }}" alt="">
                                       <span class="spntoggle" 
                                          data-toggle="popover" 
                                          data-html="true" 
                                          data-placement="bottom" 
                                          data-content="
                                            1. <a href='tel:{{ $topBusiness->main_phone }}'>{{ $topBusiness->main_phone }}</a>
                                            @if($topBusiness->secondary_phone)
                                                <br>2. <a style='font-size: 14px !important; font-weight: bold !important; color: #007bff !important;' href='tel:{{ $topBusiness->secondary_phone }}'>{{ $topBusiness->secondary_phone }}</a>
                                            @endif">
                                        Telephone
                                    </span>
                                </li>
                                <li>
                                    <img src="{{ asset('assets/images/email_icon.png') }}" alt="Email Icon">
                                    <span  class="spntoggle" data-placement="bottom" data-html="true" data-toggle="popover" 
                                          data-content="<a href='mailto:{{ $topBusiness->email_address }}'>{{ $topBusiness->email_address }}</a>">Email</span>
                                </li>
                                @if($topBusiness->website_url!="")
                                    <li>
                                        <img src="{{ asset('assets/images/globe_iconblk.png') }}" alt="Globe Icon"> 
                                        <span  class="spntoggle" data-placement="bottom" data-html="true" data-toggle="popover" 
                                              data-content="<a target='_blank' href='https://{{ $topBusiness->website_url }}'>{{ $topBusiness->website_url }}</a>">Website</span>
                                    </li>
                                @endif
                                </ul>
                              </div>
                              <div class="rating_txt"><img src="{{ asset('assets/images/'.round($topBusiness->average_rating).'rate.png') }}" alt="">({{$topBusiness->rating_count}}) Member Rating </div>
                            </div>
                          </div>
                    </div>
                @endforeach
            @endif
            
            <!--<ul class="pagination">-->
            <!--  <li>-->
            <!--    <a href="#"><img src="images/pagi_leftarrow.png" alt="" /></a>-->
            <!--  </li>-->
            <!--  <li><a href="#" class="active">01</a></li>-->
            <!--  <li><a href="#">02</a></li>-->
            <!--  <li><a href="#">03</a></li>-->
            <!--  <li><a href="#">04</a></li>-->
            <!--  <li>-->
            <!--    <a href="#"><img src="images/pagi_rightarrow.png" alt="" /></a>-->
            <!--  </li>-->
            <!--</ul>-->
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
<!-- body start end-->
<link
  rel="stylesheet"
  href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css"
/>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

<script>
  $(document).ready(function () {
    // Initialize popovers for elements with the 'spntoggle' class
    $('[data-toggle="popover"]').popover();

    // Hide popover if clicking outside the popover or toggle
    $(document).on("click", function (e) {
      if (!$(e.target).closest(".spntoggle, .popover").length) {
        $('[data-toggle="popover"]').popover("hide");
      }
    });

    // Prevent the popover from hiding when clicking inside it or the toggle button
    $(".spntoggle, .popover").on("click", function (e) {
      e.stopPropagation();
    });
  });
</script>
@include('includes/footer')
