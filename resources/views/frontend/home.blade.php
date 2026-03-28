@include('includes/header')
    <div class="popup_outer" style="display: none">
      <div class="popup_inner bg-white position-relative">
        <button type="button" class="popup_close">
          <i class="fa fa-close"></i>
        </button>
        <div class="d-flex align-items-start h-100 justify-content-start popup">
          <div class="h-100 p-2 sidebar_cover d-flex flex-column align-items-start">
            <div class="sidebar w-100">
              <div class="logo_cover d-flex align-items-center justify-content-center pb-1">
                <img src="{{ asset('assets/images/logo.png') }}" class="w-100" alt="logo" />
              </div>
            </div>
            <div class="sidebar_navigation w-100 flex-1 h-100">
              <ul class="ps-0 mb-0 h-100 flex-1">
                <li><a href="#" data-section="happening" class="active">What's happening</a></li>
                <li><a href="#" data-section="info">Info</a></li>
                <li><a href="#" data-section="features">New Features</a></li>
                <li><a href="#" data-section="faq">FAQ</a></li>
                <li><a href="#" data-section="contact">Contact</a></li>
                <li><a href="#" data-section="sponsors">Sponsors</a></li>
              </ul>
            </div>
            <button type="button" class="popup_close">
              <i class="fa fa-close"></i>
            </button>
          </div>
          <div class="sections pe-2 h-100">
            <div class="section w-100 active" id="happening">
              <h3 class="text-bold mb-3" style="font-size: 30px; line-height: 35px;">The new Catchakiwi is coming</h3>
                <p>It's a pleasure to have you here at Catchakiwi. We are currently having a makeover to better suit you. We're updating to a modernised and user-friendly interface to bring a more enjoyable browsing experience. Our team is working hard to get Catchakiwi feature-rich and looking great.</p>
                <p>Leave us your email address using the form below to keep informed on the progress of the website and get the chance to become one of the first users of the new site.</p>
                <p><a href="https://www.facebook.com/catchakiwinz" target="_blank" class="text-bold text-secondary">Like us on Facebook</a> and <a href="https://twitter.com/catchakiwi" target="_blank" class="text-bold text-secondary">follow us on Twitter </a> to get exclusive information on the project!</p>
                <hr />
                <p class="mt-3">Get updates and get the chance to become one of the first to try the new Catchakiwi</p>
                <!-- First Form -->
                <form action="notification.php" method="post" id="firstForm">
                    <div class="form-row d-flex flex-wrap flex-column flex-md-row">
                        <div class="form-group col-md-4 px-1 mt-2">
                            <input type="text" class="form-control" name="popup_name" placeholder="Name" required>
                        </div>
                        <div class="form-group col-md-4 px-1 mt-2">
                            <input type="email" class="form-control" name="popup_email" placeholder="Email" required>
                        </div>
                        <div class="form-group col-md-4 px-1 mt-2">
                            <input type="submit" id="notify" class="w-100 w-sm-auto  popup_notify_submit" value="Notify me" />
                        </div>
                    </div>
                    <div id="form-messages"></div> <!-- To display success or error messages -->
                </form>
                <!-- Your Loading Spinner -->
                <div id="loader">
                    <img src="{{ asset('assets/images/ZZ5H.gif') }}" width="100" alt="Loading...">
                </div>
                <div class="mt-3 row align-items-start flex-row flex-wrap">
                  <div class="col-12 col-sm-6 mt-3 text-center">
                    <div class="d-flex align-items-center justify-content-center position-relative happening_image_section">
                      <img src="{{ asset('assets/images/popup-image-1.png') }}" style="object-fit: contain; max-width: 300px; aspect-ratio: 3/2; width: 100%;" alt="image" />
                      <div class="image_popup">
                        <button type="button" class="image_popup_close">
                          <i class="fa fa-close"></i>
                        </button>
                        <img src="{{ asset('assets/images/popup-image-1.png') }}" style="object-fit: contain; max-width: 300px; aspect-ratio: 3/2; width: 100%;" alt="image" />
                      </div>
                    </div>
                  </div>
                  <div class="col-12 col-sm-6 mt-3 text-center">
                    <div class="d-flex align-items-center justify-content-center position-relative happening_image_section">
                      <img src="{{ asset('assets/images/popup-image-2.png') }}" style="object-fit: contain; max-width: 300px; aspect-ratio: 3/2; width: 100%;" alt="image" />
                      <div class="image_popup">
                        <button type="button" class="image_popup_close">
                          <i class="fa fa-close"></i>
                        </button>
                        <img src="{{ asset('assets/images/popup-image-2.png') }}" style="object-fit: contain; max-width: 300px; aspect-ratio: 3/2; width: 100%;" alt="image" />
                      </div>
                    </div>
                  </div>
                  <div class="col-12 col-sm-6 mt-3 text-center">
                    <div class="d-flex align-items-center justify-content-center position-relative happening_image_section">
                      <img src="{{ asset('assets/images/popup-image-1.png') }}" style="object-fit: contain; max-width: 300px; aspect-ratio: 3/2; width: 100%;" alt="image" />
                      <div class="image_popup">
                        <button type="button" class="image_popup_close">
                          <i class="fa fa-close"></i>
                        </button>
                        <img src="{{ asset('assets/images/popup-image-1.png')  }}" style="object-fit: contain; max-width: 300px; aspect-ratio: 3/2; width: 100%;" alt="image" />
                      </div>
                    </div>
                  </div>
                  <div class="col-12 col-sm-6 mt-3 text-center">
                    <div class="d-flex align-items-center justify-content-center position-relative happening_image_section">
                      <img src="{{ asset('assets/images/popup-image-2.png') }}" style="object-fit: contain; max-width: 300px; aspect-ratio: 3/2; width: 100%;" alt="image" />
                      <div class="image_popup">
                        <button type="button" class="image_popup_close">
                          <i class="fa fa-close"></i>
                        </button>
                        <img src="{{ asset('assets/images/popup-image-2.png') }}" style="object-fit: contain; max-width: 300px; aspect-ratio: 3/2; width: 100%;" alt="image" />
                      </div>
                    </div>
                  </div>
                  <div class="col-12 col-sm-6 mt-3 text-center">
                    <div class="d-flex align-items-center justify-content-center position-relative happening_image_section">
                      <img src="{{ asset('assets/images/popup-image-1.png') }}" style="object-fit: contain; max-width: 300px; aspect-ratio: 3/2; width: 100%;" alt="image" />
                      <div class="image_popup">
                        <button type="button" class="image_popup_close">
                          <i class="fa fa-close"></i>
                        </button>
                        <img src="{{ asset('assets/images/popup-image-1.png') }}" style="object-fit: contain; max-width: 300px; aspect-ratio: 3/2; width: 100%;" alt="image" />
                      </div>
                    </div>
                  </div>
                  <div class="col-12 col-sm-6 mt-3 text-center">
                    <div class="d-flex align-items-center justify-content-center position-relative happening_image_section">
                      <img src="{{ asset('assets/images/popup-image-2.png')  }}" style="object-fit: contain; max-width: 300px; aspect-ratio: 3/2; width: 100%;" alt="image" />
                      <div class="image_popup">
                        <button type="button" class="image_popup_close">
                          <i class="fa fa-close"></i>
                        </button>
                        <img src="{{ asset('assets/images/popup-image-2.png') }}" style="object-fit: contain; max-width: 300px; aspect-ratio: 3/2; width: 100%;" alt="image" />
                      </div>
                    </div>
                  </div>
                </div>
            </div>
            <div class="section w-100" id="info">
              <h3 class="text-bold mb-3" style="font-size: 30px; line-height: 35px;">What is Catchakiwi?</h3>
              <p>You've seen them in the mall, those crowded corkboards with a patchwork of handwritten ads: "babysitter available", "handcrafted quilts for sale", "for all your gardening needs, call Nigel"…</p>

              <p>From the beginning of time people with goods and services to sell have been trying to connect with people who need those things.</p>

              <p>Now there is a better way.</p>
              <p>Catchakiwi is the modern equivalent of a community noticeboard, an online forum where ordinary Kiwis with skills and services to offer can connect with an endless supply of fellow-Kiwis who need those things.</p>

              <p>Catchakiwi is about tapping into community resources, bringing seekers and sellers together and forming fruitful relationships that strengthen and sustain communities.</p>

              <p>Being self employed has never been easier. Catchakiwi could be your portal to prosperity.</p>
            </div>
            <div class="section w-100" id="features">
              <h3 class="text-bold mb-3" style="font-size: 30px; line-height: 35px;">What's changing at Catchakiwi?</h3>
              <p>Below is just a small amount of the many features you can look forward to seeing in the upcoming release of Catchakiwi</p>
              <p><span class="text-semibold">Seach-Optimisation:</span> Your searches will bring up the results you're looking for. Adding features like Location and Category will allow you to find the service you're looking for, faster than ever.</p>
              <p><span class="text-semibold">Category based emails:</span> As a registered user, you will now be able to subscribe to specific categories. You will be notified when there are any local new service providers in a category you have selected.</p>
              <p><span class="text-semibold">Maps integration:</span> If the service provider allows it, as a registered user you will be able to view the address of the service provider on a map on their profile or on a noticeboard.</p>
              <p><span class="text-semibold">Advertising Cleanup:</span> We don't appreciate being inundated with advertising popups as we click through a page, and we don't imagine that you do either. We're doing an overhaul on our advertising setup. You will only see ads that interest you for services in your area.</p>
              <p><span class="text-semibold">Social Media Integration:</span>Catchakiwi will be on the forefront of social media integration. Login with your Facebook, tweet your favourite service provider. The choice is yours.</p>
              <p><span class="text-semibold">Do more, with less:</span>You will be able to browse more of Catchakiwi without needing to logon. A larger audience will be able to view your profile without requiring a login</p>
              <p><span class="text-semibold">And many more...</span>There are so many more features that we're thinking up every day. We just can't wait to bring them all to you. Ideas also keep flying in from you, and we urge you to keep them coming. If you have anything you'd like to see in the upcoming release of Catchakiwi, let us know on our facebook page, or tweet us, or email us using the contact section of this website. One of the main strategies and benefits of Catchakiwi is collaboration. In that spirit, we are so enthusiastic to include collaborating with you in the creation the new Catchakiwi.</p>
            </div>
            <div class="section w-100" id="faq">
              <h3 class="text-bold" style="font-size: 30px; line-height: 35px;">Frequently Asked Questions</h3>
              <div class="accordion" id="accordionExample">
                <div class="accordion-item open">
                  <h2 class="accordion-header">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                      How can we be contacted about when Catchakiwi will be ready?
                    </button>
                  </h2>
                  <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                      Like us on Facebook or follow us on Twitter for exclusive information and offers. If you're only interested in the launch date, let us know by filling out the Contact section of this website.
                    </div>
                  </div>
                </div>
                <div class="accordion-item">
                  <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                      How can we be contacted about when Catchakiwi will be ready?
                    </button>
                  </h2>
                  <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                      Like us on Facebook or follow us on Twitter for exclusive information and offers. If you're only interested in the launch date, let us know by filling out the Contact section of this website.
                    </div>
                  </div>
                </div>
                <div class="accordion-item">
                  <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                      How can we be contacted about when Catchakiwi will be ready?
                    </button>
                  </h2>
                  <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                      Like us on Facebook or follow us on Twitter for exclusive information and offers. If you're only interested in the launch date, let us know by filling out the Contact section of this website.
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="section w-100" id="contact">
              <h3 class="text-bold" style="font-size: 30px; line-height: 35px;">Send us a message</h3>
               <!-- Second Form -->
                <form action="contactsubmit.php" method="post" class="mt-4" id="secondForm">
                    <div class="col-12 mt-3">
                        <input type="text" class="form-control" name="name" placeholder="Name" />
                    </div>
                    <div class="col-12 mt-3">
                        <input type="email" required class="form-control" name="email" placeholder="Email" />
                    </div>
                    <div class="col-12 mt-3">
                        <input type="tel" class="form-control" name="phone" placeholder="Phone" />
                    </div>
                    <div class="col-12 mt-3">
                        <textarea class="form-control" name="message" placeholder="Message"></textarea>
                    </div>
                    <!--<div class="col-12 mt-3">-->
                    <!--    <input type="text" class="form-control" name="word" placeholder="Type the word" />-->
                    <!--</div>-->
                    <div class="col-12 mt-3">
                        <!--<button type="submit" class="contact_submit">Send</button>-->
                        <input type="submit" id="contact_submit" class="w-100 w-sm-auto  contact_submit" value="Send" />
                    </div>
                </form>
                <div id="form-messages-second"></div> <!-- To display success or error messages -->
                <!-- Your Loading Spinner -->
                <div class="loadertwo">
                    <img src="{{ asset('assets/images/ZZ5H.gif') }}" width="100" alt="Loading...">
                </div>
            </div>
            <div class="section w-100" id="sponsors">
              <h3 class="text-bold mb-3" style="font-size: 30px; line-height: 35px;">Our Sponsors</h3>
              <p>Please take time to visit our sponsors below. They're the reason we're making it free for you to use Catchakiwi. Thank you on behalf of the Catchakiwi team.</p>
              <div class="images d-flex flex-row flex-wrap" style="max-width: 530px;">
                <div class="col-12 col-sm-6 mt-2 px-1">
                  <img src="{{ asset('assets/images/popup-image-1.png') }}" style="max-width: 250px; width: 100%; margin: 0 auto;" alt="image-1" />
                </div>
                <div class="col-12 col-sm-6 mt-2 px-1">
                  <img src="{{ asset('assets/images/popup-image-1.png') }}" style="max-width: 250px; width: 100%; margin: 0 auto;" alt="image-1" />
                </div>
                <div class="col-12 col-sm-6 mt-2 px-1">
                  <img src="{{ asset('assets/images/popup-image-1.png') }}" style="max-width: 250px; width: 100%; margin: 0 auto;" alt="image-1" />
                </div>
                <div class="col-12 col-sm-6 mt-2 px-1">
                  <img src="{{ asset('assets/images/popup-image-1.png')  }}" style="max-width: 250px; width: 100%; margin: 0 auto;" alt="image-1" />
                </div>
                <div class="col-12 col-sm-6 mt-2 px-1">
                  <img src="{{ asset('assets/images/popup-image-1.png') }}" style="max-width: 250px; width: 100%; margin: 0 auto;" alt="image-1" />
                </div>
                <div class="col-12 col-sm-6 mt-2 px-1">
                  <img src="{{ asset('assets/images/popup-image-1.png') }}" style="max-width: 250px; width: 100%; margin: 0 auto;" alt="image-1" />
                </div>
              </div>
            </div>
          </div>
        </div>
        </div>
      </div>
   <div class="home_bg">
      <!-- Header start-->
      <div class="top_bar">
         <div class="container">
            <div class="row">
               <div class="col-lg-3 col-md-7 col-sm-7 col-7">
                  <p class="nz_region">
                      <select class="countryChange">
                            <option value="IN" {{ (session('CountryCode')=="IN")?"selected":"" }}>IN-India</option>
                            <option value="NZ" {{ (session('CountryCode')=="NZ")?"selected":"" }}>NZ-New Zealand</option>
                            <option value="AU" {{ (session('CountryCode')=="AU")?"selected":"" }}>AU-Australia</option>
                            <option value="CN" {{ (session('CountryCode')=="CN")?"selected":"" }}>CN-China</option>
                            <option value="ENG" {{ (session('CountryCode')=="ENG")?"selected":"" }}>UK-United Kingdom</option>
                            <option value="US" {{ (session('CountryCode')=="US")?"selected":"" }}>US-United States</option>
                        </select>
                  </p>
               </div>
               <div class="col-lg-9 col-md-5 col-sm-5 col-5 top_menu">
                  @include('includes/topmenu')
                  @include('includes/sidemenu')
               </div>
            </div>
         </div>
      </div>
      <div class="container">
         <div class="logo">
            <h1><a href="https://catchakiwi.com/"><img src="{{ asset('assets/images/logo.png') }}" alt="" /></a></h1>
         </div>
      </div>
      <!-- Header start end-->
      <!-- body start-->
      <div class="container">
         <div class="home_midbody">
            <h2>Search Your Kiwi Business Community</h2>
         <!--   <p>So often, two people who need to connect walk straight past each other in the street. Don't let Catchakiwi
         become just an online community, let it become the hub of our community.</p>-->
            <p class="desk-text">Every day, amazing people like you pass by without ever knowing the connections that could change their lives. With Catchakiwi, you’re not just joining an online community—you’re stepping into the vibrant center of our shared community.</p>
            <button class="p-3 d-flex align-items-center justify-content-center newcacpop" id="newcacpop">
                <span class="me-sm-3">The new catchakiwi is coming</span>
                <div class="bg">
                  <div class="loader"></div>
                </div>
              </button>
            <div class="home_searchsec">
               <form action="{{ route('search', ['country' => strtolower(session('CountryCode') ?? 'nz')]) }}" method="get">
                   
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
            @if(Auth::user())
                <div class="add_getqutebutton"><a href="{{ URL::to('/add-your-business') }}">Add Your Business</a> <a href="{{ URL::to('/get-a-quote') }}">Get a Quote</a></div>
            @else
                <div class="add_getqutebutton"><a href="{{ URL::to('/login?redirect=add-your-business') }}">Add Your Business</a> <a href="{{ URL::to('/login?redirect=get-a-quote') }}">Get a  Quote</a></div>
            @endif
            
         </div>
      </div>
      <div class="for_cellphonepara">
         <p>Building a home-based business isn’t easy, but you don’t have to do it alone. Catchakiwi connects you with like-minded entrepreneurs, turning your community into a powerful business network.
         </p>
      </div>
      <!-- body start end-->
     
