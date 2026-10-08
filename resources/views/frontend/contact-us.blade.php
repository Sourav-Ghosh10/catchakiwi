@include('includes/inner-header')

<style>
    .error {
        color: red;
        font-size: 13px;
        margin-top: 4px;
    }
    .success {
        color: green;
    }
    .hidden {
        display: none !important;
    }

    /* Contact Us Form Uniform Field Sizes */
    .get_qucontafrm .frm_dv input[type="text"],
    .get_qucontafrm .frm_dv input[type="email"],
    .get_qucontafrm .frm_dv select,
    .get_qucontafrm .frm_dv textarea {
        width: 100% !important;
        max-width: 100% !important;
        box-sizing: border-box !important;
        border-radius: 8px !important;
        border: 1px solid #dcdcdc !important;
        background-color: #ffffff !important;
        padding: 10px 14px !important;
        font-size: 14px !important;
        font-family: 'Poppins', sans-serif !important;
        color: #333333 !important;
        margin-bottom: 14px !important;
    }

    .get_qucontafrm .frm_dv input[type="text"],
    .get_qucontafrm .frm_dv input[type="email"],
    .get_qucontafrm .frm_dv select {
        height: 44px !important;
        line-height: 22px !important;
    }

    .get_qucontafrm .frm_dv textarea {
        height: 120px !important;
        resize: vertical !important;
    }

    /* Mobile Damping & Clean Cellphone Screen Styling */
    @media (max-width: 767px) {
        .mid_body {
            padding-top: 15px !important;
            padding-bottom: 30px !important;
        }
        .getquote_mid {
            padding-left: 16px !important;
            padding-right: 16px !important;
        }
        .getquote_mid h2 {
            font-size: 24px !important;
            line-height: 1.3 !important;
            margin-bottom: 12px !important;
            color: #273038 !important;
            font-weight: 700 !important;
        }
        .getquote_frm {
            padding: 0 !important;
            margin-top: 15px !important;
        }
        .getquote_frm h3 {
            font-size: 15px !important;
            padding-left: 12px !important;
            margin-bottom: 15px !important;
            color: #404041 !important;
            font-weight: 600 !important;
        }
        .get_qucontafrm {
            padding: 18px 16px !important;
            background: #ffffff !important;
            border-radius: 12px !important;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.04) !important;
            border: 1px solid #edf2f7 !important;
        }
        .get_qucontafrm .row [class*="col-"] {
            padding-left: 0 !important;
            padding-right: 0 !important;
        }
        .get_qucontafrm .row {
            margin-left: 0 !important;
            margin-right: 0 !important;
        }
        .getquote_frm input[type="submit"] {
            width: 100% !important;
            max-width: 220px !important;
            height: 44px !important;
            line-height: 44px !important;
            display: block !important;
            margin: 20px auto 0 !important;
            border-radius: 25px !important;
            font-weight: 700 !important;
            font-size: 14px !important;
            background: #9bcd22 !important;
            color: #ffffff !important;
            border: none !important;
            box-shadow: 0 4px 12px rgba(155, 205, 34, 0.3) !important;
        }
    }
</style>

