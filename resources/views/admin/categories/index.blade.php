@include('includes/admin-header')
@include('includes/admin-sidebar')
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">Categories Management</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Categories</li>
            </ol>
        </nav>
    </div>
    
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="card-title">Categories List</h4>
                        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
                            <i class="mdi mdi-plus"></i> Add New Category
                        </a>
                    </div>
                    
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    
                    <div class="table-responsive">
                        <table id="categoryTable" class="table table-light">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Icon</th>
                                    <th>Title</th>
                                    <th>URL Slug</th>
                                    <th>Parent Category</th>
                                    <th>Views</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php 
                                    $i = 0; 
                                    $mainCategories = $categories->where('parent_id', 0);
                                @endphp

                                @foreach($mainCategories as $category)
                                    @php
                                        // Calculate sum of all secondary category views
                                        $totalSecondaryViews = $category->children->sum('views');
                                        $displayViews = $totalSecondaryViews > 0 ? $totalSecondaryViews : $category->views;
                                    @endphp
                                    <tr class="category-row main-category" data-category-id="{{ $category->id }}">
                                        <td>{{ $category->id }}</td>
                                        <td>
                                            @if($category->icon)
                                                <img src="{{ asset('assets/images/' . $category->icon) }}" 
                                                     alt="{{ $category->title }}" 
                                                     style="width: 40px; height: 40px; object-fit: cover; border-radius: 4px;">
                                            @else
                                                <span class="text-muted">No Icon</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="d-flex align-items-center">
                                                @if($category->children->count() > 0)
                                                    <i class="mdi mdi-chevron-right dropdown-icon me-2"></i>
                                                @endif
                                                {{ $category->title }}
                                                @if($category->children->count() > 0)
                                                    <span class="badge bg-secondary ms-2">{{ $category->children->count() }}</span>
                                                @endif
                                            </span>
                                        </td>
                                        <td>{{ $category->title_url }}</td>
                                        <td>
                                            <span class="badge bg-primary">Main Category</span>
                                        </td>
                                        <td>
                                            <strong>{{ number_format($displayViews) }}</strong>
                                            
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.categories.edit', $category->id) }}" 
                                               class="btn btn-sm btn-warning">Edit</a>
                                            <form action="{{ route('admin.categories.destroy', $category->id) }}" 
                                                  method="POST" 
                                                  style="display: inline-block;" 
                                                  onsubmit="return confirm('Are you sure you want to delete this category?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                            </form>
                                        </td>
                                    </tr>

                                    @foreach($category->children as $subcategory)
                                        <tr class="subcategory-row" data-parent-id="{{ $category->id }}">
                                            <td>{{ $subcategory->id }}</td>
                                            <td>
                                                @if($subcategory->icon)
                                                    <img src="{{ asset('assets/images/' . $subcategory->icon) }}" 
                                                         alt="{{ $subcategory->title }}" 
                                                         style="width: 40px; height: 40px; object-fit: cover; border-radius: 4px;">
                                                @else
                                                    <span class="text-muted">No Icon</span>
                                                @endif
                                            </td>
                                            <td class="subcategory-indent">
                                                <span class="text-muted">└──</span> {{ $subcategory->title }}
                                            </td>
                                            <td>{{ $subcategory->title_url }}</td>
                                            <td>{{ $category->title }}</td>
                                            <td>{{ number_format($subcategory->views) }}</td>
                                            <td>
                                                <a href="{{ route('admin.categories.edit', $subcategory->id) }}" 
                                                   class="btn btn-sm btn-warning">Edit</a>
                                                <form action="{{ route('admin.categories.destroy', $subcategory->id) }}" 
                                                      method="POST" 
                                                      style="display: inline-block;" 
                                                      onsubmit="return confirm('Are you sure you want to delete this category?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endforeach

                                @if($mainCategories->isEmpty())
                                    <tr>
                                        <td colspan="7" class="text-center">No categories found</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('includes/admin-footer')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const categoryRows = document.querySelectorAll('.category-row.main-category');
    
    categoryRows.forEach(row => {
        row.addEventListener('click', function(e) {
            // Prevent click if clicking on action buttons
            if (e.target.closest('.btn') || e.target.closest('form')) {
                return;
            }
            
            const categoryId = this.dataset.categoryId;
            const subcategoryRows = document.querySelectorAll(`[data-parent-id="${categoryId}"]`);
            const dropdownIcon = this.querySelector('.dropdown-icon');
            
            // Check if current category is already open
            const isCurrentlyOpen = subcategoryRows.length > 0 && subcategoryRows[0].classList.contains('show');
            
            // Close all other open categories
            document.querySelectorAll('.subcategory-row.show').forEach(subRow => {
                subRow.classList.remove('show');
            });
            
            // Reset all dropdown icons
            document.querySelectorAll('.dropdown-icon').forEach(icon => {
                icon.classList.remove('rotated');
            });
            
            // If current category wasn't open, open it
            if (!isCurrentlyOpen && subcategoryRows.length > 0) {
                subcategoryRows.forEach(subRow => {
                    subRow.classList.add('show');
                });
                
                if (dropdownIcon) {
                    dropdownIcon.classList.add('rotated');
                }
            }
        });
    });
});
  $('#categoryTable').DataTable({
    "paging": true,         // Enable pagination
    "searching": true,      // Enable search box
    "ordering": false,       // Enable sorting
    "info": true,           // Show table info
    "lengthMenu": [10, 100, 500, 1000],  // Add 500 as an option
    "pageLength": 500,      // Default show 500 rows on first load
    "language": {
        "search": "Search Users:",
        "lengthMenu": "Show _MENU_ entries",
        "info": "Showing _START_ to _END_ of _TOTAL_ users"
    }
});
</script>

<style>
.category-row {
    cursor: pointer;
    transition: background-color 0.2s ease;
}

.category-row:hover {
    background-color: #f8f9fa;
}

.subcategory-row {
    background-color: #f8f9fa;
    display: none;
    animation: slideDown 0.3s ease-out;
}

.subcategory-row.show {
    display: table-row;
}

.subcategory-indent {
    padding-left: 30px;
}

.dropdown-icon {
    transition: transform 0.3s ease;
}

.dropdown-icon.rotated {
    transform: rotate(90deg);
}

.main-category {
    font-weight: 600;
}

@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>