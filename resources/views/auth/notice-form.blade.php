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
    <select name="category_id" id="category_id" required>
        <option value="">Choose your Category</option>
        @if(!empty($category))
            @foreach($category as $cat)
            <option value="{{ $cat->id }}" {{ $loop->first ? 'selected' : '' }}>{{ $cat->category }}</option>
            @endforeach
        @endif
    </select>
    </div>

 <div id="rest_of_fields" style="display:none;">
 <div class="frm_dv">
 <label>Notice Options:</label><div class="radiogbutt"><input name="noticetype" type="radio" value="standard"> Standard 7 day Notice (Free) $0.00</div>
 <div class="radiogbutt"><input name="noticetype" type="radio" value="feature"> Feature Notice(Lasts 28 days)$3.00
<img src="images/help_icon.png" alt="" class="help_icon"></div>
 </div>
 
 <div class="frm_dv">
 <label>Notice Title:</label><input name="notice_title" type="text" placeholder="Enter Notice Title (35 char max)">
 </div>

 <!-- Get a Quote Fields -->
 <div id="get_a_quote_fields" style="display:none;">
     <div class="frm_dv">
        <label>I'm Looking for:</label>
        <input name="looking_for" type="text" placeholder="I'm Looking for">
     </div>
     <div class="frm_dv">
        <label>Where do you need the job done?:</label>
        <input name="job_location" type="text" placeholder="Where do you need the job done?">
     </div>
     <div class="frm_dv">
        <label>When do you need the work to start?:</label>
        <input name="start_date" type="text" placeholder="When do you need the work to start?">
     </div>
     <div class="frm_dv">
        <label>Budget:</label>
        <input name="budget" type="text" placeholder="Budget">
     </div>
 </div>

 <!-- $5 Service Deal Fields -->
 <div id="service_deal_fields" style="display:none;">
     <div class="frm_dv">
        <label>Town/Suburb:</label>
        <input name="town_suburb" type="text" placeholder="Town/Suburb">
     </div>
     <div class="frm_dv">
        <label>User name:</label>
        <input type="text" value="{{ Auth::user()->name }}" disabled>
     </div>
     <div class="frm_dv">
        <label>Date listed:</label>
        <input type="text" value="{{ date('d/m/Y') }}" disabled>
     </div>
     <div class="frm_dv">
        <label>Message:</label>
        <textarea name="message_text" placeholder="Message"></textarea>
     </div>
 </div>

 <div class="frm_dv textareadv">
 <label id="body_label">Add your content: </label><textarea name="notice_body" cols="" rows="" placeholder="Add notice body text (155 char max)."></textarea>
