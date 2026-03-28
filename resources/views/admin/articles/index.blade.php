@include('includes/admin-header')
@include('includes/admin-sidebar')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Articles</h4>
                        <div class="table-responsive">
                            <table class="table table-dark">
                                <thead>
                                    <tr>
                                        <th> # </th>
                                        <th> 
                                            <a href="{{ route('admin.articles.index', ['sort' => 'title', 'order' => ($sortBy == 'title' && $sortOrder == 'asc') ? 'desc' : 'asc']) }}" class="text-white">
                                                Title 
                                                @if($sortBy == 'title')
                                                    <i class="mdi mdi-arrow-{{ $sortOrder == 'asc' ? 'up' : 'down' }}"></i>
                                                @endif
                                            </a>
                                        </th>
                                        <th> 
                                            <a href="{{ route('admin.articles.index', ['sort' => 'writer', 'order' => ($sortBy == 'writer' && $sortOrder == 'asc') ? 'desc' : 'asc']) }}" class="text-white">
                                                Writer
                                                @if($sortBy == 'writer')
                                                    <i class="mdi mdi-arrow-{{ $sortOrder == 'asc' ? 'up' : 'down' }}"></i>
                                                @endif
                                            </a>
                                        </th>
                                        <th> 
                                            <a href="{{ route('admin.articles.index', ['sort' => 'category', 'order' => ($sortBy == 'category' && $sortOrder == 'asc') ? 'desc' : 'asc']) }}" class="text-white">
                                                Category
                                                @if($sortBy == 'category')
                                                    <i class="mdi mdi-arrow-{{ $sortOrder == 'asc' ? 'up' : 'down' }}"></i>
                                                @endif
                                            </a>
                                        </th>
                                        <th> 
                                            <a href="{{ route('admin.articles.index', ['sort' => 'status', 'order' => ($sortBy == 'status' && $sortOrder == 'asc') ? 'desc' : 'asc']) }}" class="text-white">
                                                Status
                                                @if($sortBy == 'status')
                                                    <i class="mdi mdi-arrow-{{ $sortOrder == 'asc' ? 'up' : 'down' }}"></i>
                                                @endif
                                            </a>
                                        </th>
                                        <th> 
                                            <a href="{{ route('admin.articles.index', ['sort' => 'views', 'order' => ($sortBy == 'views' && $sortOrder == 'asc') ? 'desc' : 'asc']) }}" class="text-white">
                                                Views
                                                @if($sortBy == 'views')
                                                    <i class="mdi mdi-arrow-{{ $sortOrder == 'asc' ? 'up' : 'down' }}"></i>
                                                @endif
                                            </a>
                                        </th>
                                        <th> 
                                            <a href="{{ route('admin.articles.index', ['sort' => 'published_at', 'order' => ($sortBy == 'published_at' && $sortOrder == 'asc') ? 'desc' : 'asc']) }}" class="text-white">
                                                Published At
                                                @if($sortBy == 'published_at')
                                                    <i class="mdi mdi-arrow-{{ $sortOrder == 'asc' ? 'up' : 'down' }}"></i>
                                                @endif
                                            </a>
                                        </th>
                                        <th> Actions </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($articles as $key => $article)
                                    <tr>
                                        <td> {{ $key + 1 }} </td>
                                        <td> {{ $article->title }} </td>
                                        <td> {{ $article->user->name }} </td>
                                        <td> {{ $article->category->title }} </td>
                                        <td>
                                            @if($article->status == 'published')
                                                <span class="badge badge-success">Published</span>
                                            @elseif($article->status == 'pending')
                                                <span class="badge badge-warning">Pending</span>
                                            @else
                                                <span class="badge badge-danger">Hidden</span>
                                            @endif
                                        </td>
                                        <td> {{ $article->views }} </td>
                                        <td> {{ $article->published_at ? $article->published_at->format('d M Y') : 'N/A' }} </td>
                                        <td>
                                            <a href="{{ route('admin.articles.edit', $article->id) }}" class="btn btn-primary btn-sm">Edit</a>
                                            @if($article->status != 'published')
                                                <a href="{{ route('admin.articles.status', [$article->id, 'published']) }}" class="btn btn-success btn-sm">Publish</a>
                                            @endif
                                            @if($article->status != 'hidden')
                                                <a href="{{ route('admin.articles.status', [$article->id, 'hidden']) }}" class="btn btn-danger btn-sm">Hide</a>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('includes/admin-footer')
