@include('includes/inner-header')
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
        .address-input-wrapper {
            display: inline-block;
            vertical-align: top;
            width: 455px;
            max-width: 100%;
            position: relative;
        }
        @media (max-width: 768px) {
            .address-input-wrapper {
                display: block !important;
                width: 100% !important;
            }
        }
    </style>
    
<div class="modal fade bd-example-modal-lg imagecrop" id="model" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                  <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Crop Image</h5>
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
<!--<div class="top_search nomob_search">-->
<!--<div class="container">-->
    <!--<div class="logo"><h1><a href="/"><img src="{{ asset('assets/images/logo-inner.png') }}" alt="" /></a></h1></div>-->
<!--    </div>-->
<!--<div class="container">-->
<!--<div class="home_midbody">-->
<!--<div class="home_searchsec">-->
<!--<form action="" method="post">-->
<!--<input name="" type="text" placeholder="Services I’m looking for" />-->
<!--<input name="" type="text" placeholder="Enter your location" class="location" />-->
<!--<input name="" type="submit" value="Search" />-->
<!--</form>-->
<!--</div>-->
<!--</div>-->
<!--</div>-->
<!--</div>-->
<!-- Header start end-->

<!-- body start-->
<div class="mid_body">
<div class="container">
<!--<div class="profile_banner">-->
<!--  <img src="{{ asset($profile->profile_banner) }}" alt="">-->
<!--  <div class="profile_pic"><img src="{{ asset($profile->image) }}" alt=""></div>-->
<!--  </div>-->
<div class="profile_heading">
  <h2>Edit your Business<br><br>
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
<form action="{{ route('business.list.update', $business->id) }}" id="businessForm" method="post" onsubmit="formsub()" enctype="multipart/form-data">
    @csrf
    @method('PUT')