@include('includes/footer')
 <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js"></script>

<script>
  $(document).ready(function () {
    $(".popup_close").click(function () {
      $(".popup_outer").hide();
    });
    $("#newcacpop").click(function () {
      $(".popup_outer").show();
    });
  });
</script>
<script>
    $(document).ready(function () {
        $('#notify').click(function (event) {
            event.preventDefault();

            var name = $('input[name="popup_name"]').val();
            var email = $('input[name="popup_email"]').val();

            if (name.trim() === '' || email.trim() === '' || !validateEmail(email)) {
                $('#form-messages').html('<div class="text-danger mt-2">Please fill in all fields with valid data.</div>');
            } else {
                 // Show the loader
                 $('#loader').show();
                 $.ajax({
                    type: 'POST',
                    url: 'notification.php',
                    data: $('#firstForm').serialize(),
                    success: function (response) {
                        // Hide the loader
                        $('#loader').hide();

                        // Display success message
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response,
                        });

                        // Optionally, clear form fields after success
                        $('#firstForm')[0].reset();
                        $('#form-messages').html('');
                    },
                    error: function (xhr, status, error) {
                        // Hide the loader
                        $('#loader').hide();

                        // Display error message
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Message could not be sent. Error: ' + error,
                        });
                    }
                });
            }
        });

        function validateEmail(email) {
            var re = /\S+@\S+\.\S+/;
            return re.test(email);
        }
        
    });
