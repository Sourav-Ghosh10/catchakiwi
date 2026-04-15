@include('includes/admin-header')
@include('includes/admin-sidebar')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

<style>
    :root {
        --primary-gradient: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
        --glass-bg: rgba(255, 255, 255, 0.05);
        --glass-border: rgba(255, 255, 255, 0.1);
        --accent-color: #00d2ff;
    }

    .content-wrapper {
        background: #0f111a;
        min-height: 100vh;
    }

    .page-title {
        font-weight: 700;
        letter-spacing: -0.5px;
        color: #fff;
        margin-bottom: 0.5rem;
    }

    .breadcrumb-item a {
        color: var(--accent-color);
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .breadcrumb-item.active {
        color: #888;
    }

    .card {
        background: #1a1d2e;
        border: 1px solid var(--glass-border);
        border-radius: 20px;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.4);
        overflow: hidden;
        transition: transform 0.3s ease;
    }

    .card-body {
        padding: 2.5rem;
    }

    .card-title {
        font-size: 1.5rem;
        font-weight: 600;
        color: #fff;
        margin-bottom: 2rem;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .card-title i {
        background: var(--primary-gradient);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .form-group label {
        color: #aaa;
        font-weight: 500;
        margin-bottom: 0.8rem;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .form-control-static {
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid var(--glass-border);
        color: #fff;
        padding: 0.8rem 1.2rem;
        border-radius: 12px;
        font-weight: 600;
    }

    /* Custom Upload Zone */
    .upload-zone {
        border: 2px dashed var(--glass-border);
        border-radius: 20px;
        padding: 3rem 2rem;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
        background: rgba(255, 255, 255, 0.02);
        position: relative;
    }

    .upload-zone:hover {
        border-color: var(--accent-color);
        background: rgba(0, 210, 255, 0.05);
    }

    .upload-zone i {
        font-size: 3rem;
        color: var(--accent-color);
        margin-bottom: 1rem;
        display: block;
    }

    .upload-zone p {
        color: #ccc;
        margin-bottom: 0.5rem;
        font-size: 1.1rem;
    }

    .upload-zone span {
        color: #666;
        font-size: 0.85rem;
    }

    .imageUpload {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        cursor: pointer;
    }

    /* Current Image Preview */
    .current-image-wrapper {
        margin-top: 2rem;
        background: rgba(0, 0, 0, 0.2);
        padding: 1.5rem;
        border-radius: 15px;
        border: 1px solid var(--glass-border);
    }

    .preview-img {
        max-width: 100%;
        border-radius: 10px;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
        transition: transform 0.3s ease;
    }

    .preview-img:hover {
        transform: scale(1.02);
    }

    .btn-submit {
        background: var(--primary-gradient);
        border: none;
        padding: 1rem 2.5rem;
        border-radius: 12px;
        font-weight: 700;
        color: #fff;
        letter-spacing: 1px;
        box-shadow: 0 10px 20px rgba(37, 117, 252, 0.3);
        transition: all 0.3s ease;
        margin-top: 1rem;
    }

    .btn-submit:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 30px rgba(37, 117, 252, 0.4);
        color: #fff;
    }

    /* Modal Styling */
    .modal-content {
        background: #1a1d2e;
        border: 1px solid var(--glass-border);
        border-radius: 25px;
        color: #fff;
    }

    .modal-header {
        border-bottom: 1px solid var(--glass-border);
        padding: 1.5rem 2rem;
    }

    .modal-footer {
        border-top: 1px solid var(--glass-border);
        padding: 1.5rem 2rem;
    }

    .btn-close {
        filter: invert(1);
    }

    .img-container {
        padding: 1rem;
        max-height: 60vh;
        overflow: hidden;
    }

    .cropper-view-box,
    .cropper-face {
        border-radius: 10px;
    }

    .badge-type {
        background: var(--primary-gradient);
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        margin-left: 10px;
    }
</style>

<div class="content-wrapper">
    <div class="container-fluid">
        <div class="page-header mt-4">
            <div>
                <h3 class="page-title">Advertising Console</h3>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.ads.index') }}">Ads Management</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Refine Creative</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row justify-content-center mt-4">
            <div class="col-lg-10 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">
                            <i class="bi bi-image-fill"></i>
                            Ads Editor
                            <span class="badge-type">{{ $ads->type }} placement</span>
                        </h4>

                        @if(session('success'))
                            <div class="alert alert-success border-0 rounded-4 mb-4"
                                style="background: rgba(40, 167, 69, 0.1); color: #28a745;">
                                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                            </div>
                        @endif

                        <form action="{{ route('admin.ads.update', $ads->id) }}" method="POST" class="forms-sample"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row mb-4">
                                <div class="col-md-6 mb-4">
                                    <div class="form-group">
                                        <label>Target Country</label>
                                        <div class="form-control-static">
                                            <i class="bi bi-geo-alt-fill me-2 text-primary"></i>
                                            {{ $ads->country }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <div class="form-group">
                                        <label>Ad Destination Link</label>
                                        <input type="url" name="link" class="form-control" value="{{ $ads->link }}"
                                            placeholder="https://example.com"
                                            style="background: rgba(255, 255, 255, 0.03); border: 1px solid var(--glass-border); color: #fff; padding: 0.8rem 1.2rem; border-radius: 12px;">
                                    </div>
                                </div>
                            </div>

                            <input type="hidden" name="uploadtype" value="{{ $ads->type }}" id="uploadtype">
                            <input type="hidden" name="base64image" id="base64image">

                            <div class="form-group mb-5">
                                <label>Upload New Creative</label>
                                <div class="upload-zone" id="drop-zone">
                                    <i class="bi bi-cloud-arrow-up-fill"></i>
                                    <p>Select a new image or drag it here</p>
                                    <span>High quality JPEG, PNG or WebP supported</span>
                                    <input type="file" name="adsimg" class="imageUpload" id="imageInput">
                                </div>

                                @error('msg')
                                    <div class="mt-3 text-danger small"><i class="bi bi-exclamation-triangle-fill me-1"></i>
                                        {{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-7">
                                    @if($ads->ads_image != "")
                                        <div class="current-image-wrapper">
                                            <label class="d-block mb-3"
                                                style="color: #888; letter-spacing: 1px; font-size: 0.8rem; font-weight: 600;">ACTIVE
                                                CREATIVE</label>
                                            <img src="{{ asset(str_replace('public/', '', $ads->ads_image)) }}"
                                                class="preview-img" alt="Current Ad">
                                            <div class="mt-3 text-muted small">
                                                <i class="bi bi-info-circle me-1"></i> Original path: {{ $ads->ads_image }}
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-md-5 d-flex align-items-end justify-content-md-end mt-4">
                                    <button type="submit" class="btn btn-submit w-100">
                                        <i class="bi bi-rocket-takeoff-fill me-2"></i> Deploy Creative
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modernized Modal -->
<div class="modal fade" id="model" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title d-flex align-items-center">
                    <i class="bi bi-crop me-3 text-primary"></i>
                    Refine Artwork
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0 bg-black">
                <div class="img-container">
                    <img id="image" src="">
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <div>
                    <span class="text-muted small">
                        <i class="bi bi-info-circle me-1"></i>
                        Adjust the selection to fit the placement area
                    </span>
                </div>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-dark rounded-pill px-4"
                        data-bs-dismiss="modal">Discard</button>
                    <button type="button" class="btn btn-primary rounded-pill px-5 crop" id="crop">Apply
                        Selection</button>
                </div>
            </div>
        </div>
    </div>
</div>

@include('includes/admin-footer')

<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        var image = document.getElementById('image');
        var cropper;
        var $modalElement = document.getElementById('model');
        var bsModal = new bootstrap.Modal($modalElement);
        var input = document.getElementById('imageInput');

        // Handle File Selection
        input.addEventListener("change", function (e) {
            var files = e.target.files;
            if (files && files.length > 0) {
                var file = files[0];
                var reader = new FileReader();
                reader.onload = function (e) {
                    image.src = e.target.result;
                    bsModal.show();
                };
                reader.readAsDataURL(file);
            }
        });

        // Initialize Cropper when modal opens
        $modalElement.addEventListener('shown.bs.modal', function () {
            var uploadtype = document.getElementById("uploadtype").value;
            var aspect_ratio = 1 / 1;

            if (uploadtype && uploadtype.toLowerCase() == "mid") {
                aspect_ratio = 1074 / 400;
            } else if (uploadtype && uploadtype.toLowerCase() == "side") {
                aspect_ratio = 1 / 1;
            }

            cropper = new Cropper(image, {
                aspectRatio: aspect_ratio,
                viewMode: 2,
                dragMode: 'move',
                autoCropArea: 0.9,
                restore: false,
                guides: true,
                center: true,
                highlight: false,
                cropBoxMovable: true,
                cropBoxResizable: true,
                toggleDragModeOnDblclick: false,
                checkCrossOrigin: false,
            });
        });

        // Clean up Cropper when modal closes
        $modalElement.addEventListener('hidden.bs.modal', function () {
            if (cropper) {
                cropper.destroy();
                cropper = null;
            }
        });

        // Handle Cropping
        document.getElementById("crop").addEventListener("click", function () {
            var uploadtype = document.getElementById("uploadtype").value;
            var canvas;
            var options = {
                imageSmoothingEnabled: true,
                imageSmoothingQuality: 'high',
            };

            if (uploadtype && uploadtype.toLowerCase() == "side") {
                canvas = cropper.getCroppedCanvas({ width: 400, height: 400, ...options });
            } else if (uploadtype && uploadtype.toLowerCase() == "mid") {
                canvas = cropper.getCroppedCanvas({ width: 1074, height: 400, ...options });
            } else {
                canvas = cropper.getCroppedCanvas({ width: 400, height: 400, ...options });
            }

            if (canvas) {
                canvas.toBlob(function (blob) {
                    var reader = new FileReader();
                    reader.readAsDataURL(blob);
                    reader.onloadend = function () {
                        var base64data = reader.result;
                        document.getElementById('base64image').value = base64data;
                        bsModal.hide();

                        // Optional: Show a small "Cropped Successfully" indicator
                        Swal.fire({
                            icon: 'success',
                            title: 'Selection Applied',
                            text: 'Your creative has been cropped and is ready for deployment.',
                            timer: 2000,
                            showConfirmButton: false,
                            background: '#1a1d2e',
                            color: '#fff'
                        });
                    }
                }, 'image/jpeg', 0.9);
            }
        });
    });
</script>