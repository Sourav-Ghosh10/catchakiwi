@include('includes/header')

<div>
   <!-- Header start-->
   <div class="top_bar inner">
      <div class="container">
         <div class="row">
            <div class="col-lg-2 col-md-2 col-sm-4 col-4">
               <!--<p class="nz_region">-->
               <!--    <select class="countryChange">-->
               <!--          <option value="IN" {{ (session('CountryCode')=="IN")?"selected":"" }}>IN-India</option>-->
               <!--          <option value="NZ" {{ (session('CountryCode')=="NZ")?"selected":"" }}>NZ-New Zealand</option>-->
               <!--          <option value="AU" {{ (session('CountryCode')=="AU")?"selected":"" }}>AU-Australia</option>-->
               <!--          <option value="CN" {{ (session('CountryCode')=="CN")?"selected":"" }}>CN-China</option>-->
               <!--          <option value="ENG" {{ (session('CountryCode')=="ENG")?"selected":"" }}>ENG-United Kingdom</option>-->
               <!--          <option value="US" {{ (session('CountryCode')=="US")?"selected":"" }}>US-United States</option>-->
               <!--      </select>-->
               <!--</p>-->

               <h1 class="inlogo"><a href="{{ URL::to('/') }}"><img
                        src="{{ asset('assets/images/logo-inner.png') }}"
                        alt /></a></h1>

            </div>
            <div class="col-lg-10 col-md-10 col-sm-8 col-8 top_menu">
               @include('includes/topmenu')
               @include('includes/sidemenu')
            </div>
         </div>
      </div>
   </div>
   <div class="top_search nomob_search">
      <!--<div class="container">-->
      <!--   <div class="logo">-->
      <!--      <h1><a href="{{ URL::to('/') }}"><img src="{{ asset('assets/images/logo-inner.png') }}" alt="" /></a></h1>-->
      <!--   </div>-->
      <!--</div>-->
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
      <!--</div>-->
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

               <form name="profile_photo" id="profile_photo"
                  enctype="multipart/form-data"
                  action="{{route('store.profilepic')}}" method="POST"
                  class="avatar-upload">
                  <div class="avatar-edit">
                     <input type='file' id="imageUpload"
                        accept=".png, .jpg, .jpeg" name="imageUpload"
                        class=" imageUpload" />
                     <input type="hidden" name="base64image" name="base64image"
                        id="base64image">
                     <label for="imageUpload"></label>
                  </div>
                  <div class="avatar-preview container2">
                     @php
                     if(!empty($profile->image) && $profile->image!=''){
                     $image =$profile->image;
                     }else{
                     $image = Auth::user()->profile_photo_url;
                     }
                     $url = url($image);
                     $imgs = "background-image:url($url)";

                     @endphp
                     <div id="imagePreview" style="{{ $imgs }}">
                        <input type="hidden" name="_token"
                           value="{{csrf_token()}}">
                        <input style="margin-top: 60px; visibility: hidden;"
                           type="submit" class="btn btn-warning" value="Save">
                     </div>
                  </div>
               </form>
               <div class="modal fade bd-example-modal-lg imagecrop" id="model"
                  tabindex="-1" role="dialog"
                  aria-labelledby="myLargeModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-lg">
                     <div class="modal-content">
                        <div class="modal-header">
                           <h5 class="modal-title" id="exampleModalLabel">Crop your cover image</h5>
                           <button type="button" class="close"
                              data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                           </button>
                        </div>
                        <div class="modal-body">
                           <div class="img-container">
                              <div class="row">
                                 <div class="col-md-11">
                                    <img id="image"
                                       src="https://avatars0.githubusercontent.com/u/3456749">
                                 </div>
                              </div>
                           </div>
                        </div>
                        <input type="hidden" id="uploadtype" value>
                        <div class="modal-footer">
                           <button type="button" class="btn btn-secondary"
                              data-dismiss="modal">Close</button>
                           <button type="button" class="btn btn-primary crop"
                              id="crop">Crop</button>
                        </div>
                     </div>
                  </div>
               </div>

            </div>
         </div>
         <div class="profile_heading">
            <h1>Dashboard</h1>
            <!--<h2>About Me</h2>-->
            <p class="profile_para">{{$profile->aboutus}}</p>
         </div>
         <div class="full_midpan">
            <div class="row">
               <div class="col-lg-8 col-md-8 col-sm-12">
                  <div class="left_profileform">
                     <div id="parentHorizontalTab" class="profiletab">
                        <ul class="resp-tabs-list hor_1">
                           <li class="profile">Public Profile</li>
                           <li class="message">Listings <span>({{
                                 count($businessList) + count($articles) + count($notice)}})</span></li>
                           <li class="imagesss">Messages</li>
                           <li class="setting">Settings</li>
                        </ul>
                        <div class="resp-tabs-container hor_1">
                           <div class="profilepublic">
                              <div class="profiletab_namdetls">
                                 @if($profile->name)
                                      @php
                                          $nameArray = explode(" ", trim($profile->name));

                                          $firstname = array_shift($nameArray);       // First word
                                          $lastname  = implode(" ", $nameArray);      // Remaining words
                                      @endphp
                                  @endif
                                 <form action method="post">
                                    <p>
                                       <label>Username</label>
                                       <input name="name" type="text"
                                          value="{{ $profile->name }}">
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
                                       <input name="region" type="text"
                                          value="{{ $suburb->state_name ?? '' }}">
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
                                       <input name type="text"
                                          value="{{ $suburb->country_name??'' }}">
                                    </p>
                                 </form>
                              </div>
                              <!-- <div>Dashboard Goes here</div> -->
                           </div>
                           <div class="setting_tabbasic">
                              <div class="profile_dashboard">
                                 <!--<h2>Dashboard</h2>-->
                                 <div id="accordion" class="prof_dasaccod">
                                    <h3 class="busi_tab">Business Listings <span
                                          class="number">{{ count($businessList)
                                          }}</span></h3>
                                    <div class="dash_content"> <a
                                          href="{{ route('add-your-business') }}"
                                          class="add_listbutton">Add Free
                                          Listing</a>
                                       <br class="clr">
                                       <div class="div_scroll">
                                          <table width="100%" border="0"
                                             cellspacing="0" cellpadding="0">
                                             <tr>
                                                <th align="center"
                                                   valign="top">Image</th>
                                                <th align="left" valign="top"
                                                   class="left">Title</th>
                                                <th align="center"
                                                   valign="top">Status</th>
                                                <th align="left"
                                                   valign="top">Views</th>
                                                <th align="left"
                                                   valign="top">&nbsp;</th>
                                                <th align="left"
                                                   valign="top">&nbsp;</th>
                                             </tr>
                                             @if(!empty($businessList))
                                             @foreach($businessList as
                                             $business)
                                             <tr>
                                                <td align="center" valign="top"
                                                   class="dash_pic">
                                                   @if($business->select_image)
                                                   <img
                                                      src="<?= asset($business->select_image) ?>"
                                                      alt style="width:35%">
                                                   @else
                                                   <img
                                                      src="{{ asset('assets/images/cam_img.png') }}"
                                                      alt>
                                                   @endif
                                                </td>
                                                <td align="left" valign="top"
                                                   class="left"><a
                                                      href="<?= url("/".strtolower($business->shortname)."/business/{$business->slug}/{$business->slug}/{$business->slug}")
                                                      ?>">{{
                                                      $business->display_name
                                                      }}</a></td>
                                                <td align="center" valign="top"
                                                   class="stuaactive">
                                                    <select class="change-business-status" data-id="{{ $business->id }}">
                                                       <option value="1" {{ $business->status == '1' ? 'selected' : '' }}>Active</option>
                                                       <option value="0" {{ $business->status == '0' ? 'selected' : '' }}>Inactive</option>
                                                    </select>
                                                   <!-- <img src="{{ asset('assets/images/thikmark_icon.png') }}" alt=""> -->
                                                </td>
                                                <td align="left"
                                                   valign="top"><img
                                                      src="{{ asset('assets/images/view_icon.png') }}"
                                                      alt> {{$business->view_count}}</td>
                                                <td align="left" valign="top"><a
                                                      href="{{ route('business.list.edit', $business->id) }}"
                                                      class="edit">Edit <img
                                                         src="{{ asset('assets/images/edit_icon.png') }}"
                                                         alt></a></td>
                                                <td align="left" valign="top">
                                                    <form action="{{ route('business.list.delete', $business->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this business? This action cannot be undone.');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="delete" style="background:none; border:none; padding:0; cursor:pointer;">
                                                            <img src="{{ asset('assets/images/delete_icon.png') }}" alt>
                                                        </button>
                                                    </form>
                                                </td>
                                             </tr>
                                             @endforeach
                                             @endif
                                          </table>
                                       </div>
                                    </div>
                                    <h3 class="nitice_tab">Notice Board <span
                                          class="number">{{ count($notice) }}</span></h3>
                                    <div class="dash_content">
                                       <a href="{{ route('notice-post') }}"
                                          class="add_listbutton">Post New
                                          Notice</a>
                                       <br class="clr">
                                       <div class="div_scroll">
                                          <table width="100%" border="0"
                                             cellspacing="0" cellpadding="0">
                                             <tr>
                                                <th align="center" valign="top"
                                                   class="left">Heading</th>
                                                <th align="left"
                                                   valign="top">Category</th>
                                                <th align="center"
                                                   valign="top">Active</th>
                                                <th align="left"
                                                   valign="top">Views</th>
                                                <th align="left"
                                                   valign="top">Expires</th>
                                                <th align="left"
                                                   valign="top">&nbsp;</th>
                                                <th align="left"
                                                   valign="top">&nbsp;</th>
                                             </tr>

                                          </table>
                                       </div>
                                    </div>
                                    <h3 class="article_tab">Articles Posted
                                       <span class="number">{{ count($articles) }}</span></h3>
                                    <div class="dash_content"> <a href="{{ route('article.add') }}"
                                          class="add_listbutton">Post New
                                          Article </a>
                                       <br class="clr">
                                       <div class="div_scroll">
                                          <table width="100%" border="0"
                                             cellspacing="0" cellpadding="0">
                                             <tr>
                                                <th align="center" valign="top"
                                                   class="left">Heading</th>
                                                <th align="left"
                                                   valign="top">Category</th>
                                                <th align="center"
                                                   valign="top">Status</th>
                                                <th align="left"
                                                   valign="top">Views</th>
                                                <th align="left"
                                                   valign="top">&nbsp;</th>
                                                <th align="left"
                                                   valign="top">&nbsp;</th>
                                             </tr>
                                             @if(!empty($articles))
                                             @foreach($articles as $article)
                                             <tr>
                                                <td align="left" valign="top" class="left">
                                                   <a href="{{ route('article.details', $article->slug) }}">{{ $article->title }}</a>
                                                </td>
                                                <td align="left" valign="top">
                                                   {{ $article->category->title ?? 'N/A' }}
                                                </td>
                                                <td align="center" valign="top">
                                                   <span class="badge badge-{{ $article->status == 'published' ? 'success' : 'warning' }}">
                                                      {{ ucfirst($article->status) }}
                                                   </span>
                                                </td>
                                                <td align="left" valign="top">
                                                   <img src="{{ asset('assets/images/view_icon.png') }}" alt=""> {{ $article->views }}
                                                </td>
                                                <td align="left" valign="top">
                                                   <a href="{{ route('article.user-edit', $article->id) }}" class="edit">
                                                      Edit <img src="{{ asset('assets/images/edit_icon.png') }}" alt="">
                                                   </a>
                                                </td>
                                                <td align="left" valign="top">
                                                    <form action="{{ route('article.user-delete', $article->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this article? This action cannot be undone.');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                                    </form>
                                                </td>
                                             </tr>
                                             @endforeach
                                             @endif
                                          </table>
                                       </div>
                                    </div>
                                    <h3 class="forum_tab"><a href="#">Forum
                                          Posts <span class="number">0</span>
                                          <span class="notify_forum">Please go
                                             to the main menu to view
                                             posts</span></a></h3>
                                    <!--<div class="dash_content">ddvdfdfdf</div>--></div>
                              </div>

                              @if(!empty($midData))
                              @foreach ($midData as $ad)
                              @if($ad->ads_image!="")
                              <img src="{{ asset($ad->ads_image) }}" alt>
                              @endif
                              @endforeach
                              @endif
                           </div>
                           <div class="setting_tabbasic">

                              <div class="newmsgchatbox">
                                 <!-- Chat design -->
                                 <div class="chat-container">
                                    <!-- Chat List -->
                                    <div class="chat-list" id="chatList">
                                       <div class="title-bar">
                                          📩 Messages
                                       </div>
                                       <div class="search-bar">
                                           <input type="text" id="searchInput"
                                             placeholder="Search...">
                                       </div>
                                       <!-- Chat items generated dynamically -->
                                    </div>

                                    <!-- Chat Box (Desktop) -->
                                    <div class="chat-box" id="chatBox">
                                       <div class="chat-header">
                                          <img id="chatImg"
                                             src="{{ asset('assets/images/andray_pic.png') }}"
                                             alt="Andray">
                                          <span class="user"
                                             id="chatName">Andray</span>
                                       </div>
                                       <div class="messages"
                                          id="desktopMessages"></div>
                                       <div class="input-box">
                                          <textarea id="msgInput"
                                             placeholder="Type a message..." rows="1"></textarea>
                                          <button id="sendBtn">Send</button>
                                       </div>
                                    </div>
                                 </div>
                                 <!-- Chat design end-->
                              </div>

                           </div>

                           <div class="setting_tabbasic">
                              <h2>Visibility Profile</h2>
                              <div class="frm_dv" id="nameSection">
                                  <label>Display Username *</label>

                                  <!-- Current name (read-only until edit) -->
								  <input name="name" type="text" id="displayName" 
                                         value="{{ $profile->name }}" readonly>
                                  <!-- Hidden input that appears only in edit mode -->
                                  <input name="name" type="text" id="editNameInput" 
                                         value="{{ $profile->name }}" style="display:none;">

                                  <select id="nameVisibility" disabled style="display:none">
                                      <option value="0" {{ ($profile->name_visibility ?? 1) == 0 ? 'selected' : '' }}>Hidden</option>
                                      <option value="1" {{ ($profile->name_visibility ?? 1) == 1 ? 'selected' : '' }}>Visible</option>
                                  </select>

                                  <!-- Edit / Submit / Close buttons -->
                                  <a href="#" class="edit name-edit">Edit 
                                      <img src="{{ asset('assets/images/edit_icon.png') }}" alt="edit">
                                  </a>
                                  <a href="#" class="edit name-submit text-success" style="display:none;">Save</a>
                                  <a href="#" class="edit name-close text-danger" style="display:none;">Close</a>

                                  <div class="text-success mt-2" id="nameSuccess" style="display:none;">
                                      Username updated successfully!
                                  </div>
                                  <div class="text-danger mt-2" id="nameError" style="display:none;"></div>
                              </div>
                              <div class="frm_dv" id="firstNameSection">
                                 <label>First Name *</label>
                                <input type="text" id="displayFirstName" value="{{ $profile->firstname ?? $firstname }}" class="fullnmshow"  maxlength="100" readonly>
                                <input type="text" id="editFirstName" value="{{ $profile->firstname ?? $firstname }}" class="fullnmedit" style="display:none;" maxlength="100">
                                 <select class="update-address-visibility" id="fname_visibility">
                                      <option value="0" {{ ($profile->fname_visibility ?? 1) == 0 ? 'selected' : '' }}>Hidden</option>
                                      <option value="1" {{ ($profile->fname_visibility ?? 1) == 1 ? 'selected' : '' }}>Visible</option>
                                  </select>  
                                  <a href="#" class="edit fname-edit">
                                      Edit <img src="{{ asset('assets/images/edit_icon.png') }}" alt="edit">
                                  </a>
                                  <a href="#" class="edit fname-save text-success" style="display:none;">Save</a>
                                  <a href="#" class="edit fname-close text-danger" style="display:none;">Close</a>
                             </div>
                              <div class="frm_dv" id="lastNameSection">
                                 <label>Last Name *</label>
                                 <input name="lastname" type="text" id="displayLastName" value="{{ $profile->lastname ?? $lastname }}" class="fullnmshow" readonly>
                                <input type="text" id="editLastName" value="{{ $profile->lastname ?? $lastname }}" class="fullnmedit" style="display:none;" maxlength="100">
                                 <select class="update-address-visibility" id="lname_visibility">
                                      <option value="0" {{ ($profile->lname_visibility ?? 1) == 0 ? 'selected' : '' }}>Hidden</option>
                                      <option value="1" {{ ($profile->lname_visibility ?? 1) == 1 ? 'selected' : '' }}>Visible</option>
                                  </select> 
                                  <a href="#" class="edit lname-edit">
                                      Edit <img src="{{ asset('assets/images/edit_icon.png') }}" alt="edit">
                                  </a>
                                  <a href="#" class="edit lname-save text-success" style="display:none;">Save</a>
                                  <a href="#" class="edit lname-close text-danger" style="display:none;">Close</a>
                             </div>
                              <div class="frm_dv" id="dobSection">
                                  <label>Date of Birth *</label>

                                  <!-- Display current DOB (pretty format) -->
                                  
								  <input type="date" id="displayDob" value="{{ $profile->dob }}" readonly>
                                  <!-- Hidden date picker (appears on edit) -->
                                  <input type="date" id="editDob" value="{{ $profile->dob }}" style="display:none;">

                                  <select name="dob_visibility" id="dobVisibility" disabled>
                                      <option value="0" {{ ($profile->dob_visibility ?? 0) == 0 ? 'selected' : '' }}>Hidden</option>
                                      <option value="1" {{ ($profile->dob_visibility ?? 0) == 1 ? 'selected' : '' }}>Visible</option>
                                  </select>

                                  <a href="#" class="edit dob-edit">
                                      Edit <img src="{{ asset('assets/images/edit_icon.png') }}" alt="edit">
                                  </a>
                                  <a href="#" class="edit dob-submit" style="display:none;">Save</a>
                                  <a href="#" class="edit dob-close" style="display:none;">Close</a>

                                  <div class="text-success mt-2" id="dobSuccess" style="display:none;">Date of birth updated!</div>
                              </div>
                              <div class="frm_dv ">
                                 <label>Country *</label>
                                 <select  class="selectdrop" id="country" disabled>
                                    @foreach($country as $cnty):
                                      <option value="{{ $cnty['id'] }}" {{ isset($suburb->country_name) && $cnty['name'] == $suburb->country_name?"selected":"" }}>{{ $cnty['name'] ?? ''
                                         }}</option>
                                    @endforeach
                                   </select>
                                 <select id="countryVisibility" disabled style="display:none">
                                      <option value="0" {{ ($profile->country_visibility ?? 1) == 0 ? 'selected' : '' }}>Hidden</option>
                                      <option value="1" {{ ($profile->country_visibility ?? 1) == 1 ? 'selected' : '' }}>Visible</option>
                                  </select> 
                                <a href="#" class="edit addressedit">Location Edit <img
                                       src="{{ asset('assets/images/edit_icon.png') }}"
                                       alt></a>
                             	<a href="#" class="edit addresssubmit" style="display:none;">Save</a>
                                <a href="#" class="edit addressclose" style="display:none;">Close</a>
                             </div>
                             
                               <div class="frm_dv editsuburb" style="display:none;">
                                   <label>Suburb/City *</label>
                                   <select class="livesearch selectdrop" name="towns_id" id="towns_id" placeholder="Type Suburb/City" ></select>
                                </div>
                             
                              <div class="frm_dv showaddress">
                                 <label>Region *</label>
                                 <select class="selectdrop">
                                    <option>{{ $suburb->state_name ?? ''
                                       }}</option>
                                 </select>
                                 <select name style="display:none">
                                    <option>Hidden</option>
                                    <option>Visible</option>
                                 </select> 
                                <!--<a href="#" class="edit">Edit <img src="{{ asset('assets/images/edit_icon.png') }}" alt></a> -->
                             </div>
                              <div class="frm_dv showaddress">
                                 <label>City or District *</label>
                                 <select class="selectdrop">
                                    <option>{{ $suburb->city_name??''
                                       }}</option>
                                 </select>
                                 <select class="update-address-visibility" id="city_visibility">
                                      <option value="0" {{ ($profile->city_visibility ?? 1) == 0 ? 'selected' : '' }}>Hidden</option>
                                      <option value="1" {{ ($profile->city_visibility ?? 1) == 1 ? 'selected' : '' }}>Visible</option>
                                  </select> 
                                <!--<a href="#" class="edit">Edit <img src="{{ asset('assets/images/edit_icon.png') }}" alt></a> --> 
                             </div>
                             <div class="frm_dv showaddress">
                                 <label>Suburb/Town *</label>
                                 <select class="selectdrop">
                                    <option>{{ $suburb->suburb_name??($suburb->city_name??"") }}</option>
                                 </select>
                                 <select class="update-address-visibility" id="suburb_visibility">
                                      <option value="0" {{ ($profile->suburb_visibility ?? 1) == 0 ? 'selected' : '' }}>Hidden</option>
                                      <option value="1" {{ ($profile->suburb_visibility ?? 1) == 1 ? 'selected' : '' }}>Visible</option>
                                  </select> 
                               <!--<a href="#" class="edit">Edit <img src="{{ asset('assets/images/edit_icon.png') }}" alt></a> --> 
                             </div>
                              <h2>Change Email</h2>
                              <div class="frm_dv email" id="emailSection">
                                  <label>Account Email *</label>

                                  <!-- Display current email -->
                                  <input type="email" id="displayEmail" value="{{ $profile->email }}" readonly>

                                  <!-- Edit mode input -->
                                  <input type="email" id="editEmail" value="{{ $profile->email }}" style="display:none;" class="form-control">

                                  

                                  <a href="#" class="edit email-edit">
                                      Edit <img src="{{ asset('assets/images/edit_icon.png') }}" alt="edit">
                                  </a>
                                  <a href="#" class="edit email-save text-success" style="display:none;">Submit</a>
                                  <a href="#" class="edit email-close text-danger" style="display:none;">Close</a>

                                  <div class="text-success mt-2" id="emailSuccess" style="display:none;">Email change request sent!</div>
                                  <div class="text-danger mt-2" id="emailError" style="display:none;"></div>
                                  <!-- Pending message -->
                                  @if($profile->temp_email)
                                      <div class="text-warning mt-2">
                                          <small><strong>Pending Email Change:</strong> {{ $profile->temp_email }} (Awaiting admin approval)</small>
                                      </div>
                                  @endif
                              </div>
                             <h2>Change Password</h2>
                            <div class="frm_dv pass" id="passwordSection">

                                <!-- Main Label (initial state) -->
                                <div id="initialState">
                                    <label>New Password</label>
                                    <input type="password" id="displayPassword" value="********" disabled class="form-control" style="background:#f9f9f9;">
                                    <a href="#" class="pass_resetbutt" id="changeBtn">Change</a>
                                </div>

                                <!-- Edit State -->
                                <div id="editState" style="display:none;">
                                    <label>New Password</label>
                                    <input type="password" id="newPassword" placeholder="Enter new password" class="form-control">
                                    
                                    <a href="#" class="edit text-success" id="saveBtn">Save</a>
                                    <a href="#" class="edit text-danger" id="closeBtn">Close</a>
                                </div>

                                <!-- OTP State (only this shows after Save) -->
                                <div id="otpState" style="display:none;">
                                    <label>Enter OTP</label>
                                    <input type="text" id="otpInput" placeholder="6-digit OTP" maxlength="6" class="form-control">
                                        <button type="button" id="verifyBtn" class="btn btn-success btn-sm">Verify</button>
                                        <button type="button" id="resendBtn" class="btn btn-outline-secondary btn-sm">Resend OTP</button>
                                </div>

                                <!-- Messages -->
                                <div class="text-success mt-2" id="successMsg" style="display:none;"></div>
                                <div class="text-danger mt-2" id="errorMsg" style="display:none;"></div>
                            </div>
                              <!--<div class="frm_dv pass">
                                          <label>Repeat Password</label>
                                          <input name="" type="password" placeholder="Password">
                                          <a href="#" class="edit">Edit <img src="images/edit_icon.png" alt=""></a>
                                          </div>-->
                            <div class="setting_usermsg">
                              <h2>Message Settings</h2>
                              <label>Send an email notice when:</label>
                              <div class="frm_div">
                                 <label>A member sends you a new
                                    message</label>
                                 <input name type="radio" value> Yes
                                 <input name type="radio" value> No </div>
                           </div>
                           <div class="setting_usermsg profiletabimg">
                              <h2>Change Profile Images</h2>
                              <div class="setting_tabprofilepic"
                                 id="proaccordion">
                                 <h3>Change Cover Photo </h3>
                                 <div class="probrowse_content">
                                    <form
                                       action="{{ route('store.profilebanner') }}"
                                       id="profilecoverbanner" method="POST"
                                       enctype="multipart/form-data">
                                       @csrf
                                       <div class="form-group">
                                         <div class="browsepic bdrbox"><img src="{{ asset($profile->profile_banner) }}" alt></div>
                                         <div class="newupload">
                                           <label>Update Your Cover Photo</label>
                                           <div class=customupbtn>
                                          <input type="file" name="profile_banner" id="coverupload" class="form-control imageUpload">
                                          <input type="hidden" name="base64coverimage"  id="base64coverimage" value>
                                         </div>
                                         </div>
                                          
                                          
                                          <!--  <input type="submit" name="submit" value="submit"> -->
                                       </div>
                                    </form>
                                 </div>
                                 <h3>Change Profile Photo</h3>
                                 <div class="probrowse_content">
                                    <div class="form-group">
                                      <div class="browsepic bdrbox"><img  src="{{ $url }}" alt></div>
                                      <div class="newupload">
                                      <label>Update Your Profile Photo</label>
                                      <div class=customupbtn>
                                       <input type="file" id="imageUpload" accept=".png, .jpg, .jpeg" name="imageUpload" class=" imageUpload">
                                       <input type="hidden"  name="base64coverimage" id="base64coverimage" value>
                                      </div>
                                      </div>
                                      
                                       
                                       <!--<input type="submit" name="submit" value="submit"> -->
                                    </div>
                                    <!-- <img src="{{ asset('assets/images/browse_img.png') }}" alt=""> -->
                                 </div>
                              </div>
                           </div>
                           <div class="setting_userbiogrph">
                              <form action="{{ route('store.aboutus') }}"
                                 method="POST" enctype="multipart/form-data">
                                 @csrf
                                 <h2>About the user</h2>
                                 <p>(Share a little biographical information
                                    about you, with your profile. This will
                                    be shown publicly.)</p>
                                 <textarea name="aboutus" cols rows
                                    placeholder="Enter your Biographical Info">{{$profile->aboutus}}</textarea>
                                 <input name type="submit"
                                    class="profile_save floating"
                                    value="Save Changes">
                                 <a href="{{ URL::to('/profile') }}"
                                    class="editcancelbtn">Cancel</a>
                              </form>
                           </div>
                                       </div>

                          
                        
                                    </div>
                     </div>
                  </div>
               </div>
               <div class="col-lg-4 col-md-4 col-sm-12">
                  <div class="right_advertisesec">
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

                  <!-- Modal -->
                  <div id="imageModal" class="modal">
                     <div class="modal-inner">
                        <span class="closes">&times;</span>
                        <img class="modal-content" id="modalImage">
                        <a id="visitLink" class="visit-btn" href="#"
                           target="_blank">More Info</a>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <script>
