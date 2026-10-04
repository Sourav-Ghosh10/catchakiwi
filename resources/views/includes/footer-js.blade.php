<!--<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>-->
<!--<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js'></script>-->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.js"></script>
    <script>
        var $modal = $('.imagecrop');
        var image = document.getElementById('image');
        var cropper;
        $("body").on("change", ".imageUpload", function(e){
            //alert(this.id);
            $("#uploadtype").val(this.id);
            var files = e.target.files;
            
            // Size validation (10MB = 10240 KB)
            if (files && files.length > 0) {
                var fileSize = files[0].size / 1024; // size in KB
                if (fileSize > 10240) {
                    alert('The image upload must not be greater than 10240 kilobytes (10MB).');
                    $(this).val(''); // Clear the input
                    return false;
                }
            }

            var done = function(url) {
                image.src = url;
                
                $modal.modal({
                    backdrop: 'static',
                    keyboard: false
                });
            };
            var reader;
            var file;
            var url;
            if (files && files.length > 0) {
                file = files[0];
                if (URL) {
                    done(URL.createObjectURL(file));
                } else if (FileReader) {
                    reader = new FileReader();
                    reader.onload = function(e) {
                        done(reader.result);
                    };
                    reader.readAsDataURL(file);
                }
            }
        });
        $modal.on('shown.bs.modal', function() {
            if (cropper) {
                cropper.destroy();
                cropper = null;
            }
            let uploadtype = $("#uploadtype").val();
            let ratio = 800 / 600;
            if (uploadtype == "imageUpload" || uploadtype == "imageUpload2") {
                ratio = 1;
            } else if (uploadtype == "coverupload") {
                ratio = 3;
            } else if (uploadtype && uploadtype.startsWith("noticeimg")) {
                ratio = 600 / 400;
            } else if (uploadtype == "businessimage" || uploadtype == "articleimage") {
                ratio = 800 / 600;
            }

            cropper = new Cropper(image, {
                aspectRatio: ratio,
                viewMode: 1,
                autoCropArea: 0.8,
                responsive: true,
                restore: false,
                checkCrossOrigin: false,
            });
        }).on('hidden.bs.modal', function() {
            if (cropper) {
                cropper.destroy();
                cropper = null;
            }
        });
        $("body").on("click", "#crop", function() {
            try {
                let uploadtype = $("#uploadtype").val();
                let canvas;
                if(uploadtype=="imageUpload" || uploadtype=="imageUpload2"){
                    canvas = cropper.getCroppedCanvas({ width: 200, height: 200 });
                }else if(uploadtype=="coverupload"){
                    canvas = cropper.getCroppedCanvas({ width: 1074, height: 400 });
                }else if(uploadtype.startsWith("noticeimg")){
                    canvas = cropper.getCroppedCanvas({ width: 600, height: 400 });
                }else if(uploadtype == "businessimage" || uploadtype == "articleimage"){
                    canvas = cropper.getCroppedCanvas({ width: 800, height: 600 });
                }
                if(canvas){
                    var base64data = canvas.toDataURL('image/jpeg', 0.8);
                    if(uploadtype=="imageUpload" || uploadtype=="imageUpload2"){
                        if (typeof window.showCatchakiwiLoader === 'function') {
                            window.showCatchakiwiLoader();
                        }
                        $('#base64image').val(base64data);
                        var preview = document.getElementById('imagePreview');
                        if (preview) {
                            preview.style.backgroundImage = "url("+base64data+")";
                        }
                        // alert('Submitting profile photo...');
                        $('#profile_photo').submit();
                    }else if(uploadtype=="coverupload"){
                        if (typeof window.showCatchakiwiLoader === 'function') {
                            window.showCatchakiwiLoader();
                        }
                        $('#base64coverimage').val(base64data);
                        // alert('Submitting cover banner...');
                        $('#profilecoverbanner').submit();
                    }else if(uploadtype.startsWith("noticeimg")){
                        let index = uploadtype.replace('noticeimg', '');
                        if (index === "") index = "1";
                        
                        let base64Input = $('#noticeimgbase64' + index);
                        let previewDiv = $('.noticeimgshow' + (index === "1" ? "" : index));
                        
                        base64Input.val(base64data);
                        previewDiv.removeClass('placeholder-icon').html('<img src="'+base64data+'" alt=""><div class="remove-img" data-index="'+index+'">X</div>');
                    }else if(uploadtype == "businessimage" || uploadtype == "articleimage"){ 
                        $('#base64image').val(base64data);
                        $(".cropimg").attr('src', base64data);
                        $(".remove-bus-image").show();
                    }
                    $modal.modal('hide');
                }
            } catch(err) {
                console.error('Crop error:', err);
                if (typeof window.hideCatchakiwiLoader === 'function') {
                    window.hideCatchakiwiLoader();
                }
                alert('Crop failed: ' + err.message);
            }
        });

        // Automatically show Catchakiwi spinner overlay on form submissions (Notice post/edit, Business add/edit, Profile forms, etc.)
        $(document).on("submit", "form", function(e) {
            if ($(this).hasClass('no-loader')) return;
            if (typeof window.showCatchakiwiLoader === 'function') {
                window.showCatchakiwiLoader();
            }
        });

        // Make image section clickable ONLY when the crop modal is NOT open
        $(document).on("click", ".browse_img.busdes", function(e) {
            // Don't fire if crop modal is visible
            if ($('.imagecrop').hasClass('show') || $('.imagecrop').is(':visible')) {
                return;
            }
            if ($(e.target).closest('.remove-bus-image').length > 0) {
                return;
            }
            var $input = $(this).find("input[type='file']");
            if (e.target !== $input[0]) {
                $input.trigger("click");
            }
        });

        // Handle image removal
        $(document).on("click", ".remove-bus-image", function(e) {
            e.preventDefault();
            e.stopPropagation();
            var defaultImg = "{{ asset('assets/images/busines-defaultlogo.png') }}";
            var $container = $(this).closest('.frm_propic');
            $container.find('img.cropimg').attr('src', defaultImg);
            $container.find('#base64image').val('');
            $container.find('input[type="file"]').val('');
            $(this).hide();
        });
        // Handle notice image removal
        $(document).on("click", ".remove-img", function(e) {
            e.preventDefault();
            e.stopPropagation();
            let index = $(this).data('index');
            let base64Input = $('#noticeimgbase64' + index);
            let previewDiv = $('.noticeimgshow' + (index === "1" ? "" : index));
            let fileInput = $('#noticeimg' + index);
            
            base64Input.val('');
            fileInput.val('');
            previewDiv.addClass('placeholder-icon').html('<i class="fa fa-camera"></i><span>Image '+index+'</span>');
        });

        // Dynamic Website URL Validation (only show tick mark when a valid URL is entered)
        function validateWebsiteInput(input) {
            var val = $.trim($(input).val());
            if (!val) {
                $(input).removeClass('thikmark');
                return;
            }
            var urlPattern = /^(https?:\/\/)?(www\.)?([a-zA-Z0-9-]+\.)+[a-zA-Z]{2,}(\/[^\s]*)?$/i;
            if (urlPattern.test(val)) {
                $(input).addClass('thikmark');
            } else {
                $(input).removeClass('thikmark');
            }
        }

        $(document).ready(function() {
            $('input[name="website_url"]').each(function() {
                validateWebsiteInput(this);
            });
        });

        $(document).on('input blur change keyup', 'input[name="website_url"]', function() {
            validateWebsiteInput(this);
        });
    </script>
    <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>-->

     <script src="{{ asset('assets/js/easyResponsiveTabs.js') }}"></script>
 <script type="text/javascript">
    jQuery(document).ready(function($) {
  $('#parentHorizontalTab').easyResponsiveTabs({
    type: 'default',
    width: 'auto',
    fit: true,
    tabidentify: 'hor_1'
  });
});
</script>