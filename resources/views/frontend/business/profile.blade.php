@include('includes/inner-header')

   <!--<div class="container">-->
   <!--   <div class="home_midbody">-->
   <!--      <div class="home_searchsec">-->
   <!--         <form action="" method="post">-->
   <!--            <input name="" type="text" placeholder="Services I’m looking for" />-->
   <!--            <input name="" type="text" placeholder="Enter your location" class="location" />-->
   <!--            <input name="" type="submit" value="Search" />-->
   <!--         </form>-->
   <!--      </div>-->
   <!--   </div>-->
   </div>
      <!-- Header start end-->
      <!-- body start-->
   <div class="mid_body">
      <div class="container">
         <div class="profile_banner"> 
           @if(!empty($profile->profile_banner))
                <img src="{{ asset($profile->profile_banner) }}" alt="">
            @else
                <img src="{{ asset('assets/images/default-cover.png') }}" alt="">
            @endif
            <div class="profile_pic-dis">
               

               <form name="profile_photo" id="profile_photo" enctype="multipart/form-data" action="{{route('store.profilepic')}}" method="POST" class="avatar-upload">
              <!--<div class="avatar-edit">
                  <input type='file' id="imageUpload" accept=".png, .jpg, .jpeg" name="imageUpload" class=" imageUpload" />
                  <input type="hidden" name="base64image" name="base64image" id="base64image">
                  <label for="imageUpload"></label>
              </div>-->
              <div class="avatar-preview container2">
                  @php
                     if(!empty($profile->image) && $profile->image!=''){
                     $image =$profile->image;
                     }else{
                     $image = 'https://ui-avatars.com/api/?name='. urlencode($profile->name).'&color=7F9CF5&background=EBF4FF';
                     }
                     $url = url($image);
                     $imgs = "background-image:url($url)";

                   @endphp
                  <div id="imagePreview" style="{{ $imgs }}">
                      <!--<input type="hidden" name="_token" value="{{csrf_token()}}">
                      <input style="margin-top: 60px; visibility: hidden;" type="submit" class="btn btn-warning" value="Save">-->  
                  </div>
              </div>
          </form>
          <div class="modal fade bd-example-modal-lg imagecrop" id="model" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-lg">
                <div class="modal-content">
                  <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">New message</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                  </div>
                  <div class="modal-body">
                      <div class="img-container">
                          <div class="row">
                              <div class="col-md-11">
                                  <img id="image" src="https://avatars0.githubusercontent.com/u/3456749">
                              </div>
                          </div>
                      </div>
                    </div>
                    <input type="hidden" id="uploadtype" value="">
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      <button type="button" class="btn btn-primary crop" id="crop">Crop</button>
                    </div>
                </div>
              </div>
            </div>

            </div>
         </div>
         <div class="profile_heading">
            <h2>About Me</h2>
            <p class="profile_para">{{$profile->aboutus}}</p>
         </div>
         <div class="full_midpan">
            <div class="row">
               <div class="col-lg-8 col-md-8 col-sm-12">
                  <div class="left_profileform">
                     <div id="parentHorizontalTab" class="profiletab">
                        <ul class="resp-tabs-list ">
                           <li class="profile">Profile</li>
                           <!--<li class="message">Message </li>-->
                           <!--<li class="setting">Settings</li>-->
                        </ul>
                        <div class="resp-tabs-container " style="display:block !important">
                           <div>
                              <div class="profiletab_namdetls">
                                 @if($profile->name)
                                       @php
                                             $name =  explode(" ", $profile->name);
                                             $firstname =  $name[0];
                                             $lastname = isset($name[1]) ? $name[1] : '';
                                       @endphp
                                 @endif
                                 <form action="" method="post">
                                    <p>
                                       <label>Display Username</label>
                                       <input name="name" type="text" value="{{ $profile->name }}">
                                    </p>
                                   @if($profile->fname_visibility==1)
                                    <p>
                                       <label>First Name</label>
                                       <input name="firstname" type="text" value="{{ $firstname }}">
                                    </p>
                                   @endif
                                   @if($profile->lname_visibility==1)
                                    <p>
                                       <label>Last Name</label>
                                       <input name="lastname" type="text" value="{{ $lastname }}">
                                    </p>
                                   @endif
                                   @if($profile->dob_visibility==1)
                                    <p>
                                    	<label>Date of Birth</label>
                                       	<input name="dateofbirth" type="text" value="{{ \Carbon\Carbon::parse($profile->dob)->format('j M Y') }}">
                                    </p>
                                   @endif
                                    <p>
                                       <label>Region</label>
                                       <input name="region" type="text" value="{{ $suburb->state_name ?? '' }}">
                                    </p>
                                   @if($profile->city_visibility==1)
                                    <p>
                                       <label>District/City</label>
                                       <input name="district" type="text" value="{{ $suburb->city_name??'' }}">
                                    </p>
                                   @endif
                                   @if($profile->suburb_visibility==1)
                                    <p>
                                       <label>Suburb/Town</label>
                                       <input name="suburb" type="text" value="{{ $suburb->suburb_name?? ($suburb->city_name??"") }}">
                                    </p>
                                   @endif
                                    <p>
                                       <label>Country</label>
                                       <input name="" type="text" value="{{ $suburb->country_name??'' }}">
                                    </p>
                                 </form>
                              </div>
                              <div class="profile_dashboard">
                                 <div id="accordion" class="prof_dasaccod">
                                    <h3 class="busi_tab">Business Listings <span class="number">{{ count($businessList) }}</span></h3>
                                    <div class="dash_content"> 
                                    <!--<a href="{{ route('add-your-business') }}" class="add_listbutton">Add Free Listing</a>-->
                                       <br class="clr">
                                       <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <!--<tr>-->
                                          <!--   <th align="center" valign="top">Image</th>-->
                                          <!--   <th align="left" valign="top" class="left">Title</th>-->
                                          <!--   <th align="center" valign="top">Active</th>-->
                                          <!--   <th align="left" valign="top">Views</th>-->
                                          <!--   <th align="left" valign="top">&nbsp;</th>-->
                                          <!--   <th align="left" valign="top">&nbsp;</th>-->
                                          <!--</tr>-->
                                          @if(!empty($businessList))
                                            @foreach($businessList as $business)
                                                  <tr>
                                                     <td align="center" valign="top" class="dash_pic">
                                                         @if($business->select_image) 
                                                            <img src="<?= asset($business->select_image) ?>" alt="" style="width:35%">
                                                         @else 
                                                            <img src="{{ asset('assets/images/cam_img.png') }}" alt="">
                                                         @endif
                                                        </td>
                                                     <td align="left" valign="top" class="left"><a href="{{ URL::to($country.'/business/'.$business->title_url."/".$business->sec_title_url."/".$business->slug) }}">{{ $business->display_name }}</a></td>
                                                     <td align="center" valign="top">
                                                         <!--<img src="{{ asset('assets/images/thikmark_icon.png') }}" alt="">-->
                                                    </td>
                                                     <td align="left" valign="top">
                                                         <!--<img src="{{ asset('assets/images/view_icon.png') }}" alt=""> 01-->
                                                         </td>
                                                     <td align="left" valign="top">
                                                         <!--<a href="#" class="edit">Edit <img src="{{ asset('assets/images/edit_icon.png') }}" alt=""></a>-->
                                                    </td>
                                                     <td align="left" valign="top">
                                                        <a href="{{ URL::to($country.'/business/'.$business->title_url."/".$business->sec_title_url."/".$business->slug) }}" class="edit">View <img src="{{ asset('assets/images/edit_icon.png') }}" alt=""></a>
                                                     </td>
                                                  </tr>
                                            @endforeach
                                          @endif
                                       </table>
                                    </div>
                                    <h3 class="nitice_tab">Notice Board <span class="number">{{ count($notice) }}</span></h3>
                                    <div class="dash_content"> 
                                       <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                             <th align="center" valign="top" class="left">Heading</th>
                                             <th align="left" valign="top">Category</th>
                                             <th align="center" valign="top">Active</th>
                                             <th align="left" valign="top">Views</th>
                                             <th align="left" valign="top">Expires</th>
                                             <th align="left" valign="top">&nbsp;</th>
                                          </tr>
                                          @foreach($notice as $n)
                                          <tr>
                                             <td align="center" valign="top" class="left">{{ $n->heading }}</td>
                                             <td align="left" valign="top">{{ $n->noticecategory->category ?? 'N/A' }}</td>
                                             <td align="center" valign="top"><img src="{{ asset('assets/images/thikmark_icon.png') }}" alt=""></td>
                                             <td align="left" valign="top"><img src="{{ asset('assets/images/view_icon.png') }}" alt=""> {{ $n->views }}</td>
                                             <td align="left" valign="top" class="expdate">{{ \Carbon\Carbon::parse($n->expire_at)->format('h:ia d/m/Y') }}</td>
                                             <td align="left" valign="top">
                                                <a href="{{ route('notice-board') }}" class="edit">View <img src="{{ asset('assets/images/edit_icon.png') }}" alt=""></a>
                                             </td>
                                          </tr>
                                          @endforeach
                                       </table>
                                    </div>
                                    <h3 class="article_tab">Articles Posted <span class="number">{{ count($articles) }}</span></h3>
                                    <div class="dash_content"> 
                                       <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                             <th align="center" valign="top" class="left">Heading</th>
                                             <th align="left" valign="top">Category</th>
                                             <th align="center" valign="top">Active</th>
                                             <th align="left" valign="top">Views</th>
                                             <th align="left" valign="top">&nbsp;</th>
                                          </tr>
                                          @foreach($articles as $article)
                                          <tr>
                                             <td align="center" valign="top" class="left">{{ $article->title }}</td>
                                             <td align="left" valign="top">{{ $article->category->title ?? 'N/A' }}</td>
                                             <td align="center" valign="top"><img src="{{ asset('assets/images/thikmark_icon.png') }}" alt=""></td>
                                             <td align="left" valign="top"><img src="{{ asset('assets/images/view_icon.png') }}" alt=""> {{ $article->views }}</td>
                                             <td align="left" valign="top">
                                                <a href="{{ route('article.details', $article->slug) }}" class="edit">View <img src="{{ asset('assets/images/edit_icon.png') }}" alt=""></a>
                                             </td>
                                          </tr>
                                          @endforeach
                                       </table>
                                    </div>
                                    <!--<h3 class="forum_tab"><a href="#">Forum Posts <span class="number">04</span> <span class="notify_forum">Please go to the main menu to view posts</span></a></h3>-->
                                    <!--<div class="dash_content">ddvdfdfdf</div>--></div>
                              </div>
                           </div>
                           <div>
                              <!--<div class="message_inbox">-->
                              <!--   <div class="msg_inbox">-->
                              <!--      <div class="msg_thum"> <img src="{{ asset('assets/images/profile_pic.png') }}" alt=""> <a href="#">Reply</a> </div>-->
                              <!--      <div class="msg_incontent">-->
                              <!--         <h3>Sanjy Website Designer <span>Thu, Jan 23, 2:49 PM</span></h3>-->
                              <!--         <h5>Message from listing page: KiwiHelp: Computer Tranining made easy</h5>-->
                              <!--         <p>Hello Andray. Can you please fix my computer. I am having trouble starting it and when it starts it goes very slow. Can you ring me on 04 593 5649. Its urgent to get sorted.</p>-->
                              <!--      </div>-->
                              <!--   </div>-->
                              <!--   <div class="msg_inbox">-->
                              <!--      <div class="msg_thum"> <img src="{{ asset('assets/images/no_pic.png') }}" alt=""> <a href="#">Reply</a> </div>-->
                              <!--      <div class="msg_incontent">-->
                              <!--         <h3>Monna <span>Thu, Jan 23, 2:49 PM</span></h3>-->
                              <!--         <h5>Message from listing page: KiwiHelp: Computer Tranining made easy</h5>-->
                              <!--         <p>I see you can assemble flat pac furniture. I have just purchased a office table from Warehouse Stationary and no idea or tools to assemble it. Are you able to come around and assemble it please. Can you tell me the approximate price it will be? I live in Paraparaumu. Thank you</p>-->
                              <!--      </div>-->
                              <!--   </div>-->
                              <!--   <div class="msg_inbox replysec"> <img src="{{ asset('assets/images/reply_icon.png') }}" alt="" class="reply_icon">-->
                              <!--      <div class="msg_thum"> <img src="{{ asset('assets/images/andray_pic.png') }}" alt=""> </div>-->
                              <!--      <div class="msg_incontent">-->
                              <!--         <h3>Andray Ochkas</h3>-->
                              <!--         <h5>Message from listing page: KiwiHelp: Computer Tranining made easy</h5>-->
                              <!--         <p>Thanks for your enquiry. I am happy to help. I can probably do it tomorrow afternoon around 3pm. My price will be $50.</p> <a href="#" class="send">Send</a> </div>-->
                              <!--   </div>-->
                              <!--</div>-->
                              @if(!empty($midData))
                                @foreach ($midData as $ad) 
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
                           <div>
                              
                             
                              <div class="setting_userbiogrph">
                                  
                                    <a href="{{ url()->previous()}}" class="profile_save"> Back</a>
                              </div>
                           </div>
                        </div>
                     </div>
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
 @include('includes/footer-js')    
@include('includes/footer')