<div id="accordion" class="tab_form">
  <h3>Listing Details</h3>
  <div class="acc_content"> 
    <div class="homebased_option">
     <div class="disflex">
    <p>Homebased Startup Business? *</p>
    <label><input name="homebased_business" id="1" class="homebased_business" type="radio" value="Yes" {{ strtolower($business->homebased_business) == 'yes' ? 'checked' : '' }} required>Yes</label>
    <label><input name="homebased_business" id="2" class="homebased_business" type="radio" value="No" {{ strtolower($business->homebased_business) == 'no' ? 'checked' : '' }}> No</label>
      </div>
     <div class="notification_homebased" style="display:none;">Welcome! Homebased startups get a free membership to most of our services</div> 
    </div>
    <div class="frm_dv bestsuitsyou" style="display:{{ strtolower($business->homebased_business) == 'yes' ? 'none' : 'block' }};">
    <label>Please choose the option which best suits you</label>
        <select name="bestsuitsyou">
       <!--<option value="Startup homebased first year" {{ $business->suits_you == 'Startup homebased first year' ? 'selected' : '' }}>Startup homebased first year</option>-->
            <option value="Homebased, older than one year" {{ $business->suits_you == 'Homebased, older than one year' ? 'selected' : '' }}>Homebased, older than one year</option>
            <option value="Company business Less than 5 employees" {{ $business->suits_you == 'Company business Less than 5 employees' ? 'selected' : '' }}>Company business Less than 5 employees</option>
            <option value="Company Business with 5 or more employees" {{ $business->suits_you == 'Company Business with 5 or more employees' ? 'selected' : '' }}>Company Business with 5 or more employees</option>
        </select>
    </div>
    <div class="frm_dv">
    <label>My Company Name *</label>
    <input name="company_name" type="text" class="@error('company_name') is-invalid @enderror" value="{{ old('company_name', $business->company_name) }}" placeholder="" required>
    @error('company_name')
        <span class="invalid-feedback">{{ $message }}</span>
    @enderror
    </div>
    <div class="frm_dv">
    <label>Display Name *</label>
    <input name="display_name" type="text" placeholder="Display name" value="{{ old('display_name', $business->display_name) }}" class="@error('display_name') is-invalid @enderror" required>
    @error('display_name')
        <span class="invalid-feedback">{{ $message }}</span>
    @enderror
    <img src="{{ asset('assets/images/help_icon.png') }}" alt="" class="help_icon">
    <div class="help_icontxt">This is how your listing will show up. Use your usual company name, or swap it out for something that fits the job or gig better, up to you.</div>
    </div>
    <div class="frm_dv catfield">
    <label>Primary Category  *</label>
    <select name="category" id="category" class="category selectsize" required>
        <option value="">Select Category</option>
        @if(!empty($category))
            @foreach($category as $cat)
                <option value="{{ $cat['id'] }}" {{ $business->primary_category == $cat['id'] ? 'selected' : '' }}>{{ $cat['title'] }}</option>
            @endforeach
        @endif
    </select>
    </div>
    <div class="frm_dv catfield">
    <label>Secondary Category *</label>
    <select id="subcat" class="category selectsize" name="subcat" required>
        <!-- Populate secondary categories here based on the selected primary category -->
    </select>
    </div>
    <div class="frm_dv ">
        <label>Business Description</label>
        <img src="images/editor_image.png" alt=""> 
        <div id="editor">{!! $business->business_description !!}</div>
        <input type="hidden" name="description" id="description" value="{{ $business->business_description }}">
    </div>
    <div class="frm_dv frm_propic">
    <div class="browse_img busdes"><h4>Company Logo Or Image </h4>
      <div class="delimgwrap">
        <button type="button" class="remove-bus-image" style="display: {{ (old('base64image') || ($business->select_image && $business->select_image != 'assets/images/busines-defaultlogo.png')) ? 'flex' : 'none' }};" title="Remove image">&times;</button>
        <img class="cropimg bdrbox" src="{{ old('base64image') ? old('base64image') : asset(preg_replace('#^public[\\\/]#', '', $business->select_image)) }}" alt="">
      </div>
      <div class="newupload">
       <label>Select your business Logo or Image </label>
        <div class=customupbtn>
          <input name="imageUpload" type="file" id="businessimage" class="imageUpload" accept="image/*">
          <input type="hidden" name="base64image" id="base64image" value="{{ old('base64image') }}">
        </div>
    	
      </div>
     
    </div>
   </div>
  </div>
  <h3>Complete Your Contact Details <span>(Required)</span></h3>
  <div class="acc_content">
    <div class="frm_dv">
    <label>Contact Person *</label>
    <input name="contact_person" type="text" value="{{ $business->contact_person }}" required> 
    </div>
    <div class="frm_dv">
    <label>Email Address  *</label>
    <input name="email" type="text" value="{{ $business->email_address }}" required>
    </div>
    <div class="frm_dv">
    <label>Country *</label>
    <select class="livesearch " name="country" id="country_select" required>
      <option value="" disabled>Select Country</option>
      @if(!empty($country))
        @foreach($country as $cnty)
            <option value="{{$cnty['id']}}" {{ $business->country == $cnty['id'] ? 'selected' : '' }}>{{ $cnty['name'] }}</option>
        @endforeach
      @endif
      </select>
    </div>
    <div class="frm_dv m_phone">
    <label>Main phone *</label>
    <input name="phone_no" type="text" value="{{ $business->main_phone }}" required>
    </div>
    <div class="frm_dv m_phone">
    <label>Secondary phone</label>
    <input name="phone_no_two" type="text" value="{{ $business->secondary_phone }}">
    </div>
    <div class="frm_dv">
    <label>Website URL</label>
    <input name="website_url" type="text" value="{{ $business->website_url }}">
    </div>
    <div class="frm_dv catfield">
        <label class="dist">Address * </label>
        <div class="address-input-wrapper">
            <input 
                type="text" 
                name="city_id" 
                id="city_id" 
                class="street_address @error('city_id') is-invalid @enderror" 
                placeholder="Start typing your address…" 
                autocomplete="off" 
                value="{{ old('city_id', $business->region ? $business->region : $business->address) }}" 
                style="width: 100%;"
                required
            >
            <span id="city_id_spinner" style="display:none; position:absolute; right:10px; top:50%; transform:translateY(-50%); color:#9bcd22;">&#8987;</span>
            <ul id="city_id_suggestions" style="
                display:none;
                position:absolute;
                top:100%; left:0; right:0;
                background:#fff;
                border:1px solid #9bcd22;
                border-top:none;
                list-style:none;
                margin:0; padding:0;
                z-index:9999;
                max-height:220px;
                overflow-y:auto;
                box-shadow:0 4px 12px rgba(0,0,0,0.1);
            "></ul>
        </div>
        @error('city_id')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>

    <div class="frm_dv">
        <label>Enter unit or apartment number</label>
        <input name="appt_number" type="text" value="{{ $business->apartment_number }}" placeholder="Enter unit or apartment number">
    </div>
    
    <div class="frm_dv display_addrs">
        <label>Display Address? *</label>
        <input name="display_addrs" type="radio" value="yes" {{ $business->display_address == 'yes' ? 'checked' : '' }}>Yes
        <input name="display_addrs" type="radio" value="no" {{ ($business->display_address == 'no' || empty($business->display_address)) ? 'checked' : '' }}>No
        <span>Yes display your business address on your public listing - No keeps it confidential</span>
    </div>
  </div>
  <h3>Add your social networks <span>(optional)</span></h3>
  <div class="acc_content social_inputlinks">
    <div class="frm_dv">
    <label>Facebook</label>
    <input class="fb" name="facebook_prof" type="text" value="{{ $business->facebook }}">
    </div>
    <div class="frm_dv">
    <label>LinkedIn</label>
    <input class="in" name="linkedin" type="text" value="{{ $business->linkedIn }}">
    </div>
    <div class="frm_dv">
    <label>Twitter</label>
    <input class="twitter" name="twitter" type="text" value="{{ $business->twitter }}">
    </div>
  </div>
