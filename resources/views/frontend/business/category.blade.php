@include('includes/inner-header')

<div class="top_search nomob_search">
   <div class="container">
      <div class="logo">
         <h1><a href="index.html"><img src="{{ asset('assets/images/logo-inner.png') }}') }}" alt="" /></a></h1>
      </div>
   </div>
   <div class="container">
      <div class="home_midbody">
         <div class="home_searchsec">
            <form action="" method="post">
               <input name="" type="text" placeholder="Services Im looking for" />
               <input name="" type="text" placeholder="Enter your location" class="location" />
               <input name="" type="submit" value="Search" />
            </form>
         </div>
      </div>
   </div>
</div>
<!-- Header start end-->
<!-- body start-->
<div class="mid_body">
   <div class="container">
      <div class="full_midpan">
         <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-12">
               <div class="lft_businesscat">
               <form action="" method="post">
                     <input name="" type="text" placeholder="Quick Business Search">
                     <input name="" type="submit" value=""> </form>
                   <h3 class="mobaccobtn">Catchakiwi by Category...</h3>
                  <ul class="mobaccont">
                     <li><img src="{{ asset('assets/images/b1.png') }}" alt=""><a href="{{ URL::to('business/category') }}">Accommodation <span>(24)</span></a>
                        <ul>
                           <li><a href="#">Backpackers</a></li>
                           <li><a href="#">Holiday Apartments</a></li>
                           <li><a href="#">Accommodation Booking</a></li>
                           <li><a href="#">Bed & Breakfast</a></li>
                           <li><a href="#">Farmstays & Homestays</a></li>
                           <li><a href="#">View More</a></li>
                        </ul>
                     </li>
                     <li><img src="{{ asset('assets/images/b2.png') }}" alt=""><a href="#">Animals and Pets <span> (10)</span></a></li>
                     <li><img src="{{ asset('assets/images/b3.png') }}" alt=""><a href="#">Automotive <span> (72)</span></a></li>
                     <li><img src="{{ asset('assets/images/b4.png') }}" alt=""><a href="#">Boats & Marine <span> (3)</span></a></li>
                     <li><img src="{{ asset('assets/images/b5.png') }}" alt=""><a href="#">Catcha... <span> (2)</span></a></li>
                     <li><img src="{{ asset('assets/images/b6.png') }}" alt=""><a href="#">Catchakiwi HubZones <span>(4)</span></a></li>
                     <li><img src="{{ asset('assets/images/b7.png') }}" alt=""><a href="#">Community <span> (6)</span></a></li>
                     <li><img src="{{ asset('assets/images/b8.png') }}" alt=""><a href="#">Computers & Electronics <span> (63)</span></a></li>
                     <li><img src="{{ asset('assets/images/b9.png') }}" alt=""><a href="#">Construction & Contractors <span> (66)</span></a></li>
                     <li><img src="{{ asset('assets/images/b10.png') }}" alt=""><a href="#">Dining and Catering <span> (13)</span></a></li>
                     <li><img src="{{ asset('assets/images/b11.png') }}" alt=""><a href="#">Education <span> (41)</span></a></li>
                     <li><img src="{{ asset('assets/images/b12.png') }}" alt=""><a href="#">Entertainment <span> (25)</span></a></li>
                     <li><img src="{{ asset('assets/images/b13.png') }}" alt=""><a href="#">Events <span> (6)</span></a></li>
                     <li><img src="{{ asset('assets/images/b14.png') }}" alt=""><a href="#">Farming <span> (5)</span></a></li>
                     <li><img src="{{ asset('assets/images/b15.png') }}" alt=""><a href="#">Food <span> (24)</span></a></li>
                     <li><img src="{{ asset('assets/images/b16.png') }}" alt=""><a href="#">Health & Medicine <span> (113)</span></a></li>
                     <li><img src="{{ asset('assets/images/b17.png') }}" alt=""><a href="#">Home & Garden <span> (182)</span></a></li>
                     <li><img src="{{ asset('assets/images/b18.png') }}" alt=""><a href="#">Legal & Financial <span> (45)</span></a></li>
                     <li><img src="{{ asset('assets/images/b19.png') }}" alt=""><a href="#">Manufacturing & Wholesale <span> (27)</span></a></li>
                     <li><img src="{{ asset('assets/images/b20.png') }}" alt=""><a href="#">Markets <span> (51)</span></a></li>
                     <li><img src="{{ asset('assets/images/b21.png') }}" alt=""><a href="#">Merchants <span> (18)</span></a></li>
                     <li><img src="{{ asset('assets/images/b22.png') }}" alt=""><a href="#">Money & Finance <span> (18)</span></a></li>
                     <li><img src="{{ asset('assets/images/b23.png') }}" alt=""><a href="#">Personal Care <span> (39)</span></a></li>
                     <li><img src="{{ asset('assets/images/b24.png') }}" alt=""><a href="#">Re-enactment <span> (1)</span></a></li>
                     <li><img src="{{ asset('assets/images/b25.png') }}" alt=""><a href="#">Real Estate <span> (30)</span></a></li>
                     <li><img src="{{ asset('assets/images/b26.png') }}" alt=""><a href="#">Shopping <span> (62)</span></a></li>
                     <li><img src="{{ asset('assets/images/b27.png') }}" alt=""><a href="#">Tourism <span> (21) </span></a></li>
                     <li><img src="{{ asset('assets/images/b28.png') }}" alt=""><a href="#">Trade & Services <span> (104)</span></a></li>
                     <li><img src="{{ asset('assets/images/b29.png') }}" alt=""><a href="#">Travel & Transportation <span> (29)</span></a></li>
                     <li><img src="{{ asset('assets/images/b30.png') }}" alt=""><a href="#">Wedding Arrangements  <span> (15)</span></a></li>
                  </ul>
               </div>
            </div>
            <div class="col-lg-8 col-md-8 col-sm-12">
               <div class="right_business">
                  <div class="bus_catlist">
                     <h3>Accommodation</h3>
                     <ul>
                        <li><a href="{{ URL::to('business/details') }}">Accommodation Booking (4)</a></li>
                        <li><a href="{{ URL::to('business/details') }}">Backpackers (0)</a></li>
                        <li><a href="{{ URL::to('business/details') }}">Bed & Breakfast (2)</a></li>
                        <li><a href="{{ URL::to('business/details') }}">Farmstays & Homestays (1)</a></li>
                        <li><a href="{{ URL::to('business/details') }}">Guest Houses (0)</a></li>
                     </ul>
                     <ul>
                        <li><a href="{{ URL::to('business/details') }}">Holiday Accommodation (1)</a></li>
                        <li><a href="{{ URL::to('business/details') }}">Holiday Apartments (0)</a></li>
                        <li><a href="{{ URL::to('business/details') }}">Holiday Parks & Camping Grounds (3)</a></li>
                        <li><a href="{{ URL::to('business/details') }}">Hostels (0)</a></li>
                        <li><a href="{{ URL::to('business/details') }}">Hotels (5)</a></li>
                     </ul>
                     <ul>
                        <li><a href="{{ URL::to('business/details') }}">Hotels & Taverns (1)</a></li>
                        <li><a href="{{ URL::to('business/details') }}">Luxury Lodge (2)</a></li>
                        <li><a href="{{ URL::to('business/details') }}">Motels & Lodges (5)</a></li>
                     </ul>
                  </div>
                  <div class="top_ratedbusiness">
                     <div class="search_restspan">
                        <a href="#">
                           <div class="row">
                              <div class="col-lg-4 col-md-4 col-sm-12 search_lftthum"> <span class="homebaed_sticker">Homebased</span> <img src="{{ asset('assets/images/result_leftpic1.png') }}" alt=""> </div>
                              <div class="col-lg-8 col-md-8 col-sm-12 results_rightdtls">
                                 <h4>P&B Auto Electrical Ltd</h4>
                                 <div class="location_txt"><img src="{{ asset('assets/images/location_icon.png') }}" alt="">20 Woodward St, Frankton, Hamilton 3204, New Zealand</div>
                                 <div class="mobweb_txt">
                                    <ul>
                                       <li><img src="{{ asset('assets/images/phone_icon.png') }}" alt=""> Telephone</li>
                                       <li><img src="{{ asset('assets/images/location_icon.png') }}" alt=""> Map / Location</li>
                                       <li><img src="{{ asset('assets/images/website_icon.png') }}" alt=""> Website</li>
                                    </ul>
                                 </div>
                                 <div class="rating_txt"><img src="{{ asset('assets/images/star_rating.png') }}" alt="">(6) Member Rating </div>
                                 <p>Newmarket Auto Repairs offers excellent car repairs and servicing, with the convenience of a central Auckland location. We are experts in servicing European and Japanese cars, including BMW, Audi and</p>
                              </div>
                           </div>
                        </a>
                     </div>
                     <div class="search_restspan">
                        <a href="#">
                           <div class="row">
                              <div class="col-lg-4 col-md-4 col-sm-12 search_lftthum"> <img src="{{ asset('assets/images/result_leftpic2.png') }}" alt=""> </div>
                              <div class="col-lg-8 col-md-8 col-sm-12 results_rightdtls">
                                 <h4>Nemarket Auto Repairs</h4>
                                 <div class="location_txt"><img src="{{ asset('assets/images/location_icon.png') }}" alt="">20 Woodward St, Frankton, Hamilton 3204, New Zealand</div>
                                 <div class="mobweb_txt">
                                    <ul>
                                       <li><img src="{{ asset('assets/images/phone_icon.png') }}" alt=""> Telephone</li>
                                       <li><img src="{{ asset('assets/images/location_icon.png') }}" alt=""> Map / Location</li>
                                       <li><img src="{{ asset('assets/images/website_icon.png') }}" alt=""> Website</li>
                                    </ul>
                                 </div>
                                 <div class="rating_txt"><img src="{{ asset('assets/images/star_rating.png') }}" alt="">(6) Member Rating </div>
                                 <p>Newmarket Auto Repairs offers excellent car repairs and servicing, with the convenience of a central Auckland location. We are experts in servicing European and Japanese cars, including BMW, Audi and</p>
                              </div>
                           </div>
                        </a>
                     </div>
                     <div class="search_restspan">
                        <a href="#">
                           <div class="row">
                              <div class="col-lg-4 col-md-4 col-sm-12 search_lftthum"> <img src="{{ asset('assets/images/result_leftpic3.png') }}" alt=""> </div>
                              <div class="col-lg-8 col-md-8 col-sm-12 results_rightdtls">
                                 <h4>HCS New Zealand Ltd T/A PC Heroes</h4>
                                 <div class="location_txt"><img src="{{ asset('assets/images/location_icon.png') }}" alt="">20 Woodward St, Frankton, Hamilton 3204, New Zealand</div>
                                 <div class="mobweb_txt">
                                    <ul>
                                       <li><img src="{{ asset('assets/images/phone_icon.png') }}" alt=""> Telephone</li>
                                       <li><img src="{{ asset('assets/images/location_icon.png') }}" alt=""> Map / Location</li>
                                       <li><img src="{{ asset('assets/images/website_icon.png') }}" alt=""> Website</li>
                                    </ul>
                                 </div>
                                 <div class="rating_txt"><img src="{{ asset('assets/images/star_rating.png') }}" alt="">(6) Member Rating </div>
                                 <p>Newmarket Auto Repairs offers excellent car repairs and servicing, with the convenience of a central Auckland location. We are experts in servicing European and Japanese cars, including BMW, Audi and</p>
                              </div>
                           </div>
                        </a>
                     </div>
                     <div class="search_restspan">
                        <a href="#">
                           <div class="row">
                              <div class="col-lg-4 col-md-4 col-sm-12 search_lftthum"> <img src="{{ asset('assets/images/result_leftpic4.png') }}" alt=""> </div>
                              <div class="col-lg-8 col-md-8 col-sm-12 results_rightdtls">
                                 <h4>R J Macartney Holdings Ltd T/A Fulton Automotive</h4>
                                 <div class="location_txt"><img src="{{ asset('assets/images/location_icon.png') }}" alt="">20 Woodward St, Frankton, Hamilton 3204, New Zealand</div>
                                 <div class="mobweb_txt">
                                    <ul>
                                       <li><img src="{{ asset('assets/images/phone_icon.png') }}" alt=""> Telephone</li>
                                       <li><img src="{{ asset('assets/images/location_icon.png') }}" alt=""> Map / Location</li>
                                       <li><img src="{{ asset('assets/images/website_icon.png') }}" alt=""> Website</li>
                                    </ul>
                                 </div>
                                 <div class="rating_txt"><img src="{{ asset('assets/images/star_rating.png') }}" alt="">(6) Member Rating </div>
                                 <p>Newmarket Auto Repairs offers excellent car repairs and servicing, with the convenience of a central Auckland location. We are experts in servicing European and Japanese cars, including BMW, Audi and</p>
                              </div>
                           </div>
                        </a>
                     </div>
                  </div>
                  <ul class="pagination">
                     <li>
                        <a href="#"><img src="{{ asset('assets/images/pagi_leftarrow.png') }}" alt=""></a>
                     </li>
                     <li><a href="#" class="active">01</a></li>
                     <li><a href="#">02</a></li>
                     <li><a href="#">03</a></li>
                     <li><a href="#">04</a></li>
                     <li>
                        <a href="#"><img src="{{ asset('assets/images/pagi_rightarrow.png') }}" alt=""></a>
                     </li>
                  </ul>
               </div>
            </div>
         </div>
         <div class="bottom_advsec"> <img src="{{ asset('assets/images/ads_pic1.png') }}" alt=""> <img src="{{ asset('assets/images/ads_pic2.png') }}" alt=""> <img src="{{ asset('assets/images/ads_pic3.png') }}" alt=""> <img src="{{ asset('assets/images/ads_google2.png') }}" alt="" class="gadd_bottom"> </div>
      </div>
   </div>