document.addEventListener("DOMContentLoaded", function () {
  const images = document.querySelectorAll(".ad-image");
  const modal = document.getElementById("imageModal");
  const modalImg = document.getElementById("modalImage");
  const closeBtn = document.querySelector(".closes");
  const visitBtn = document.getElementById("visitLink");

  images.forEach(image => {
    image.addEventListener("click", function () {
      modal.style.display = "block";
      modalImg.src = this.dataset.img;
      visitBtn.href = this.dataset.link;
    });
  });

  closeBtn.addEventListener("click", function () {
    modal.style.display = "none";
  });

  // Also close modal if clicking outside modal-inner
  modal.addEventListener("click", function (e) {
    if (e.target === modal) {
      modal.style.display = "none";
    }
  });
});
</script>
   <script>
  /* --------------------------------------------------------------
   CHAT  ONE-POLLING, NO DUPLICATE LISTENERS
   -------------------------------------------------------------- */
// const chatList       = document.getElementById("chatList");
// const desktopMessages = document.getElementById("desktopMessages");
// const chatName        = document.getElementById("chatName");
// const chatImg         = document.getElementById("chatImg");
// const msgInput        = document.getElementById("msgInput");
// const sendBtn         = document.getElementById("sendBtn");
// let pollingInterval   = null;               // **only one**
// let currentChatId     = null;               // remember which chat is open
// const csrfToken       = document.querySelector('meta[name="csrf-token"]').content;