</div>
<input name="" type="submit" id="" value="Update Business">
  <a href="{{ URL::to('/profile') }}" class="editcancelbtn">Cancel</a>
</form>
</div>
</div>
<div class="col-lg-4 col-md-4 col-sm-12">
<div class="support_advertiser">
    <i class="fa fa-heart"></i>
    <span>Support our advertisers, catchakiwi exists because of them</span>
</div>
<div class="right_advertisesec">
  @if(!empty($sideData))
    @foreach ($sideData as $ad) 
        @if($ad->ads_image != "")
            <div class="ad-card">
                @if($ad->link)
                    <a href="{{ $ad->link }}" target="_blank">
                        <img src="{{ asset($ad->ads_image) }}" alt="">
                    </a>
                @else
                    <img src="{{ asset($ad->ads_image) }}" alt="">
                @endif
            </div>
        @endif 
    @endforeach
  @endif
</div>
</div>
</div>
</div>
</div>
</div>
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
const quill = new Quill('#editor', {
  modules: {
    toolbar: toolbarOptions
  },
  theme: 'snow'
});

// Sync Quill content to hidden input as the user types
quill.on('text-change', function() {
    var content = quill.root.innerHTML;
    if (quill.getText().trim().length === 0) {
        content = "";
    }
    $('#description').val(content);
    if ($('#description').length && typeof $('#description').valid === 'function') {
        $('#description').valid();
    }
});

