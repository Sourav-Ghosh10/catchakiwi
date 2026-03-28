@include('includes/header')

   <div>
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
                            <option value="US" {{ (session('CountryCode')=="US")?"selected":"" }}>US-United States</option>
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
         <h1><a href="{{ URL::to('/dashboard') }}"><img src="{{ asset('assets/images/logo-inner.png') }}" alt="" /></a></h1>
      </div>
   </div>
   <div class="container">
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
      <!-- Header start end-->




<div class="mid_body">
<div class="container">
<div class="full_midpan">
<div class="row">
<div class="col-lg-8 col-md-8 col-sm-12">
<div class="left_notice">
<div class="brad_cam">
<ul>
<li><a href="#">Dashboard</a></li>
<li><a href="#"> My Notices</a></li>
<li class="active"><a href="#">Post Notice </a></li> 
</ul>
<br class="clr">
</div>
<h2>Post Notice<br>
<span>Communicate your message to the catchakiwi community (Lasts 7 days). </span></h2>
<form action="{{ route('notice-submit') }}" method="post" enctype='multipart/form-data'>
    @csrf
<div class="left_profileform notice_posefrm">
<div class="frm_dv">
    <label>Category:</label>
    <select name="category_id">
        <option>Choose your Category</option>
        @if(!empty($category))
            @foreach($category as $cat)
            <option value="{{ $cat->id }}">{{ $cat->category }}</option>
            @endforeach
        @endif
    </select>
    </div>
 <div class="frm_dv">
 <label>Notice Options:</label><div class="radiogbutt"><input name="noticetype" type="radio" value="standard"> Standard 7 day Notice (Free) $0.00</div>
 <div class="radiogbutt"><input name="noticetype" type="radio" value="feature"> Feature Notice(Lasts 28 days)$3.00
<img src="images/help_icon.png" alt="" class="help_icon"></div>
 </div>
 <!--<div class="frm_dv">
 <label></label><div class="radiogbutt"><input name="" type="radio" value=""> Feature Notice(Lasts 28 days)$3.00
<img src="images/help_icon.png" alt="" class="help_icon"></div>
 </div>-->
 <div class="frm_dv">
 <label>Notice Title:</label><input name="notice_title" type="text" placeholder="Enter Notice Title (35 char max)">

 </div>
 <div class="frm_dv textareadv">
 <label>Add your content: </label><textarea name="notice_body" cols="" rows="" placeholder="Add notice body text (155 char max)."></textarea>
</div>
 <div class="frm_dv">
 <label>Image preview</label>
 <div class="imageprvsec">
<ul>
 <li class="noticeimgshow"></li>
 <li></li>
 <li></li>
 <li></li>
</ul>
 </div>
 </div>
 <div class="frm_dv browse_img">
 <label>Images:</label>
<div class="custom_browse"> <input id="uploadFile" placeholder="Choose your free image" disabled="disabled" />
<label  class="custom-file-input" >
<input type="file" name="noticeimg" class="imageUpload" id="noticeimg">
<input type="hidden" name="noticeimgbase64" class="noticeimgbase64" id="noticeimgbase64">
</label>
<span>Recommended size 640w/480px ( JPG,GIF,PNG )	</span>
</div>
 </div>
 <div class="frm_dv">
 <label><!--Notice Options:--></label>
<div class="chk_addtnlbox"><input name="" type="checkbox" value="" checked>Add 3 more images (free renewal) $2.00
 <img src="images/help_icon.png" alt="" class="help_icon">
 <!--<div class="help_icontxt">Text Goes Here.</div>--></div>
 
 </div>
 <div class="frm_dv browse_img">
 <label><!--Additional image 4:--></label>
<div class="custom_browse"> <input id="uploadFile" placeholder="Choose Image" disabled="disabled" />
<label  class="custom-file-input" >
<input type="file" id="uploadBtn">
</label></div>
 </div>
 <div class="frm_dv browse_img">
 <label><!--Additional image 4:--></label>
<div class="custom_browse"> <input id="uploadFile" placeholder="Choose Image" disabled="disabled" />
<label  class="custom-file-input" >
<input type="file" id="uploadBtn">
</label></div>
 </div>
 <div class="frm_dv browse_img">
 <label><!--Additional image 4:--></label>
<div class="custom_browse"> <input id="uploadFile" placeholder="Choose Image" disabled="disabled" />
<label  class="custom-file-input" >
<input type="file" id="uploadBtn">
</label></div>
 </div>
  <div class="frm_dv"><!--<label></label>
  <img src="images/loader.gif" alt="" class="loader">-->
  <!--<div class="profile_img">
  <img src="images/profile_pic.png" alt="" class="pro">
  <p>T1577932667100 
  <span>01/03/2020</span></p>
  <img src="images/notice_chaticon.png" alt="" class="helpic"> </div>-->
  </div>
 <div class="frm_dv"><label></label>
 <input name="submit" type="submit" value="Create Notice"></div>
</div>
</form>
</div>
</div>
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

 @include('includes/footer-js')    
@include('includes/footer')