// /* --------------------------------------------------------------
//    1. BUILD CHAT LIST (called only once)
//    -------------------------------------------------------------- */
// function fetchChatList() {
//     fetch('/chat/list', {
//         headers: { 'Accept':'application/json', 'X-Requested-With':'XMLHttpRequest' }
//     })
//     .then(r => r.json())
//     .then(users => {
//         // ---- clear old items (except title & search) ----
//         const keep = chatList.querySelectorAll('.title-bar, .search-bar');
//         chatList.innerHTML = '';
//         keep.forEach(el => chatList.appendChild(el));

//         users.forEach(u => {
//             const item = document.createElement('div');
//             item.className = 'chat-item';
//             item.dataset.id   = u.id;
//             item.dataset.name = u.name;
//             item.dataset.img  = u.image;

//             item.innerHTML = `
//                 <div class="chat-header-item">
//                     <div class="left">
//                         <img src="${u.image}" alt="${u.name}">
//                         <div class="name-msg">
//                             <span>${u.name}</span>
//                             <div class="last-msg">${u.last_message}</div>
//                         </div>
//                     </div>
//                     <div class="time">
//                         ${u.last_message_time.split(',')[0]}
//                         ${u.unread_count ? `<span class="unread-badge">${u.unread_count}</span>` : ''}
//                     </div>
//                 </div>
//                 <div class="accordion-content"></div>
//             `;
//             chatList.appendChild(item);
//         });

