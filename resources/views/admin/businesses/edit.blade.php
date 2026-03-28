@include('includes/admin-header')
@include('includes/admin-sidebar')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/quill/1.3.7/quill.snow.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/quill/1.3.7/quill.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>

<style>
/* Hide the label */
label[for="editor"] {
    display: none;
}
#editor{
    min-height:200px;
    background: white;
    color: black;
}
.ql-editor h1, .ql-editor h2, .ql-editor h3,
.ql-editor h4, .ql-editor h5, .ql-editor h6 {
    color: inherit;
}
.ql-toolbar {
    background: white;
    border: 1px solid #ccc;
}
.help_icon {
    cursor: pointer;
    margin-left: 5px;
}
.help_icontxt {
    display: none;
    background: #f8f9fa;
    padding: 10px;
    border-radius: 4px;
    margin-top: 5px;
    font-size: 12px;
    color: #666;
}
.disflex {
    display: flex;
    align-items: center;
    gap: 15px;
}
.notification_homebased {
    background: #d4edda;
    color: #155724;
    padding: 10px;
    border-radius: 4px;
    margin-top: 10px;
}

/* Fix form control styling for better visibility */
.form-control {
    background-color: white !important;
    color: #495057 !important;
    border: 1px solid #ced4da;
    border-radius: 4px;
    padding: 8px 12px;
}

