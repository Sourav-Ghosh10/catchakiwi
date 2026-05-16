@include('includes/admin-header')
@include('includes/admin-sidebar')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-8 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Notice Categories</h4>
                        <div class="table-responsive">
                            <table class="table table-dark">
                                <thead>
                                    <tr>
                                        <th> # </th>
                                        <th> Icon </th>
                                        <th> Category </th>
                                        <th> Subtitle </th>
                                        <th> Status </th>
                                        <th> Actions </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($categories as $key => $category)
                                    <tr>
                                        <td> {{ $key + 1 }} </td>
                                        <td>
                                            @if($category->icon)
                                                <img src="{{ asset($category->icon) }}" alt="" style="width: 30px; height: 30px; border-radius: 4px;">
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td> {{ $category->category }} </td>
                                        <td> {{ Str::limit($category->subtitle, 30) }} </td>
                                        <td>
                                            @if($category->is_active)
                                                <span class="badge badge-success">Active</span>
                                            @else
                                                <span class="badge badge-danger">Inactive</span>
                                            @endif
                                            @if($category->is_new)
                                                <span class="badge badge-info">New</span>
                                            @endif
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editModal{{$category->id}}">Edit</button>
                                            <form action="{{ route('admin.notice-categories.destroy', $category->id) }}" method="POST" style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            
            @foreach($categories as $category)
            <!-- Edit Modal -->
            <div class="modal fade" id="editModal{{$category->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content bg-dark text-white">
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Notice Category</h5>
                            <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="{{ route('admin.notice-categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="modal-body">
                                <div class="form-group">
                                    <label>Category Title</label>
                                    <input type="text" name="category" class="form-control" value="{{ $category->category }}" required style="color: #fff; background: #2A3038;">
                                </div>
                                <div class="form-group">
                                    <label>Subtitle</label>
                                    <input type="text" name="subtitle" class="form-control" value="{{ $category->subtitle }}" style="color: #fff; background: #2A3038;">
                                </div>
                                <div class="form-group">
                                    <label>Theme Color (e.g. #f0f9eb)</label>
                                    <input type="text" name="color" class="form-control" value="{{ $category->color }}" style="color: #fff; background: #2A3038;">
                                </div>
                                <div class="form-group">
                                    <label>Type (e.g. deals, jobs, sales)</label>
                                    <input type="text" name="type" class="form-control" value="{{ $category->type }}" style="color: #fff; background: #2A3038;">
                                </div>
                                <div class="form-group">
                                    <label>Category Icon</label>
                                    <input type="file" name="icon" class="form-control" style="color: #fff; background: #2A3038;">
                                    @if($category->icon)
                                        <small class="text-muted">Current: <img src="{{ asset($category->icon) }}" width="20"></small>
                                    @endif
                                </div>
                                <div class="form-check form-check-flat form-check-primary">
                                    <label class="form-check-label">
                                        <input type="checkbox" name="is_active" class="form-check-input" {{ $category->is_active ? 'checked' : '' }}> Is Active <i class="input-helper"></i></label>
                                </div>
                                <div class="form-check form-check-flat form-check-info">
                                    <label class="form-check-label">
                                        <input type="checkbox" name="is_new" class="form-check-input" {{ $category->is_new ? 'checked' : '' }}> Is New Badge <i class="input-helper"></i></label>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach

            <div class="col-lg-4 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Add New Notice Category</h4>
                        <form class="forms-sample" action="{{ route('admin.notice-categories.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="category">Category Title</label>
                                <input type="text" class="form-control" id="category" name="category" placeholder="Enter category title" required style="color: #fff; background: #2A3038;">
                            </div>
                            <div class="form-group">
                                <label for="subtitle">Subtitle</label>
                                <input type="text" class="form-control" id="subtitle" name="subtitle" placeholder="Enter subtitle" style="color: #fff; background: #2A3038;">
                            </div>
                            <div class="form-group">
                                <label for="color">Theme Color</label>
                                <input type="text" class="form-control" id="color" name="color" placeholder="#f0f9eb" style="color: #fff; background: #2A3038;">
                            </div>
                            <div class="form-group">
                                <label for="type">Type</label>
                                <input type="text" class="form-control" id="type" name="type" placeholder="e.g. deals" style="color: #fff; background: #2A3038;">
                            </div>
                            <div class="form-group">
                                <label for="icon">Category Icon</label>
                                <input type="file" class="form-control" id="icon" name="icon" style="color: #fff; background: #2A3038;">
                            </div>
                            <div class="form-check form-check-flat form-check-primary">
                                <label class="form-check-label">
                                    <input type="checkbox" name="is_active" class="form-check-input" checked> Is Active <i class="input-helper"></i></label>
                            </div>
                            <div class="form-check form-check-flat form-check-info">
                                <label class="form-check-label">
                                    <input type="checkbox" name="is_new" class="form-check-input"> Is New Badge <i class="input-helper"></i></label>
                            </div>
                            <button type="submit" class="btn btn-primary mr-2">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('includes/admin-footer')
