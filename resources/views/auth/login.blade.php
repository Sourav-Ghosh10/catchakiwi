@include('includes/header')

<?php

$ipData = session('ipData');
?>
    <!-- Header start-->
    <div class="top_bar inner">
    <div class="container">
    <div class="row">
    <div class="col-lg-3 col-md-3 col-sm-3 col-3">
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
 <div class="col-lg-9 col-md-9 col-sm-9 col-9 top_menu">
            @include('includes/topmenu')
            @include('includes/sidemenu')
         </div>
    </div>
    </div>
    </div>
    </div>
    <div class="top_search nomob_search">
    <div class="container"><div class="logo"><h1><a href="https://catchakiwi.com/"><img src="{{ asset('assets/images/logo-inner.png') }}" alt="" /></a></h1></div></div>
    <div class="container" style="display:none;">
    <div class="home_midbody">
    <div class="home_searchsec">
    <form action="" method="post">
    <input name="" type="text" placeholder="Services I’m looking for" />
    <input name="" type="text" placeholder="Enter your location" class="location" />
    <input name="" type="submit" value="Search" />
    </form>
    </div>
    </div>
    </div></div>
    <!-- Header start end-->
    
    <!-- body start-->
    <div class="mid_body">
    <div class="container loginbody">
    <div class="row desktoplogin">
    <div class="col-lg-8 col-md-12 ordermob2 col-sm-12 login_joinus">
    <h2>Join us Free!</h2>
    <p>Connecting kiwis with their local business and service<br>
    communities through our….</p>
    <ul>
      <li> <span><img src="{{ asset('assets/images/notice_icon.png') }}" alt=""></span> <strong>Notice Board:</strong> Post public messages, items for sale or wanted, announce your events!</li>
      <li> <span><img src="{{ asset('assets/images/business_icon.png') }}" alt=""></span> <strong>Business Listings:</strong> Share your business or services you offer.</li>
      <li> <span><img src="{{ asset('assets/images/article_icon.png') }}" alt=""></span> <strong>Articles:</strong> Share and browse written articles with community members</li>
      <li> <span><img src="{{ asset('assets/images/forum_icon.png') }}" alt=""></span> <strong>Forum:</strong> Open for discussion anytime!</li>
    </ul>
    </div>
    <div class="col-lg-4 col-md-12 ordermob1 col-sm-12">
    <div class="login_box">
      <img src="{{ asset('assets/images/login_usericon.png')  }}" class="usericon" alt="">
      <h2><span>Sign In </span>Existing Member?</h2>
      <x-jet-validation-errors class="mb-4" />
                        
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <input id="email" class="block mt-1 w-full" type="email" placeholder="Email" name="email" :value="old('email')" required autofocus >
                            <input id="password" class="block mt-1 w-full" type="password" placeholder="Password" name="password" required autocomplete="current-password">
                            @if (request()->has('redirect')) 
                            <input type="hidden" name="redirect" value="{{ request()->get('redirect') }}">
                            @endif
                            @if (request()->has('redirectto')) 
                            <input type="hidden" name="redirectto" value="{{ request()->get('redirectto') }}">
                            @endif
                            <div class="forgot_sec">
                                <p class="remeber">
                                     <x-jet-checkbox id="remember_me" name="remember" />
                                    <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                                </p>
                                <p class="forgot_pass">
                                    @if (Route::has('password.request'))
                                        <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                                         {{ __('Forgot your password?') }}
                                        </a>
                                    @endif
                                </p>
                            </div>
                            <input name="submit" type="submit" value="Sign In">
                        </form>
                            <p class="login_firsttime">First time user?</p>
                            <a href="{{ URL::to('register') }}" class="reg-btn">{{ __('Register Here') }}</a> 
                       <div class="login_social"> <img src="{{ asset('assets/images/login_socialborder.png') }}" alt="" class="soc_border">
                            <ul>
                                <li><img src="{{ asset('assets/images/login_fb.png') }}" alt=""><a href="https://www.facebook.com/catchakiwiNZ/" target="_blank">Facebook</a></li>
                                <!--<li><img src="{{ asset('assets/images/login_gplus.png') }}" alt=""><a href="#" target="_blank">Google+</a></li>-->
                                <li><img src="{{ asset('assets/images/login_twitter.png') }}" alt=""><a href="https://x.com/Catchakiwi" target="_blank">Twitter</a></li>
                                <li><img src="{{ asset('assets/images/login_in.png') }}" alt=""><a href="https://www.linkedin.com/company/catchakiwi/" target="_blank">Linkedin</a></li>
                                <li><img src="{{ asset('assets/images/youtube-icon.png') }}" alt="" width="13"><a href="https://www.youtube.com/@catchakiwinz8758" target="_blank">Youtube</a></li>
                            </ul>
                        </div>
    </div></div>
    </div>
    
    </div>
    </div>
    <!-- body start end-->
@include('includes/footer')