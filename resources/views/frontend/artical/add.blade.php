@include('includes/inner-header')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/quill/1.3.7/quill.snow.min.css" />
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<style>
    label[for="editor"] { display: none; }
    #editor { min-height: 300px; background: #fff; border-radius: 0 0 5px 5px; }
    .ql-toolbar { border-radius: 5px 5px 0 0; background: #f8f9fa; }
    .cropimg { width: 100%; max-width: 400px; height: auto; display: block; margin-bottom: 15px; border: 1px solid #ddd; padding: 5px; border-radius: 5px; }
    .help_icon { cursor: pointer; margin-left: 5px; }
    .help_icontxt { display: none; background: #f9f9f9; padding: 10px; border: 1px solid #ddd; border-radius: 5px; margin-top: 5px; font-size: 14px; }
    .delimgwrap { position: relative; width: fit-content; }
    .delpicc { position: absolute; top: -10px; right: -10px; width: 25px; height: 25px; cursor: pointer; z-index: 10; }
</style>

<div class="modal fade bd-example-modal-lg imagecrop" id="model" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Crop Featured Image</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="img-container">
                    <img id="image" src="">
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

<div class="mid_body">
    <div class="container">
        <div class="full_midpan">
            <div class="row">
                <div class="col-lg-8 col-md-8 col-sm-12">
                    <div class="left_searchresults">
                        <h3><img src="{{ asset('assets/images/article_icon2.png') }}" alt=""> Articles <br>
                            <span><a href="{{ url('/') }}" style="color: #729b0f; text-decoration: none;">Home</a> > <a href="{{ route('article.list') }}" style="color: #729b0f; text-decoration: none;">Articles</a> > Add Article</span> 
                        </h3>
                    </div>
                </div>
            </div>
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

                    <div class="left_profileform">
                        <form action="{{ route('article.store') }}" id="articleForm" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="tab_form">
                                <div class="acc_content" style="display:block; border-top:none;">
                                    <div class="frm_dv">
                                        <label>Article Title *</label>
                                        <input name="title" type="text" value="{{ old('title') }}" placeholder="Enter a catchy title" required>
                                    </div>

                                    <div class="frm_dv">
                                        <label>Category *</label>
                                        <select name="category_id" id="category_id" class="form-select" required>
                                            <option value="">Select Category</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="frm_dv">
                                        <label>Featured Image (Optional)</label>
                                        <div class="browse_img">
                                           <div class="delimgwrap" id="preview_container">
                                             <img class="delpicc" id="remove_image_btn" src="{{ asset('assets/images/close-window.png') }}" alt="">
                                            <img class="cropimg" id="featured_image_preview" src="{{ asset('assets/images/articledefaltimg.png') }}" alt="Article Image">
                                          </div>
                                            <div class="newupload">
                                                <div class="customupbtn">
                                                    <input name="imageUpload" type="file" id="articleimage" class="imageUpload" accept="image/*">
                                                    <input type="hidden" name="base64image" id="base64image">
                                                    <input type="hidden" name="remove_image" id="remove_image" value="0">
                                                </div>
                                                <span class="small text-muted">Recommended size 800x600px. Click to upload and crop.</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="frm_dv">
                                        <label>Content *</label>
                                        <div id="editor">{!! old('content') !!}</div>
                                        <input type="hidden" name="content" id="content_input">
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4">
                                <input type="submit" value="Submit for Review">
                                <a href="{{ route('article.list') }}" class="editcancelbtn">Cancel</a>
                            </div>
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
                                            <img src="{{ asset($ad->ads_image) }}" alt="Ad">
                                        </a>
                                    @else
                                        <img src="{{ asset($ad->ads_image) }}" alt="Ad">
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/quill/1.3.7/quill.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var toolbarOptions = [
            [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
            ['bold', 'italic', 'underline'], 
            [{ 'list': 'ordered'}, { 'list': 'bullet' }],
            [{ 'align': [] }],
            ['link', 'image', 'video']
        ];

        var quill = new Quill('#editor', {
            modules: { toolbar: toolbarOptions },
            theme: 'snow'
        });

        var form = document.getElementById('articleForm');
        form.onsubmit = function() {
            var content = document.querySelector('#content_input');
            content.value = quill.root.innerHTML;
            
            if (quill.getText().trim().length === 0 && quill.root.innerHTML.indexOf('<img') === -1) {
                alert('Please enter some content for your article.');
                return false;
            }
        };

        // Handle Image Removal
        document.getElementById('remove_image_btn').addEventListener('click', function() {
            document.getElementById('remove_image').value = '1';
            document.getElementById('base64image').value = '';
            document.getElementById('articleimage').value = '';
            document.getElementById('preview_container').style.display = 'none';
        });

        // Show remove button and image when new image is selected
        $("body").on("click", "#crop", function() {
            if ($("#uploadtype").val() === "articleimage") {
                document.getElementById('preview_container').style.display = 'block';
                document.getElementById('remove_image_btn').style.display = 'block';
                document.getElementById('remove_image').value = '0';
            }
        });
    });
</script>

@include('includes/footer-js')
@include('includes/footer')
