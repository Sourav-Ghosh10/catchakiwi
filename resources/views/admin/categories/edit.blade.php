@include('includes/admin-header')
@include('includes/admin-sidebar')
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">Edit Category</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.categories.index') }}">Categories</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit {{ $category->title }}</li>
            </ol>
        </nav>
    </div>
    
    <div class="row">
        <div class="col-md-8 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Edit Category Details</h4>
                    
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="form-group">
                            <label for="title">Category Title *</label>
                            <input type="text" 
                                   class="form-control" 
                                   id="title" 
                                   name="title" 
                                   value="{{ old('title', $category->title) }}" 
                                   required>
                        </div>
                        
                        <div class="form-group">
                            <label for="parent_id">Parent Category *</label>
                            <select class="form-control" id="parent_id" name="parent_id" required>
                                <option value="0" {{ old('parent_id', $category->parent_id) == '0' ? 'selected' : '' }}>
                                    Main Category (No Parent)
                                </option>
                                @foreach($parentCategories as $parent)
                                    <option value="{{ $parent->id }}" {{ old('parent_id', $category->parent_id) == $parent->id ? 'selected' : '' }}>
                                        {{ $parent->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="icon">Category Icon</label>
                            @if($category->icon)
                                <div class="mb-2">
                                    <img src="{{ asset('assets/images/' . $category->icon) }}" 
                                         alt="{{ $category->title }}" 
                                         style="width: 60px; height: 60px; object-fit: cover; border-radius: 4px;">
                                    <small class="text-muted d-block">Current icon</small>
                                </div>
                            @endif
                            <input type="file" 
                                   class="form-control" 
                                   id="icon" 
                                   name="icon" 
                                   accept="image/*">
                            <small class="form-text text-muted">Upload a new icon to replace the current one (optional)</small>
                        </div>
                        
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Update Category</button>
                            <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Category Information</h5>
                    <ul class="list-unstyled">
                        <li><strong>Created:</strong> {{ $category->created_on ? \Carbon\Carbon::parse($category->created_on)->format('M d, Y H:i') : 'N/A' }}</li>
                        <li><strong>Modified:</strong> {{ $category->modified_on ? \Carbon\Carbon::parse($category->modified_on)->format('M d, Y H:i') : 'N/A' }}</li>
                        <li>
                            <strong>Views:</strong> 
                            @if($category->parent_id == 0 && $category->children->count() > 0)
                                @php
                                    $totalSecondaryViews = $category->children->sum('views');
                                    $displayViews = $totalSecondaryViews > 0 ? $totalSecondaryViews : $category->views;
                                @endphp
                                {{ number_format($displayViews) }}
                                
                            @else
                                {{ number_format($category->views) }}
                            @endif
                        </li>
                        <li><strong>Type:</strong> {{ $category->parent_id == 0 ? 'Main Category' : 'Subcategory' }}</li>
                        @if($category->children->count() > 0)
                            <li><strong>Subcategories:</strong> {{ $category->children->count() }}</li>
                        @endif
                    </ul>
                    
                    @if($category->children->count() > 0)
                        <div class="mt-3">
                            <h6>Subcategories:</h6>
                            <ul class="list-unstyled">
                                @foreach($category->children as $child)
                                    <li>• {{ $child->title }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@include('includes/admin-footer')