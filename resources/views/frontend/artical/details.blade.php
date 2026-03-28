@include('includes/inner-header')

<div class="mid_body">
    <div class="container">
        <div class="full_midpan">
            <div class="row">
                <div class="col-lg-8 col-md-8 col-sm-12">
                    <div class="left_searchresults">
                        <h3><img src="{{ asset('assets/images/article_icon2.png') }}" alt=""> Articles <br>
                            <span><a href="{{ url('/') }}" style="color: #729b0f; text-decoration: none;">Home</a> > <a href="{{ route('article.list') }}" style="color: #729b0f; text-decoration: none;">Articles</a> > <a href="{{ route('article.category', $article->category->slug) }}" style="color: #729b0f; text-decoration: none;">{{ $article->category->title }}</a> </span> 
                        </h3>
                        
                        <div class="article_detailsbody">
                            @if($article->image)
                                <img src="{{ asset($article->image) }}" class="img-fluid rounded mb-4 w-100" alt="{{ $article->title }}">
                            @endif

                            <h2>{{ $article->title }}</h2>
                            
                            <div class="article-content" style="font-size: 14px; line-height: 1.8; color: #404041;">
                                {!! $article->content !!}
                            </div>

                            <div class="contribute_article">
                                <h3>Contributed by:</h3>
                                <a href="{{ url($country_name.'/profile/'.Crypt::encryptString($article->user->id)) }}">
                                    <img src="{{ $article->user->profile_image }}" alt="Profile" style="width: 50px; height: 50px; border-radius: 50%;">
                                </a>
                                <h4><a href="{{ url($country_name.'/profile/'.Crypt::encryptString($article->user->id)) }}">{{ $article->user->name }}</a></h4>
                                <p><strong>Posted: </strong> {{ $article->published_at->format('d/m/y h:ia') }}</p>
                            </div>

                            <div class="article-meta-info" style="font-size: 13px; color: #888; padding: 8px 0; margin-bottom: 10px; border-bottom: 1px solid #eee;">
                                ✨ {{ $article->views ?? 0 }} views &nbsp; | &nbsp; 💬 {{ $article->comments->where('status', 1)->count() }} comments &nbsp; | &nbsp; Posted {{ $article->published_at->format('d/m/y') }}
                            </div>

                            <div class="msg_inbox aticle_commentbox">
                                <div class="sortby">
                                    <h3>{{ $article->comments->where('status', 1)->count() }} Comments</h3> 
                                    <span>
                                        <label>Sort by</label> 
                                        <select name="comment_sort" id="commentSort">
                                            <option value="newest" selected>Newest</option>
                                            <option value="oldest">Oldest</option>
                                        </select>
                                    </span>
                                </div>

                                @auth
                                    <div class="msg_incontent mb-4">
                                        <form action="{{ route('article.comment', $article->id) }}" method="POST">
                                            @csrf
                                            <textarea name="content" cols="" rows="3" placeholder="Add a Comment........" required></textarea>
                                            <button type="submit" class="btn btn-primary mt-2">Post Comment</button>
                                        </form>
                                    </div>
                                @else
                                    <p class="mb-4">Please <a href="{{ route('login') }}">login</a> to post a comment.</p>
                                @endauth

                                <div id="commentsContainer">
                                    @foreach($article->comments->where('status', 1)->sortByDesc('created_at') as $comment)
                                        <div class="comment-item mb-3 p-3 border-bottom" data-timestamp="{{ $comment->created_at->timestamp }}">
                                            <div class="d-flex align-items-center mb-2">
                                                <img src="{{ $comment->user->profile_image }}" alt="User" style="width: 30px; height: 30px; border-radius: 50%; margin-right: 10px;">
                                                <strong style="color: #729b0f;">{{ $comment->user->name }}</strong>
                                                <span class="text-muted ml-2 small">{{ $comment->created_at->diffForHumans() }}</span>
                                            </div>
                                            <p style="font-size: 13px;">{{ $comment->content }}</p>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-4 col-sm-12">
                    <div class="article_search">
                        <form action="{{ route('article.list') }}" method="get">
                            <input name="search" type="text" placeholder="Quick Article Search">
                            <input name="" type="submit" value="">
                        </form>
                    </div>
                    <div class="rgt_articlelist">
                        <h3>Articles By Category</h3>
                        <ul>
                            @foreach($categories as $category_item)
                                <li>
                                    <a href="{{ route('article.category', $category_item->slug) }}">{{ $category_item->title }} <span>({{ $category_item->articles()->published()->count() }})</span></a>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    @foreach($sideData as $ad)
                        <div class="mb-4 mt-3">
                            @if($ad->link)
                                <a href="{{ $ad->link }}" target="_blank">
                                    <img src="{{ asset($ad->ads_image) }}" class="img-fluid rounded shadow-sm w-100" alt="Ad">
                                </a>
                            @else
                                <img src="{{ asset($ad->ads_image) }}" class="img-fluid rounded shadow-sm w-100" alt="Ad">
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Comment sorting functionality
    document.addEventListener('DOMContentLoaded', function() {
        const sortSelect = document.getElementById('commentSort');
        const commentsContainer = document.getElementById('commentsContainer');
        
        if (sortSelect && commentsContainer) {
            sortSelect.addEventListener('change', function() {
                const sortOrder = this.value;
                const comments = Array.from(commentsContainer.querySelectorAll('.comment-item'));
                
                // Sort comments based on timestamp
                comments.sort((a, b) => {
                    const timestampA = parseInt(a.getAttribute('data-timestamp'));
                    const timestampB = parseInt(b.getAttribute('data-timestamp'));
                    
                    if (sortOrder === 'newest') {
                        return timestampB - timestampA; // Descending (newest first)
                    } else {
                        return timestampA - timestampB; // Ascending (oldest first)
                    }
                });
                
                // Clear container and re-append sorted comments
                commentsContainer.innerHTML = '';
                comments.forEach(comment => {
                    commentsContainer.appendChild(comment);
                });
            });
        }
    });
</script>

@include('includes/footer')
