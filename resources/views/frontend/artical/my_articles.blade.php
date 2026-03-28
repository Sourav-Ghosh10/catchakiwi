@include('includes/inner-header')

<div class="mid_body">
    <div class="container">
        <div class="full_midpan">
            <div class="row">
                <div class="col-lg-12">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h2 class="mb-0">My Articles</h2>
                        <a href="{{ route('article.add') }}" class="btn btn-primary">Submit New Article</a>
                    </div>

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Status</th>
                                <th>Views</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($articles as $key => $article)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>
                                        @if($article->status == 'published')
                                            <a href="{{ route('article.details', $article->slug) }}">{{ $article->title }}</a>
                                        @else
                                            {{ $article->title }}
                                        @endif
                                    </td>
                                    <td>{{ $article->category->title }}</td>
                                    <td>
                                        @if($article->status == 'published')
                                            <span class="badge bg-success text-white">Published</span>
                                        @elseif($article->status == 'pending')
                                            <span class="badge bg-warning text-dark">Pending</span>
                                        @else
                                            <span class="badge bg-danger text-white">Hidden</span>
                                        @endif
                                    </td>
                                    <td><strong>{{ $article->views }}</strong></td>
                                    <td>{{ $article->created_at->format('M d, Y') }}</td>
                                    <td>
                                        <a href="{{ route('article.user-edit', $article->id) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">You haven't submitted any articles yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('includes/footer')
