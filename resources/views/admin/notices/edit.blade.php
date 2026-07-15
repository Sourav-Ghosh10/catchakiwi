@include('includes/admin-header')
@include('includes/admin-sidebar')

<style>
.notice-edit-wrapper { max-width: 900px; margin: 0 auto; }
.page-header-card {
    background: linear-gradient(135deg,#1e2130,#252836);
    border:1px solid #2c2e3e; border-radius:12px;
    padding:22px 28px; display:flex; align-items:center;
    justify-content:space-between; flex-wrap:wrap; gap:12px; margin-bottom:22px;
}
.page-header-card h4 { margin:0; font-size:1.3rem; font-weight:700; color:#e8eaf0; }
.breadcrumb-path { font-size:12px; color:#6c7293; margin-top:3px; }
.breadcrumb-path a { color:#6c7293; text-decoration:none; }
.meta-badges { display:flex; gap:8px; flex-wrap:wrap; }
.meta-badge { padding:4px 12px; border-radius:20px; font-size:11px; font-weight:600; letter-spacing:.5px; text-transform:uppercase; }
.meta-badge.mid  { background:#1f2842; color:#7c9fe8; border:1px solid #2d3f6a; }
.meta-badge.st   { background:#2c2416; color:#f0b84c; border:1px solid #5c4116; }
.meta-badge.ft   { background:#1d1f3a; color:#a78cf8; border:1px solid #3a2f6e; }

.edit-card { background:#1e2130; border:1px solid #2c2e3e; border-radius:12px; margin-bottom:20px; }
.edit-card > .edit-card-header:first-child { border-radius:12px 12px 0 0; }
.edit-card-header { padding:15px 22px; border-bottom:1px solid #2c2e3e; display:flex; align-items:center; gap:10px; }
.s-icon { width:30px; height:30px; border-radius:8px; display:flex; align-items:center; justify-content:center; font-size:14px; flex-shrink:0; }
.s-icon.blue   { background:#1f2842; color:#7c9fe8; }
.s-icon.purple { background:#1d1f3a; color:#a78cf8; }
.s-icon.green  { background:#1f2e2a; color:#6ecba8; }
.s-icon.amber  { background:#2c2416; color:#f0b84c; }
.edit-card-header h6 { margin:0; font-size:.8rem; font-weight:700; text-transform:uppercase; letter-spacing:1px; color:#b6bbce; }
.edit-card-body { padding:22px; }

.field-label { font-size:11px; font-weight:600; letter-spacing:.6px; text-transform:uppercase; color:#6c7293; margin-bottom:6px; display:block; }
.required-star { color:#f07c7c; }
.edit-input {
    width:100%; background:#252836; border:1px solid #35384a; border-radius:8px;
    color:#c8ccd8; padding:10px 14px; font-size:14px; outline:none;
    transition:border-color .2s, box-shadow .2s;
}
.edit-input:focus { border-color:#6c63ff; box-shadow:0 0 0 3px rgba(108,99,255,.15); color:#e8eaf0; }
textarea.edit-input { resize:vertical; min-height:110px; line-height:1.6; }
select.edit-input { cursor: pointer; }
/* Wrap selects in .sel-wrap for the arrow decoration */
.sel-wrap {
    position: relative;
    display: block;
}
.sel-wrap::after {
    content: '';
    position: absolute;
    right: 14px;
    top: 50%;
    transform: translateY(-50%);
    width: 0; height: 0;
    border-left: 5px solid transparent;
    border-right: 5px solid transparent;
    border-top: 6px solid #6c7293;
    pointer-events: none;
}
.sel-wrap select.edit-input {
    padding-right: 36px !important;
}
select.edit-input option { background:#252836; color:#c8ccd8; }
.char-counter { font-size:11px; color:#4e5270; text-align:right; margin-top:4px; transition:color .2s; }
.char-counter.warn  { color:#f0b84c; }
.char-counter.limit { color:#f07c7c; }
.field-hint { font-size:11px; color:#4e5270; margin-top:5px; }

/* notice type cards */
.type-grid { display:grid; grid-template-columns:1fr 1fr; gap:12px; }
.type-card {
    position:relative; border:2px solid #35384a; border-radius:10px;
    padding:16px 18px; cursor:pointer; transition:border-color .2s, background .2s;
    background:#252836;
}
.type-card input[type="radio"] { position:absolute; opacity:0; width:0; height:0; }
.type-card.sel-std  { border-color:#f0b84c; background:rgba(240,184,76,.06); box-shadow:0 0 0 3px rgba(240,184,76,.12); }
.type-card.sel-feat { border-color:#a78cf8; background:rgba(167,140,248,.06); box-shadow:0 0 0 3px rgba(167,140,248,.12); }
.tc-check { position:absolute; top:10px; right:12px; width:16px; height:16px; border-radius:50%; border:2px solid #35384a; display:flex; align-items:center; justify-content:center; font-size:8px; }
.type-card.sel-std  .tc-check { border-color:#f0b84c; background:#f0b84c; color:#1e1a0a; }
.type-card.sel-feat .tc-check { border-color:#a78cf8; background:#a78cf8; color:#1d1f3a; }
.tc-icon  { font-size:20px; margin-bottom:6px; }
.tc-label { font-size:13px; font-weight:700; color:#c8ccd8; margin-bottom:2px; }
.tc-desc  { font-size:11px; color:#4e5270; }

/* item-type radio buttons */
.radio-group { display:flex; gap:16px; flex-wrap:wrap; }
.radio-opt {
    display:flex; align-items:center; gap:8px;
    background:#252836; border:1px solid #35384a; border-radius:8px;
    padding:10px 16px; cursor:pointer; transition:border-color .2s;
    font-size:13px; color:#c8ccd8;
}
.radio-opt input[type="radio"] { accent-color:#6c63ff; width:15px; height:15px; cursor:pointer; }
.radio-opt:has(input:checked) { border-color:#6c63ff; background:rgba(108,99,255,.08); }

.two-col { display:grid; grid-template-columns:1fr 1fr; gap:18px; }
.field-group { margin-bottom:18px; }
.field-group:last-child { margin-bottom:0; }

/* images */
.img-gallery { display:flex; flex-wrap:wrap; gap:12px; }
.img-thumb { position:relative; width:120px; height:88px; border-radius:8px; overflow:hidden; border:1px solid #35384a; }
.img-thumb img { width:100%; height:100%; object-fit:cover; display:block; }
.no-img-box { padding:24px 20px; text-align:center; color:#4e5270; font-size:13px; background:#252836; border:1px dashed #35384a; border-radius:8px; width:100%; }

/* Image upload grid */
.adm-img-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:14px; }
.adm-img-slot {
    position:relative; border:2px dashed #35384a; border-radius:10px;
    aspect-ratio:3/2; overflow:hidden; cursor:pointer; background:#252836;
    display:flex; align-items:center; justify-content:center;
    transition:border-color .2s, background .2s;
}
.adm-img-slot:hover { border-color:#6c63ff; background:#2a2d40; }
.adm-img-slot img { width:100%; height:100%; object-fit:cover; display:block; position:absolute; inset:0; }
.adm-placeholder { display:flex; flex-direction:column; align-items:center; gap:6px; color:#4e5270; pointer-events:none; }
.adm-placeholder i { font-size:26px; }
.adm-placeholder span { font-size:11px; }
.adm-remove {
    position:absolute; top:6px; right:6px; width:22px; height:22px;
    border-radius:50%; background:rgba(240,76,76,.85); color:#fff;
    display:flex; align-items:center; justify-content:center;
    font-size:11px; font-weight:700; cursor:pointer; z-index:10;
    transition:background .2s;
}
.adm-remove:hover { background:#d63030; }
@media(max-width:640px){ .adm-img-grid{ grid-template-columns:repeat(2,1fr); } }

/* actions */
.action-bar { display:flex; align-items:center; gap:12px; flex-wrap:wrap; margin-bottom:32px; }
.btn-save {
    background:linear-gradient(135deg,#6c63ff,#8b85ff); border:none; color:#fff;
    padding:11px 28px; border-radius:8px; font-size:14px; font-weight:600;
    cursor:pointer; transition:transform .15s, box-shadow .15s; display:flex; align-items:center; gap:8px;
}
.btn-save:hover { transform:translateY(-1px); box-shadow:0 6px 20px rgba(108,99,255,.35); }
.btn-cancel {
    background:#252836; border:1px solid #35384a; color:#8a8fa8;
    padding:11px 20px; border-radius:8px; font-size:14px; font-weight:500;
    text-decoration:none; display:inline-flex; align-items:center; gap:6px;
    transition:background .2s, color .2s;
}
.btn-cancel:hover { background:#2c2e3e; color:#c8ccd8; }
.alert-ok  { padding:12px 16px; border-radius:8px; margin-bottom:18px; background:#162a21; border:1px solid #255c38; color:#6ecba8; font-size:13px; }
.alert-err { padding:12px 16px; border-radius:8px; margin-bottom:18px; background:#2a1616; border:1px solid #5c2525; color:#f07c7c; font-size:13px; }

@media(max-width:640px){ .two-col,.type-grid{ grid-template-columns:1fr; } }

/* Selectize dark-theme overrides */
.selectize-control { width:100%; }
.selectize-input {
    background:#252836 !important; border:1px solid #35384a !important;
    border-radius:8px !important; color:#c8ccd8 !important;
    padding:9px 14px !important; box-shadow:none !important;
    font-size:14px !important; min-height:40px !important;
    display:flex !important; align-items:center !important;
}
.selectize-input.focus { border-color:#6c63ff !important; box-shadow:0 0 0 3px rgba(108,99,255,.15) !important; }
.selectize-input input { color:#c8ccd8 !important; }
.selectize-input input::placeholder { color:#4e5270 !important; }
.selectize-dropdown {
    background:#252836 !important; border:1px solid #35384a !important;
    border-radius:8px !important; box-shadow:0 8px 24px rgba(0,0,0,.4) !important;
    z-index:9999 !important;
}
.selectize-dropdown .option { color:#c8ccd8 !important; padding:9px 14px !important; }
.selectize-dropdown .option:hover,
.selectize-dropdown .option.active { background:#2c2e3e !important; color:#e8eaf0 !important; }
</style>

<div class="main-panel">
<div class="content-wrapper">
<div class="notice-edit-wrapper">

    {{-- Header --}}
    <div class="page-header-card">
        <div>
            <h4><i class="mdi mdi-pencil-box-outline" style="color:#6c63ff;margin-right:8px;"></i>Edit Notice</h4>
            <div class="breadcrumb-path">
                <a href="{{ route('admin.dashboard') }}">Dashboard</a> /
                <a href="{{ route('admin.notices.index') }}">Notices</a> / Edit #{{ $notice->id }}
            </div>
        </div>
        <div class="meta-badges">
            <span class="meta-badge mid"># {{ $notice->id }}</span>
            @if($notice->noticetype === 'feature')
                <span class="meta-badge ft">⭐ Featured</span>
            @else
                <span class="meta-badge st">📋 Standard</span>
            @endif
        </div>
    </div>

    @if(session('success'))
        <div class="alert-ok"><i class="mdi mdi-check-circle"></i> {{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="alert-err">
            @foreach($errors->all() as $e) <div>{{ $e }}</div> @endforeach
        </div>
    @endif

    <form action="{{ route('admin.notices.update', $notice->id) }}" method="POST">
        @csrf
        @method('PUT')
        <input type="hidden" name="header_country" value="{{ $notice->country ?? 'NZ' }}">

        {{-- ── Card 1: Classification ──────────────────── --}}
        <div class="edit-card">
            <div class="edit-card-header">
                <div class="s-icon blue"><i class="mdi mdi-tag-outline"></i></div>
                <h6>Classification</h6>
            </div>
            <div class="edit-card-body">
                <div class="field-group">
                    <label class="field-label" for="category_id">Category <span style="font-size:10px;color:#4e5270;font-weight:400;text-transform:none;letter-spacing:0;">(read-only)</span></label>
                    {{-- Hidden input carries the value since disabled fields don't submit --}}
                    <input type="hidden" name="category_id" value="{{ $notice->category_id }}">
                    <div class="sel-wrap">
                    <select id="category_id" class="edit-input" disabled
                        style="opacity:0.5; cursor:not-allowed; background:#1a1d28;">
                        @foreach($category as $cat)
                            <option value="{{ $cat->id }}"
                                data-slug="{{ $cat->slug ?? '' }}"
                                {{ $notice->category_id == $cat->id ? 'selected' : '' }}>
                                {{ $cat->category }}
                            </option>
                        @endforeach
                    </select>
                    </div>
                    <div class="field-hint"><i class="mdi mdi-lock-outline"></i> Category cannot be changed after submission.</div>
                </div>

                {{-- Notice Type — hidden for cat 2 (Get a Quote) --}}
                <div class="field-group" id="notice_type_section">
                    <label class="field-label">Notice Type <span class="required-star">*</span></label>
                    <div class="type-grid">
                        <label class="type-card {{ $notice->noticetype == 'standard' ? 'sel-std' : '' }}" id="card-std">
                            <input type="radio" name="noticetype" value="standard" {{ $notice->noticetype == 'standard' ? 'checked' : '' }}>
                            <div class="tc-check">{{ $notice->noticetype == 'standard' ? '✓' : '' }}</div>
                            <div class="tc-icon">📋</div>
                            <div class="tc-label">Standard</div>
                            <div class="tc-desc">7 days · Free</div>
                        </label>
                        <label class="type-card {{ $notice->noticetype == 'feature' ? 'sel-feat' : '' }}" id="card-feat">
                            <input type="radio" name="noticetype" value="feature" {{ $notice->noticetype == 'feature' ? 'checked' : '' }}>
                            <div class="tc-check">{{ $notice->noticetype == 'feature' ? '✓' : '' }}</div>
                            <div class="tc-icon">⭐</div>
                            <div class="tc-label">Feature</div>
                            <div class="tc-desc">28 days · $3.00</div>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        {{-- ── Card 2: Dynamic Fields ──────────────────── --}}
        <div class="edit-card">
            <div class="edit-card-header">
                <div class="s-icon purple"><i class="mdi mdi-text-box-outline"></i></div>
                <h6 id="content_card_title">Notice Content</h6>
            </div>
            <div class="edit-card-body">

                {{-- Notice Title (hidden for cat 2) --}}
                <div class="field-group" id="title_section">
                    <label class="field-label" for="notice_title">Notice Title <span class="required-star">*</span></label>
                    <input type="text" name="notice_title" id="notice_title" class="edit-input"
                        value="{{ old('notice_title', $notice->heading) }}" maxlength="35">
                    <div class="char-counter" id="title-counter">{{ strlen($notice->heading) }} / 35 characters</div>
                </div>

                {{-- ── Get a Quote specific fields (cat 2) ── --}}
                <div id="quote_fields" style="display:none;">
                    <div class="field-group">
                        <label class="field-label" for="looking_for_select">I'm Looking for</label>
                        <div class="sel-wrap">
                        <select name="looking_for" id="looking_for_select" class="edit-input">
                            <option value="">Select Service</option>
                            @foreach(['Architect and Drafting','Brick and block Laying','Building','Car Cleaning','Carpet and Furniture cleaning','Cleaning','Computer Help','Concreting','Electrical','Flooring','Gardening','Gib Fixing and Plastering','Handy person','House washing','Interior Design','Landscaping','Locksmith','Moving','Painting','Plumbing','Roofing','Tiling'] as $svc)
                                <option value="{{ $svc }}" {{ ($notice->looking_for ?? '') === $svc ? 'selected' : '' }}>{{ $svc }}</option>
                            @endforeach
                        </select>
                        </div>
                    </div>
                    <div class="two-col">
                        <div class="field-group">
                            <label class="field-label" for="quote_job_loc">Where is the job?</label>
                            <select name="job_location" id="quote_job_loc" placeholder="Select Suburb/City"></select>
                        </div>
                        <div class="field-group">
                            <label class="field-label" for="start_date_sel">When to start?</label>
                            <div class="sel-wrap">
                            <select name="start_date" id="start_date_sel" class="edit-input">
                                <option value="">Select Timing</option>
                                @foreach(['Emergency','ASAP','Next few days',"I'm flexible",'Next few weeks','Next few months'] as $t)
                                    <option value="{{ $t }}" {{ ($notice->start_date ?? '') === $t ? 'selected' : '' }}>{{ $t }}</option>
                                @endforeach
                            </select>
                            </div>
                        </div>
                        <div class="field-group">
                            <label class="field-label" for="budget_sel">Budget</label>
                            <div class="sel-wrap">
                            <select name="budget" id="budget_sel" class="edit-input">
                                <option value="">Select Budget</option>
                                @foreach(['Under $300','$300 to $600','$600 to $1000','More than $1000','Not sure'] as $b)
                                    <option value="{{ $b }}" {{ ($notice->budget ?? '') === $b ? 'selected' : '' }}>{{ $b }}</option>
                                @endforeach
                            </select>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ── $5 Service Deal / Items-for-Sale ── --}}
                <div id="service_fields" style="display:none;">
                    <div class="field-group">
                        <label class="field-label" for="town_suburb_sel">Town / Suburb</label>
                        <select name="town_suburb" id="town_suburb_sel" placeholder="Select Town/Suburb"></select>
                    </div>
                </div>

                {{-- ── Items-for-Sale radio ── --}}
                <div id="item_options" style="display:none;">
                    <div class="field-group">
                        <label class="field-label">Item Options</label>
                        <div class="radio-group">
                            <label class="radio-opt">
                                <input type="radio" name="item_type" value="Item for sale"
                                    {{ ($notice->looking_for ?? '') === 'Item for sale' ? 'checked' : '' }}>
                                Item for sale
                            </label>
                            <label class="radio-opt">
                                <input type="radio" name="item_type" value="Item Wanted"
                                    {{ ($notice->looking_for ?? '') === 'Item Wanted' ? 'checked' : '' }}>
                                Item Wanted
                            </label>
                        </div>
                    </div>
                </div>

                {{-- Content / Description textarea (always shown) --}}
                <div class="field-group" style="margin-bottom:0;">
                    <label class="field-label" for="notice_body" id="body_label">Content <span class="required-star">*</span></label>
                    <textarea name="notice_body" id="notice_body" class="edit-input" rows="5"
                        maxlength="{{ in_array($notice->category_id, [1,9]) ? 300 : 155 }}" required>{{ old('notice_body', $notice->content) }}</textarea>
                    <div class="char-counter" id="body-counter">
                        {{ strlen($notice->content) }} / {{ in_array($notice->category_id, [1,9]) ? 300 : 155 }} characters
                    </div>
                </div>

            </div>
        </div>

        {{-- ── Card 3: Images ─────────────────────────── --}}
        <div class="edit-card">
            <div class="edit-card-header">
                <div class="s-icon amber"><i class="mdi mdi-image-outline"></i></div>
                <h6>Notice Images <span style="font-size:10px;color:#4e5270;text-transform:none;font-weight:400;">· up to 3 slots (6 for featured)</span></h6>
            </div>
            <div class="edit-card-body">
                <div class="adm-img-grid" id="admin_img_grid">
                    @php $maxSlots = $notice->noticetype === 'feature' ? 6 : 3; @endphp
                    @for($i = 1; $i <= $maxSlots; $i++)
                        @php $existingImg = $noticeImages[$i-1] ?? null; @endphp
                        <div class="adm-img-slot" id="adm_slot_{{ $i }}" onclick="document.getElementById('adm_file_{{ $i }}').click();">
                            @if($existingImg)
                                <img src="{{ asset($existingImg->img_path) }}" id="adm_preview_{{ $i }}" alt="">
                                <input type="hidden" name="noticeimgbase64[]" class="adm-b64" id="adm_b64_{{ $i }}" value="{{ $existingImg->img_path }}">
                            @else
                                <img src="" id="adm_preview_{{ $i }}" alt="" style="display:none;">
                                <input type="hidden" name="noticeimgbase64[]" class="adm-b64" id="adm_b64_{{ $i }}" value="">
                                <div class="adm-placeholder" id="adm_ph_{{ $i }}">
                                    <i class="mdi mdi-camera-plus-outline"></i>
                                    <span>Image {{ $i }}</span>
                                </div>
                            @endif
                            @if($existingImg)
                                <div class="adm-remove" onclick="event.stopPropagation(); adminRemoveImg({{ $i }});">✕</div>
                            @else
                                <div class="adm-remove" id="adm_rm_{{ $i }}" onclick="event.stopPropagation(); adminRemoveImg({{ $i }});" style="display:none;">✕</div>
                            @endif
                            <input type="file" id="adm_file_{{ $i }}" accept="image/*" style="display:none;"
                                onchange="adminHandleFile(this, {{ $i }})">
                        </div>
                    @endfor
                </div>
                <p class="field-hint" style="margin-top:14px;margin-bottom:0;">
                    <i class="mdi mdi-information-outline"></i>
                    Click a slot to upload or replace an image. Click <strong>✕</strong> to remove. Recommended: 600×400px · JPG/PNG/GIF
                </p>
            </div>
        </div>

        {{-- Action Bar --}}
        <div class="action-bar">
            <button type="submit" class="btn-save">
                <i class="mdi mdi-content-save-outline"></i> Save Changes
            </button>
            <a href="{{ route('admin.notices.index') }}" class="btn-cancel">
                <i class="mdi mdi-arrow-left"></i> Back to Notices
            </a>
        </div>
    </form>

</div>
</div>
</div>

<script>
(function () {
    // ── Notice Type Card Toggle ─────────────────────────────
    document.querySelectorAll('input[name="noticetype"]').forEach(function(r) {
        r.addEventListener('change', function() {
            document.getElementById('card-std').className  = 'type-card' + (this.value==='standard' ? ' sel-std' : '');
            document.getElementById('card-feat').className = 'type-card' + (this.value==='feature'  ? ' sel-feat' : '');
            document.querySelector('#card-std  .tc-check').textContent = this.value==='standard' ? '✓' : '';
            document.querySelector('#card-feat .tc-check').textContent = this.value==='feature'  ? '✓' : '';
        });
    });

    // ── Character Counters ──────────────────────────────────
    function attachCounter(inputId, counterId, max) {
        var el = document.getElementById(inputId);
        var ct = document.getElementById(counterId);
        if (!el || !ct) return;
        el.addEventListener('input', function() {
            var l = this.value.length;
            ct.textContent = l + ' / ' + max + ' characters';
            ct.className   = 'char-counter' + (l>=max ? ' limit' : l>=max*.85 ? ' warn' : '');
        });
    }
    attachCounter('notice_title', 'title-counter', 35);

    // ── Category Switcher ───────────────────────────────────
    var ITEM_SLUGS  = ['items-for-sale','items-for-sale-or-wanted'];
    var ITEM_NAMES  = ['items for sale','items for sale or wanted'];

    function applyCategory(catId, catSlug, catName) {
        var isQuote   = catId == '2';
        var isService = catId == '1';
        var isItems   = ITEM_SLUGS.includes(catSlug) || ITEM_NAMES.includes(catName);

        // Sections
        document.getElementById('notice_type_section').style.display = isQuote ? 'none' : '';
        document.getElementById('title_section').style.display       = isQuote ? 'none' : '';
        document.getElementById('quote_fields').style.display        = isQuote ? '' : 'none';
        document.getElementById('service_fields').style.display      = (isService || isItems) ? '' : 'none';
        document.getElementById('item_options').style.display        = isItems ? '' : 'none';

        // Body label & maxlength
        var bodyTa    = document.getElementById('notice_body');
        var bodyLabel = document.getElementById('body_label');
        var bodyCt    = document.getElementById('body-counter');
        if (isQuote) {
            bodyLabel.innerHTML = 'Job Description <span class="required-star">*</span>';
            bodyTa.maxLength = 300;
        } else if (isService || isItems) {
            bodyLabel.innerHTML = 'Description <span class="required-star">*</span>';
            bodyTa.maxLength = 300;
        } else {
            bodyLabel.innerHTML = 'Content <span class="required-star">*</span>';
            bodyTa.maxLength = 155;
        }
        var max = bodyTa.maxLength;
        bodyCt.textContent = bodyTa.value.length + ' / ' + max + ' characters';
        attachCounter('notice_body', 'body-counter', max);
    }

    document.getElementById('category_id').addEventListener('change', function() {
        var opt  = this.options[this.selectedIndex];
        var slug = opt ? (opt.dataset.slug || '') : '';
        var name = opt ? opt.textContent.trim().toLowerCase() : '';
        applyCategory(this.value, slug, name);
    });

    // ── Fire on page load ───────────────────────────────────
    window.addEventListener('load', function() {
        var sel  = document.getElementById('category_id');
        var opt  = sel.options[sel.selectedIndex];
        var slug = opt ? (opt.dataset.slug || '') : '';
        var name = opt ? opt.textContent.trim().toLowerCase() : '';
        applyCategory(sel.value, slug, name);
        attachCounter('notice_body', 'body-counter', document.getElementById('notice_body').maxLength);
    });
    // ── Image Upload Handling ───────────────────────
    window.adminHandleFile = function(input, index) {
        var file = input.files[0];
        if (!file) return;
        var reader = new FileReader();
        reader.onload = function(e) {
            var b64 = e.target.result;
            // Update hidden base64 input
            document.getElementById('adm_b64_' + index).value = b64;
            // Show preview
            var preview = document.getElementById('adm_preview_' + index);
            preview.src = b64;
            preview.style.display = 'block';
            // Hide placeholder
            var ph = document.getElementById('adm_ph_' + index);
            if (ph) ph.style.display = 'none';
            // Show remove btn
            var rm = document.getElementById('adm_rm_' + index);
            if (rm) rm.style.display = 'flex';
        };
        reader.readAsDataURL(file);
    };

    window.adminRemoveImg = function(index) {
        document.getElementById('adm_b64_' + index).value = '';
        var preview = document.getElementById('adm_preview_' + index);
        preview.src = '';
        preview.style.display = 'none';
        // Show placeholder (create if missing)
        var ph = document.getElementById('adm_ph_' + index);
        if (ph) {
            ph.style.display = 'flex';
        } else {
            var slot = document.getElementById('adm_slot_' + index);
            var newPh = document.createElement('div');
            newPh.className = 'adm-placeholder';
            newPh.id = 'adm_ph_' + index;
            newPh.innerHTML = '<i class="mdi mdi-camera-plus-outline"></i><span>Image ' + index + '</span>';
            slot.appendChild(newPh);
        }
        // Hide remove btn
        var rm = document.getElementById('adm_rm_' + index);
        if (rm) rm.style.display = 'none';
        // Reset file input
        var fi = document.getElementById('adm_file_' + index);
        if (fi) fi.value = '';
    };
})();

// ── Selectize Town Dropdowns ─────────────────────────────────
$(document).ready(function() {
    var townSuburb  = '{{ addslashes($notice->town_suburb ?? '') }}';
    var jobLocation = '{{ addslashes($notice->job_location ?? '') }}';
    var csrfToken   = '{{ csrf_token() }}';
    @php
        $noticeCountryId = \App\Models\Country::where('shortname', $notice->country ?? 'NZ')
            ->value('id') ?? 157;
    @endphp
    var countryId = '{{ $noticeCountryId }}';

    function loadTowns(selectizeInstance, selectedVal) {
        if (!selectizeInstance) return;
        $.ajax({
            url: '{{ route('GetCityStatesameVal') }}',
            method: 'POST',
            data: { country_id: countryId, selected: selectedVal, _token: csrfToken },
            success: function(response) {
                selectizeInstance.clearOptions();
                try {
                    var opts = typeof response === 'string' ? JSON.parse(response) : response;
                    if (opts && opts.length > 0) {
                        selectizeInstance.addOption(opts);
                        selectizeInstance.refreshOptions(false);

                        // The controller marks the matching option with selected:true
                        // Use that exact value to avoid format mismatches
                        var preSelected = null;
                        for (var i = 0; i < opts.length; i++) {
                            if (opts[i].selected === true) {
                                preSelected = opts[i].value;
                                break;
                            }
                        }
                        // Fall back to raw selectedVal if nothing was marked
                        if (preSelected) {
                            selectizeInstance.setValue(preSelected, true);
                        } else if (selectedVal) {
                            selectizeInstance.setValue(selectedVal, true);
                        }
                    }
                } catch(e) { console.error('Selectize parse error', e); }
            },
            error: function(xhr) { console.error('Town load error', xhr.status); }
        });
    }

    var $townSel = $('#town_suburb_sel').selectize({
        create: false, placeholder: 'Select Town/Suburb',
        render: { no_results: function() { return '<div class="no-results">No results found</div>'; } }
    });
    var townSelectize = $townSel[0].selectize;

    var $jobSel = $('#quote_job_loc').selectize({
        create: false, placeholder: 'Select Suburb/City',
        render: { no_results: function() { return '<div class="no-results">No results found</div>'; } }
    });
    var jobSelectize = $jobSel[0].selectize;

    // Load towns for whichever fields are visible on load
    setTimeout(function() {
        loadTowns(townSelectize, townSuburb);
        loadTowns(jobSelectize, jobLocation);
    }, 300);
});
</script>

@include('includes/admin-footer')