//         attachChatItemEvents();               // <-- **once**
//         if (users.length) openChat(users[0].id, users[0].name, users[0].image);
//     })
//     .catch(console.error);
// }

// /* --------------------------------------------------------------
//    2. CLICK HANDLERS  attached **once**
//    -------------------------------------------------------------- */
// function attachChatItemEvents() {
//     chatList.querySelectorAll('.chat-header-item').forEach(header => {
//         header.addEventListener('click', () => {
//             const item = header.parentElement;
//             const id   = item.dataset.id;
//             const name = item.dataset.name;
//             const img  = item.dataset.img;

//             if (window.innerWidth > 768) {
//                 chatList.querySelectorAll('.chat-item').forEach(i => i.classList.remove('active'));
//                 item.classList.add('active');
//                 openChat(id, name, img);
//             } else {
//                 chatList.querySelectorAll('.accordion-content').forEach(c => c.classList.remove('show'));
//                 const content = item.querySelector('.accordion-content');
//                 loadChatMobile(content, id);
//                 content.classList.add('show');
//             }
//         });
//     });
// }

// /* --------------------------------------------------------------
//    3. OPEN A CHAT (desktop)  one polling interval only
//    -------------------------------------------------------------- */
// function openChat(id, name, img) {
//     if (currentChatId === id) return;           // already open  nothing
//     currentChatId = id;

//     // stop previous polling
//     if (pollingInterval) clearInterval(pollingInterval);

//     desktopMessages.innerHTML = '';
//     chatName.textContent = name;
//     chatImg.src = img;

//     fetchMessages(id);
//     pollingInterval = setInterval(() => fetchMessages(id), 5000);

//     // ---- refresh only the badges (lightweight) ----
//     refreshBadges();
// }