</div>
 <style>
    .image-upload-grid {
        display: grid;
        grid-template-columns: repeat(3, 150px);
        gap: 20px;
        margin-top: 5px;
    }
    .image-upload-box {
        width: 150px;
        height: 150px;
        aspect-ratio: 1/1;
        border: 2px dashed #ccc;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        position: relative;
        overflow: hidden;
        background-color: #fcfcfc;
        transition: all 0.3s ease;
    }
    .image-upload-box:hover {
        border-color: #ff9900;
        background-color: #fff9f0;
    }
    .image-upload-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .image-upload-box .placeholder-icon {
        font-size: 24px;
        color: #aaa;
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    .image-upload-box .placeholder-icon span {
        font-size: 12px;
        margin-top: 5px;
        color: #999;
    }
    .remove-img {
        position: absolute;
        top: 5px;
        right: 5px;
        background: rgba(255, 0, 0, 0.7);
        color: white;
        border-radius: 50%;
        width: 20px;
        height: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        cursor: pointer;
        z-index: 10;
    }
    .left_profileform .frm_dv {
        display: flex;
        align-items: flex-start;
        margin-bottom: 15px;
    }
    .left_profileform .frm_dv label {
        width: 180px;
        min-width: 180px;
        margin-bottom: 0;
        padding-top: 10px;
        font-weight: 600;
        color: #333;
    }
    .left_profileform .frm_dv input[type="text"],
    .left_profileform .frm_dv select,
    .left_profileform .frm_dv textarea,
    .left_profileform .frm_dv .image-upload-grid,
    .left_profileform .frm_dv .radiogbutt,
    .left_profileform .frm_dv .chk_addtnlbox {
        flex: 1;
    }
    .left_profileform .frm_dv textarea {
        min-height: 120px;
    }
</style>

 <div class="frm_dv">
    <label>Images (3 places):</label>
    <div style="flex: 1;">
        <div class="image-upload-grid">
            <!-- Box 1 -->
            <div class="image-upload-box" onclick="document.getElementById('noticeimg1').click();">
                <div id="noticeimgshow1" class="noticeimgshow placeholder-icon">
                    <i class="fa fa-camera"></i>
                    <span>Image 1</span>
                </div>
                <input type="file" name="noticeimg[]" class="imageUpload" id="noticeimg1" style="display:none;">
                <input type="hidden" name="noticeimgbase64[]" class="noticeimgbase64" id="noticeimgbase641">
            </div>

            <!-- Box 2 -->
            <div class="image-upload-box" onclick="document.getElementById('noticeimg2').click();">
                <div id="noticeimgshow2" class="noticeimgshow2 placeholder-icon">
                    <i class="fa fa-camera"></i>
                    <span>Image 2</span>
                </div>
                <input type="file" name="noticeimg[]" class="imageUpload" id="noticeimg2" style="display:none;">
                <input type="hidden" name="noticeimgbase64[]" class="noticeimgbase64" id="noticeimgbase642">
            </div>

            <!-- Box 3 -->
            <div class="image-upload-box" onclick="document.getElementById('noticeimg3').click();">
                <div id="noticeimgshow3" class="noticeimgshow3 placeholder-icon">
                    <i class="fa fa-camera"></i>
                    <span>Image 3</span>
                </div>
                <input type="file" name="noticeimg[]" class="imageUpload" id="noticeimg3" style="display:none;">
                <input type="hidden" name="noticeimgbase64[]" class="noticeimgbase64" id="noticeimgbase643">
            </div>
        </div>
        <span style="font-size: 11px; color: #999; display: block; margin-top: 10px;">Recommended size: Square (e.g. 600x600px) | JPG, GIF, PNG</span>
    </div>
 </div>
 
 <div class="frm_dv" id="additional_images_section">
 <label><!--Notice Options:--></label>
<div class="chk_addtnlbox"><input name="" type="checkbox" value="" checked>Add 3 more images (free renewal) $2.00
 <img src="images/help_icon.png" alt="" class="help_icon">
 </div>
 </div>

  <div class="frm_dv">
  </div>
 <div class="frm_dv"><label></label>
 <input name="submit" type="submit" value="Create Notice"></div>
 </div>
</div>
</form>

<script>
document.getElementById('category_id').addEventListener('change', function() {
    var categoryId = this.value;
    var restOfFields = document.getElementById('rest_of_fields');
    var getAQuoteFields = document.getElementById('get_a_quote_fields');
    var serviceDealFields = document.getElementById('service_deal_fields');
    var additionalImagesSection = document.getElementById('additional_images_section');
    var bodyLabel = document.getElementById('body_label');
    var bodyTextarea = document.getElementsByName('notice_body')[0];

    if (categoryId) {
        restOfFields.style.display = 'block';
        
        // ID 1 is $5 Service Deal
        // ID 2 is Get a Quote
        if (categoryId == '1') {
            serviceDealFields.style.display = 'block';
            getAQuoteFields.style.display = 'none';
            additionalImagesSection.style.display = 'none';
            bodyLabel.innerText = 'Description:';
            bodyTextarea.placeholder = 'Description';
        } else if (categoryId == '2') {
            serviceDealFields.style.display = 'none';
            getAQuoteFields.style.display = 'block';
            additionalImagesSection.style.display = 'none';
            bodyLabel.innerText = 'Provide a description of your job:';
            bodyTextarea.placeholder = 'Provide a description of your job';
        } else {
            serviceDealFields.style.display = 'none';
            getAQuoteFields.style.display = 'none';
            additionalImagesSection.style.display = 'block';
            bodyLabel.innerText = 'Add your content:';
            bodyTextarea.placeholder = 'Add notice body text (155 char max).';
        }
    } else {
        restOfFields.style.display = 'none';
    }
});

window.addEventListener('load', function() {
    var categorySelect = document.getElementById('category_id');
    if (categorySelect.value !== "") {
        categorySelect.dispatchEvent(new Event('change'));
    }
});
</script>
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