</script>

<script>
    $(document).ready(function () {
        $('#contact_submit').click(function (event) {
            event.preventDefault();
           // alert('hi');

            var name = $('input[name="name"]').val();
            var email = $('input[name="email"]').val();
            var phone = $('input[name="phone"]').val();
            var message = $('textarea[name="message"]').val();
            // var word = $('input[name="word"]').val();

            if (name.trim() === '' || email.trim() === '' || !validateEmailTwo(email) || phone.trim() === '' || message.trim() === '') {
                $('#form-messages-second').html('<div class="error">Please fill in all fields with valid data.</div>');
            } else {
                // Show the loader
                $('.loadertwo').show();
                $.ajax({
                    type: 'POST',
                    url: 'contactsubmit.php', // Change this to the actual handler for the second form
                    data: $('#secondForm').serialize(),
                    success: function (response) {
                        // Hide the loader
                        $('.loadertwo').hide();
                        console.log('success');
                         $('#form-messages').html('');
                        // Display success message
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response,
                        });

                        // Optionally, clear form fields after success
                        $('#secondForm')[0].reset();

                    },
                    error: function (xhr, status, error) {
                        // Hide the loader
                        $('.loadertwo').hide();

                        // Display error message
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Message could not be sent. Error: ' + error,
                        });
                    }
                });
            }
        });

        function validateEmailTwo(email) {
            var re = /\S+@\S+\.\S+/;
            return re.test(email);
        }
        $('.countryChange').change(function () {
            var countryId = $(this).val();
            //alert(countryId);
            $.ajax({
                url: 'changecountry?country_id='+countryId, // Replace with your backend route to fetch cities
                method: 'GET',
                success: function (response) {
                    //console.log(response);
                    window.location.href="";
                },
                error: function (xhr, status, error) {
                    console.error(error);
                }
            });
        });
    //   $('#serviceselect').selectize({
    //         create: false,
    //         sortField: 'text',
    //         render: {
    //             no_results: function(data, escape) {
    //                 return '<div class="no-results">No results found</div>';
    //             }
    //         }
    //     });
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
        
        
        // $('.countryChange').change(function () {
        //     var countryId = $(this).val();
        //     var selectizeInstance = $('#locationselect')[0].selectize;
        //     //console.log(selectizeInstance);return false;
        //     //alert(countryId);
        //     $.ajax({
        //         url: 'getCitystateforselectsize', // Replace with your backend route to fetch cities
        //         method: 'POST',
        //         data: {
        //             country_id: countryId,
        //             _token: $('input[name="_token"]').val()
        //         },
        //         success: function (response) {
        //             console.log(response);
        //             $('.otherscoun').addClass('hidden');
        //             $('.otherscoun').val('others');
        //             $('#cityid').attr('required', 'required');
        //             $('.selectize-control').show();
        //             //$('.cityid').show();
        //             //$('#cityid').html(response);
        //             //$('#cityid').prepend('<option value="" selected>Select Location</option>');
        //             selectizeInstance.clear();
        //             selectizeInstance.clearOptions();
        //             selectizeInstance.settings.placeholder = 'Select Location';
        //             selectizeInstance.updatePlaceholder();
                    
        //             selectizeInstance.addOption(JSON.parse(response));
        //             // Refresh the dropdown to display new options
        //             selectizeInstance.refreshOptions(true);
        //             $('#locationselect-selectized').trigger('keyup');

        //         },
        //         error: function (xhr, status, error) {
        //             console.error(error);
        //         }
        //     });
        
        // });
        $(document).ready(function() {
        
        
        // Show/Hide selectize control based on word count
        // DELETED CONFLICTING MANUAL HANDLERS
    });
         
        //$('#countries').trigger('change');
        
    });
    
</script>