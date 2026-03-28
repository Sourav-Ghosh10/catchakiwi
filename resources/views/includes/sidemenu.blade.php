
                     	<div class="after_logmenu @if(!Auth::user()) withoutlogmenu @endif">
                     	    @if(Auth::user())
                     			<!--<a href="#" class="msg_notift"> <span>12</span><img src="{{ asset('assets/images/top_msgicon.png') }}" alt="">
									<div class="notification_dropdown notifidrop">
										<p class="notifi_title">Notifications</p>
									
                                      <h3 class="comsoon_title">Coming soon</h3>
                                  </div>
									
								</a>-->
                          		<a href="#" class="msg_notift position-relative" id="notificationBell">
                                    <span class="badge badge-danger" id="unreadCount">{{ auth()->user()->receivedNotifications()->wherePivot('read', false)->count() }}</span>
                                    <img src="{{ asset('assets/images/top_msgicon.png') }}" alt="Notifications">
                                </a>

                                <!-- Dropdown -->
                                <div class="notification_dropdown notifidrop" id="notificationDropdown" style="display:none;">
                                    <p class="notifi_title">Notifications</p>
                                    <ul class="list-group" id="notificationList">
                                        @if(auth()->user()->receivedNotifications()->latest()->limit(10)->count() == 0)
                                            <li class="list-group-item text-center text-muted">No notifications yet</li>
                                        @else
                                            @foreach(auth()->user()->receivedNotifications()->latest()->limit(10)->get() as $notif)
                                                <li class="list-group-item notification-item {{ $notif->pivot->read ? '' : 'unread' }}"
                                                    data-id="{{ $notif->id }}"
                                                    style="cursor:pointer; padding:10px;">
                                                    <strong>{{ $notif->title }}</strong>
                                                    <p class="mb-0 text-truncate" style="max-width:250px;" data-full-message="{{ $notif->message }}">
                                                        {{ Str::limit($notif->message, 50) }}
                                                    </p>
                                                    <small class="text-muted">{{ $notif->sent_at->diffForHumans() }}</small>
                                                </li>
                                            @endforeach
                                        @endif
                                    </ul>
                                    <div class="text-center mt-2">
                                    </div>
                                </div>
								<a href="#" class="email_notift">
                                    <span id="headerMsgCount">0</span>
                                    <img src="{{ asset('assets/images/top_emailicon.png') }}" alt="">

                                    <div class="notification_dropdown msgdrop">
                                        <p class="notifi_title">Messages</p>
                                        <ul id="headerMsgList">
                                            <!-- Messages injected here by JS -->
                                            <li class="loading">Loading messages...</li>
                                        </ul>
                                        <p class="seeallnotifi">
                                            <a href="https://catchakiwi.com/profile#parentHorizontalTab3">See All</a>
                                        </p>
                                    </div>
                                </a>
								@endif
								<div class="slide_menu">
      <div id="mySidenav" class="sidenav"> <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <a href="https://catchakiwi.com/" class="slidelogo"><img src="{{ asset('assets/images/menu_logo.png') }}" alt="" class="menu_logo"></a>
         @if(Auth::user())
         <div class="menu_afterloginbut"> <strong>{{ Auth::user()->name }}</strong>
            <br>
            <!--<div class="notify_sec">
               <a href="#"> <span>12</span><img src="{{ asset('assets/images/top_msgicon.png') }}" alt=""> </a>
               <a href="#"> <span>23</span> <img src="{{ asset('assets/images/top_emailicon.png') }}" alt=""></a>
            </div>-->
         </div>
          @else
            <div class="menu_loginbut"><a href="{{ URL::to('/login') }}">Login</a></div>
         @endif
         @if(Auth::user())
         <div class="gw-sidebar">
            <div id="gw-sidebar" class="gw-sidebar">
               <div class="nano-content">
                  <ul class="gw-nav gw-nav-list">
                     <li class="dash">
                        <a href="{{ URL::to('/profile') }}"><img src="{{ asset('assets/images/dash_icon.png') }}" alt=""> <span class="gw-menu-text">Dashboard</span> <b></b> </a>
                     </li>
                     <li>
                        <a href="javascript:void(0)"><img src="{{ asset('assets/images/garage-sale.png') }}" alt=""> <span class="gw-menu-text">Garagesales</span> <b></b> </a>
                     </li>
                     <li>
                        <a href="javascript:void(0)"> <img src="{{ asset('assets/images/vehicle.png') }}" alt=""><span class="gw-menu-text">Vehicles</span> <b></b> </a>
                     </li>
                     <li>
                        <a href="javascript:void(0)"><img src="{{ asset('assets/images/real-estate.png') }}" alt=""> <span class="gw-menu-text">Real Estate</span> <b></b> </a>
                     </li>
                     <li>
                        <a href="javascript:void(0)"><img src="{{ asset('assets/images/catch-a-ride.png') }}" alt=""> <span class="gw-menu-text">Catch-a-Ride</span> <b></b> </a>
                     </li>
                     <li class="init-arrow-down subm">
                        <a href="javascript:void(0)"><img src="{{ asset('assets/images/bussiness.png') }}" alt=""> Business</a><span class="gw-menu-text"></span> <b class="gw-arrow"></b>
                        <ul class="gw-submenu">
                           <li><a href="{{ URL::to(strtolower(session('CountryCode')).'/business') }}">Find Business</a></li>
                           <li> <a href="{{ URL::to('/add-your-business') }}">Add your business</a> </li>
                           <li> <a href="javascript:void(0)">Latest Businesses joined</a> </li>
                           <li> <a href="javascript:void(0)">Top Rated Businesses</a> </li>
                           <li> <a href="javascript:void(0)">Business Categories</a> </li>
                           <li> <a href="javascript:void(0)">Edit your Business Listing</a> </li>
                        </ul>
                     </li>
                     <li class="init-arrow-down subm">
                        <a href="javascript:void(0)"> <img src="{{ asset('assets/images/noticeboard.png') }}" alt=""><span class="gw-menu-text">Notice Board</span> <b class="gw-arrow icon-arrow-up8"></b> </a>
                        <ul class="gw-submenu">
                           <li><a href="{{ route('notice-board') }}">Find Notice Board</a></li>
                           <li> <a href="javascript:void(0)">Add a notice</a> </li>
                           <li> <a href="javascript:void(0)">View latest notices</a> </li>
                           <li> <a href="javascript:void(0)">Notice categories</a> </li>
                           <li> <a href="javascript:void(0)">Edit your notices</a> </li>
                        </ul>
                     </li>
                     <li class="init-arrow-down subm">
                        <a href="javascript:void(0)"><img src="{{ asset('assets/images/Articles.png') }}" alt=""> <span class="gw-menu-text">Articles</span> <b></b> </a>
                        <ul class="gw-submenu">
                           <li><a href="{{ route('article.list') }}">Find Articles</a></li>
                           <li> <a href="{{ route('article.add') }}">Add an Article</a> </li>
                           <li> <a href="{{ route('article.list') }}">View latest Articles</a> </li>
                           <li> <a href="{{ route('article.list') }}">Article categories</a> </li>
                           <li> <a href="{{ route('article.my-articles') }}">Your Articles & Views</a> </li>
                        </ul>
                     </li>
                     <li>
                        <a href="javascript:void(0)"><img src="{{ asset('assets/images/forum.png') }}" alt=""> <span class="gw-menu-text">Forum</span> <b></b> </a>
                     </li>
                  </ul>
               </div>
            </div>
         </div>
         @else
            <ul class="bflmenu">
                <li><a href="{{ URL::to(strtolower(session('CountryCode')).'/business') }}">Businesses</a></li>
                <li><a href="{{ route('notice-board') }}">Notice Board</a></li>
                <li><a href="{{ route('article.list') }}">Articles</a></li>
                <li><a href="#">Forum</a></li>
            </ul>
        @endif
        @if( Auth::user() )
         <div class="menu_loginbut">

               <form method="POST" action="{{ route('logout') }}"> @csrf
                  <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                    {{ __('Log Out') }}
                   </a>
                </form>
            
         </div>
         @endif
      </div> 
      
      @if( Auth::user() ) 
        
        @if(Request::is('/') || Request::is('dashboard'))
                <span onclick="openNav()" class="menutag"> <img src="{{ asset('assets/images/menu_icon.png') }}" alt="" ></span> 
        @else
            <span onclick="openNav()" class="menutag"> <img src="{{ asset('assets/images/menu_iconblk.png') }}" alt="" ></span> 
        @endif
        
        @else
            @if(Request::is('/') || Request::is('dashboard'))
                <span onclick="openNav()" class="menutag"> <img src="{{ asset('assets/images/menu_icon.png') }}" alt="" ></span> 
            @else
                <span onclick="openNav()" class="menutag"> <img src="{{ asset('assets/images/menu_iconblk.png') }}" alt="" ></span> 
            @endif
      @endif
</div>
 @if(Auth::user())
                     	
                     		 @if (empty(Auth::user()->image))
                     		 <a href="#" class="after_logname">
                     		<img src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}">
							</a>
							 
							 @else
							 <a href="#" class="after_logname">
							 <!--<img src="{{ Auth::user()->profile_photo_url }}" alt="">-->
							 <img src="{{ asset(\Auth::user()->image) }}"/>
							 
							 </a>
							 @endif
						</div>
						</ul>
						@else
					
						</ul>
						@endif
</nav>
						
						
<!-- Full Notification Modal -->
<div class="modal fade" id="notificationModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle"></h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" id="modalMessage"></div>
            <div class="modal-footer">
                <small class="text-muted mr-auto" id="modalTime"></small>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>						
