@include('includes/inner-header')

    
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