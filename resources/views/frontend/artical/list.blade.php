@include('includes/inner-header')

<div class="mid_body">
    <div class="container">
        <div class="full_midpan">
            <div class="row artilist">
                <div class="col-lg-8 col-md-8 col-sm-12">
                    <div class="left_searchresults">
                        <h3><img src="{{ asset('assets/images/article_icon2.png') }}" alt=""> Articles <br>
                            <span>
                                <a href="{{ url('/') }}" style="color: #729b0f; text-decoration: none;">Home</a> > 
                                @if(isset($category))
                                    <a href="{{ route('article.list') }}" style="color: #729b0f; text-decoration: none;">Articles</a> > {{ $category->title }}
                                @else
                                    Articles
                                @endif
                            </span> 
                            <a href="{{ route('article.add') }}" class="submit_ariclebut">Submit Article</a>
                        </h3>
                        <h4>
                            @if(request('search'))
                                Search Results for "{{ request('search') }}"
                            @elseif(isset($category))
                                {{ $category->title }}
                            @else
                                Latest Articles
                            @endif
                        </h4>
                        @if(isset($category) && $category->description)
                            <p style="color: #666; margin-bottom: 15px; font-size: 15px;">{{ $category->description }}</p>
                        @endif

                        @forelse($articles as $article)
                            <div class="search_restspan article_listpan">
                                <div class="row">
                                    @if($article->image)
                                    <div class="col-lg-4 col-md-4 col-sm-12 search_lftthum">
                                        <img src="{{ asset($article->image) }}" alt="{{ $article->title }}">
                                    </div>
                                    @endif
                                    <div class="{{ $article->image ? 'col-lg-8 col-md-8' : 'col-lg-12 col-md-12' }} col-sm-12 results_rightdtls">
                                        <h4>{{ $article->title }}</h4>
                                        <div class="startbus_txt">
                                            <img src="{{ asset('assets/images/starting_busicin.png') }}" alt="">
                                            <a href="{{ route('article.category', $article->category->slug) }}">{{ $article->category->title }}</a>
                                        </div>
                                        <div class="mobweb_txt">
                                            <ul>
                                                <li class="user"><img src="{{ asset('assets/images/user_icon.png') }}" alt=""> <a href="{{ url($country_name.'/profile/'.Crypt::encryptString($article->user->id)) }}">{{ $article->user->name }}</a></li>
                                                <li><img src="{{ asset('assets/images/time_icon.png') }}" alt=""> {{ $article->published_at->format('d/m/y h:ia') }}</li>
                                                <li><img src="{{ asset('assets/images/view_icon.png') }}" alt=""> {{ $article->views }} views</li>
                                            </ul>
                                        </div>
                                        <p>{{ Str::limit(strip_tags($article->content), 180) }}</p>
                                        <a href="{{ route('article.details', $article->slug) }}" class="article_readmorebut">Read More</a>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="alert alert-info">No articles found.</div>
                        @endforelse

                        <div class="mt-4">
                            {{ $articles->appends(request()->query())->links() }}
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-4 col-sm-12">
                    <div class="article_search">
                        <form action="{{ route('article.list') }}" method="get">
                            <input name="search" type="text" placeholder="Quick Article Search" value="{{ request('search') }}">
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
                        <div class="mb-4 mt-3 deskaddlist">
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
 @foreach($sideData as $ad)
                        <div class="mb-4 mt-3 mobaddlist">
                            @if($ad->link)
                                <a href="{{ $ad->link }}" target="_blank">
                                    <img src="{{ asset($ad->ads_image) }}" class="img-fluid rounded shadow-sm w-100" alt="Ad">
                                </a>
                            @else
                                <img src="{{ asset($ad->ads_image) }}" class="img-fluid rounded shadow-sm w-100" alt="Ad">
                            @endif
                        </div>
                    @endforeach
<script>
document.addEventListener("DOMContentLoaded", function() {
  const section = document.querySelector(".rgt_articlelist");
  const heading = section.querySelector("h3");

  heading.addEventListener("click", function() {
    section.classList.toggle("active");
  });
});
</script>
@include('includes/footer')
