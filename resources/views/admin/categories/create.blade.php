@include('includes/admin-header')
@include('includes/admin-sidebar')
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">Add New Category</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.categories.index') }}">Categories</a></li>
                <li class="breadcrumb-item active" aria-current="page">Add Category</li>
            </ol>
        </nav>
    </div>
    
    <div class="row">
        <div class="col-md-8 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Category Details</h4>
                    
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="form-group">
                            <label for="title">Category Title *</label>
                            <input type="text" 
                                   class="form-control" 
                                   id="title" 
                                   name="title" 
                                   value="{{ old('title') }}" 
                                   required>
                        </div>
                        
                        <div class="form-group">
                            <label for="parent_id">Parent Category *</label>
                            <select class="form-control" id="parent_id" name="parent_id" required>
                                <option value="0" {{ old('parent_id') == '0' ? 'selected' : '' }}>Main Category (No Parent)</option>
                                @foreach($parentCategories as $parent)
                                    <option value="{{ $parent->id }}" {{ old('parent_id') == $parent->id ? 'selected' : '' }}>
                                        {{ $parent->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="icon">Category Icon</label>
                            <input type="file" 
                                   class="form-control" 
                                   id="icon" 
                                   name="icon" 
                                   accept="image/*">
                            <small class="form-text text-muted">Upload an icon for this category (optional)</small>
                        </div>
                        
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Create Category</button>
                            <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Instructions</h5>
                    <ul class="list-unstyled">
                        <li><strong>Title:</strong> Enter a descriptive category name</li>
                        <li><strong>Parent Category:</strong> Select "Main Category" for top-level categories, or choose a parent for subcategories</li>
                        <li><strong>Icon:</strong> Upload a small image (recommended: 64x64px or smaller)</li>
                    </ul>
                    
                    <div class="mt-3">
                        <h6>Supported Image Formats:</h6>
                        <small class="text-muted">JPEG, PNG, JPG, GIF (Max: 2MB)</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('includes/admin-footer')