@include('includes/inner-header')
<div class="mid_body">
    <div class="container">
        <div class="full_midpan notice-post-page">
            <div class="row">
                <div class="col-lg-8 col-md-8 col-sm-12">
                    <div class="left_notice">
                        <div class="left_searchresults">
                            <h3><img src="{{ asset('assets/images/notice_titleicon.png') }}" alt="Notice Board"> Notice Board
                                <br>
                                <span><a href="{{ url('/') }}" style="color: #729b0f; text-decoration: none;">Home</a> >
                                    <a href="{{ route('notice-board') }}"
                                        style="color: #729b0f; text-decoration: none;">Notice Board</a> > 
                                    {{ isset($notice) ? 'Edit Notice' : 'Post Notice' }}</span>
                            </h3>
                        </div>
                        <form action="{{ isset($notice) ? route('notice.update', $notice->id) : route('notice-submit') }}" method="post" enctype='multipart/form-data'>
                            @csrf
                            @if(isset($notice))
                                @method('PUT')
                            @endif
                            
                            @if(session('success'))
                                <div class="alert alert-success" style="border-left: 4px solid #729b0f; background-color: #f6fbf0; color: #40570b; padding: 12px 15px; margin-bottom: 20px; border-radius: 4px; font-family: 'Poppins', sans-serif;">
                                    <i class="fa fa-check-circle" style="margin-right: 8px;"></i>
                                    {{ session('success') }}
                                </div>
                            @endif

                            @if(session('error'))
                                <div class="alert alert-danger" style="border-left: 4px solid #d9534f; background-color: #fdf7f7; color: #b94a48; padding: 12px 15px; margin-bottom: 20px; border-radius: 4px; font-family: 'Poppins', sans-serif;">
                                    <i class="fa fa-exclamation-triangle" style="margin-right: 8px;"></i>
                                    {{ session('error') }}
                                </div>
                            @endif

                            <div id="active_standard_warning" class="alert alert-danger" style="display: none; border-left: 4px solid #d9534f; background-color: #fdf7f7; color: #b94a48; padding: 12px 15px; margin-bottom: 20px; border-radius: 4px; font-family: 'Poppins', sans-serif;">
                                <i class="fa fa-exclamation-triangle" style="margin-right: 8px;"></i>
                                <span>You already have an active 7-Day notice. You cannot submit this notice type until it expires.</span>
                            </div>

                            <div class="left_profileform notice_posefrm">
                                <div class="frm_dv">
                                    <label>Category:</label>
                                    <select name="category_id" id="category_id" required>
                                        <option value="" {{ old('category_id', isset($notice) ? $notice->category_id : request()->query('category')) ? '' : 'selected' }}>Choose your Category</option>
                                        @if(!empty($category))
                                            @foreach($category as $cat)
                                                <option value="{{ $cat->id }}" data-category-slug="{{ $cat->slug ?? '' }}" {{ (string) old('category_id', isset($notice) ? $notice->category_id : request()->query('category')) === (string) $cat->id || (string) old('category_id', isset($notice) ? $notice->category_id : request()->query('category')) === (string) $cat->slug ? 'selected' : '' }}>
                                                    {{ $cat->category }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>

                                <div id="rest_of_fields" style="display:none;">
                                    <div id="item_options_fields" class="frm_dv" style="display:none;">
                                        <label>Item Options:</label>
                                        <div class="item-options">
                                            <div class="radiogbutt"><input name="item_type" type="radio" value="Item for sale" {{ old('item_type', isset($notice) ? $notice->looking_for : 'Item for sale') === 'Item for sale' ? 'checked' : '' }}>
                                                Item for sale</div>
                                            <div class="radiogbutt"><input name="item_type" type="radio" value="Item Wanted" {{ old('item_type', isset($notice) ? $notice->looking_for : '') === 'Item Wanted' ? 'checked' : '' }}>
                                                Item Wanted</div>
                                        </div>
                                    </div>

                                    <div class="frm_dv" id="notice_options_fields">
                                        <label class="notice-options-label">
                                            Notice Options:
                                            <button type="button" class="notice-help-button" id="notice_options_help_button"
                                                aria-label="About notice options" aria-expanded="false"
                                                aria-controls="notice_options_help_text">?</button>
                                            <span class="notice-help-text" id="notice_options_help_text" role="tooltip" hidden>
                                                <strong>Feature Notice benefits:</strong>
                                                <ul>
                                                    <li>Active for 28 days</li>
                                                    <li>Add 3 extra photos</li>
                                                    <li>More visibility for your notice</li>
                                                </ul>
                                            </span>
                                        </label>
                                        <div class="notice-options">
                                            <div class="radiogbutt" style="display: flex; align-items: center; gap: 8px;">
                                                <input name="noticetype" type="radio" value="standard" {{ old('noticetype', isset($notice) ? $notice->noticetype : 'standard') === 'standard' ? 'checked' : '' }}>
                                                7 day Notice (Free) $0.00
                                            </div>
                                            <div class="radiogbutt" style="display: flex; align-items: center; gap: 8px;">
                                                <input name="noticetype" type="radio" value="feature" {{ old('noticetype', isset($notice) ? $notice->noticetype : '') === 'feature' ? 'checked' : '' }}>
                                                28 day Feature Notice ( $3.00)
                                                <img src="images/help_icon.png" alt="" class="help_icon">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="frm_dv">
                                        <label>Notice Title:</label>
                                        <div class="notice-field-column">
                                            <input name="notice_title" id="notice_title" type="text" placeholder="Enter Notice Title (35 char max)" maxlength="35" value="{{ old('notice_title', $notice->heading ?? '') }}">
                                            <div id="title_counter" class="notice-character-counter">{{ isset($notice) ? strlen($notice->heading) : 0 }} / 35 characters</div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="header_country" id="header_country" value="{{ session('CountryCode') ?? 'NZ' }}">

                                    <!-- Get a Quote Fields -->
                                    <div id="get_a_quote_fields" style="display:none;">
                                        <div class="frm_dv">
                                            <label>I'm Looking for:</label>
                                            <select name="looking_for">
                                                <option value="">Select Service</option>
                                                @foreach(['Architect and Drafting', 'Brick and block Laying', 'Building', 'Car Cleaning', 'Carpet and Furniture cleaning', 'Cleaning', 'Computer Help', 'Concreting', 'Electrical', 'Flooring', 'Gardening', 'Gib Fixing and Plastering', 'Handy person', 'House washing', 'Interior Design', 'Landscaping', 'Locksmith', 'Moving', 'Painting', 'Plumbing', 'Roofing', 'Tiling'] as $service)
                                                    <option value="{{ $service }}" {{ old('looking_for', $notice->looking_for ?? '') === $service ? 'selected' : '' }}>{{ $service }}</option>
                                                @endforeach
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
                                                @foreach(['Emergency', 'ASAP', 'Next few days', "I'm flexible", 'Next few weeks', 'Next few months'] as $timing)
                                                    <option value="{{ $timing }}" {{ old('start_date', $notice->start_date ?? '') === $timing ? 'selected' : '' }}>{{ $timing }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="frm_dv">
                                            <label>Budget:</label>
                                            <select name="budget">
                                                <option value="">Select Budget</option>
                                                @foreach(['Under $300', '$300 to $600', '$600 to $1000', 'More than $1000', 'Not sure'] as $b)
                                                    <option value="{{ $b }}" {{ old('budget', $notice->budget ?? '') === $b ? 'selected' : '' }}>{{ $b }}</option>
                                                @endforeach
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

                                    <!-- Garage Sales Fields -->
                                    <div id="garage_sales_fields" style="display:none;">
                                        <div class="frm_dv" style="position:relative;">
                                            <label for="gs_address_input">Sale Address:</label>
                                            <div style="flex:1; max-width:535px; position:relative;">
                                                <input
                                                    type="text"
                                                    id="gs_address_input"
                                                    name="gs_address"
                                                    placeholder="Start typing the sale address…"
                                                    autocomplete="off"
                                                    value="{{ old('gs_address', $notice->gs_address ?? '') }}"
                                                >
                                                <span id="gs_address_spinner" style="display:none; position:absolute; right:10px; top:50%; transform:translateY(-50%); color:#9bcd22;">&#8987;</span>
                                                <ul id="gs_address_suggestions" style="
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
                                                    box-shadow:0 4px 12px rgba(0,0,0,.12);
                                                    font-family:'Poppins',sans-serif;
                                                    font-size:13px;
                                                "></ul>
                                            </div>
                                            <input type="hidden" name="gs_lat" id="gs_lat" value="{{ old('gs_lat', $notice->gs_lat ?? '') }}">
                                            <input type="hidden" name="gs_lng" id="gs_lng" value="{{ old('gs_lng', $notice->gs_lng ?? '') }}">
                                        </div>
                                        <div id="gs_map_preview" style="display:none; margin-bottom:15px;">
                                            <div class="frm_dv">
                                                <label></label>
                                                <div id="gs_map_container" style="flex:1; max-width:535px; height:200px; border:1px solid #9bcd22; border-radius:4px; overflow:hidden;"></div>
                                            </div>
                                        </div>
                                        <div class="frm_dv">
                                            <label for="gs_additional_info">Additional Info:</label>
                                            <textarea
                                                name="gs_additional_info"
                                                id="gs_additional_info"
                                                placeholder="e.g. Date, time, items for sale, parking info… (200 char max)"
                                                maxlength="200"
                                                rows="3"
                                                style="flex:1; max-width:535px; min-height:80px; border:1px solid #9bcd22; padding:10px 12px; font-family:'Poppins',sans-serif; font-size:14px; resize:vertical;"
                                            >{{ old('gs_additional_info', $notice->gs_additional_info ?? '') }}</textarea>
                                        </div>
                                    </div>


                                    <div class="frm_dv textareadv">
                                        <label id="body_label">Add your content: </label>
                                        <div class="notice-field-column">
                                            <textarea name="notice_body" id="notice_body" cols="" rows="" placeholder="Add notice body text." maxlength="{{ isset($notice) && in_array($notice->category_id, [1, 9]) ? '300' : '155' }}">{{ old('notice_body', $notice->content ?? '') }}</textarea>
                                            <div id="body_counter" class="notice-character-counter">{{ isset($notice) ? strlen($notice->content) : 0 }} / {{ isset($notice) && in_array($notice->category_id, [1, 9]) ? '300' : '155' }} characters</div>
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
                                                display: flex;
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
                                        <label id="notice_images_label">Images (3 places):</label>
                                        <div class="notice-images-field">
                                            <div class="image-upload-grid">
                                                <!-- Box 1 -->
                                                <div class="image-upload-box"
                                                    onclick="document.getElementById('noticeimg1').click();">
                                                    @if(isset($noticeImages) && isset($noticeImages[0]))
                                                        <div id="noticeimgshow1" class="noticeimgshow">
                                                            <img src="{{ asset($noticeImages[0]->img_path) }}" alt="">
                                                            <div class="remove-img" data-index="1">X</div>
                                                        </div>
                                                    @else
                                                        <div id="noticeimgshow1" class="noticeimgshow placeholder-icon">
                                                            <i class="fa fa-camera"></i>
                                                            <span>Image 1</span>
                                                        </div>
                                                    @endif
                                                    <input type="file" name="noticeimg[]" class="imageUpload"
                                                        id="noticeimg1" style="display:none;">
                                                    <input type="hidden" name="noticeimgbase64[]"
                                                        class="noticeimgbase64" id="noticeimgbase641"
                                                        value="{{ isset($noticeImages) && isset($noticeImages[0]) ? $noticeImages[0]->img_path : '' }}">
                                                </div>

                                                <!-- Box 2 -->
                                                <div class="image-upload-box"
                                                    onclick="document.getElementById('noticeimg2').click();">
                                                    @if(isset($noticeImages) && isset($noticeImages[1]))
                                                        <div id="noticeimgshow2" class="noticeimgshow2">
                                                            <img src="{{ asset($noticeImages[1]->img_path) }}" alt="">
                                                            <div class="remove-img" data-index="2">X</div>
                                                        </div>
                                                    @else
                                                        <div id="noticeimgshow2" class="noticeimgshow2 placeholder-icon">
                                                            <i class="fa fa-camera"></i>
                                                            <span>Image 2</span>
                                                        </div>
                                                    @endif
                                                    <input type="file" name="noticeimg[]" class="imageUpload"
                                                        id="noticeimg2" style="display:none;">
                                                    <input type="hidden" name="noticeimgbase64[]"
                                                        class="noticeimgbase64" id="noticeimgbase642"
                                                        value="{{ isset($noticeImages) && isset($noticeImages[1]) ? $noticeImages[1]->img_path : '' }}">
                                                </div>

                                                <!-- Box 3 -->
                                                <div class="image-upload-box"
                                                    onclick="document.getElementById('noticeimg3').click();">
                                                    @if(isset($noticeImages) && isset($noticeImages[2]))
                                                        <div id="noticeimgshow3" class="noticeimgshow3">
                                                            <img src="{{ asset($noticeImages[2]->img_path) }}" alt="">
                                                            <div class="remove-img" data-index="3">X</div>
                                                        </div>
                                                    @else
                                                        <div id="noticeimgshow3" class="noticeimgshow3 placeholder-icon">
                                                            <i class="fa fa-camera"></i>
                                                            <span>Image 3</span>
                                                        </div>
                                                    @endif
                                                    <input type="file" name="noticeimg[]" class="imageUpload"
                                                        id="noticeimg3" style="display:none;">
                                                    <input type="hidden" name="noticeimgbase64[]"
                                                        class="noticeimgbase64" id="noticeimgbase643"
                                                        value="{{ isset($noticeImages) && isset($noticeImages[2]) ? $noticeImages[2]->img_path : '' }}">
                                                </div>

                                                <!-- Feature notice boxes 4-6 -->
                                                @foreach(range(4, 6) as $imageIndex)
                                                    @php $imgKey = $imageIndex - 1; @endphp
                                                    <div class="image-upload-box feature-image-slot" data-image-index="{{ $imageIndex }}" hidden
                                                        onclick="document.getElementById('noticeimg{{ $imageIndex }}').click();">
                                                        @if(isset($noticeImages) && isset($noticeImages[$imgKey]))
                                                            <div id="noticeimgshow{{ $imageIndex }}" class="noticeimgshow{{ $imageIndex }}">
                                                                <img src="{{ asset($noticeImages[$imgKey]->img_path) }}" alt="">
                                                                <div class="remove-img" data-index="{{ $imageIndex }}">X</div>
                                                            </div>
                                                        @else
                                                            <div id="noticeimgshow{{ $imageIndex }}" class="noticeimgshow{{ $imageIndex }} placeholder-icon">
                                                                <i class="fa fa-camera"></i>
                                                                <span>Image {{ $imageIndex }}</span>
                                                            </div>
                                                        @endif
                                                        <input type="file" name="noticeimg[]" class="imageUpload"
                                                            id="noticeimg{{ $imageIndex }}" hidden>
                                                        <input type="hidden" name="noticeimgbase64[]"
                                                            class="noticeimgbase64" id="noticeimgbase64{{ $imageIndex }}"
                                                            value="{{ isset($noticeImages) && isset($noticeImages[$imgKey]) ? $noticeImages[$imgKey]->img_path : '' }}">
                                                    </div>
                                                @endforeach
                                            </div>
                                            <span class="notice-image-recommendation">Recommended
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
                                        <input name="submit" type="submit" value="{{ isset($notice) ? 'Update Notice' : 'Create Notice' }}">
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

                            function loadTowns(selectizeInstance, selectedVal = '') {
                                if (!selectizeInstance) return;

                                const countryShortName = $('.countryChange').val();
                                const countryId = countryMap[countryShortName];

                                if (!countryId) return;

                                $.ajax({
                                    url: '{{ route('GetCityStatesameVal') }}',
                                    method: 'POST',
                                    data: {
                                        country_id: countryId,
                                        selected: selectedVal,
                                        _token: $('input[name="_token"]').val()
                                    },
                                    success: function(response) {
                                        selectizeInstance.clearOptions();
                                        selectizeInstance.addOption(JSON.parse(response));
                                        selectizeInstance.refreshOptions(false);
                                        if (selectedVal) {
                                            selectizeInstance.setValue(selectedVal, true);
                                        }
                                    }
                                });
                            }

                            function updateQuoteTowns() {
                                loadTowns($('#quote_towns')[0]?.selectize, "{{ $notice->job_location ?? '' }}");
                            }

                            function updateServiceDealTowns() {
                                loadTowns($('#service_deal_towns')[0]?.selectize, "{{ $notice->town_suburb ?? '' }}");
                            }

                            document.getElementById('category_id').addEventListener('change', function () {
                                var categoryId = this.value;
                                var selectedCategory = this.options[this.selectedIndex];
                                var categorySlug = selectedCategory ? selectedCategory.dataset.categorySlug : '';
                                var categoryName = selectedCategory ? selectedCategory.textContent.trim().toLowerCase() : '';
                                var itemCategorySlugs = ['items-for-sale', 'items-for-sale-or-wanted'];
                                var itemCategoryNames = ['items for sale', 'items for sale or wanted'];
                                var isItemsCategory = itemCategorySlugs.includes(categorySlug)
                                    || itemCategoryNames.includes(categoryName);
                                var isGarageSales = (categorySlug === 'garage-sales') || (categoryName === 'garage sales');
                                var restOfFields = document.getElementById('rest_of_fields');
                                var getAQuoteFields = document.getElementById('get_a_quote_fields');
                                var serviceDealFields = document.getElementById('service_deal_fields');
                                var garageSalesFields = document.getElementById('garage_sales_fields');
                                var additionalImagesSection = document.getElementById('additional_images_section');
                                var bodyLabel = document.getElementById('body_label');
                                var bodyTextarea = document.getElementsByName('notice_body')[0];
                                var itemOptionsFields = document.getElementById('item_options_fields');
                                var noticeOptionsFields = document.getElementById('notice_options_fields');

                                // Always hide garage fields first, re-show if needed
                                if (garageSalesFields) garageSalesFields.style.display = 'none';

                                if (categoryId) {
                                    restOfFields.style.display = 'block';
                                    if (itemOptionsFields) itemOptionsFields.style.setProperty('display', 'none', 'important'); // hidden by default
                                    if (noticeOptionsFields) noticeOptionsFields.style.display = ''; // shown by default

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
                                    } else if (isItemsCategory) {
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
                                        if (itemOptionsFields) itemOptionsFields.style.setProperty('display', 'none', 'important');
                                        if (noticeOptionsFields) noticeOptionsFields.style.setProperty('display', 'none', 'important');
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
                                    } else if (isGarageSales) {
                                        serviceDealFields.style.display = 'none';
                                        getAQuoteFields.style.display = 'none';
                                        additionalImagesSection.style.display = 'none';
                                        if (garageSalesFields) garageSalesFields.style.display = 'block';
                                        bodyLabel.innerText = 'Description:';
                                        bodyTextarea.placeholder = 'Describe your garage sale (300 char max).';
                                        bodyTextarea.maxLength = 300;
                                        document.getElementById('body_counter').innerText = bodyTextarea.value.length + ' / 300 characters';
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
                                    var countryShortName = $(this).val();
                                    $('#header_country').val(countryShortName);
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

                             function checkSubmissionValidity() {
                                 var submitBtn = document.querySelector('input[name="submit"]');
                                 var activeWarning = document.getElementById('active_standard_warning');

                                 if (submitBtn) {
                                     submitBtn.disabled = false;
                                     submitBtn.style.opacity = 1;
                                     submitBtn.style.cursor = 'pointer';
                                 }
                                 if (activeWarning) {
                                     activeWarning.style.display = 'none';
                                 }
                             }

                             window.addEventListener('load', function () {
                                 var categorySelect = document.getElementById('category_id');
                                 if (categorySelect.value !== "") {
                                     categorySelect.dispatchEvent(new Event('change'));
                                 }
                                 checkSubmissionValidity();
                             });

                            // Character counter logic
                            document.getElementById('notice_title').addEventListener('input', function() {
                                document.getElementById('title_counter').innerText = this.value.length + ' / 35 characters';
                            });

                            document.getElementById('notice_body').addEventListener('input', function() {
                                var max = this.maxLength > 0 ? this.maxLength : 155;
                                document.getElementById('body_counter').innerText = this.value.length + ' / ' + max + ' characters';
                            });

                            function updateFeatureImageSlots() {
                                var featureSelected = document.querySelector('input[name="noticetype"][value="feature"]').checked;
                                document.getElementById('notice_images_label').textContent = featureSelected
                                    ? 'Images (6 places):'
                                    : 'Images (3 places):';

                                document.querySelectorAll('.feature-image-slot').forEach(function(slot) {
                                    slot.hidden = !featureSelected;

                                    if (!featureSelected) {
                                        var index = slot.dataset.imageIndex;
                                        document.getElementById('noticeimg' + index).value = '';
                                        document.getElementById('noticeimgbase64' + index).value = '';
                                        document.getElementById('noticeimgshow' + index).classList.add('placeholder-icon');
                                        document.getElementById('noticeimgshow' + index).innerHTML =
                                            '<i class="fa fa-camera"></i><span>Image ' + index + '</span>';
                                    }
                                });
                            }

                             document.getElementById('category_id').addEventListener('change', checkSubmissionValidity);
                             document.querySelectorAll('input[name="noticetype"]').forEach(function(option) {
                                 option.addEventListener('change', function() {
                                     updateFeatureImageSlots();
                                     checkSubmissionValidity();
                                 });
                             });
                             updateFeatureImageSlots();
                             checkSubmissionValidity();

                            var noticeHelpButton = document.getElementById('notice_options_help_button');
                            var noticeHelpText = document.getElementById('notice_options_help_text');

                            noticeHelpButton.addEventListener('click', function(event) {
                                event.stopPropagation();
                                var willOpen = noticeHelpText.hidden;
                                noticeHelpText.hidden = !willOpen;
                                noticeHelpButton.setAttribute('aria-expanded', willOpen ? 'true' : 'false');
                            });

                            document.addEventListener('click', function(event) {
                                if (!noticeHelpText.hidden && !noticeHelpText.contains(event.target)) {
                                    noticeHelpText.hidden = true;
                                    noticeHelpButton.setAttribute('aria-expanded', 'false');
                                }
                            });

                            document.addEventListener('keydown', function(event) {
                                if (event.key === 'Escape' && !noticeHelpText.hidden) {
                                    noticeHelpText.hidden = true;
                                    noticeHelpButton.setAttribute('aria-expanded', 'false');
                                    noticeHelpButton.focus();
                                }
                            });
                        </script>

                        <script>
                        // ── OpenStreetMap Address Autocomplete & Map for Garage Sales ─────────────────
                        (function () {
                            var addressInput   = document.getElementById('gs_address_input');
                            var suggestionsList = document.getElementById('gs_address_suggestions');
                            var spinner        = document.getElementById('gs_address_spinner');
                            var latField       = document.getElementById('gs_lat');
                            var lngField       = document.getElementById('gs_lng');
                            var mapPreview     = document.getElementById('gs_map_preview');
                            var mapContainer   = document.getElementById('gs_map_container');
                            var debounceTimer  = null;
                            var leafletMap     = null;
                            var leafletMarker  = null;

                            if (!addressInput) return;

                            function hideSuggestions() {
                                suggestionsList.innerHTML = '';
                                suggestionsList.style.display = 'none';
                            }

                            function clearCoords() {
                                latField.value = '';
                                lngField.value = '';
                                if (mapPreview) mapPreview.style.display = 'none';
                            }

                            function initMap(lat, lng) {
                                if (typeof L === 'undefined') return;
                                if (mapPreview) mapPreview.style.display = 'block';
                                
                                if (!leafletMap) {
                                    leafletMap = L.map(mapContainer).setView([lat, lng], 15);
                                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                        maxZoom: 19,
                                        attribution: '© OpenStreetMap'
                                    }).addTo(leafletMap);
                                    leafletMarker = L.marker([lat, lng]).addTo(leafletMap);
                                } else {
                                    leafletMap.setView([lat, lng], 15);
                                    leafletMarker.setLatLng([lat, lng]);
                                }
                            }

                            function loadSDK(cb) {
                                if (typeof L !== 'undefined') { cb(); return; }
                                var head = document.head;
                                var link = document.createElement('link');
                                link.rel = 'stylesheet';
                                link.href = 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.css';
                                head.appendChild(link);
                                
                                var s = document.createElement('script');
                                s.src = 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.js';
                                s.onload = cb;
                                head.appendChild(s);
                            }

                            function fetchSuggestions(q) {
                                if (spinner) spinner.style.display = 'inline';
                                fetch('https://nominatim.openstreetmap.org/search?format=json&addressdetails=1&limit=6&accept-language=en&q=' + encodeURIComponent(q))
                                    .then(function(r) { return r.json(); })
                                    .then(function(d) {
                                        if (spinner) spinner.style.display = 'none';
                                        suggestionsList.innerHTML = '';
                                        if (!d || !d.length) { hideSuggestions(); return; }
                                        d.forEach(function(item) {
                                            var label = item.display_name;
                                            var li = document.createElement('li');
                                            li.textContent = label;
                                            li.style.cssText = 'padding:9px 14px; cursor:pointer; border-bottom:1px solid #f0f0f0;';
                                            li.addEventListener('mouseenter', function() { li.style.background = '#f6fbf0'; });
                                            li.addEventListener('mouseleave', function() { li.style.background = ''; });
                                            li.addEventListener('mousedown', function(e) {
                                                e.preventDefault();
                                                addressInput.value = label;
                                                latField.value = item.lat;
                                                lngField.value = item.lon; // Note: Nominatim uses 'lon' instead of 'lng'
                                                hideSuggestions();
                                                loadSDK(function() { initMap(item.lat, item.lon); });
                                            });
                                            suggestionsList.appendChild(li);
                                        });
                                        suggestionsList.style.display = 'block';
                                    }).catch(function() { if (spinner) spinner.style.display = 'none'; });
                            }

                            addressInput.addEventListener('input', function() {
                                clearTimeout(debounceTimer);
                                clearCoords();
                                var q = this.value.trim();
                                if (q.length < 3) { hideSuggestions(); return; }
                                debounceTimer = setTimeout(function() { fetchSuggestions(q); }, 500); // 500ms debounce for Nominatim
                            });

                            addressInput.addEventListener('blur', function() {
                                setTimeout(hideSuggestions, 200);
                            });

                            // If editing an existing garage sale notice that already has coords
                            if (latField.value && lngField.value) {
                                loadSDK(function() {
                                    initMap(parseFloat(latField.value), parseFloat(lngField.value));
                                });
                            }
                        })();
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
