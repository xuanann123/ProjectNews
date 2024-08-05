<aside class="col-lg-4 sidebar-home">
    <!-- Search -->
    <div class="widget">
        <h4 class="widget-title"><span>Search</span></h4>
        <form action="{{ route('post.search') }}" class="widget-search">
            <input class="mb-3" id="search-query" value="{{ request()->input('keyword') }}" name="keyword" type="search"
                placeholder="Type &amp; Hit Enter...">
            <i class="ti-search"></i>
            <button type="submit" class="btn btn-primary btn-block">Search</button>
        </form>
    </div>

    <!-- about me -->
    @if (Auth::user())
        <div class="widget widget-about">
            <h4 class="widget-title">Hi, I am {{ Auth::user()->name }}!</h4>
            @php
                $url_user = Storage::url(Auth::user()->image);
            @endphp
            <img class="img-fluid" src="{{ $url_user }}" alt="Themefisher">
            <p>{{ Auth::user()->description }}</p>
            <ul class="list-inline social-icons mb-3">

                <li class="list-inline-item"><a href="#"><i class="ti-facebook"></i></a></li>

                <li class="list-inline-item"><a href="#"><i class="ti-twitter-alt"></i></a></li>

                <li class="list-inline-item"><a href="#"><i class="ti-linkedin"></i></a></li>

                <li class="list-inline-item"><a href="#"><i class="ti-github"></i></a></li>

                <li class="list-inline-item"><a href="#"><i class="ti-youtube"></i></a></li>

            </ul>
            <a href="about-me.html" class="btn btn-primary mb-2">About me</a>
        </div>
    @endif


    <!-- Promotion -->
    <div class="promotion">
        <img src="{{ url('theme/fontend/images/promotion.jpg') }}" class="img-fluid w-100">
        <div class="promotion-content">
            <h5 class="text-white mb-3">Create Stunning Website!!</h5>
            <p class="text-white mb-4">Lorem ipsum dolor sit amet, consectetur sociis. Etiam nunc amet
                id dignissim. Feugiat id tempor vel sit ornare turpis posuere.</p>
            <a href="https://themefisher.com/" class="btn btn-primary">Get Started</a>
        </div>
    </div>

    <!-- authors -->
    <div class="widget widget-author">
        <h4 class="widget-title">Authors</h4>
        @foreach ($list_user as $user)
            @if (count($user->posts) > 0)
                <div class="media align-items-center">
                    @php
                        $url_auth = Storage::url($user->image);
                    @endphp
                    <div class="mr-3">
                        <img class="widget-author-image" src="{{ $url_auth }}">
                    </div>
                    <div class="media-body">

                        <h5 class="mb-1"><a class="post-title" href="author-single.html">{{ $user->name }}</a>
                        </h5>
                        @foreach ($user->roles as $role)
                            <span class="bg-success rounded text-white"
                                style="padding: 3px; font-size: 12px">{{ $role->name }}</span>
                        @endforeach
                    </div>
                </div>
            @endif
        @endforeach

    </div>
    <!-- Search -->

    <div class="widget">
        <h4 class="widget-title"><span>Never Miss A News</span></h4>
        <form action="#!" method="post" name="mc-embedded-subscribe-form" target="_blank" class="widget-search">
            <input class="mb-3" id="search-query" name="s" type="search" placeholder="Your Email Address">
            <i class="ti-email"></i>
            <button type="submit" class="btn btn-primary btn-block" name="subscribe">Subscribe
                now</button>
            <div style="position: absolute; left: -5000px;" aria-hidden="true">
                <input type="text" name="b_463ee871f45d2d93748e77cad_a0a2c6d074" tabindex="-1">
            </div>
        </form>
    </div>

    <!-- categories -->
    <div class="widget widget-categories">
        <h4 class="widget-title"><span>Categories</span></h4>
        <ul class="list-unstyled widget-list">
            @foreach ($list_category as $category)
                <li><a href="{{ route('post.detail.cat', ['category' => $category->id, 'slug' => $category->slug]) }}"
                        class="d-flex">{{ $category->name }} <small
                            class="ml-auto">({{ count($category->posts) }})</small></a>
                </li>
            @endforeach


        </ul>
    </div><!-- tags -->
    <div class="widget">
        <h4 class="widget-title"><span>Tags</span></h4>
        <ul class="list-inline widget-list-inline widget-card">
            @foreach ($tags as $tag)
                <li class="list-inline-item"><a href="{{ route('tag.detail', $tag->id) }}">{{ $tag->name }}</a>
                </li>
            @endforeach
        </ul>
    </div><!-- recent post -->
    <div class="widget">
        <h4 class="widget-title">Recent Post</h4>

        @foreach ($get_list_recent_post_sidebar as $post)
            <article class="widget-card">
                <div class="d-flex">
                    @php
                        $url = Storage::url($post->image);
                    @endphp
                    <img class="card-img-sm" src="{{ $url }}">
                    <div class="ml-3">
                        <h5><a class="post-title"
                                href="{{ route('post.detail', ['id' => $post->id, 'slug' => $post->slug]) }}">{{ $post->title }}</a>
                        </h5>
                        <ul class="card-meta list-inline mb-0">
                            <li class="list-inline-item mb-0">
                                <i class="ti-calendar"></i>{{ date('d-m-Y', strtotime($post->created_at)) }}
                            </li>
                        </ul>
                    </div>
                </div>
            </article>
        @endforeach



    </div>

    <!-- Social -->
    <div class="widget">
        <h4 class="widget-title"><span>Social Links</span></h4>
        <ul class="list-inline widget-social">
            <li class="list-inline-item"><a href="#"><i class="ti-facebook"></i></a></li>
            <li class="list-inline-item"><a href="#"><i class="ti-twitter-alt"></i></a></li>
            <li class="list-inline-item"><a href="#"><i class="ti-linkedin"></i></a></li>
            <li class="list-inline-item"><a href="#"><i class="ti-github"></i></a></li>
            <li class="list-inline-item"><a href="#"><i class="ti-youtube"></i></a></li>
        </ul>
    </div>
</aside>