.form-control:focus {
    background-color: white !important;
    color: #495057 !important;
    border-color: #80bdff;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}

.form-control option {
    background-color: white !important;
    color: #495057 !important;
    padding: 8px 12px;
}

/* Ensure select dropdowns are visible */
select.form-control {
    background-color: white !important;
    color: #495057 !important;
    appearance: none;
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
    background-position: right 8px center;
    background-repeat: no-repeat;
    background-size: 16px 12px;
    padding-right: 40px;
}

select.form-control option {
    background-color: white;
    color: #495057;
}

/* Fix pagination styling only */
.pagination {
    margin: 0;
    padding: 0;
}

.page-item .page-link {
    color: #6c757d;
    background-color: #fff;
    border: 1px solid #dee2e6;
    padding: 8px 12px;
    font-size: 14px;
    line-height: 1.25;
    border-radius: 4px;
    margin: 0 2px;
}

.page-item.active .page-link {
    background-color: #007bff;
    border-color: #007bff;
    color: white;
}

.page-item.disabled .page-link {
    color: #6c757d;
    background-color: #fff;
    border-color: #dee2e6;
    opacity: 0.5;
}

.page-item .page-link:hover {
    color: #0056b3;
    background-color: #e9ecef;
    border-color: #dee2e6;
}

.dataTables_info {
    padding-top: 8px;
    color: #6c757d;
    font-size: 14px;
}

.dataTables_paginate {
    display: flex;
    justify-content: flex-end;
    align-items: center;
}

/* Override default Laravel pagination styling */
.pagination .page-link {
    position: relative;
    display: block;
    color: #007bff;
    text-decoration: none;
    background-color: #fff;
    border: 1px solid #dee2e6;
    transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
}

.pagination .page-item:first-child .page-link {
    border-top-left-radius: 4px;
    border-bottom-left-radius: 4px;
}

.pagination .page-item:last-child .page-link {
    border-top-right-radius: 4px;
    border-bottom-right-radius: 4px;
}

.pagination .page-item.active .page-link {
    z-index: 3;
    color: #fff;
    background-color: #007bff;
    border-color: #007bff;
}

.pagination .page-item.disabled .page-link {
    color: #6c757d;
    pointer-events: none;
    background-color: #fff;
    border-color: #dee2e6;
}
</style>

<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">Edit Business</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.businesses.index') }}">Business</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit Business</li>
            </ol>
        </nav>
    </div>

    {{-- Success/Error Messages --}}
    @if(session('success'))
        <script>
            Swal.fire({
                title: 'Success!',
                text: 'Business updated successfully!',
                icon: 'success',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK'
            });
        </script>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Edit Business: {{ $business->company_name }}</h4>
                    
                    {{-- Business Owner Info --}}
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6>Business Owner Information:</h6>
                            <p><strong>Name:</strong> {{ $business->user->name }}</p>
                            <p><strong>Email:</strong> {{ $business->user->email }}</p>
                            <p><strong>Location:</strong> {{ $locationInfo['city_name'] ?? 'N/A' }}, {{ $locationInfo['state_name'] ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6>Business Information:</h6>
                            <p><strong>Business ID:</strong> {{ $locationInfo['country_name'] ?? 'BIZ' }}000{{ $business->id }}</p>
                            <p><strong>Created:</strong> {{ $business->created_at->format('Y-m-d H:i:s') }}</p>
                            <p><strong>Last Updated:</strong> {{ $business->updated_at->format('Y-m-d H:i:s') }}</p>
                        </div>
                    </div>

                    <form action="{{ route('admin.businesses.update', $business->id) }}" method="POST" id="businessForm" onsubmit="formsub()" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        {{-- Listing Details Section --}}
                        <div class="card mb-4">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0">Listing Details</h5>
                            </div>
                            <div class="card-body">
                                {{-- Homebased Business --}}
                                <div class="form-group">
                                    <div class="disflex">
                                        <p><strong>Homebased Startup Business? *</strong></p>
                                        <label>
                                            <input name="homebased_business" class="homebased_business" type="radio" value="yes" 
                                                   {{ strtolower($business->homebased_business) == 'yes' ? 'checked' : '' }} required> Yes
                                        </label>
                                        <label>
                                            <input name="homebased_business" class="homebased_business" type="radio" value="no"
                                                   {{ strtolower($business->homebased_business) == 'no' ? 'checked' : '' }}> No
                                        </label>
                                    </div>
                                    <div class="notification_homebased" style="display:none;">
                                        Welcome! Homebased startups get a free membership to most of our services
                                    </div>
                                </div>

                                {{-- Best Suits You --}}
                                <div class="form-group bestsuitsyou" style="display:{{ strtolower($business->homebased_business) == 'yes' ? 'none' : 'block' }};">
                                    <label>Please choose the option which best suits you</label>
                                    <select name="suits_you" class="form-control">
                                        <option value="Homebased, older than one year" {{ $business->suits_you == 'Homebased, older than one year' ? 'selected' : '' }}>Homebased, older than one year</option>
                                        <option value="Company business Less than 5 employees" {{ $business->suits_you == 'Company business Less than 5 employees' ? 'selected' : '' }}>Company business Less than 5 employees</option>
                                        <option value="Company Business with 5 or more employees" {{ $business->suits_you == 'Company Business with 5 or more employees' ? 'selected' : '' }}>Company Business with 5 or more employees</option>
                                    </select>
                                </div>

                                <div class="row">
                                    {{-- Company Name --}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>My Company Name *</label>
                                            <input name="company_name" type="text" class="form-control" value="{{ $business->company_name }}" required>
                                        </div>
                                    </div>

                                    {{-- Display Name --}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Display Name *</label>
                                            <input name="display_name" type="text" class="form-control" value="{{ $business->display_name }}" required>
                                            <img src="{{ asset('assets/images/help_icon.png') }}" alt="" class="help_icon">
                                            <div class="help_icontxt">This is how your listing will show up. Use your usual company name, or swap it out for something that fits the job or gig better, up to you.</div>
                                        </div>
                                    </div>

                                    {{-- Primary Category --}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Primary Category *</label>
                                            <select name="primary_category" id="category" class="form-control category" required>
                                                <option value="">Select Category</option>
                                                @if(!empty($categories))
                                                    @foreach($categories as $cat)
                                                        <option value="{{ $cat->id }}" {{ $business->primary_category == $cat->id ? 'selected' : '' }}>{{ $cat->title }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>

                                    {{-- Secondary Category --}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Secondary Category *</label>
                                            <select id="subcat" class="form-control category" name="secondary_category" required>
                                                <option value="">Select Secondary Category</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                {{-- Business Description with Quill Editor --}}
                                <div class="form-group">
                                    <label>Business Description *</label>
                                    <div id="editor">{!! $business->business_description !!}</div>
                                    <input type="hidden" name="business_description" id="description" value="{{ $business->business_description }}">
                                </div>

                                {{-- Business Image --}}
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <label>Select Image</label>
                                            <input name="imageUpload" type="file" id="businessimage" class="form-control-file imageUpload">
                                            <input type="hidden" name="base64image" id="base64image">
                                        </div>
                                        <div class="col-md-4">
                                            @if($business->select_image)
                                                <img class="cropimg img-fluid" src="{{ asset($business->select_image) }}" alt="Business Image" style="max-width: 200px; height: auto;">
                                            @else
                                                <img class="cropimg img-fluid" alt="No Image" style="max-width: 200px; height: 150px; background: #f8f9fa; border: 1px dashed #ddd;">
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Contact Details Section --}}
                        <div class="card mb-4">
                            <div class="card-header bg-success text-white">
                                <h5 class="mb-0">Complete Your Contact Details <span>(Required)</span></h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    {{-- Contact Person --}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Contact Person *</label>
                                            <input name="contact_person" type="text" class="form-control" value="{{ $business->contact_person }}" required>
                                        </div>
                                    </div>

                                    {{-- Email Address --}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Email Address *</label>
                                            <input name="email_address" type="email" class="form-control" value="{{ $business->email_address }}" required>
                                        </div>
                                    </div>

                                    {{-- Country --}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Country *</label>
                                            <select class="form-control" name="country" id="country_select" required>
                                                <option value="" disabled>Select Country</option>
                                                @if(!empty($countries))
                                                    @foreach($countries as $cnty)
                                                        <option value="{{ $cnty->id }}" {{ $business->country == $cnty->id ? 'selected' : '' }}>{{ $cnty->name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>

                                    {{-- Main Phone --}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Main phone *</label>
                                            <input name="main_phone" type="text" class="form-control" value="{{ $business->main_phone }}" required>
                                        </div>
                                    </div>

                                    {{-- Secondary Phone --}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Secondary phone</label>
                                            <input name="secondary_phone" type="text" class="form-control" value="{{ $business->secondary_phone }}">
                                        </div>
                                    </div>

                                    {{-- Website URL --}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Website URL</label>
                                            <input name="website_url" type="url" class="form-control" value="{{ $business->website_url }}">
                                        </div>
                                    </div>

                                    {{-- Street Address --}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Enter Street Address *</label>
                                            <input name="address" type="text" class="form-control" value="{{ $business->address }}" required>
                                        </div>
                                    </div>

                                    {{-- Apartment Number --}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Enter apartment number</label>
                                            <input name="apartment_number" type="text" class="form-control" value="{{ $business->apartment_number }}">
                                        </div>
                                    </div>

                                    {{-- City/Region --}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Town/suburb, City/District, Region *</label>
                                            <select class="form-control addressdd" name="region" id="city_id" required>
                                                <option value="">Select City/District</option>
                                            </select>
                                        </div>
                                    </div>

                                    {{-- Map --}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Map (Note: Paste your address Share Embed link here)</label>
                                            <input name="map" type="text" class="form-control" value="{{ $business->map }}">
                                        </div>
                                    </div>

                                    {{-- Display Address --}}
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label><strong>Display Address? *</strong></label>
                                            <div>
                                                <label class="mr-3">
                                                    <input name="display_address" type="radio" value="yes" {{ $business->display_address == 'yes' ? 'checked' : '' }}> Yes
                                                </label>
                                                <label>
                                                    <input name="display_address" type="radio" value="no" {{ $business->display_address == 'no' ? 'checked' : '' }}> No
                                                </label>
                                                <small class="form-text text-muted">Yes display your business address on your public listing - No keeps it confidential</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Social Networks Section --}}
                        <div class="card mb-4">
                            <div class="card-header bg-info text-white">
                                <h5 class="mb-0">Add your social networks <span>(optional)</span></h5>
                            </div>
                            <div class="card-body social_inputlinks">
                                <div class="row">
                                    {{-- Facebook --}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Facebook</label>
                                            <input class="form-control fb" name="facebook" type="text" value="{{ $business->facebook }}" placeholder="https://www.facebook.com/profile.php?id=your_id&ref=bookmarks">
                                        </div>
                                    </div>

                                    {{-- LinkedIn --}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>LinkedIn</label>
                                            <input class="form-control in" name="linkedIn" type="text" value="{{ $business->linkedIn }}" placeholder="https://linkedin.com/in/your_id">
                                        </div>
                                    </div>

                                    {{-- Twitter --}}
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Twitter</label>
                                            <input class="form-control twitter" name="twitter" type="text" value="{{ $business->twitter }}" placeholder="https://twitter.com/your_id">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Status --}}
                        <div class="card mb-4">
                            <div class="card-header bg-warning text-dark">
                                <h5 class="mb-0">Business Status</h5>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Status *</label>
                                    <select class="form-control" name="status" required>
                                        <option value="1" {{ $business->status == '1' ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ $business->status == '0' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group text-right">
                            <button type="submit" class="btn btn-primary btn-lg">Update Business</button>
                            <a href="{{ route('admin.businesses.index') }}" class="btn btn-secondary btn-lg">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@include('includes/admin-footer')

<script>
// Quill Editor Setup
var toolbarOptions = [
    [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
    ['bold', 'italic', 'underline'], 
    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
    [{ 'align': [] }],
    ['link', 'image', 'video'],
];

const quill = new Quill('#editor', {
    modules: {
        toolbar: toolbarOptions
    },
    theme: 'snow'
});

function formsub(){
    var quillContent = document.querySelector('input[name=business_description]');
    quillContent.value = quill.root.innerHTML;   
}

// Help Icon Toggle
$(document).on('click','.help_icon',function(){
    $('.help_icontxt').toggle();
});

// Homebased Business Toggle
$(document).on('change', '.homebased_business', function(){
    if($(this).val()=="yes"){
        $('.notification_homebased').show();
        $(".bestsuitsyou").hide();
    }else{
        $('.notification_homebased').hide();
        $(".bestsuitsyou").show();
    }
});

// Category and Subcategory Logic
$(document).on('change', '#category', function() {
    var catId = $(this).val();
    var oldcatId = @json($business->primary_category ?? null);
    var selectedSecondary = @json($business->secondary_category ?? null);
    
    $.ajax({
        type: 'POST',
        url: "{{ url('/') }}/ajaxcontroller/getsubcat",
        data: {
            "_token": $('input[name="_token"]').val(),
            "catid": catId,
            "selected": selectedSecondary
        },
        dataType: "json",
        success: function(response) { 
            console.log("Sub Cat", response);
            
            $('#subcat').empty();
            $('#subcat').append('<option value="">Select Secondary Category</option>');
            
            $.each(response, function(key, value) {
                var selected = (selectedSecondary == value.value) ? 'selected' : '';
                $('#subcat').append('<option value="' + value.value + '" ' + selected + '>' + value.text + '</option>');
            });
        },
        error: function(xhr, status, error) {
            console.error('Subcategory AJAX Error:', error);
        }
    });
});

// Trigger category change on page load to populate subcategory
$("#category").trigger("change");

// Country and City Logic
$(document).ready(function () {
    $('#country_select').change(function () {
        var countryId = $(this).val();
        var oldCountry = @json($business->country ?? null);
        var selectedRegion = @json($business->region ?? '');
        
        $.ajax({
            url: '{{ url('/') }}/GetCityStatesameVal',
            method: 'POST',
            data: {
                "country_id": countryId,
                "_token": $('input[name="_token"]').val(),
                "selected": selectedRegion
            },
            success: function (response) {
                console.log('City Response:', response);
                
                $('#city_id').empty();
                if (countryId == 157) {
                    $('#city_id').append('<option value="">Select Suburb/Town</option>');
                } else {
                    $('#city_id').append('<option value="">Select City/State</option>');
                }
                
                try {
                    var data = JSON.parse(response);
                    $.each(data, function(key, value) {
                        var selected = (selectedRegion == value.value) ? 'selected' : '';
                        $('#city_id').append('<option value="' + value.value + '" ' + selected + '>' + value.text + '</option>');
                    });
                } catch(e) {
                    console.error('Error parsing city response:', e);
                }
            },
            error: function (xhr, status, error) {
                console.error('City AJAX Error:', error);
            }
        });
    });
    
    // Only trigger if country select exists and has a value
    if ($('#country_select').length && $('#country_select').val()) {
        $('#country_select').trigger('change');
    }
});

// Form Validation
$(document).ready(function() {
    $('#businessForm').validate({
        rules: {
            company_name: {
                required: true,
                maxlength: 255
            },
            display_name: {
                required: true,
                maxlength: 255
            },
            business_description: {
                required: true,
                minlength: 100,
                maxlength: 1000
            },
            imageUpload: {
                extension: "jpg|jpeg|png|gif",
                filesize: 2048
            },
            email_address: {
                required: true,
                email: true,
                maxlength: 255
            },
            main_phone: {
                required: true,
                maxlength: 15
            },
            address: {
                required: true,
                maxlength: 255
            },
            display_address: {
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
            business_description: {
                required: "Please enter a description.",
                minlength: "Description must be at least 100 characters.",
                maxlength: "Description must not exceed 1000 characters."
            },
            imageUpload: {
                extension: "Please upload an image file (jpg, jpeg, png, gif) only.",
                filesize: "Image must be less than 2 MB."
            },
            email_address: {
                required: "Please enter your email address.",
                email: "Please enter a valid email address.",
                maxlength: "Email address must not exceed 255 characters."
            },
            main_phone: {
                required: "Please enter your phone number.",
                maxlength: "Phone number must not exceed 15 characters."
            },
            address: {
                required: "Please enter your address.",
                maxlength: "Address must not exceed 255 characters."
            },
            display_address: {
                required: "Please select Yes or No."
            }
        },
        submitHandler: function(form) {
            // Set the description content from Quill editor before submitting
            var quillContent = document.querySelector('input[name=business_description]');
            quillContent.value = quill.root.innerHTML;
            form.submit();
        }
    });
});

// Custom file size validation method
$.validator.addMethod('filesize', function (value, element, param) {
    return this.optional(element) || (element.files[0].size <= param * 1024);
}, 'File size must be less than {0} KB');
</script>