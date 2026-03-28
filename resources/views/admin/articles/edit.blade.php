@include('includes/admin-header')
@include('includes/admin-sidebar')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/quill/1.3.7/quill.snow.min.css" />
<style>
    #editor { min-height: 300px; background: #fff; color: #000; border-radius: 0 0 5px 5px; }
    .ql-toolbar { border-radius: 5px 5px 0 0; background: #f8f9fa; }
    .ql-container.ql-snow { border: 1px solid #ced4da; }
</style>
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Edit Article</h4>
                        <form class="forms-sample" action="{{ route('admin.articles.update', $article->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" class="form-control" id="title" name="title" value="{{ $article->title }}" required style="color: #000;">
                            </div>
                            <div class="form-group">
                                <label for="category_id">Category</label>
                                <select class="form-control" id="category_id" name="category_id" required style="color: #000;">
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ $article->category_id == $category->id ? 'selected' : '' }}>{{ $category->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select class="form-control" id="status" name="status" required style="color: #000;">
                                    <option value="pending" {{ $article->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="published" {{ $article->status == 'published' ? 'selected' : '' }}>Published</option>
                                    <option value="hidden" {{ $article->status == 'hidden' ? 'selected' : '' }}>Hidden</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="content">Content</label>
                                <div id="editor">{!! old('content', $article->content) !!}</div>
                                <input type="hidden" name="content" id="content_input">
                            </div>
                            <button type="submit" class="btn btn-primary mr-2">Update</button>
                            <a href="{{ route('admin.articles.index') }}" class="btn btn-dark">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('includes/admin-footer')
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

        var form = document.querySelector('form.forms-sample');
        form.onsubmit = function() {
            var content = document.querySelector('#content_input');
            content.value = quill.root.innerHTML;
            
            if (quill.getText().trim().length === 0 && quill.root.innerHTML.indexOf('<img') === -1) {
                alert('Please enter some content for your article.');
                return false;
            }
        };
    });
</script>
