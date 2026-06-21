@include('includes/inner-header')
<div class="mid_body">
    <div class="container">
        <div class="full_midpan">
            <div class="row">
                <div class="col-lg-8 col-md-8 col-sm-12">
                    <div class="left_notice">
                        <div class="left_searchresults">
                            <h3><img src="{{ asset('assets/images/notice_icon.png') }}" alt=""> Notice Board
                                <br>
                                <span><a href="{{ url('/') }}" style="color: #729b0f; text-decoration: none;">Home</a> >
                                    <a href="{{ route('notice-board') }}"
                                        style="color: #729b0f; text-decoration: none;">Notice Board</a> > Post
                                    Notice</span>
                            </h3>
                        </div>
                        <form action="{{ route('notice-submit') }}" method="post" enctype='multipart/form-data'>
                            @csrf
                            <div class="left_profileform notice_posefrm">
                                <div class="frm_dv">
                                    <label>Category:</label>
                                    <select name="category_id" id="category_id" required>
                                        <option value="">Choose your Category</option>
                                        @if(!empty($category))
                                            @foreach($category as $cat)
                                                <option value="{{ $cat->id }}" {{ $loop->first ? 'selected' : '' }}>
                                                    {{ $cat->category }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>

                                <div id="rest_of_fields" style="display:none;">
                                    <div id="item_options_fields" class="frm_dv" style="display:none;">
                                        <label>Item Options:</label>
                                        <div class="radiogbutt"><input name="item_type" type="radio" value="Item for sale" checked>
                                            Item for sale</div>
                                        <div class="radiogbutt"><input name="item_type" type="radio" value="Item Wanted">
                                            Item Wanted</div>
                                    </div>

                                    <div class="frm_dv">
                                        <label>Notice Options:</label>
                                        <div class="notice-options">
                                            <div class="radiogbutt"><input name="noticetype" type="radio" value="standard" {{ old('noticetype', 'standard') === 'standard' ? 'checked' : '' }}>
                                                7 day Notice (Free) $0.00</div>
                                            <div class="radiogbutt"><input name="noticetype" type="radio" value="feature" {{ old('noticetype') === 'feature' ? 'checked' : '' }}>
                                                28 day Feature Notice ( $3.00)
                                                <img src="images/help_icon.png" alt="" class="help_icon">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="frm_dv">
                                        <label>Notice Title:</label>
                                        <div style="flex: 1; display: block;">
                                            <input name="notice_title" id="notice_title" type="text" placeholder="Enter Notice Title (35 char max)" maxlength="35">
                                            <div id="title_counter" style="font-size: 12px; color: #666; text-align: right; margin-top: 4px; max-width: 535px;">0 / 35 characters</div>
                                        </div>
                                    </div>

                                    <!-- Get a Quote Fields -->
                                    <div id="get_a_quote_fields" style="display:none;">
                                        <div class="frm_dv">
                                            <label>I'm Looking for:</label>
                                            <select name="looking_for">
                                                <option value="">Select Service</option>
                                                <option value="Architect and Drafting">Architect and Drafting</option>
                                                <option value="Brick and block Laying">Brick and block Laying</option>
                                                <option value="Building">Building</option>
                                                <option value="Car Cleaning">Car Cleaning</option>
                                                <option value="Carpet and Furniture cleaning">Carpet and Furniture cleaning</option>
                                                <option value="Cleaning">Cleaning</option>
                                                <option value="Computer Help">Computer Help</option>
                                                <option value="Concreting">Concreting</option>
                                                <option value="Electrical">Electrical</option>
                                                <option value="Flooring">Flooring</option>
                                                <option value="Gardening">Gardening</option>
                                                <option value="Gib Fixing and Plastering">Gib Fixing and Plastering</option>
                                                <option value="Handy person">Handy person</option>
                                                <option value="House washing">House washing</option>
                                                <option value="Interior Design">Interior Design</option>
                                                <option value="Landscaping">Landscaping</option>
                                                <option value="Locksmith">Locksmith</option>
                                                <option value="Moving">Moving</option>
                                                <option value="Painting">Painting</option>
                                                <option value="Plumbing">Plumbing</option>
                                                <option value="Roofing">Roofing</option>
                                                <option value="Tiling">Tiling</option>
                                            </select>
                                        </div>
                                        <div class="frm_dv quote_location_dv">
                                            <label>Where do you need the job done?:</label>
                                            <div class="location_input_wrapper">
                                                <select name="job_location" id="quote_towns" placeholder="Select Suburb/City"></select>
                                            </div>
                                        </div>
                                        <div class="frm_dv">
                                            <label>When do you need the work to start?:</label>
                                            <select name="start_date">
                                                <option value="">Select Timing</option>
                                                <option value="Emergency">Emergency</option>
                                                <option value="ASAP">ASAP</option>
                                                <option value="Next few days">Next few days</option>
                                                <option value="I'm flexible">I'm flexible</option>
                                                <option value="Next few weeks">Next few weeks</option>
                                                <option value="Next few months">Next few months</option>
                                            </select>
                                        </div>
                                        <div class="frm_dv">
                                            <label>Budget:</label>
                                            <select name="budget">
                                                <option value="">Select Budget</option>
                                                <option value="Under $300">Under $300</option>
                                                <option value="$300 to $600">$300 to $600</option>
                                                <option value="$600 to $1000">$600 to $1000</option>
                                                <option value="More than $1000">More than $1000</option>
                                                <option value="Not sure">Not sure</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- $5 Service Deal Fields -->
                                    <div id="service_deal_fields" style="display:none;">
                                        <div class="frm_dv service_location_dv">
                                            <label>Town/Suburb:</label>
                                            <div class="location_input_wrapper">
                                                <select name="town_suburb" id="service_deal_towns" placeholder="Select Town/Suburb"></select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="frm_dv textareadv">
                                        <label id="body_label">Add your content: </label>
                                        <div style="flex: 1; display: block;">
                                            <textarea name="notice_body" id="notice_body" cols="" rows="" placeholder="Add notice body text (155 char max)." maxlength="155" style="width: 100%; max-width: 535px;"></textarea>
                                            <div id="body_counter" style="font-size: 12px; color: #666; text-align: right; margin-top: 4px; max-width: 535px;">0 / 155 characters</div>
                                        </div>
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
                                            height: 100px;
                                            aspect-ratio: 3/2;
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
                                            gap: 12px;
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

                                        .left_profileform .frm_dv .notice-options {
                                            display: grid;
                                            grid-template-columns: repeat(2, minmax(0, 1fr));
                                            width: 100%;
                                            max-width: 535px;
                                            gap: 12px;
                                        }

                                        .left_profileform .frm_dv .notice-options .radiogbutt {
                                            box-sizing: border-box;
                                            width: 100%;
                                            max-width: 100%;
                                            min-width: 0;
                                            overflow: hidden;
                                            white-space: nowrap;
                                        }

                                        /* Quote & Service Deal Location Field Enhancements */
                                        .quote_location_dv .location_input_wrapper,
                                        .service_location_dv .location_input_wrapper {
                                            flex: 1;
                                        }

                                        .quote_location_dv .selectize-control,
                                        .service_location_dv .selectize-control {
                                            width: 100%;
                                            max-width: 535px;
                                        }

                                        .quote_location_dv .selectize-input,
                                        .service_location_dv .selectize-input {
                                            padding: 0 12px !important;
                                            border: 1px solid #9bcd22 !important;
                                            border-radius: 0 !important;
                                            box-shadow: none !important;
                                            height: 40px !important;
                                            background: #fff url('{{ asset('assets/images/location_icon.png') }}') no-repeat !important;
                                            background-position: calc(100% - 12px) center !important;
                                            background-size: 14px !important;
                                            padding-right: 35px !important;
                                            display: flex !important;
                                            align-items: center !important;
                                            font-family: 'Poppins', sans-serif !important;
                                        }

                                        .left_profileform .frm_dv select,
                                        .left_profileform .frm_dv input[type="text"] {
                                            border: 1px solid #9bcd22 !important;
                                            height: 40px !important;
                                            border-radius: 0 !important;
                                            padding: 0 12px !important;
                                            width: 100% !important;
                                            max-width: 535px !important;
                                            background: #fff !important;
                                            font-family: 'Poppins', sans-serif !important;
                                            transition: border-color 0.3s ease;
                                        }

                                        .left_profileform .frm_dv select:hover,
                                        .left_profileform .frm_dv input[type="text"]:hover,
                                        .quote_location_dv .selectize-input:hover,
                                        .quote_location_dv .selectize-input.focus,
                                        .service_location_dv .selectize-input:hover,
                                        .service_location_dv .selectize-input.focus {
                                            border-color: #729b0f !important;
                                            outline: none !important;
                                        }

                                        .quote_location_dv .selectize-input input,
                                        .service_location_dv .selectize-input input {
                                            font-family: 'Poppins', sans-serif !important;
                                            font-size: 14px !important;
                                        }

                                        .quote_location_dv .selectize-dropdown,
                                        .service_location_dv .selectize-dropdown {
                                            border-radius: 0 !important;
                                            box-shadow: 0 6px 12px rgba(0,0,0,.1) !important;
                                            border: 1px solid #e1e1e1 !important;
                                            z-index: 1000 !important;
                                        }

                                        @media only screen and (max-width: 767px) {
                                            .left_profileform.notice_posefrm .frm_dv {
                                                display: flex !important;
                                                flex-direction: column;
                                                gap: 7px;
                                                margin-bottom: 18px;
                                            }

                                            .left_profileform.notice_posefrm .frm_dv label {
                                                width: 100% !important;
                                                min-width: 0 !important;
                                                padding-top: 0;
                                                margin-bottom: 0;
                                                line-height: 1.35;
                                            }

                                            .left_profileform.notice_posefrm .frm_dv input[type="text"],
                                            .left_profileform.notice_posefrm .frm_dv select,
                                            .left_profileform.notice_posefrm .frm_dv textarea,
                                            .left_profileform.notice_posefrm .frm_dv .location_input_wrapper,
                                            .left_profileform.notice_posefrm .frm_dv .quote_location_dv,
                                            .left_profileform.notice_posefrm .frm_dv .service_location_dv,
                                            .left_profileform.notice_posefrm .frm_dv .chk_addtnlbox {
                                                width: 100% !important;
                                                max-width: 100% !important;
                                            }

                                            .left_profileform.notice_posefrm .frm_dv input[type="text"],
                                            .left_profileform.notice_posefrm .frm_dv select {
                                                height: 48px !important;
                                                padding: 0 16px !important;
                                                font-size: 16px !important;
                                                line-height: 48px !important;
                                            }

                                            .left_profileform.notice_posefrm .frm_dv textarea {
                                                min-height: 150px;
                                                padding: 14px 16px !important;
                                                font-size: 16px !important;
                                                line-height: 1.5;
                                            }

                                            .quote_location_dv .selectize-control,
                                            .service_location_dv .selectize-control {
                                                width: 100% !important;
                                                max-width: 100% !important;
                                            }

                                            .quote_location_dv .selectize-input,
                                            .service_location_dv .selectize-input {
                                                min-height: 48px !important;
                                                padding: 0 16px !important;
                                                font-size: 16px !important;
                                            }

                                            .left_profileform.notice_posefrm .frm_dv .radiogbutt {
                                                width: 100%;
                                                min-height: 46px;
                                                margin-bottom: 8px;
                                                padding: 11px 14px;
                                                border: 1px solid #dedede;
                                                border-radius: 6px;
                                                background: #fff;
                                                line-height: 1.4;
                                                display: flex;
                                                align-items: center;
                                                gap: 8px;
                                            }

                                            .left_profileform.notice_posefrm .frm_dv .notice-options {
                                                grid-template-columns: 1fr;
                                                max-width: 100%;
                                                gap: 0;
                                            }

                                            .left_profileform.notice_posefrm .frm_dv .radiogbutt input[type="radio"] {
                                                flex: 0 0 auto;
                                                margin: 0;
                                            }

                                            .image-upload-grid {
                                                grid-template-columns: repeat(3, minmax(0, 1fr));
                                                gap: 8px;
                                                width: 100%;
                                            }

                                            .image-upload-box {
                                                width: 100%;
                                                height: auto;
                                                min-height: 82px;
                                            }

                                            .left_profileform.notice_posefrm input[type="submit"] {
                                                width: 100%;
                                                max-width: 260px;
                                            }
                                        }

                                        @media only screen and (max-width: 420px) {
                                            .image-upload-grid {
                                                grid-template-columns: repeat(2, minmax(0, 1fr));
                                            }
                                        }
                                    </style>

                                    <div class="frm_dv">
                                        <label>Images (3 places):</label>
                                        <div style="flex: 1;">
                                            <div class="image-upload-grid">
                                                <!-- Box 1 -->
                                                <div class="image-upload-box"
                                                    onclick="document.getElementById('noticeimg1').click();">
                                                    <div id="noticeimgshow1" class="noticeimgshow placeholder-icon">
                                                        <i class="fa fa-camera"></i>
                                                        <span>Image 1</span>
                                                    </div>
                                                    <input type="file" name="noticeimg[]" class="imageUpload"
                                                        id="noticeimg1" style="display:none;">
                                                    <input type="hidden" name="noticeimgbase64[]"
                                                        class="noticeimgbase64" id="noticeimgbase641">
                                                </div>

                                                <!-- Box 2 -->
                                                <div class="image-upload-box"
                                                    onclick="document.getElementById('noticeimg2').click();">
                                                    <div id="noticeimgshow2" class="noticeimgshow2 placeholder-icon">
                                                        <i class="fa fa-camera"></i>
                                                        <span>Image 2</span>
                                                    </div>
                                                    <input type="file" name="noticeimg[]" class="imageUpload"
                                                        id="noticeimg2" style="display:none;">
                                                    <input type="hidden" name="noticeimgbase64[]"
                                                        class="noticeimgbase64" id="noticeimgbase642">
                                                </div>

                                                <!-- Box 3 -->
                                                <div class="image-upload-box"
                                                    onclick="document.getElementById('noticeimg3').click();">
                                                    <div id="noticeimgshow3" class="noticeimgshow3 placeholder-icon">
                                                        <i class="fa fa-camera"></i>
                                                        <span>Image 3</span>
                                                    </div>
                                                    <input type="file" name="noticeimg[]" class="imageUpload"
                                                        id="noticeimg3" style="display:none;">
                                                    <input type="hidden" name="noticeimgbase64[]"
                                                        class="noticeimgbase64" id="noticeimgbase643">
                                                </div>
                                            </div>
                                            <span
                                                style="font-size: 11px; color: #999; display: block; margin-top: 10px;">Recommended
                                                size: 600 x 400px | JPG, GIF, PNG</span>
                                        </div>
                                    </div>

                                    <div class="frm_dv" id="additional_images_section">
                                        <label><!--Notice Options:--></label>
                                        <div class="chk_addtnlbox"><input name="" type="checkbox" value="" checked>Add 3
                                            more images (free renewal) $2.00
                                            <img src="images/help_icon.png" alt="" class="help_icon">
                                        </div>
                                    </div>

                                    <div class="frm_dv">
                                    </div>
                                    <div class="frm_dv"><label></label>
                                        <input name="submit" type="submit" value="Create Notice">
                                    </div>
                                </div>
                            </div>
                        </form>

                        <script>
                            // Create a mapping of shortnames to IDs for the header dropdown
                            const countryMap = {
                                @foreach($country as $cnty)
                                    "{{ $cnty['shortname'] }}": "{{ $cnty['id'] }}",
                                @endforeach
                            };

                            function loadTowns(selectizeInstance) {
                                if (!selectizeInstance) return;

                                const countryShortName = $('.countryChange').val();
                                const countryId = countryMap[countryShortName];

                                if (!countryId) return;

                                $.ajax({
                                    url: '{{ route('GetCityStatesameVal') }}',
                                    method: 'POST',
                                    data: {
                                        country_id: countryId,
                                        _token: $('input[name="_token"]').val()
                                    },
                                    success: function(response) {
                                        selectizeInstance.clearOptions();
                                        selectizeInstance.addOption(JSON.parse(response));
                                        selectizeInstance.refreshOptions(false);
                                    }
                                });
                            }

                            function updateQuoteTowns() {
                                loadTowns($('#quote_towns')[0]?.selectize);
                            }

                            function updateServiceDealTowns() {
                                loadTowns($('#service_deal_towns')[0]?.selectize);
                            }

                            document.getElementById('category_id').addEventListener('change', function () {
                                var categoryId = this.value;
                                var restOfFields = document.getElementById('rest_of_fields');
                                var getAQuoteFields = document.getElementById('get_a_quote_fields');
                                var serviceDealFields = document.getElementById('service_deal_fields');
                                var additionalImagesSection = document.getElementById('additional_images_section');
                                var bodyLabel = document.getElementById('body_label');
                                var bodyTextarea = document.getElementsByName('notice_body')[0];
                                var itemOptionsFields = document.getElementById('item_options_fields');

                                if (categoryId) {
                                    restOfFields.style.display = 'block';
                                    itemOptionsFields.style.display = 'none'; // hidden by default

                                    // ID 1 is $5 Service Deal
                                    // ID 2 is Get a Quote
                                    if (categoryId == '1') {
                                        serviceDealFields.style.display = 'block';
                                        getAQuoteFields.style.display = 'none';
                                        additionalImagesSection.style.display = 'none';
                                        bodyLabel.innerText = 'Description:';
                                        bodyTextarea.placeholder = 'Description (300 char max).';
                                        bodyTextarea.maxLength = 300;
                                        document.getElementById('body_counter').innerText = bodyTextarea.value.length + ' / 300 characters';

                                        // Initialize Selectize for service deal town field
                                        if (!$('#service_deal_towns').hasClass('selectized')) {
                                            $('#service_deal_towns').selectize({
                                                create: false,
                                                placeholder: 'Select Town/Suburb',
                                                render: {
                                                    no_results: function(data, escape) {
                                                        return '<div class="no-results">No results found</div>';
                                                    }
                                                }
                                            });
                                        }
                                        updateServiceDealTowns();
                                    } else if (categoryId == '9') {
                                        serviceDealFields.style.display = 'block';
                                        getAQuoteFields.style.display = 'none';
                                        itemOptionsFields.style.display = 'block';
                                        additionalImagesSection.style.display = 'none';
                                        bodyLabel.innerText = 'Description:';
                                        bodyTextarea.placeholder = 'Description (300 char max).';
                                        bodyTextarea.maxLength = 300;
                                        document.getElementById('body_counter').innerText = bodyTextarea.value.length + ' / 300 characters';

                                        // Initialize Selectize for service deal town field
                                        if (!$('#service_deal_towns').hasClass('selectized')) {
                                            $('#service_deal_towns').selectize({
                                                create: false,
                                                placeholder: 'Select Town/Suburb',
                                                render: {
                                                    no_results: function(data, escape) {
                                                        return '<div class="no-results">No results found</div>';
                                                    }
                                                }
                                            });
                                        }
                                        updateServiceDealTowns();
                                    } else if (categoryId == '2') {
                                        serviceDealFields.style.display = 'none';
                                        getAQuoteFields.style.display = 'block';
                                        additionalImagesSection.style.display = 'none';
                                        bodyLabel.innerText = 'Provide a description of your job:';
                                        bodyTextarea.placeholder = 'Provide a description of your job';

                                        // Initialize Selectize for quote form if not already initialized
                                        if (!$('#quote_towns').hasClass('selectized')) {
                                            $('#quote_towns').selectize({
                                                create: false,
                                                placeholder: 'Select Suburb/City',
                                                render: {
                                                    no_results: function(data, escape) {
                                                        return '<div class="no-results">No results found</div>';
                                                    }
                                                }
                                            });
                                        }
                                        updateQuoteTowns();
                                    } else {
                                        serviceDealFields.style.display = 'none';
                                        getAQuoteFields.style.display = 'none';
                                        additionalImagesSection.style.display = 'block';
                                        bodyLabel.innerText = 'Add your content:';
                                        bodyTextarea.placeholder = 'Add notice body text (155 char max).';
                                        bodyTextarea.maxLength = 155;
                                        document.getElementById('body_counter').innerText = bodyTextarea.value.length + ' / 155 characters';
                                    }
                                } else {
                                    restOfFields.style.display = 'none';
                                }
                            });

                            $(document).ready(function() {
                                // Listen for changes in the header country dropdown
                                $('.countryChange').on('change', function() {
                                    updateQuoteTowns();
                                    updateServiceDealTowns();
                                });

                                // Initial load if category is already selected
                                var initialCat = $('#category_id').val();
                                if (initialCat == '2') {
                                    setTimeout(updateQuoteTowns, 500);
                                } else if (initialCat == '1' || initialCat == '9') {
                                    setTimeout(updateServiceDealTowns, 500);
                                }
                            });

                            window.addEventListener('load', function () {
                                var categorySelect = document.getElementById('category_id');
                                if (categorySelect.value !== "") {
                                    categorySelect.dispatchEvent(new Event('change'));
                                }
                            });

                            // Character counter logic
                            document.getElementById('notice_title').addEventListener('input', function() {
                                document.getElementById('title_counter').innerText = this.value.length + ' / 35 characters';
                            });

                            document.getElementById('notice_body').addEventListener('input', function() {
                                var max = this.maxLength > 0 ? this.maxLength : 155;
                                document.getElementById('body_counter').innerText = this.value.length + ' / ' + max + ' characters';
                            });
                        </script>
                    </div>
                </div>
                <div class="modal fade bd-example-modal-lg imagecrop" id="model" tabindex="-1" role="dialog"
                    aria-labelledby="myLargeModalLabel" aria-hidden="true">
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
                    <div class="support_advertiser">
                        <i class="fa fa-heart"></i>
                        <span>Support our advertisers, catchakiwi exists because of them</span>
                    </div>
                    <div class="right_advertisesec">
                        @if(!empty($sideData))
                            @foreach ($sideData as $ad)
                                @if($ad->ads_image != "")
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