// /* --------------------------------------------------------------
//    4. FETCH MESSAGES + render with seen icon
//    -------------------------------------------------------------- */
// function renderMessage(msg, container) {
//     const div = document.createElement('div');
//     div.className = 'msg ' + msg.type;

//     if (msg.type === 'other') {
//         div.innerHTML = `<div class="sender">${msg.sender}</div>${msg.text}<span class="msg-time">${msg.time}</span>`;
//     } else {
//         const icon = msg.seen
//             ? '<span class="seen-icon">Seen</span>'
//             : '<span class="seen-icon">Sent</span>';
//         div.innerHTML = `${msg.text}<span class="msg-time">${msg.time}</span>${icon}`;
//     }
//     container.appendChild(div);
// }

// function fetchMessages(id) {
//     fetch(`/chat/messages/${id}`, {
//         headers: { 'Accept':'application/json', 'X-Requested-With':'XMLHttpRequest' }
//     })
//     .then(r => r.json())
//     .then(msgs => {
//         desktopMessages.innerHTML = '';
//         msgs.forEach(m => renderMessage(m, desktopMessages));
//         desktopMessages.scrollTop = desktopMessages.scrollHeight;
//     })
//     .catch(console.error);
// }

// /* --------------------------------------------------------------
//    5. MOBILE  accordion version (unchanged logic, just uses renderMessage)
//    -------------------------------------------------------------- */
// function loadChatMobile(container, id) {
//     container.innerHTML = '';
//     const wrap = document.createElement('div');
//     wrap.className = 'messages';

//     fetch(`/chat/messages/${id}`, {
//         headers: { 'Accept':'application/json', 'X-Requested-With':'XMLHttpRequest' }
//     })
//     .then(r => r.json())
//     .then(msgs => {
//         msgs.forEach(m => renderMessage(m, wrap));
//         container.appendChild(wrap);

//         const inputBox = document.createElement('div');
//         inputBox.className = 'input-box';
//         inputBox.innerHTML = `
//             <form class="mobile-message-form">
//                 <input type="hidden" name="_token" value="${csrfToken}">
//                 <input type="hidden" name="receiver_id" value="${id}">
//                 <input type="text" name="message" placeholder="Type a message...">
//                 <button type="submit">Send</button>
//             </form>`;
//         container.appendChild(inputBox);

//         inputBox.querySelector('.mobile-message-form')
//             .addEventListener('submit', e => {
//                 e.preventDefault();
//                 const txt = e.target.message.value.trim();
//                 if (txt) {
//                     sendMessage(id, txt, container);
//                     e.target.message.value = '';
//                 }
//             });
//     });
// }

// /* --------------------------------------------------------------
//    6. SEND MESSAGE (desktop + mobile)
//    -------------------------------------------------------------- */
// function sendMessage(receiverId, text, mobileContainer = null) {
//     if (!text) return;

//     fetch('/chat/send', {
//         method: 'POST',
//         headers: {
//             'Content-Type': 'application/json',
//             'Accept': 'application/json',
//             'X-Requested-With': 'XMLHttpRequest',
//             'X-CSRF-TOKEN': csrfToken
//         },
//         body: JSON.stringify({ receiver_id: receiverId, message: text })
//     })
//     .then(r => r.json())
//     .then(msg => {
//         // append instantly (optimistic UI)
//         const div = document.createElement('div');
//         div.className = 'msg me';
//         div.innerHTML = `${msg.text}<span class="msg-time">${msg.time}</span><span class="seen-icon">Sent</span>`;

//         if (window.innerWidth > 768) {
//             desktopMessages.appendChild(div);
//             desktopMessages.scrollTop = desktopMessages.scrollHeight;
//         } else if (mobileContainer) {
//             const wrap = mobileContainer.querySelector('.messages');
//             wrap.appendChild(div);
//             wrap.scrollTop = wrap.scrollHeight;
//         }

//         // refresh badge for the *other* user (lightweight)
//         refreshBadges();
//     })
//     .catch(console.error);
// }

// /* --------------------------------------------------------------
//    7. REFRESH ONLY UNREAD BADGES (no full list rebuild)
//    -------------------------------------------------------------- */
// function refreshBadges() {
//     fetch('/chat/unread', {
//         headers: { 'Accept':'application/json', 'X-Requested-With':'XMLHttpRequest' }
//     })
//     .then(r => r.json())
//     .then(counts => {
//         document.querySelectorAll('.chat-item').forEach(item => {
//             const uid = item.dataset.id;
//             const badge = item.querySelector('.unread-badge');
//             const cnt   = counts[uid] ?? 0;

//             if (cnt) {
//                 if (!badge) {
//                     const timeDiv = item.querySelector('.time');
//                     const span = document.createElement('span');
//                     span.className = 'unread-badge';
//                     span.textContent = cnt;
//                     timeDiv.appendChild(span);
//                 } else {
//                     badge.textContent = cnt;
//                 }
//             } else if (badge) {
//                 badge.remove();
//             }
//         });
//     });
// }

// /* --------------------------------------------------------------
//    8. DESKTOP SEND BUTTON
//    -------------------------------------------------------------- */
// sendBtn.addEventListener('click', () => {
//     const active = document.querySelector('.chat-item.active');
//     if (active) {
//         const id = active.dataset.id;
//         sendMessage(id, msgInput.value);
//         msgInput.value = '';
//     }
// });

// /* --------------------------------------------------------------
//    9. INITIALISE
//    -------------------------------------------------------------- */
// fetchChatList();          // builds list + attaches listeners once
// setInterval(refreshBadges, 15000);   // keep badges fresh even when no chat is open
     
/* =============================================================
   GLOBAL ELEMENTS
   ============================================================= */
const chatList       = document.getElementById("chatList");
const desktopMessages = document.getElementById("desktopMessages");
const chatName        = document.getElementById("chatName");
const chatImg         = document.getElementById("chatImg");
const msgInput        = document.getElementById("msgInput");
const sendBtn         = document.getElementById("sendBtn");
let pollingInterval   = null;
let currentChatId     = null;               // <-- remember open chat
const csrfToken       = document.querySelector('meta[name="csrf-token"]').content;

/* --------------------------------------------------------------
   1. BUILD CHAT LIST (once)
   -------------------------------------------------------------- */
function fetchChatList() {
    fetch('/chat/list', {
        headers: { 'Accept':'application/json', 'X-Request-With':'XMLHttpRequest' }
    })
    .then(r => r.json())
    .then(users => {
        // keep title & search bar
        const keep = chatList.querySelectorAll('.title-bar, .search-bar');
        chatList.innerHTML = '';
        keep.forEach(el => chatList.appendChild(el));

        users.forEach(u => {
            const item = document.createElement('div');
            item.className = 'chat-item';
            item.dataset.id   = u.id;
            item.dataset.name = u.name;
            item.dataset.img  = u.image;

            item.innerHTML = `
                <div class="chat-header-item">
                    <div class="left">
                        <img src="${u.image}" alt="${u.name}">
                        <div class="name-msg">
                            <span>${u.name}</span>
                            <div class="last-msg">${u.last_message}</div>
                        </div>
                    </div>
                    <div class="time">
                        ${u.last_message_time.split(',')[0]}
                        ${u.unread_count ? `<span class="unread-badge">${u.unread_count}</span>` : ''}
                    </div>
                </div>
                <div class="accordion-content"></div>
            `;
            chatList.appendChild(item);
        });

        attachChatItemEvents();                 // <-- once
        // **DO NOT auto-open any chat**  right side stays blank
    })
    .catch(console.error);
}

/* --------------------------------------------------------------
   2. CLICK HANDLERS (once)
   -------------------------------------------------------------- */
function attachChatItemEvents() {
    chatList.querySelectorAll('.chat-header-item').forEach(header => {
        header.addEventListener('click', () => {
            const item = header.parentElement;
            const id   = item.dataset.id;
            const name = item.dataset.name;
            const img  = item.dataset.img;

            if (window.innerWidth > 768) {
                // remove active from all
                chatList.querySelectorAll('.chat-item').forEach(i => i.classList.remove('active'));
                item.classList.add('active');

                openChat(id, name, img);          // <-- ONLY HERE we load messages
            } else {
                // mobile accordion
                chatList.querySelectorAll('.accordion-content').forEach(c => c.classList.remove('show'));
                const content = item.querySelector('.accordion-content');
                loadChatMobile(content, id);
                content.classList.add('show');
            }
        });
    });
}

