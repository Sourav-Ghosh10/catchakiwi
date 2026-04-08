@include('includes/inner-header')

<div class="top_search nomob_search">
   <div class="container">
      <div class="logo">
         <h1>
             </h1>
      </div>
   </div>
   <div class="container">
      <div class="home_midbody">
         <div class="home_searchsec">
            <form action="{{ route('search', ['country' => $country_name]) }}" method="get">
                   
                   <div class="searchpan">
                       <div class="serchservice">
                           <select name="service" id="serviceselect" placeholder="Type Your Service">
                       <option></option>
                       @if(!empty($category))
                            @foreach($category as $cat)
                                @if(!empty($cat->subcat))
                                    @foreach($cat->subcat as $subcat)
                                        <option value="{{ $subcat->title_url }},{{ $cat->title_url }}">{{ $cat->title }}, {{ $subcat->title }}</option>
                                    @endforeach
                                @endif
                            @endforeach
                       @endif
                   </select>
                   <div class="selectize-continue" id="service-continue"><i class="fa fa-chevron-right"></i></div>
                       </div>
                       <div class="serchlocation">
                            
                   <select name="location" id="locationselect" placeholder="Type Your Location">
                       <option></option>
                       @if(!empty($states))
                           @foreach($states as $state)
                                <option value="{{ $state['name'] }}">{{ $state['name'] }}</option>
                                @foreach($state['cities'] as $cities)
                                    <option value="{{ $cities['name'].",".$state['name'] }}">{{ $cities['name'].",".$state['name'] }}</option>
                                    @if(session('CountryCode')=="NZ")
                                        @foreach($cities['towns'] as $town)
                                            <option value="{{ $town['suburb_name'].",".$cities['name'].",".$state['name'] }}">{{ $town['suburb_name'].",".$cities['name'].",".$state['name'] }}</option>
                                        @endforeach
                                    @endif
                                @endforeach
                            @endforeach
                       @endif
                   </select>
                   <div class="selectize-continue" id="location-continue"><i class="fa fa-chevron-right"></i></div>
                       </div>
                     <input name="" type="submit" value="Search" />
                   </div>
                  
                  <!--<input name="" type="text" placeholder="Services I’m looking for" />-->
                  <!--<input name="" type="text" placeholder="Enter your location" class="location" />-->
                  <!--<input name="" type="submit" value="Search" />-->
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
                  <form action="{{ route('search', ['country' => $country_name]) }}" method="get">
                     <input name="search" type="text" placeholder="Quick Business Search" required>
                     <input name="" type="submit" value="">
                  </form>
                  <h3 class="mobaccobtn">Catchakiwi by Category...</h3>
                  <ul class="mobaccont">
                    @if(!empty($categories))
                        @foreach($categories as $cat)
                             <li>
                                <img src="{{ asset('assets/images/'.$cat['icon']) }}" alt=""><a href="{{ URL::to($country_name.'/business/'.$cat->title_url) }}">{{ $cat['title'] }} <span>({{ $cat['parent_businesses_count'] }})</span></a>
                                @if(!empty($cat['subcategories']))
                                    <ul>
                                        @foreach($cat['subcategories'] as $subcategories)
                                           <li><a href="{{ URL::to($country_name.'/business/'.$cat->title_url."/".$subcategories->title_url) }}">{{ $subcategories['title'] }}<span> ({{ $subcategories['businesses_count'] }})</span></a></li>
                                       @endforeach
                                    </ul>
                                @endif
                            </li>
                        @endforeach
                    @endif
                  </ul>
               </div>
            </div>
            <div class="col-lg-8 col-md-8 col-sm-12">
                @if(!empty($latestBusiness))
               <div class="right_business">
                  <div class="latest_business">
                     <h2><img src="{{ asset('assets/images/latest_busicon.png') }}" alt=""> Latest Business Joined</h2>
                     <div class="latest_businesslist">
                            @foreach($latestBusiness as $ltstbusiness)
                                <div class="latest_buspan">
                                   
                                   <a href="{{ URL::to($country_name.'/business/'.$ltstbusiness->title_url."/".$ltstbusiness->sec_title_url."/".$ltstbusiness->slug) }}"> 
                                     <div class="homebuswrap">
                                         @if($ltstbusiness->homebased_business =="yes") 
                                        <span class="homebaed_sticker">Homebased</span>
                                    @endif
                                            @if(!empty($ltstbusiness->select_image) && file_exists(base_path($ltstbusiness->select_image))  && filesize(base_path($ltstbusiness->select_image)) > 0)
                                           		<img src="{{ asset($ltstbusiness->select_image) }}" alt="">
                                           @else
                                           		<!--<img src="{{ asset('public/assets/business/default_company.jpg') }}" alt="">-->
                                     			<img src="https://ui-avatars.com/api/?name={{ urlencode(preg_replace('/[^A-Za-z0-9 ]/', '', $ltstbusiness->display_name)) }}&color=7F9CF5&background=EBF4FF" alt="">
                                           @endif
                                     </div>   
                                 
                                      <div class="latest_busirgttext">
                                         <h3>{{ $ltstbusiness->display_name }}</h3>
                                         <p>{{ $ltstbusiness->title }} > {{ $ltstbusiness->sec_title }}</p>
                                        <p>{{ \Illuminate\Support\Str::limit(strip_tags($ltstbusiness->business_description), 40) }}</p>                                     
                                      </div>
                                   </a>
                                   <br class="clr"/>
                                </div>
                            @endforeach
                        
                     </div>
                  </div>
                @endif
                  <div class="top_ratedbusiness">
                     <h2>
                        @if(!empty($searchQuery))
                            Search Results For <span>"{{ $searchQuery }}" ({{ $topratedBusiness->count() }} hits)</span>
                        @else
                            <img src="{{ asset('assets/images/top_ratedicon.png') }}" alt=""> Top Rated Business
                        @endif
                     </h2>
                     @if(!empty($topratedBusiness))
                        @foreach($topratedBusiness as $topBusiness)
                            <div class="search_restspan">
                                <!--<a href="{{ URL::to($country_name.'/business/'.$topBusiness->slug) }}">-->
                                   <div class="row">
                                      <div class="col-lg-4 col-md-4 col-sm-12 search_lftthum">
                                         <a href="{{ URL::to($country_name.'/business/'.$topBusiness->title_url."/".$topBusiness->sec_title_url."/".$topBusiness->slug) }}">
                                            @if(!empty($topBusiness->homebased_business) && strtolower(trim($topBusiness->homebased_business)) === 'yes')
                                                <span class="homebaed_sticker" style="width:82%;">Homebased</span>
                                            @endif
                                        
                                           @if(!empty($topBusiness->select_image) && file_exists(base_path($topBusiness->select_image))  && filesize(base_path($topBusiness->select_image)) > 0)
                                           		<img src="{{ asset($topBusiness->select_image) }}" alt="">
                                           @else
                                           		<!--<img src="{{ asset('public/assets/business/default_company.jpg') }}" alt="">-->
												<img src="https://ui-avatars.com/api/?name={{ urlencode(preg_replace('/[^A-Za-z0-9 ]/', '', $topBusiness->display_name)) }}&color=7F9CF5&background=EBF4FF" alt="">
                                           @endif
                                         </a>
                                      </div>
                                      <div class="col-lg-8 col-md-8 col-sm-12 results_rightdtls">
                                        <h4>
 <a href="{{ URL::to($country_name.'/business/'.$topBusiness->title_url.'/'.$topBusiness->sec_title_url.'/'.$topBusiness->slug) }}"> {{ $topBusiness->display_name }} </a>
