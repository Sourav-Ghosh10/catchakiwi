@include('includes/header')

<?php

$ipData = session('ipData');
?>
  <!-- Header start-->
<div class="top_bar inner">
   <div class="container">
      <div class="row">
         <div class="col-lg-3 col-md-3 col-sm-12">
            <p class="nz_region">
                <select class="countryChange">
                    <option value="IN" {{ (session('CountryCode')=="IN")?"selected":"" }}>IN-India</option>
                    <option value="NZ" {{ (session('CountryCode')=="NZ")?"selected":"" }}>NZ-New Zealand</option>
                    <option value="AU" {{ (session('CountryCode')=="AU")?"selected":"" }}>AU-Australia</option>
                    <option value="CN" {{ (session('CountryCode')=="CN")?"selected":"" }}>CN-China</option>
                    <option value="ENG" {{ (session('CountryCode')=="ENG")?"selected":"" }}>ENG-United Kingdom</option>
                </select>
            </p>
         </div>
         <div class="col-lg-9 col-md-9 col-sm-12 top_menu">
            @include('includes/topmenu')
            @include('includes/sidemenu')
         </div>
      </div>
   </div>
</div>
<div class="top_search nomob_search">
   <div class="container">
      <div class="logo">
         <h1><a href="https://catchakiwi.com/"><img src="{{ asset('assets/images/logo-inner.png') }}" alt="" /></a></h1>
      </div>
   </div>
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
   </div>
</div>
<!-- Header start end-->
 <!-- body start-->
    <div class="mid_body">
        <div class="container loginbody">
            <div class="row">
                <div class="col-lg-8 col-md-12 col-sm-12 ordermob2 register_leftsec"> <img src="{{ asset('assets/images/register_banner.png') }}" alt="" class="register_pic">
                    <h3>The catchakiwi way</h3>
                    <p>Find all the help you need on catchakiwi.</p>
                    <p>Looking at starting a new business, its easy to start it on catchakiwi.
                        <br> If you already have a business, get it out there, to other catchakiwi people like you!</p>
                    <p>What are you waiting for - let’s go!</p> <a href="{{ route('login') }}" class="havean_account">Login</a> </div>
                <div class="col-lg-4 col-md-12 col-sm-12 ordermob1">
                    <div class="login_box register"> <img src="{{ asset('assets/images/creat_accounticon.png') }}" class="usericon" alt="">
                        <h2><span>Create an Account</span></h2>
                        <p>Or register here. Just fill in the fields below
                            <br> (all are required) to set up a new account.</p>
                            <x-jet-validation-errors class="mb-4" />
                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            <input id="name" class="block mt-1 w-full f_name" placeholder="First Name" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" >
                            <input id="email" class="block mt-1 w-full" type="email" placeholder="Email" name="email" :value="old('email')" required>
                             <div class="form-group row">    
                               <!-- <label for="role" class="col-md-12 col-form-label text-md-left">{{ __('Select Suburb') }}</label> -->
                                   <div class="col-sm-12">
                                       <div class="glob">
                                           <select class="livesearch form-control" name="country" id="country" placeholder="Select Country" >
                                              <option value="" disabled selected>Select Country</option>
                                              @if(!empty($country))
                                                @foreach($country as $cnty)
                                                    <option value="{{$cnty['id']}}" <?= (isset($suburb) && $suburb->country_name==$cnty['shortname'])?'selected':'' ?>>{{$cnty['name']}}</option>
                                                @endforeach
                                              @endif;
                                              </select>
                                          </div>
                                    </div>
                                </div>
                            <div class="form-group row">    
                                   <div class="col-sm-12">
                                        <select class="livesearch form-control" name="towns_id" id="towns_id" placeholder="Type Suburb/City" ></select>
                                   </div>
                          </div>

                          <!--<div id="region_district_dtls"></div>-->
                            <input id="password" class="block mt-1 w-full" placeholder="Password" type="password" name="password" required autocomplete="new-password">
                             <input id="password_confirmation" class="block mt-1 w-full" placeholder="Re-Enter Password" type="password" name="password_confirmation" required autocomplete="new-password">
                            <!--<input name="" type="text" placeholder="City or District" class="c_name"> -->
                            
                            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                             <div class="ml-2">
                                {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                        'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-sm text-gray-600 hover:text-gray-900">'.__('Terms of Service').'</a>',
                                        'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-sm text-gray-600 hover:text-gray-900">'.__('Privacy Policy').'</a>',
                                ]) !!}
                            </div>
                            @endif
                            <button type="submit" class="regbutton">{{ __('Register Now') }}</button>
                        </form>
                        <div class="login_social"> <img src="{{ asset('assets/images/login_socialborder.png') }}" alt="" class="soc_border">
                            <ul>
                                <li><img src="{{ asset('assets/images/login_fb.png') }}" alt=""><a href="https://www.facebook.com/catchakiwiNZ/" target="_blank">Facebook</a></li>
                                <!--<li><img src="{{ asset('assets/images/login_gplus.png') }}" alt=""><a href="#" target="_blank">Google+</a></li>-->
                                <li><img src="{{ asset('assets/images/login_twitter.png') }}" alt=""><a href="https://x.com/Catchakiwi" target="_blank">Twitter</a></li>
                                <li><img src="{{ asset('assets/images/login_in.png') }}" alt=""><a href="https://www.linkedin.com/company/catchakiwi/" target="_blank">Linkedin</a></li>
                                <li><img src="{{ asset('assets/images/youtube-icon.png') }}" alt="" width="13"><a href="https://www.youtube.com/@catchakiwinz8758" target="_blank">Youtube</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- body start end-->
@include('includes/footer')