/* --------------------------------------------------------------
   3. OPEN CHAT (desktop)  load messages + mark seen
   -------------------------------------------------------------- */
function openChat(id, name, img) {
    if (currentChatId === id) return;          // already open
    currentChatId = id;

    // stop any previous polling
    if (pollingInterval) clearInterval(pollingInterval);

    // ---- blank right side first ----
    desktopMessages.innerHTML = '';
    chatName.textContent = name;
    chatImg.src = img;

    // load messages
    fetchMessages(id);

    // start polling (every 5 s)
    pollingInterval = setInterval(() => fetchMessages(id), 5000);

    // ---- MARK ALL INCOMING MESSAGES AS SEEN ----
    markSeen(id);

    // refresh badge counts (they will disappear)
    refreshBadges();
}

/* --------------------------------------------------------------
   4. FETCH MESSAGES + render
   -------------------------------------------------------------- */
function renderMessage(msg, container) {
    const div = document.createElement('div');
    div.className = 'msg ' + msg.type;

    if (msg.type === 'other') {
        div.innerHTML = `<div class="sender">${msg.sender}</div>${msg.text}<span class="msg-time">${msg.time}</span>`;
    } else {
        const icon = msg.seen
            ? '<span class="seen-icon">Seen</span>'
            : '<span class="seen-icon">Sent</span>';
        div.innerHTML = `${msg.text}<span class="msg-time">${msg.time}</span>${icon}`;
    }
    container.appendChild(div);
}

function fetchMessages(id) {
    fetch(`/chat/messages/${id}`, {
        headers: { 'Accept':'application/json', 'X-Requested-With':'XMLHttpRequest' }
    })
    .then(r => r.json())
    .then(msgs => {
        desktopMessages.innerHTML = '';
        msgs.forEach(m => renderMessage(m, desktopMessages));
        desktopMessages.scrollTop = desktopMessages.scrollHeight;
    })
    .catch(console.error);
}

/* --------------------------------------------------------------
   5. MARK SEEN (called once when chat opens)
   -------------------------------------------------------------- */