</div>
<!-- body start end-->
<script>
document.addEventListener("DOMContentLoaded", function () {

    // MOBILE ONLY
    if (window.innerWidth > 767) return;

    document.querySelectorAll(".mobaccont > li").forEach(function (li) {

        let submenu = li.querySelector("ul");

        // Check parent category count
        let countSpan = li.querySelector("a span");
        let hasCount = countSpan ? parseInt(countSpan.textContent.replace(/\D/g, "")) : 0;

        let a = li.querySelector("a");

        // Disable parent link when business count = 0
        if (a && hasCount === 0) {

            a.addEventListener("click", function (e) {
                e.preventDefault();
                e.stopImmediatePropagation();
            });

            a.addEventListener("pointerdown", function (e) {
                e.preventDefault();
                e.stopImmediatePropagation();
            });

            a.setAttribute("tabindex", "-1");
            a.classList.add("disabled-link");

            // Do NOT create arrow if count = 0
            return;
        }

        // If no submenu → stop
        if (!submenu) {
            return;
        }

        // Create arrow icon
        let icon = document.createElement("span");
        icon.classList.add("toggle-icon");

        // Prevent <a> default click on mobile
        if (a) {
            a.addEventListener("click", function (e) {
                e.preventDefault();
                e.stopImmediatePropagation();
            });
        }

        // Toggle accordion on icon click
        icon.addEventListener("pointerdown", function (e) {
            e.preventDefault();
            e.stopImmediatePropagation();

            // Close all others
            document.querySelectorAll(".mobaccont li.open").forEach(function (other) {
                if (other !== li) {
                    other.classList.remove("open");
                    let ul = other.querySelector("ul");
                    if (ul) ul.style.display = "none";
                }
            });

            // Toggle current
            if (li.classList.contains("open")) {
                li.classList.remove("open");
                submenu.style.display = "none";
            } else {
                li.classList.add("open");
                submenu.style.display = "block";
            }
        });

        li.appendChild(icon);


        /* ---------------------------------------------------
           NEW PART: Disable SUBCATEGORY links where count = 0
        -----------------------------------------------------*/

        submenu.querySelectorAll("li").forEach(function (subLi) {

            let subSpan = subLi.querySelector("a span");
            let subA = subLi.querySelector("a");

            if (!subSpan || !subA) return;

            let subCount = parseInt(subSpan.textContent.replace(/\D/g, "")) || 0;

            if (subCount === 0) {

                subA.addEventListener("click", function (e) {
                    e.preventDefault();
                    e.stopImmediatePropagation();
                });

                subA.addEventListener("pointerdown", function (e) {
                    e.preventDefault();
                    e.stopImmediatePropagation();
                });

                subA.setAttribute("tabindex", "-1");
                subA.classList.add("disabled-link");
            }
        });

    });
});
</script>

<script>
function toggleMobileAccordion(btn) {
    if (window.innerWidth <= 767) {  // Mobile check
        btn.classList.toggle('active');                 // Toggle button
        btn.nextElementSibling.classList.toggle('active'); // Toggle content
    }
}

document.querySelectorAll('.mobaccobtn').forEach(btn => {
    btn.addEventListener('click', function () {
        toggleMobileAccordion(this);
    });
});
</script>   
@include('includes/footer')