@include('includes/business-header')
    <!--<link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet">-->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
        /* Hide the label */
        label[for="editor"] {
            display: none;
        }
        #editor{
            min-height:200px;
        }
        .ql-editor h1, .ql-editor h2, .ql-editor h3,
        .ql-editor h4, .ql-editor h5, .ql-editor h6 {
            color: inherit; /* Use inherit to maintain the text color */
        }
        .error {
            color: #ff0000;
            font-size: 13px;
            margin-top: 5px;
            display: block;
        }
        .invalid-feedback {
            display: block;
            color: #ff0000;
            font-size: 13px;
            margin-top: 5px;
        }
        input.error, select.error, textarea.error {
            border: 1px solid #ff0000 !important;
        }
        .selectize-control.error .selectize-input {
            border: 1px solid #ff0000 !important;
        }
        .display_addrs label {
            font-weight: normal;
            margin-right: 15px;
            cursor: pointer;
        }
        .display_addrs input[type="radio"] {
            margin-right: 5px;
            vertical-align: middle;
        }
        .btn_continue {
            background-color: #f7941d;
            color: #fff;
            padding: 6px 30px;
            border: none;
            border-radius: 20px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s;
            float: left;
            margin-top: 10px;
            margin-bottom: 20px;
        }
        .btn_continue:hover {
            background-color: #e68510;
            color: #fff;
        }
        .acc_content {
            overflow: hidden; /* Ensure float doesn't break layout */
        }
        .browse_img.busdes {
            cursor: pointer;
        }
    </style>
    
<div class="modal fade bd-example-modal-lg imagecrop" id="model" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                  <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">New message</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                  </div>
                <div class="modal-body">
                    <div class="img-container">
                        <img id="image" src="https://avatars0.githubusercontent.com/u/3456749">
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
<div class="top_search nomob_search">
<div class="container">
    <!--<div class="logo"><h1><a href="/"><img src="{{ asset('assets/images/logo-inner.png') }}" alt="" /></a></h1></div>-->
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
</div></div>
<!-- Header start end-->

<!-- body start-->
<div class="mid_body">
<div class="container">
<div class="profile_banner mobileoff">
  <img src="{{ asset($profile->profile_banner) }}" alt="">
  <div class="profile_pic"><img src="{{ asset($profile->image) }}" alt=""></div>
  </div>
<div class="profile_heading">
  <h2>Add your Business
  <span>Share your Business or the Services you Offer</span></h2>
 </div>
<div class="full_midpan">
<div class="row">
<div class="col-lg-8 col-md-8 col-sm-12">
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
@if (session('success'))
    <script>
        Swal.fire({
            title: '',
            text: "Congratulations on listing your new homebased business on catchakiwi.You will now be taken to the dashboard.",
            icon: 'success',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Continue'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '/profile';
            }
        });
    </script>
@endif


<div class="left_profileform">
<form action="{{ route('business.list.insert')  }}" id="businessForm" method="post" enctype="multipart/form-data">
    @csrf