function formsub(){
    var quillContent = document.querySelector('input[name=description]');
    if (quillContent) {
        quillContent.value = quill.root.innerHTML;
    }
}
function resetValidation() {
    var validator = $('#businessForm').validate();
    validator.resetForm();  // Resets the form's validation messages
    validator.reset();      // Resets the form's internal state
    $('#businessForm').find('.error').removeClass('error'); // Remove error classes
}
$(document).ready(function() {
    var istrue = false;
    $('#businessForm').validate({
        ignore: ".selectize-input input",
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
                var name = $(element).attr("name");
                if ($('input[name="' + name + '"].error').length === 0) {
                    $(element).closest('.frm_dv').removeClass('error-container');
                }
            }
            if ($(element).next().hasClass('selectize-control')) {
                $(element).next().find('.selectize-input').removeClass('error');
            }
        },
        rules: {
            company_name: {
                required: true,
                maxlength: 255
            },
            display_name: {
                required: true,
                maxlength: 255
            },
            description: {
                required: true,
                minlength: 50
            },
            imageUpload: {
                extension: "jpg|jpeg|png|gif",
                filesize: 2048  // Size in KB
            },
            email: {
                required: true,
                email: true,
                maxlength: 255
            },
            phone_no: {
                required: true,
                maxlength: 20
            },
            city_id: {
                required: true,
                maxlength: 255
            },
            display_addrs: {
                required: true
            }
        },
        messages: {
            company_name: {
                required: "Please enter your company name.",
                maxlength: "Company name must not exceed 255 characters."
            },
            display_name: {
                required: "Please enter display name.",
                maxlength: "Display name must not exceed 255 characters."
            },
            description: {
                required: "Please enter a description.",
                minlength: "Business description must be at least 50 characters."
            },
            imageUpload: {
                extension: "Please upload an image file (jpg, jpeg, png, gif) only.",
                filesize: "Image must be less than 2 MB."
            },
            email: {
                required: "Please enter your email address.",
                email: "Please enter a valid email address.",
                maxlength: "Email address must not exceed 255 characters."
            },
            phone_no: {
                required: "Please enter your phone number.",
                maxlength: "Phone number must not exceed 20 characters."
            },
            city_id: {
                required: "Please enter your address.",
                maxlength: "Address must not exceed 255 characters."
            },
            display_addrs: {
                required: "Please select Yes or No."
            }
        },
        submitHandler: function(form) {
            $('#description').val(quill.root.innerHTML);
            if (quill.getText().trim().length === 0) {
                $('#description').val("");
            }
            form.submit();
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
@include('includes/footer-js')
@include('includes/footer')
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
    let oldcatId = <?= $business->primary_category ?>;
    var selectizeInstance = $('#subcat')[0].selectize;
    selectizeInstance.setValue(""); 
    $.ajax({
        type: 'POST',
        url: "<?= URL::to('/')  ?>/ajaxcontroller/getsubcat",
        data:  "_token="+$('input[name="_token"]').val()+"&catid="+catId+"&selected="+<?= json_encode($business->secondary_category) ?>,
        dataType: "json",
        async: false,
        success: function(response) { 
        console.log("Sub Cat",response)       
            $('.selectize-control').show();
            //$('.cityid').show();
            //$('#cityid').html(response);

            selectizeInstance.clearOptions();
            selectizeInstance.addOption(response);
            // Refresh the dropdown to display new options
            selectizeInstance.refreshOptions(false);
            
            if(oldcatId == catId){
                //alert("here");
                var selectedValue = <?= json_encode($business->secondary_category) ?>;
                if (selectedValue) { 
                    selectizeInstance.setValue(selectedValue); 
                }
            }else {
                
            }
        } 
    });
});
$("#category").trigger("change"); 
$(document).on('change', '.homebased_business', function(){
    if($(this).val()=="Yes"){
        $('.notification_homebased').show();
        $(".bestsuitsyou").hide();
    }else{
        $('.notification_homebased').hide();
        $(".bestsuitsyou").show();
    }
}); 

// Hide bubble when focusing on other fields
$(document).on('focus', 'input:not(.homebased_business), select, textarea, .ql-editor', function() {
    $('.notification_homebased').fadeOut();
});

// Selectize focus needs special handling
$(document).on('mousedown', '.selectize-input', function() {
    $('.notification_homebased').fadeOut();
});
</script>

<script>
// ── OpenStreetMap Address Autocomplete for Edit Business ─────────────────
(function () {
    var addressInput   = document.getElementById('city_id');
    var suggestionsList = document.getElementById('city_id_suggestions');
    var spinner        = document.getElementById('city_id_spinner');
    var debounceTimer  = null;

    if (!addressInput) return;

    function hideSuggestions() {
        if (suggestionsList) {
            suggestionsList.innerHTML = '';
            suggestionsList.style.display = 'none';
        }
    }

    var selectedCountryCode = '{{ strtolower(session("CountryCode", "NZ")) }}';

    function updateCountryCode() {
        var countryText = $("#country_select option:selected").text().toLowerCase().trim();
        var countryVal  = $("#country_select").val();
        if (countryText.includes('new zealand') || countryVal == '157') {
            selectedCountryCode = 'nz';
        } else if (countryText.includes('australia')) {
            selectedCountryCode = 'au';
        } else if (countryText.includes('united kingdom') || countryText.includes('uk')) {
            selectedCountryCode = 'gb';
        } else if (countryText.includes('united states') || countryText.includes('us')) {
            selectedCountryCode = 'us';
        }
    }

    $('#country_select').change(function () {
        updateCountryCode();
    });
    updateCountryCode();

    function fetchSuggestions(q) {
        if (spinner) spinner.style.display = 'inline';
        var countryFilter = selectedCountryCode ? '&countrycodes=' + selectedCountryCode : '';
        fetch('https://nominatim.openstreetmap.org/search?format=json&addressdetails=1&limit=6&accept-language=en' + countryFilter + '&q=' + encodeURIComponent(q))
            .then(function(r) { return r.json(); })
            .then(function(d) {
                if (spinner) spinner.style.display = 'none';
                if (!suggestionsList) return;
                suggestionsList.innerHTML = '';
                if (!d || !d.length) { hideSuggestions(); return; }
                d.forEach(function(item) {
                    var label = item.display_name;
                    var li = document.createElement('li');
                    li.textContent = label;
                    li.style.cssText = 'padding:9px 14px; cursor:pointer; border-bottom:1px solid #f0f0f0; background:#fff; color:#333; font-size:14px; text-align:left;';
                    li.addEventListener('mouseenter', function() { li.style.background = '#f6fbf0'; });
                    li.addEventListener('mouseleave', function() { li.style.background = '#fff'; });
                    li.addEventListener('mousedown', function(e) {
                        e.preventDefault();
                        addressInput.value = label;
                        hideSuggestions();
                        if (typeof $(addressInput).valid === 'function') {
                            $(addressInput).valid();
                        }
                    });
                    suggestionsList.appendChild(li);
                });
                suggestionsList.style.display = 'block';
            }).catch(function() { if (spinner) spinner.style.display = 'none'; });
    }

    addressInput.addEventListener('input', function() {
        clearTimeout(debounceTimer);
        var q = this.value.trim();
        if (q.length < 3) { hideSuggestions(); return; }
        debounceTimer = setTimeout(function() { fetchSuggestions(q); }, 500);
    });

    addressInput.addEventListener('blur', function() {
        setTimeout(hideSuggestions, 200);
    });
})();
</script>
