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
            let uploadtype = $("#uploadtype").val();
            if(uploadtype == "imageUpload" || uploadtype == "imageUpload2"){
                cropper = new Cropper(image, {
                    aspectRatio: 1,
                    viewMode: 1,
                });
            }else if(uploadtype=="coverupload"){
                cropper = new Cropper(image, {
                    aspectRatio: 3,
                    viewMode: 1,
                });
            }else if(uploadtype == "noticeimg"){
                cropper = new Cropper(image, {
                    aspectRatio: 6/4,
                    viewMode: 1,
                });
            }else if(uploadtype == "businessimage" || uploadtype == "articleimage"){
                cropper = new Cropper(image, {
                    aspectRatio: 800/600,
                    viewMode: 1,
                });
            }
            
        }).on('hidden.bs.modal', function() {
            cropper.destroy();
            cropper = null;
        });
        $("body").on("click", "#crop", function() {
            try {
                let uploadtype = $("#uploadtype").val();
                let canvas;
                if(uploadtype=="imageUpload" || uploadtype=="imageUpload2"){
                    canvas = cropper.getCroppedCanvas({ width: 200, height: 200 });
                }else if(uploadtype=="coverupload"){
                    canvas = cropper.getCroppedCanvas({ width: 1074, height: 400 });
                }else if(uploadtype=="noticeimg"){
                    canvas = cropper.getCroppedCanvas({ width: 310, height: 206 });
                }else if(uploadtype == "businessimage" || uploadtype == "articleimage"){
                    canvas = cropper.getCroppedCanvas({ width: 800, height: 600 });
                }
                if(canvas){
                    var base64data = canvas.toDataURL('image/jpeg', 0.8);
                    if(uploadtype=="imageUpload" || uploadtype=="imageUpload2"){
                        $('#base64image').val(base64data);
                        var preview = document.getElementById('imagePreview');
                        if (preview) {
                            preview.style.backgroundImage = "url("+base64data+")";
                        }
                        // alert('Submitting profile photo...');
                        $('#profile_photo').submit();
                    }else if(uploadtype=="coverupload"){
                        $('#base64coverimage').val(base64data);
                        // alert('Submitting cover banner...');
                        $('#profilecoverbanner').submit();
                    }else if(uploadtype=="noticeimg"){
                        $('#noticeimgbase64').val(base64data);
                        $(".noticeimgshow").html('<img src="'+base64data+'" alt=""><span>X</span>');
                    }else if(uploadtype == "businessimage" || uploadtype == "articleimage"){ 
                        $('#base64image').val(base64data);
                        $(".cropimg").attr('src', base64data);
                        $(".remove-bus-image").show();
                    }
                    $modal.modal('hide');
                }
            } catch(err) {
                console.error('Crop error:', err);
                alert('Crop failed: ' + err.message);
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