<div id="accordion" class="tab_form">
  <h3>Listing Details</h3>
  <div class="acc_content"> 
    <div class="homebased_option">
      <div class="disflex">
     <p>Homebased Startup Business? *</p>
    <label><input name="homebased_business"  id="1" class="homebased_business" type="radio" value="Yes" required {{ old('homebased_business')=='Yes' ? 'checked' : '' }}>Yes</label>
    <label><input name="homebased_business" id="2" class="homebased_business" type="radio" value="No" {{ old('homebased_business')=='No' ? 'checked' : '' }}> No</label></div>
   
    <div class="notification_homebased" style="display:none;">Welcome! Homebased startups get a free membership to most of our services</div> 
    </div>
    <div class="frm_dv bestsuitsyou" style="display:none;">
    <label>Please choose the option which best suits you</label>
        <select name="bestsuitsyou">
            <!-- <option value="Startup homebased first year">Startup homebased first year</option> -->
            <option value="Homebased, older than one year" {{ old('bestsuitsyou')=='Homebased, older than one year'?'selected':'' }}>Homebased, older than one year</option>
            <option value="Company business Less than 5 employees" {{ old('bestsuitsyou')=='Company business Less than 5 employees'?'selected':'' }}>Company business Less than 5 employees</option>
            <option value="Company Business with 5 or more employees" {{ old('bestsuitsyou')=='Company Business with 5 or more employees'?'selected':'' }}>Company Business with 5 or more employees</option>
        </select>
    
    </div>
    <div class="frm_dv">
    <label>My Company Name *</label>
    <input name="company_name" type="text" class="@error('company_name') is-invalid @enderror" value="{{ old('company_name') }}" placeholder="" required>
    @error('company_name')
        <span class="invalid-feedback">{{ $message }}</span>
    @enderror
    </div>
    <div class="frm_dv">
    <label>Display Name *</label>
    <input name="display_name" type="text" placeholder="Display name" value="{{ old('display_name') }}" class="@error('display_name') is-invalid @enderror" required>
    @error('display_name')
        <span class="invalid-feedback">{{ $message }}</span>
    @enderror
    <img src="{{ asset('assets/images/help_icon.png') }}" alt="" class="help_icon">
    <div class="help_icontxt">This is how your listing will show up. Use your usual company name, or swap it out for something that fits the job or gig better, up to you.</div>
    </div>
    <div class="frm_dv catfield">
    <label>Primary Category  *</label>
    <select name="category" id="category" class="category selectsize" placeholder="Select Category" required>
        <option value="">Select Category</option>
        @if(!empty($category))
            @foreach($category as $cat)
                <option value="{{ $cat['id'] }}" {{ old('category')==$cat['id'] ? 'selected' : '' }}>{{ $cat['title'] }}</option>
            @endforeach
        @endif
    </select>
    @error('category')
        <span class="invalid-feedback">{{ $message }}</span>
    @enderror
    </div>
    <div class="frm_dv catfield">
    <label>Secondary Category *</label>
    <select id="subcat" class="category selectsize" name="subcat" placeholder="Select Sub Category" required>
    </select>
    @error('subcat')
        <span class="invalid-feedback">{{ $message }}</span>
    @enderror
    </div>
    <div class="frm_dv ">
        <label>Business Description*</label>
        <img src="images/editor_image.png" alt=""> 
        <!--<textarea id="description" name="description" rows="6" cols="33" placeholder="Describe the products / services you provide and area(s) you serve (Max 1000, Min 100 characters)"></textarea>-->
        <!--<span class="editordes_text"></span>-->
        <div id="editor">{!! old('description') !!}</div>
        <input type="hidden" name="description" id="description" value="{{ old('description') }}">
        @error('description')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>
    <div class="frm_dv frm_propic">
    <div class="browse_img busdes">
      <div class="delimgwrap">
        <button type="button" class="remove-bus-image" style="display: {{ old('base64image') ? 'flex' : 'none' }};" title="Remove image">&times;</button>
        <img class="cropimg bdrbox" src="{{ old('base64image') ? old('base64image') : asset('assets/images/busines-defaultlogo.png') }}" alt="Business Logo">
      </div>
      <div class="newupload">
      <label>Select Your Business Logo</label>
        <div class=customupbtn>
          <input name="imageUpload" type="file" value="browse" id="businessimage" class="imageUpload"  placeholder="" >
          <input type="hidden" name="base64image" name="base64image" id="base64image" value="{{ old('base64image') }}">
          <!--<span>For better results, make sure to upload an image that has a 4:3 (800x600) aspect ratio.</span>-->
         </div>
      </div>
    </div>
    </div>
    <div class="frm_dv">
        <button type="button" class="btn_continue">Continue</button>
    </div>
  </div>
  <h3>Complete Your Contact Details <span>(Required)</span></h3>
  <div class="acc_content">
    <div class="frm_dv">
    <label>Contact Person *</label>
    <input name="contact_person" type="text" value="{{ old('contact_person',$profile->name) }}" placeholder="" class="thikmark @error('contact_person') is-invalid @enderror" required> 
    @error('contact_person')
        <span class="invalid-feedback">{{ $message }}</span>
    @enderror
    </div>
    <div class="frm_dv">
    <label>Email Address  *</label>
    <input name="email" type="text" value="{{ old('email',$profile->email) }}" placeholder="" class="thikmark @error('email') is-invalid @enderror" required>
    @error('email')
        <span class="invalid-feedback">{{ $message }}</span>
    @enderror
    </div>
    <div class="frm_dv">
    <label>Country *</label>
    <select class="livesearch " name="country" id="country_select" placeholder="Select Country"  required>
      <option value="" disabled selected>Select Country</option>
      @if(!empty($country))
        @foreach($country as $cnty)
            <option value="{{$cnty['id']}}" {{ (old('country', session('CountryCode')) == $cnty['id'] || old('country') == $cnty['id'] || (empty(old('country')) && session('CountryCode') == $cnty['shortname'])) ? 'selected' : '' }}>{{$cnty['name']}}</option>
        @endforeach
      @endif;
      </select>
      @error('country')
          <span class="invalid-feedback">{{ $message }}</span>
      @enderror
    <!--<input name="" type="text" value="New Zealand +64" placeholder="">-->
    </div>
    <div class="frm_dv m_phone">
    <label>Main phone *</label>
    <!--<select name="" class="ph_code">-->
    <!--<option>STD</option>-->
    <!--</select>-->
    <input name="phone_no" type="text"  value="{{ old('phone_no') }}" placeholder="Enter Phone Number" class="@error('phone_no') is-invalid @enderror" required>
    @error('phone_no')
        <span class="invalid-feedback">{{ $message }}</span>
    @enderror
    </div>
    <div class="frm_dv m_phone">
    <label>Secondary phone</label>
    <input name="phone_no_two" type="text" value="{{ old('phone_no_two') }}" placeholder="Enter Phone Number" >
    </div>
    <div class="frm_dv">
    <label>Website URL</label>
    <input name="website_url" type="text" value="{{ old('website_url') }}" placeholder="" class="thikmark">
    </div>
    <div class="frm_dv">
        <label>Enter Street Address *</label>
        <input name="street_address" type="text" placeholder="Enter Street Address" class="street_address @error('street_address') is-invalid @enderror" value="{{ old('street_address') }}"  required>
        @error('street_address')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>
    <div class="frm_dv">
        <label>Enter apartment number</label>
        <input name="appt_number" type="text" placeholder="Enter apartment number" class="street_address valid" value="{{ old('appt_number') }}">
    </div>
    <!--<div class="frm_dv">-->
    <!--<label>Address</label>-->
    <!--<input name="address" type="text" placeholder="Start typing your address ( Number, Street, Suburb, City )" required>-->
    <!--</div>-->
    
    <!--<div class="frm_dv">-->
    <!--    <label>Region* </label>-->
    <!--    <select class="form-control selectsize addressdd" name="state_id" id="state_id" placeholder="Select State" required>-->
    <!--    </select>-->
    <!--</div>-->
    <!--<div class="frm_dv"> -->
    <!--    <label>Street*</label>-->
    <!--    <input name="appt_number" type="text" placeholder="Street*" class="appt_number" required>-->
    <!--</div>-->
    <div class="frm_dv catfield">
        <label class="dist">Town/suburb, <br>City/District, Region * </label>
        <select class="addressdd selectsize " name="city_id" id="city_id" placeholder="Select City/District" required>
        </select>
        @error('city_id')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>
    <!--<div class="frm_dv">-->
    <!--    <label>Town/suburb*</label>-->
    <!--    <select id="town_id" name="town_id" class="selectsize addressdd" placeholder="Select Sub Category" required>-->
    <!--    </select>-->
        <!--<select class=" addressdd" name="town_id" id="town_id" placeholder="Select Suburb/City" >-->
        <!--</select>-->
    <!--</div>-->
    <div class="frm_dv">
        <label>Map (Note : Paste you address Share Embed link here)</label>
        <input name="map" type="text" placeholder="Map" class="map"  value="{{ old('map') }}">
    </div>
    
    
    <div class="frm_dv display_addrs">
        <label>Display Address? *</label>
        <div class="disflex">
            <label><input name="display_addrs" type="radio" value="yes" {{ old('display_addrs')=='yes'?'checked':'' }}> Yes</label>
            <label><input name="display_addrs" type="radio" value="no" {{ old('display_addrs')=='no'?'checked':'' }}> No</label>
        </div>
        @error('display_addrs')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
        <span>Yes display your business address on your public listing - No keeps it confidential</span>
    </div>
    <div class="frm_dv">
        <button type="button" class="btn_continue">Continue</button>
    </div>
  </div>
  <h3>Add you social networks <span>(optional)</span></h3>
  <div class="acc_content social_inputlinks">
    <div class="frm_dv">
    <label>Facebook</label>
    <input class="fb" name="facebook_prof" type="text" value="{{ old('facebook_prof') }}" placeholder="https://www.facebook.com/profile.php?id=your_id&ref=bookmarks">
    </div>
    <div class="frm_dv">
    <label>LinkedIn</label>
    <input class="in" name="linkedin" type="text" value="{{ old('linkedin') }}" placeholder="https://linkedin.com/in/your_id">
    </div>
    <div class="frm_dv">
    <label>Twitter</label>
    <input class="twitter" name="twitter" type="text" value="{{ old('twitter') }}" placeholder="https://twitter.com/your_id">
    </div>
  </div>