</h4>
<p><?= substr(trim(preg_replace('/<[^>]+>/', ' ',$topBusiness->business_description)), 0, 100); ?>...</p>


                                        <!--<div class="location_txt"><a href="{{ URL::to($country_name.'/business/'.$topBusiness->title_url."/".$topBusiness->sec_title_url."/".$topBusiness->slug) }}"><img src="{{ asset('assets/images/location_icon.png') }}" alt=""><?= (($topBusiness->display_address == "yes")?$topBusiness->address.", ":"") . $topBusiness->region ?></a></div>-->
                                        {!! $topBusiness->display_address === "yes"
                                        ? '<div class="location_txt">
                                            <a href="'.URL::to($country_name.'/business/'.$topBusiness->title_url.'/'.$topBusiness->sec_title_url.'/'.$topBusiness->slug).'">
                                                <img src="'.asset('assets/images/location_icon.png').'" alt="">
                                                '.$topBusiness->address.', '.$topBusiness->region.'
                                            </a>
                                           </div>'
                                        : '' !!}
                                         <div class="mobweb_txt"> 
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
                                                <span  class="spntoggle msgtap" data-userid='{{ $topBusiness->user_id }}' data-username='{{ $topBusiness->name }}'> Message</span>
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
                                <!--</a>-->
                             </div>
                        @endforeach
                     @endif
                  </div>
               </div>
            </div>
         </div>
         <div class="bottom_advsec">
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
@include('includes/footer')
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js"></script>


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

        // If no submenu  stop
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
              $('#serviceselect').selectize({
        placeholder: 'Type Your Service',
        create: true,
        createOnBlur: true,
        persist: true,
        render: {
            option: function(data, escape) {
                return '<div class="option">' + escape(data.text) + '</div>';
            },
            no_results: function() {
                return '<div class="selectize-no-results">No results found</div>';
            }
        },
        onFocus: function() {
            var value = this.getValue();
            if (value) {
                var text = this.options[value] ? this.options[value].text : value;
                this.clear(true);
                this.setTextboxValue(text);
            }
            this.open();
        },
        onDropdownOpen: function($dropdown) {
            $('#service-continue').show();
            var self = this;
            setTimeout(function() {
                if (!self.hasOptions) {
                    $dropdown.append('<div class="selectize-no-results">No results found</div>');
                }
            }, 1);
        },
        onDropdownClose: function() {
            $('#service-continue').hide();
        },
        onType: function(str) {
            var self = this;
            setTimeout(function() {
                var $dropdownContent = self.$dropdown_content;
                if (!$dropdownContent.children().length) {
                    $dropdownContent.html('<div class="selectize-no-results">No results found</div>');
                }
            }, 1);
        }
    });
        // $('#locationselect').selectize({
        //     create: false,
        //     sortField: 'text',
        //     render: {
        //         no_results: function(data, escape) {
        //             return '<div class="no-results">No results found</div>';
        //         }
        //     }
        // });
        $('#locationselect').selectize({
            placeholder: 'Type Your Location',
            create: true,
            createOnBlur: true,
            persist: true,
            render: {
                option: function(data, escape) {
                    return '<div class="option">' + escape(data.text) + '</div>';
                },
                no_results: function() {
                    return '<div class="selectize-no-results">No results found</div>';
                }
            },
            onFocus: function() {
                var value = this.getValue();
                if (value) {
                    var text = this.options[value] ? this.options[value].text : value;
                    this.clear(true);
                    this.setTextboxValue(text);
                }
                this.open();
            },
            onDropdownOpen: function($dropdown) {
                $('#location-continue').show();
                var self = this;
                setTimeout(function() {
                    if (!self.hasOptions) {
                        $dropdown.append('<div class="selectize-no-results">No results found</div>');
                    }
                }, 1);
            },
            onDropdownClose: function() {
                $('#location-continue').hide();
            },
            onType: function(str) {
                var self = this;
                setTimeout(function() {
                    var $dropdownContent = self.$dropdown_content;
                    if (!$dropdownContent.children().length) {
                        $dropdownContent.html('<div class="selectize-no-results">No results found</div>');
                    }
                }, 1);
            }
        });

        $('#service-continue').click(function() {
            $('#serviceselect')[0].selectize.close();
        });
        $('#location-continue').click(function() {
            $('#locationselect')[0].selectize.close();
        });

        // Ensure typed text is submitted if no option is selected
        $('.home_searchsec form').on('submit', function() {
            var serviceSelectize = $('#serviceselect')[0].selectize;
            var locationSelectize = $('#locationselect')[0].selectize;

            if (!serviceSelectize.getValue() && serviceSelectize.lastQuery) {
                serviceSelectize.addOption({value: serviceSelectize.lastQuery, text: serviceSelectize.lastQuery});
                serviceSelectize.setValue(serviceSelectize.lastQuery);
            }
            if (!locationSelectize.getValue() && locationSelectize.lastQuery) {
                locationSelectize.addOption({value: locationSelectize.lastQuery, text: locationSelectize.lastQuery});
                locationSelectize.setValue(locationSelectize.lastQuery);
            }
        });
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
            // LOGGED IN → open popup
            $("#msguserid").val($(this).data('userid'));
            $('#quickMsgText').val('');
      		$('.usernm').text($(this).data('username'));
            $(".msgpopinvisual").fadeIn(200);
        @else
            // NOT LOGGED IN  go to login + remember this page
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