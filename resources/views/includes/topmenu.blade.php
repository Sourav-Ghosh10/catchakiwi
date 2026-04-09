<nav>
                     <ul class="deskmenu">
                        <li><a href="{{ URL::to(strtolower(session('CountryCode')).'/business') }}">Business</a></li>
                        <li><a href="{{ route('notices') }}">Notice Board</a></li>
                        <li><a href="{{ route('article.list') }}">Articles</a></li>
                        <li><a href="#">Forum</a></li>
                        <!-- <li class="login_button"></li> -->
                        @if(!Auth::user())
                        <li class="login_button"><a href="{{ URL::to('/login?redirectto='.url()->current()) }}">Login</a></li>
                        @endif
                     </ul>                     	
                    @if(!Auth::user())
                      <div class="mobtop_login"><a href="{{ URL::to('/login') }}">Login</a></div> 
                     @endif