</div>
<input name="" type="submit" id="addbusinesssubmit" value="Let’s Go">
<a href="{{ URL::to('/profile') }}" class="editcancelbtn">Cancel</a>
</form>
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
<script>
    $(document).on('click','.help_icon',function(){
        $('.help_icontxt').toggle();
    })
</script>
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/ckeditor/4.12.1/ckeditor.js" integrity="sha512-UvcGDOLeiRUzzdU/3/ikx/CGJEp4fWiU6AQ9lbIugIu2KuJ25yivvZ8GQUv9Y/c+TpVH32f7SWpCFeMsKPnD1A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>-->
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/ckeditor/4.0.1/ckeditor.js" integrity="sha512-bInPHQYV0tIhTh8G1j1RrFU1616Hi7b/zG9WHXEzljqKkbKvRvuimXKtNxJ2KxB6CIlTzbM8DCdkXbXQBCYjXQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>-->
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/quill/2.0.0/quill.min.js" integrity="sha512-JCbKR+ic1suPXjhrjk+rUAD92EHFMdlDeXJimfMZ8DrJNJclsM4K0+mgWoFT2Tz0sEWwcocijCJXqTS7BzDESw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>-->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/quill/1.3.7/quill.snow.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/quill/1.3.7/quill.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>

<script>
    