function markSeen(receiverId) {
    fetch(`/chat/mark-seen/${receiverId}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .catch(console.error);
}

/* --------------------------------------------------------------
   6. MOBILE  accordion
   -------------------------------------------------------------- */
function loadChatMobile(container, id) {
    container.innerHTML = '';
    const wrap = document.createElement('div');
    wrap.className = 'messages';

    fetch(`/chat/messages/${id}`, {
        headers: { 'Accept':'application/json', 'X-Requested-With':'XMLHttpRequest' }
    })
    .then(r => r.json())
    .then(msgs => {
        msgs.forEach(m => renderMessage(m, wrap));
        container.appendChild(wrap);

        const inputBox = document.createElement('div');
        inputBox.className = 'input-box';
        inputBox.innerHTML = `
            <form class="mobile-message-form">
                <input type="hidden" name="_token" value="${csrfToken}">
                <input type="hidden" name="receiver_id" value="${id}">
                <textarea name="message" placeholder="Type a message..." rows="1"></textarea>
                <button type="submit">Send</button>
            </form>`;
        container.appendChild(inputBox);

        inputBox.querySelector('.mobile-message-form')
            .addEventListener('submit', e => {
                e.preventDefault();
                const txt = e.target.message.value.trim();
                if (txt) {
                    sendMessage(id, txt, container);
                    e.target.message.value = '';
                    e.target.message.style.height = 'auto';
                }
            });
    });
}

/* --------------------------------------------------------------
   7. SEND MESSAGE (desktop + mobile)
   -------------------------------------------------------------- */
function sendMessage(receiverId, text, mobileContainer = null) {
    if (!text) return;

    fetch('/chat/send', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({ receiver_id: receiverId, message: text })
    })
    .then(r => r.json())
    .then(msg => {
        const div = document.createElement('div');
        div.className = 'msg me';
        div.innerHTML = `${msg.text}<span class="msg-time">${msg.time}</span><span class="seen-icon">Sent</span>`;

        if (window.innerWidth > 768) {
            desktopMessages.appendChild(div);
            desktopMessages.scrollTop = desktopMessages.scrollHeight;
        } else if (mobileContainer) {
            const wrap = mobileContainer.querySelector('.messages');
            wrap.appendChild(div);
            wrap.scrollTop = wrap.scrollHeight;
        }

        refreshBadges();
    })
    .catch(console.error);
}

/* --------------------------------------------------------------
   8. REFRESH UNREAD BADGES
   -------------------------------------------------------------- */
function refreshBadges() {
    fetch('/chat/unread', {
        headers: { 'Accept':'application/json', 'X-Requested-With':'XMLHttpRequest' }
    })
    .then(r => r.json())
    .then(counts => {
        document.querySelectorAll('.chat-item').forEach(item => {
            const uid = item.dataset.id;
            const badge = item.querySelector('.unread-badge');
            const cnt   = counts[uid] ?? 0;

            if (cnt) {
                if (!badge) {
                    const timeDiv = item.querySelector('.time');
                    const span = document.createElement('span');
                    span.className = 'unread-badge';
                    span.textContent = cnt;
                    timeDiv.appendChild(span);
                } else {
                    badge.textContent = cnt;
                }
            } else if (badge) {
                badge.remove();
            }
        });
    });
}

/* --------------------------------------------------------------
   9. DESKTOP SEND BUTTON
   -------------------------------------------------------------- */
sendBtn.addEventListener('click', () => {
    const active = document.querySelector('.chat-item.active');
    if (active) {
        const id = active.dataset.id;
        sendMessage(id, msgInput.value);
        msgInput.value = '';
        msgInput.style.height = 'auto';
    }
});

/* --------------------------------------------------------------
   10. INITIALISE
   -------------------------------------------------------------- */
fetchChatList();                     // builds list only
setInterval(refreshBadges, 15000);

/* --- Auto-resize & Enter-to-send for Desktop Chat --- */
if (msgInput) {
    msgInput.addEventListener('input', function() {
        this.style.height = 'auto';
        this.style.height = (this.scrollHeight) + 'px';
    });
    
    msgInput.addEventListener('keydown', function(e) {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            sendBtn.click();
        }
    });
}

/* --- Auto-resize logic for mobile textarea (delegation) --- */
document.addEventListener('input', function(e) {
    if (e.target.name === 'message' && e.target.tagName === 'TEXTAREA') {
        e.target.style.height = 'auto';
        e.target.style.height = (e.target.scrollHeight) + 'px';
    }
});

document.addEventListener('keydown', function(e) {
    if (e.target.name === 'message' && e.target.tagName === 'TEXTAREA' && e.key === 'Enter' && !e.shiftKey) {
        e.preventDefault();
        const form = e.target.closest('form');
        if (form) {
            const submitBtn = form.querySelector('button[type="submit"]');
            if (submitBtn) submitBtn.click();
        }
    }
});
     $("#country").trigger("change");
     $(".addressedit").click(function(event){
         event.preventDefault()
         $(this).hide()
       	 $("#country").prop("disabled", false);
         $('#countryVisibility').prop('disabled', false);
         $(".showaddress").hide();
         $(".editsuburb").show();
         $(".addresssubmit").show();
         $(".addressclose").show();
       
     })
     $(".addressclose").click(function(event){
         event.preventDefault()
         $(this).hide()
       	 $("#country").prop("disabled", true);
         $('#countryVisibility').prop('disabled', true);
         $(".showaddress").show();
         $(".editsuburb").hide();
         $(".addresssubmit").hide();
         $(".addressclose").hide(); 
         $(".addressedit").show()
     })
     $('.addresssubmit').click(function(e) {
        e.preventDefault();

        let countryId = $('#country').val();
        let suburbId  = $('#towns_id').val();
        const visibility = $('#countryVisibility').val();
        if (!countryId || !suburbId) {
            alert('Please select country and suburb');
            return;
        }

        $.ajax({
            url: '/profile/update', // your route
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                country_id: countryId,
                suburb_id:  suburbId,        
                country_visibility: visibility
            },
            success: function(res) {
                alert('Location updated successfully!');
              	window.location.href="";
                resetLocationForm();
                location.reload(); // or update DOM without reload
            },
            error: function(xhr) {
                let errors = xhr.responseJSON?.errors || {error: ['Something went wrong']};
                alert(Object.values(errors).flat().join('\n'));
            }
        });
    });
     
    $(document).ready(function() {
        const originalName = '{{ $profile->name }}';

        // Click Edit
        $('.name-edit').on('click', function(e) {
            e.preventDefault();

            $('#displayName').hide();
            $('#editNameInput').show().focus();
			$('#nameVisibility').prop('disabled', false);
            $('.name-edit').hide();
            $('.name-submit, .name-close').show();
        });

        // Click Close  revert
        $('.name-close').on('click', function(e) {
            e.preventDefault();
            resetNameForm();
          	$('#nameVisibility').prop('disabled', false);
        });

        // Click Submit → AJAX update
        $('.name-submit').on('click', function(e) {
            e.preventDefault();

            const newName = $('#editNameInput').val().trim();
            const visibility = $('#nameVisibility').val();
            if (newName === '') {
                alert('Username cannot be empty');
                return;
            }

            if (newName.length > 255) {
                alert('Username too long (max 255 characters)');
                return;
            }

            $.ajax({
                url: '/profile/update',                     
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    name: newName,
                    name_visibility: visibility
                },
                success: function(response) {
                  window.location.href="";
                    // Update display instantly
                    $('#displayName').text(newName);
                    $('#nameSuccess').fadeIn().delay(3000).fadeOut();

                    resetNameForm();
                },
                error: function(xhr) {
                    let msg = 'Something went wrong';
                    if (xhr.responseJSON?.errors?.name) {
                        msg = xhr.responseJSON.errors.name[0];
                    } else if (xhr.responseJSON?.message) {
                        msg = xhr.responseJSON.message;
                    }
                    $('#nameError').text(msg).fadeIn().delay(5000).fadeOut();
                }
            });
        });

        function resetNameForm() {
            $('#editNameInput').val(originalName).hide();
            $('#displayName').text(originalName).show();

            $('.name-submit, .name-close, #nameError').hide();
            $('.name-edit').show();
        }
    });
    $(document).ready(function() {
        const originalDob = '{{ $profile->dob ?? "" }}';

        $('.dob-edit').on('click', function(e) {
            e.preventDefault();

            $('#displayDob').hide();
            $('#editDob').show().focus();
			$('#dobVisibility').prop('disabled', false);
            $('.dob-edit').hide();
            $('.dob-submit, .dob-close').show();
        });

        $('.dob-close').on('click', function(e) {
            e.preventDefault();
            $('#editDob').val(originalDob).hide();
            $('#dobVisibility').prop('disabled', true);
            $('#displayDob').show();
            $('.dob-submit, .dob-close').hide();
            $('.dob-edit').show();
        });

        $('.dob-submit').on('click', function(e) {
            e.preventDefault();

            const newDob = $('#editDob').val();
            const visibility = $('#dobVisibility').val();
            // Optional: prevent future dates & under 13 years
            if (newDob) {
                const today = new Date();
                birth = new Date(newDob);
                age = today.getFullYear() - birth.getFullYear();
                if (birth > today) {
                    alert('Date of birth cannot be in the future');
                    return;
                }
                if (age < 13 || (age === 13 && today < new Date(today.getFullYear() - 13, birth.getMonth(), birth.getDate()))) {
                    alert('You must be at least 13 years old');
                    return;
                }
            }

            $.ajax({
                url: '/profile/update',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    dob: newDob || null,
                    dob_visibility: visibility
                },
                success: function() {
                   window.location.href="";
                    if (newDob) {
                        const formatted = new Date(newDob).toLocaleDateString('en-GB', {
                            day: 'numeric', month: 'long', year: 'numeric'
                        });
                        $('#displayDob').text(formatted);
                    } else {
                        $('#displayDob').text('Not set');
                    }

                    $('#dobSuccess').fadeIn().delay(3000).fadeOut();

                    $('#editDob').hide();
                    $('#displayDob').show();
                    $('.dob-submit, .dob-close').hide();
                    $('.dob-edit').show();
                },
                error: function() {
                    alert('Failed to update date of birth');
                }
            });
        });
    });
    $('.update-address-visibility').on('change', function (e) {
        e.preventDefault();

        // Ask confirmation
        if (!confirm("Are you sure you want to update visibility?")) {
            return; // stop if user cancels
        }

        let field = $(this).attr('id');   // city_visibility OR suburb_visibility
        let value = $(this).val();

        $.ajax({
            url: '/profile/update',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                [field]: value
            },
            success: function () {
                alert("Visibility updated successfully!");
                window.location.reload();
            },
            error: function () {
                alert('Failed to update visibility');
            }
        });
    });
     
     
     
     // First Name , Last Name Edit
     $(document).ready(function() {
        // Original values (for cancel)
        const origFirst = '{{ $profile->firstname ?? "" }}';
        const origLast  = '{{ $profile->lastname ?? "" }}';
        const origFVis  = '{{ $profile->fname_visibility ?? 1 }}';
        const origLVis  = '{{ $profile->lname_visibility ?? 1 }}';

        // Reusable function to save both fields in one AJAX call
        function saveNames() {
            const firstname = $('#editFirstName').val().trim();
            const lastname  = $('#editLastName').val().trim();
            const fVis = $('#fname_visibility').val();
            const lVis = $('#lname_visibility').val();

            if ($('#editFirstName').is(':visible') && !firstname) {
                alert('First name is required');
                return;
            }
            if ($('#editLastName').is(':visible') && !lastname) {
                alert('Last name is required');
                return;
            }

            $.ajax({
                url: '/profile/update',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    firstname: firstname || origFirst,
                    lastname:  lastname  || origLast,
                    fname_visibility: fVis,
                    lname_visibility: lVis
                },
                success: function() {
                    // Update display
                    window.location.reload()
                    $('#displayFirstName').text(firstname || origFirst);
                    $('#displayLastName').text(lastname || origLast);

                    // Close both forms
                    closeForm('#firstNameSection');
                    closeForm('#lastNameSection');

                    // Show success once
                    $('.text-success').fadeIn().delay(3000).fadeOut();
                },
                error: function(xhr) {
                    alert(xhr.responseJSON?.errors
                        ? Object.values(xhr.responseJSON.errors).flat().join(', ')
                        : 'Save failed');
                }
            });
        }

        function openForm(section) {
            $(section + ' .fullnmshow').hide();           // hide readonly input
            $(section + ' .fullnmedit').show().focus(); // show editable input
            //$(section + ' select').prop('disabled', false);   // enable visibility dropdown
            $(section + ' .edit').hide();                     // hide all edit links
            $(section + ' .fname-save, ' + section + ' .lname-save, ' + 
              section + ' .fname-close, ' + section + ' .lname-close').show();
        }

        // CLOSE / CANCEL
        function closeForm(section) {
            $(section + ' .fullnmedit').hide();
            $(section + ' .fullnmshow').show();
            //$(section + ' select').prop('disabled', true);
            $(section + ' .fname-save, ' + section + ' .lname-save, ' + 
              section + ' .fname-close, ' + section + ' .lname-close').hide();
            $(section + ' .fname-edit, ' + section + ' .lname-edit').show();
        }

        // First Name Events
        $('.fname-edit').click(e => { e.preventDefault(); openForm('#firstNameSection'); });
        $('.fname-close').click(e => { e.preventDefault(); closeForm('#firstNameSection'); });
        $('.fname-save').click(e => { e.preventDefault(); saveNames(); });

        // Last Name Events
        $('.lname-edit').click(e => { e.preventDefault(); openForm('#lastNameSection'); });
        $('.lname-close').click(e => { e.preventDefault(); closeForm('#lastNameSection'); });
        $('.lname-save').click(e => { e.preventDefault(); saveNames(); });
    });
</script>
<script>
$(document).ready(function() {
    const originalEmail = '{{ $profile->email }}';

    $('.email-edit').on('click', function(e) {
        e.preventDefault();
        $('#displayEmail').hide();
        $('#editEmail').show().focus();
        $('.email-edit').hide();
        $('.email-save, .email-close').show();
    });

    $('.email-close').on('click', function(e) {
        e.preventDefault();
        $('#editEmail').val(originalEmail).hide();
        $('#displayEmail').show();
        $('.email-save, .email-close').hide();
        $('.email-edit').show();
    });

    $('.email-save').on('click', function(e) {
        e.preventDefault();
        const newEmail = $('#editEmail').val().trim();

        if (!newEmail || !/^\S+@\S+\.\S+$/.test(newEmail)) {
            alert('Please enter a valid email address');
            return;
        }

        if (newEmail === originalEmail) {
            alert('New email must be different');
            return;
        }

        $.ajax({
            url: '/profile/change-email',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                email: newEmail
            },
            success: function() {
                $('#emailSuccess').text('Email change request sent to admin!').fadeIn().delay(5000).fadeOut();
                $('#editEmail').hide();
                $('#displayEmail').show().val(originalEmail);
                $('.email-save, .email-close').hide();
                $('.email-edit').show();

                // Show pending message
                location.reload(); // or dynamically add pending text
            },
            error: function(xhr) {
                $('#emailError').text(xhr.responseJSON?.message || 'Failed to request change').fadeIn();
            }
        });
    });
});
</script>
<script>
$(document).ready(function() {
    const routeRequest = '{{ route("profile.password-request") }}';
    const routeVerify  = '{{ route("profile.password-verify") }}';

    // Click Change
    $('#changeBtn').on('click', function(e) {
        e.preventDefault();
        $('#initialState').hide();
        $('#editState').show();
        $('#newPassword').val('').focus();
    });

    // Click Close
    $('#closeBtn').on('click', function(e) {
        e.preventDefault();
        $('#editState').hide();
        $('#initialState').show();
        $('#successMsg, #errorMsg').hide();
    });

    // Click Save → Send OTP
    $('#saveBtn').on('click', function(e) {
        e.preventDefault();
        const newPass = $('#newPassword').val().trim();

        if (!newPass || newPass.length < 8) {
            alert('Password must be at least 8 characters');
            return;
        }

        $.post(routeRequest, {
            _token: '{{ csrf_token() }}',
            password: newPass
        })
        .done(function() {
            $('#successMsg').text('OTP sent to your email!').fadeIn();
            $('#editState').hide();           // Hide New Password + Save/Close
            $('#initialState').hide();
            $('#otpState').show();            // Only show OTP
        })
        .fail(function(xhr) {
            $('#errorMsg').text(xhr.responseJSON?.message || 'Error').fadeIn();
        });
    });

    // Verify OTP
    $('#verifyBtn').on('click', verifyOtp);
    //$('#otpInput').on('input', function() {
     //   if ($(this).val().length === 6) verifyOtp();
    //});

    function verifyOtp() {
        $.post(routeVerify, {
            _token: '{{ csrf_token() }}',
            otp: $('#otpInput').val()
        })
        .done(function() {
            $('#successMsg').html('<strong>Password changed successfully!</strong>').fadeIn();
            setTimeout(() => location.reload(), 2000);
        })
        .fail(function(xhr) {
            $('#errorMsg').text(xhr.responseJSON?.message || 'Invalid OTP').fadeIn();
            $('#otpInput').val('').focus();
        });
    }

    // Resend OTP
    $('#resendBtn').on('click', function() {
        const lastPass = $('#newPassword').val().trim();
        if (!lastPass) {
            alert('Password lost. Please start again.');
            location.reload();
            return;
        }
        $.post(routeRequest, { _token: '{{ csrf_token() }}', password: lastPass })
         .done(() => {
             $('#successMsg').text('New OTP sent!').fadeIn().delay(3000).fadeOut();
             $('#otpInput').val('').focus();
         });
    });
});
  
  
/* =============================================================
   MESSAGE SEARCH FUNCTIONALITY - ENHANCED VERSION
   Add this code to your existing chat script
   ============================================================= */

// Get the search input element
const searchInput = document.getElementById('searchInput');
let searchDebounceTimer = null;

// Add event listener for search input with debouncing
if (searchInput) {
    searchInput.addEventListener('input', function(e) {
        const searchTerm = e.target.value.toLowerCase().trim();
        
        // Debounce for performance (wait 300ms after user stops typing)
        clearTimeout(searchDebounceTimer);
        searchDebounceTimer = setTimeout(() => {
            filterChatList(searchTerm);
        }, 100);
    });
    
    // Also handle Enter key
    searchInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            clearTimeout(searchDebounceTimer);
            const searchTerm = e.target.value.toLowerCase().trim();
            filterChatList(searchTerm);
        }
    });
}

/**
 * Filter chat list based on search term
 * Searches in: user name, last message content
 */
function filterChatList(searchTerm) {
    const chatItems = chatList.querySelectorAll('.chat-item');
    
    chatItems.forEach(item => {
        if (!searchTerm) {
            // Show all items if search is empty
            item.style.display = '';
            return;
        }

        // Get searchable data
        const userName = item.dataset.name.toLowerCase();
        const lastMessage = item.querySelector('.last-msg')?.textContent.toLowerCase() || '';
        
        // Check if search term matches
        const matches = userName.includes(searchTerm) || lastMessage.includes(searchTerm);
        
        // Show/hide item
        item.style.display = matches ? '' : 'none';
    });
    
    // Show "no results" message if all items are hidden
    showNoResultsMessage();
}

/**
 * Show "No results found" message when search yields nothing
 */
function showNoResultsMessage() {
    const chatItems = chatList.querySelectorAll('.chat-item');
    const visibleItems = Array.from(chatItems).filter(item => item.style.display !== 'none');
    
    // Remove existing "no results" message
    const existingMsg = chatList.querySelector('.no-results-msg');
    if (existingMsg) existingMsg.remove();
    
    // Add message if no visible items
    if (visibleItems.length === 0 && searchInput.value.trim()) {
        const noResultsDiv = document.createElement('div');
        noResultsDiv.className = 'no-results-msg';
        noResultsDiv.style.cssText = 'padding: 20px; text-align: center; color: #999;';
        noResultsDiv.textContent = 'No conversations found';
        chatList.appendChild(noResultsDiv);
    }
}

/**
 * Clear search and show all chats
 */
function clearSearch() {
    if (searchInput) {
        searchInput.value = '';
        filterChatList('');
    }
}

// Optional: Add clear button functionality
// You can add this button in your HTML: <button onclick="clearSearch()">Clear</button>

// Export function if using modules
// export { filterChatList, clearSearch };
</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Check if there's a success message from article submission/update
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: '{{ session('success') }}',
            confirmButtonText: 'OK',
            confirmButtonColor: '#729b0f'
        }).then((result) => {
            // After the user clicks OK, open the articles tab
            if (result.isConfirmed) {
                // Trigger click on the "Listings" tab (second tab)
                const listingsTab = document.querySelector('.resp-tabs-list.hor_1 li:nth-child(2)');
                if (listingsTab) {
                    listingsTab.click();
                    
                    // After a short delay, open the Articles accordion
                    setTimeout(() => {
                        const articleTab = document.querySelector('.article_tab');
                        if (articleTab && !articleTab.classList.contains('active')) {
                            articleTab.click();
                        }
                    }, 300);
                }
            }
        });
    @endif
</script>
<script>
    $(document).on('change', '.change-business-status', function() {
        const id = $(this).data('id');
        const status = $(this).val();
        const $select = $(this);

        $.ajax({
            url: '{{ route("business.update-status") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                id: id,
                status: status
            },
            success: function(response) {
                if(response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Updated!',
                        text: 'Business status updated successfully!',
                        confirmButtonColor: '#729b0f'
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Failed to update status.'
                    });
                    location.reload();
                }
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred. Please try again.'
                });
                location.reload();
            }
        });
    });
</script>
   <!-- body start end-->

   @include('includes/footer-js')
   @include('includes/footer')
