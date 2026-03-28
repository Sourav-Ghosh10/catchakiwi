@include('includes/admin-header')
@include('includes/admin-sidebar')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Article Categories</h4>
                        <div class="table-responsive">
                            <table class="table table-dark">
                                <thead>
                                    <tr>
                                        <th> # </th>
                                        <th> Title </th>
                                        <th> Description </th>
                                        <th> Slug </th>
                                        <th> Actions </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($categories as $key => $category)
                                    <tr>
                                        <td> {{ $key + 1 }} </td>
                                        <td> {{ $category->title }} </td>
                                        <td> {{ Str::limit($category->description, 50) }} </td>
                                        <td> {{ $category->slug }} </td>
                                        <td>
                                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editModal{{$category->id}}">Edit</button>
                                            <form action="{{ route('admin.article-categories.destroy', $category->id) }}" method="POST" style="display:inline-block;">
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
                            <h5 class="modal-title">Edit Category</h5>
                            <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="{{ route('admin.article-categories.update', $category->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="modal-body">
                                <div class="form-group">
                                    <label>Category Title</label>
                                    <input type="text" name="title" class="form-control" value="{{ $category->title }}" required style="color: #000;">
                                </div>
                                <div class="form-group">
                                    <label>Category Description (Optional)</label>
                                    <input type="text" name="description" class="form-control" value="{{ $category->description }}" placeholder="Enter category description" style="color: #000;">
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

            <div class="col-lg-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Add New Category</h4>
                        <form class="forms-sample" action="{{ route('admin.article-categories.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="title">Category Title</label>
                                <input type="text" class="form-control" id="title" name="title" placeholder="Enter category title" required style="color: #000;">
                            </div>
                            <div class="form-group">
                                <label for="description">Category Description (Optional)</label>
                                <input type="text" class="form-control" id="description" name="description" placeholder="Enter category description" style="color: #000;">
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