//         CKEDITOR.replace( 'description', {
//             allowedContent:true,
//         });
var toolbarOptions = [
    [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
    //['bold', 'italic', 'underline', 'strike'],        // toggled buttons
    ['bold', 'italic', 'underline'], 
    // ['blockquote', 'code-block'],
 
    // [{ 'header': 1 }, { 'header': 2 }],               // custom button values
    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
    // [{ 'script': 'sub'}, { 'script': 'super' }],      // superscript/subscript
    // [{ 'indent': '-1'}, { 'indent': '+1' }],          // outdent/indent
    // [{ 'direction': 'rtl' }],                         // text direction

    // [{ 'size': ['small', false, 'large', 'huge'] }],  // custom dropdown
    
    [{ 'align': [] }],

    // [{ 'color': [] }, { 'background': [] }],          // dropdown with defaults from theme
    // [{ 'font': [] }],
    // [{ 'align': [] }],
     ['link', 'image', 'video'],
    // ['clean']                                         // remove formatting button
];
// var quill = new Quill('#editor', {
//             modules: {
//               toolbar: toolbarOptions
//             },
//             theme: 'snow'
//         });
// Quill Editor setup
const quill = new Quill('#editor', {
  modules: {
    toolbar: toolbarOptions
  },
  theme: 'snow'
});

// Sync Quill content to hidden input as the user types
quill.on('text-change', function() {
    var content = quill.root.innerHTML;
    // If editor only contains <p><br></p>, treat as empty
    if (quill.getText().trim().length === 0) {
        content = "";
    }
    $('#description').val(content);
    // Trigger validation on change
    $('#description').valid();
});

$(document).ready(function() {
    // Initialize Accordion
    $("#accordion").accordion({
        heightStyle: "content",
        collapsible: true,
        active: 0 // Default to first section
    });

    // Function to expand section based on an element inside it
    function expandSectionWithError(element) {
        var $section = $(element).closest(".acc_content");
        if ($section.length) {
            var index = $("#accordion .acc_content").index($section);
            $("#accordion").accordion("option", "active", index);
            
            // Also scroll to the error
            $('html, body').animate({
                scrollTop: $(element).offset().top - 100
            }, 500);
        }
    }

    // Auto-expand for backend errors on page load
    setTimeout(function() {
        var $backendError = $(".invalid-feedback, .is-invalid").first();
        if ($backendError.length) {
            expandSectionWithError($backendError);
        }
    }, 100);

    $('#businessForm').validate({
        ignore: ".selectize-input input", // Validate hidden fields, but ignore Selectize dummy input
        invalidHandler: function(event, validator) {
            // Expand the first section that has a validation error
            if (validator.errorList.length > 0) {
                // Delay slightly to ensure jQuery Validate has finished its work
                setTimeout(function() {
                    expandSectionWithError(validator.errorList[0].element);
                }, 10);
            }
        },
        rules: {
            homebased_business: { required: true },
            company_name: { required: true, maxlength: 255 },
            display_name: { required: true, maxlength: 255 },
            category: { required: true },
            subcat: { required: true },
            description: { 
                required: true,
                minlength: 50 // Minimum 50 characters of content
            },
            contact_person: { required: true, maxlength: 255 },
            email: { required: true, email: true, maxlength: 255 },
            country: { required: true },
            phone_no: { required: true, maxlength: 20 },
            street_address: { required: true, maxlength: 255 },
            city_id: { required: true },
            display_addrs: { required: true }
        },
        messages: {
            company_name: "Please enter your company name.",
            display_name: "Please enter a display name.",
            category: "Please select a primary category.",
            subcat: "Please select a secondary category.",
            description: "Please provide a business description (min. 50 characters).",
            email: "Please enter a valid email address.",
            phone_no: "Please enter a contact phone number.",
            street_address: "Please enter the street address.",
            city_id: "Please select your town/city.",
            display_addrs: "Please decide if you want to display your address."
        },
        errorElement: 'span',
        errorClass: 'error',
        errorPlacement: function(error, element) {
            if (element.attr("name") == "homebased_business" || element.attr("name") == "display_addrs") {
                error.appendTo(element.closest(".frm_dv, .disflex"));
            } else if (element.hasClass("selectize-control") || element.next().hasClass("selectize-control")) {
                error.insertAfter(element.next(".selectize-control"));
            } else if (element.attr("id") == "description") {
                error.appendTo(element.closest(".frm_dv"));
            } else {
                error.insertAfter(element);
            }
        },
        highlight: function(element) {
            $(element).addClass('error');
            if ($(element).attr("type") == "radio") {
                $(element).closest('.frm_dv').addClass('error-container');
            }
            if ($(element).next().hasClass('selectize-control')) {
                $(element).next().find('.selectize-input').addClass('error');
            }
        },
        unhighlight: function(element) {
            $(element).removeClass('error');
            if ($(element).attr("type") == "radio") {
                // Check if any other radio in the same group still has an error
                var name = $(element).attr("name");
                if ($('input[name="' + name + '"].error').length === 0) {
                    $(element).closest('.frm_dv').removeClass('error-container');
                }
            }
            if ($(element).next().hasClass('selectize-control')) {
                $(element).next().find('.selectize-input').removeClass('error');
            }
        },
        submitHandler: function(form) {
            // Final sync just in case
            $('#description').val(quill.root.innerHTML);
            if (quill.getText().trim().length === 0) {
                $('#description').val("");
            }
            
            if ($('#businessForm').valid()) {
                form.submit();
            }
        }
    });

    // Handle Continue button clicks
    $(document).on('click', '.btn_continue', function() {
        var $section = $(this).closest('.acc_content');
        var isValid = true;
        
        // Find all inputs, selects, and textareas in the current section
        $section.find('input, select, textarea').each(function() {
            // Some inputs might be hidden but need validation (like the Quill description)
            // The validator.element() method triggers validation for a single element
            if (!$("#businessForm").validate().element(this)) {
                isValid = false;
            }
        });

        if (isValid) {
            var currentIndex = $("#accordion .acc_content").index($section);
            $("#accordion").accordion("option", "active", currentIndex + 1);
            
            // Wait for accordion animation to finish before scrolling
            setTimeout(function() {
                var $nextHeader = $("#accordion h3").eq(currentIndex + 1);
                if ($nextHeader.length) {
                    $('html, body').animate({
                        scrollTop: $nextHeader.offset().top - 10
                    }, 300);
                }
            }, 350);
        }
    });
});
// $(document).on('click','#addbusinesssubmit', function(event) {
//     event.preventDefault(); // Prevent the default form submission
//     if (!$('#businessForm').valid()) return;
//     //if(istrue){
//         
//         $.ajax({
//                     url: '<?= route('business.list.insert')  ?>',
//                     method: 'POST',
//                     data: new FormData($('#businessForm')[0]),
//                     contentType: false,
//                     processData: false,
//                     success: function(response) {
//                         if (response.success) {
//                             //alert(response.message);
//                             // Perform any additional actions on success
//                             Swal.fire({
//                                 title: '',
//                                 text: "Congratulations on listing your new homebased business on catchakiwi.You will now be taken to the dashboard.",
//                                 icon: 'success',
//                                 confirmButtonColor: '#3085d6',
//                                 confirmButtonText: 'Continue'
//                             }).then((result) => {
//                                 if (result.isConfirmed) {
//                                     window.location.href = '/profile';
//                                 }
//                             });    
//                         }
//                     },
//                     error: function(response) {
//                         // Handle validation errors
//                         if (response.status === 422) {
//                             let errors = response.responseJSON.errors;
//                             alert(errors.company_name[0]);
//                             $("input[name=company_name])").val("");
//                             // var validator = $('#businessForm').validate();
//                             // validator.resetForm();  // Resets the form's validation messages
//                             // validator.reset();      // Resets the form's internal state
//                             // $('#businessForm').find('.error').removeClass('error');
//                             // $.each(errors, function(key, value) {
//                             //     //alert(value[0]); // Display the first error message
//                             // });
//                         }
//                     }
//                 });
//     //}
// })
 </script>
<script>
    $('.category').selectize({
        create: false,
        placeholder: 'Select category',
        render: {
            no_results: function(data, escape) {
                return '<div class="no-results">No results found</div>';
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
        onChange: function(value) {
            if (value) {
                $(this.$input).valid();
            }
        }
    });

    $('.addressdd').selectize({
        create: false,
        render: {
            no_results: function(data, escape) {
                return '<div class="no-results">No results found</div>';
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
        onChange: function(value) {
            if (value) {
                $(this.$input).valid();
            }
        }
    });

$(document).on('change', '#category', function() {
    var catId = $(this).val();
    var selectizeInstance = $('#subcat')[0].selectize;
    var oldSubcat = "{{ old('subcat') }}";
    
    $.ajax({
        type: 'POST',
        url: "ajaxcontroller/getsubcat",
        data:  "_token="+$('input[name="_token"]').val()+"&catid="+catId,
        dataType: "json",
        async: false,
        success: function(response) { 
            $('.selectize-control').show();
            selectizeInstance.clearOptions();
            selectizeInstance.addOption(response);
            
            if(oldSubcat) {
                selectizeInstance.setValue(oldSubcat);
            }
            
            selectizeInstance.refreshOptions(false);
        } 
    });
});
// Trigger category change on load if value exists
if($('#category').val()) {
    $('#category').trigger('change');
}

$(document).on('change', '.homebased_business', function(){
    if($(this).val()=="Yes"){
        $('.notification_homebased').show();
        $(".bestsuitsyou").hide();
    }else{
        $('.notification_homebased').hide();
        $(".bestsuitsyou").show();
    }
}); 
// Trigger radio check on load
$('.homebased_business:checked').trigger('change');
</script>
<script>
$(document).ready(function () {
        $('#country_select').change(function () {
            var selectizeInstance = $('#city_id')[0].selectize;
            var countryId = $(this).val();
            var oldCityId = "{{ old('city_id') }}";
            
            $.ajax({
                url: 'GetCityStatesameVal',
                method: 'POST',
                data: {
                    country_id: countryId,
                    _token: $('input[name="_token"]').val()
                },
                success: function (response) {
                    var options = JSON.parse(response);
                    $('.selectize-control').show();
                    
                    if (countryId == 157) {
                        selectizeInstance.settings.placeholder = 'Select Suburb/Town';
                    } else {
                        selectizeInstance.settings.placeholder = 'Select City/State';
                    }
                    selectizeInstance.updatePlaceholder();

                    selectizeInstance.clearOptions();
                    selectizeInstance.addOption(options);
                    
                    if(oldCityId) {
                        selectizeInstance.setValue(oldCityId);
                    }
                    
                    selectizeInstance.refreshOptions(false);
                },
                error: function (xhr, status, error) {
                    console.error(error);
                }
            });
        });
        $('#country_select').trigger('change');
    });
    // $(document).ready(function() {
    //         $('#addbusinesssubmit').click(function() {
                
    //             return false;
    //         });
    //     });
    // $(document).ready(function () {
    //     $('#country_select').change(function () {
    //         var countryId = $(this).val();
    //         var selectizeInstance = $('#state_id')[0].selectize;
    //         //console.log(selectizeInstancest);
    //         //alert(countryId);
            
    //         $.ajax({
    //             type: 'POST',
    //             url: "getstateforselectsize",
    //             data:  "_token="+$('input[name="_token"]').val()+"&country_id="+countryId+"&request_for=state",
    //             dataType: "json",
    //             async: false,
    //             success: function(response) { 
    //             console.log(response)   
    //             console.log(response)
    //                 $('.selectize-control').show();
    //                 //$('.cityid').show();
    //                 //$('#cityid').html(response);
        
    //                 selectizeInstance.clearOptions();
    //                 selectizeInstance.addOption(response);
    //                 // Refresh the dropdown to display new options
    //                 selectizeInstance.refreshOptions(false);
                
    //             } 
    //         });
    //     });
    //     $('#country_select').trigger('change');
        
    //     $('#state_id').change(function () {
    //         var stateId = $(this).val();
    //         var selectizeInstance = $('#town_id')[0].selectize;
    //         var selectizeInstancecity = $('#city_id')[0].selectize;
    //         //console.log(selectizeInstancest);
    //         //alert(countryId);
            
    //         $.ajax({
    //             type: 'POST',
    //             url: "getstateforselectsize",
    //             data:  "_token="+$('input[name="_token"]').val()+"&state_id="+stateId+"&request_for=city",
    //             dataType: "json",
    //             async: false,
    //             success: function(response) { 
    //             console.log(response)   
    //             console.log(response)
    //                 $('.selectize-control').show();
    //                 //$('.cityid').show();
    //                 //$('#cityid').html(response);
        
    //                 selectizeInstance.clearOptions();
    //                 selectizeInstance.addOption(response);
    //                 // Refresh the dropdown to display new options
    //                 selectizeInstance.refreshOptions(false);
                    
    //                 selectizeInstancecity.clearOptions();
    //                 selectizeInstancecity.addOption(response);
    //                 // Refresh the dropdown to display new options
    //                 selectizeInstancecity.refreshOptions(false);
                
    //             } 
    //         });
    //     });
    // });
    
</script>