<div class="mid_body">
    <div class="container">
        <div class="getquote_mid">
            <h2>Contact Us</h2>
            <div class="getquote_frm">
                @if (session('success'))
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header"></div>
                            <div class="modal-body">
                                {{ session('success') }}<br><br>
                                <b>We will get back to you soon</b>
                            </div>
                            <a href="/" class="btn contctbackcatki">Back to the homepage</a>
                        </div>
                    </div>
                </div>
                @endif

                <form action="{{ route('contact-us') }}" method="post" id="contactform">
                    @csrf
                    <h3>Please Provide Your Contact Details.</h3>
                    
                    <div class="get_qucontafrm">
                        <div class="frm_dv">
                            <div class="row">
                                <div class="col-sm-6 col-12">
                                    <input name="name" type="text" value="{{ old('name') }}" placeholder="Name *" required>
                                    @error('name')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-sm-6 col-12">
                                    <input name="email" type="email" value="{{ old('email') }}" placeholder="Email *" required>
                                    @error('email')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6 col-12">
                                    <select name="country" class="country" id="countries" required>
                                        @if(!empty($country))
                                            @foreach($country as $cnty)
                                                <option value="{{$cnty['id']}}" data-short="{{$cnty['shortname']}}" <?= (session('CountryCode')==$cnty['shortname'])?'selected':'' ?>>{{$cnty['name']}}</option>
                                            @endforeach
                                        @endif
                                        <option value="others">Others</option>
                                    </select>
                                    @error('country')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                            
                                <div class="col-sm-6 col-12" style="position:relative;">
                                    <input 
                                        type="text" 
                                        name="suburb_id" 
                                        id="contact_address_input" 
                                        placeholder="Start typing town/suburb or address…" 
                                        autocomplete="off" 
                                        value="{{ old('suburb_id') }}" 
                                        required
                                    >
                                    <span id="contact_address_spinner" style="display:none; position:absolute; right:15px; top:12px; color:#9bcd22; font-size:16px;">&#8987;</span>
                                    <ul id="contact_address_suggestions" style="
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
                                        border-radius:0 0 6px 6px;
                                    "></ul>
                                    @error('suburb_id')
                                        <div class="error">{{ $message }}</div>
                                    @enderror

                                    <input name="otherscoun" type="text" value="{{ old('otherscoun') }}" placeholder="Country *" class="hidden otherscoun">
                                    @error('otherscoun')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12 col-12">
                                    <input name="phone_no" type="text" value="{{ old('phone_no') }}" placeholder="Mobile Number">
                                    @error('phone_no')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12 col-12">
                                    <textarea name="message" placeholder="Message *" required>{{old('message')}}</textarea>
                                    @error('message')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <input name="" type="submit" value="Submit">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@include('includes/footer')

<script>
$(document).ready(function () {
    var debounceTimer;
    var sessionCountryCode = "{{ session('CountryCode', 'NZ') }}";

    $('#countries').change(function () {
        var countryId = $(this).val();
        var selectedOpt = $(this).find('option:selected');
        var shortCode = selectedOpt.data('short') || sessionCountryCode;
        if (shortCode && shortCode !== 'others') {
            sessionCountryCode = shortCode;
        }

        if (countryId === 'others') {
            $('.otherscoun').removeClass('hidden').attr('required', 'required');
        } else {
            $('.otherscoun').addClass('hidden').removeAttr('required').val('others');
        }
    });
    $('#countries').trigger('change');

    var addressInput = document.getElementById('contact_address_input');
    var suggestionsList = document.getElementById('contact_address_suggestions');
    var spinner = document.getElementById('contact_address_spinner');

    function hideSuggestions() {
        if (suggestionsList) {
            suggestionsList.innerHTML = '';
            suggestionsList.style.display = 'none';
        }
    }

    function fetchSuggestions(q) {
        if (spinner) spinner.style.display = 'inline';
        var cCode = sessionCountryCode;
        fetch('https://nominatim.openstreetmap.org/search?format=json&addressdetails=1&limit=6&accept-language=en&countrycodes=' + cCode + '&q=' + encodeURIComponent(q))
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
                    li.style.cssText = 'padding:9px 14px; cursor:pointer; border-bottom:1px solid #f0f0f0; background:#fff; color:#333; font-size:13px; text-align:left;';
                    li.addEventListener('mouseenter', function() { li.style.background = '#f6fbf0'; });
                    li.addEventListener('mouseleave', function() { li.style.background = '#fff'; });
                    li.addEventListener('mousedown', function(e) {
                        e.preventDefault();
                        addressInput.value = label;
                        hideSuggestions();
                    });
                    suggestionsList.appendChild(li);
                });
                suggestionsList.style.display = 'block';
            }).catch(function() { if (spinner) spinner.style.display = 'none'; });
    }

    if (addressInput) {
        addressInput.addEventListener('input', function() {
            clearTimeout(debounceTimer);
            var q = this.value.trim();
            if (q.length < 2) { hideSuggestions(); return; }
            debounceTimer = setTimeout(function() { fetchSuggestions(q); }, 400);
        });

        addressInput.addEventListener('blur', function() {
            setTimeout(hideSuggestions, 200);
        });
    }

    $('#exampleModal').modal({
        backdrop: 'static',
        keyboard: false,
        show: false
    });
});
</script>

@if (session('success'))
<script>
$(document).ready(function() {
    $('#exampleModal').modal('show');
});
</script>
@endif
