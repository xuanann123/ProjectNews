@extends('layouts.master')
@section('title')
    Trang chủ
@endsection
@section('content')
    <div class="banner text-center">
        <div class="container">
            <div class="row">
                <div class="col-lg-9 mx-auto">
                    <h1 class="mb-5">Bạn Thích Làm Gì?<br> Muốn Đọc Gì Hôm Nay?</h1>
                    <ul class="list-inline widget-list-inline">
                        @foreach ($tags as $tag)
                            <li class="list-inline-item"><a href="{{ route('tag.detail', $tag->id) }}">{{ $tag->name }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>


        <svg class="banner-shape-1" width="39" height="40" viewBox="0 0 39 40" fill="none"
            xmlns="http://www.w3.org/2000/svg">
            <path d="M0.965848 20.6397L0.943848 38.3906L18.6947 38.4126L18.7167 20.6617L0.965848 20.6397Z" stroke="#040306"
                stroke-miterlimit="10" />
            <path class="path" d="M10.4966 11.1283L10.4746 28.8792L28.2255 28.9012L28.2475 11.1503L10.4966 11.1283Z" />
            <path d="M20.0078 1.62949L19.9858 19.3804L37.7367 19.4024L37.7587 1.65149L20.0078 1.62949Z" stroke="#040306"
                stroke-miterlimit="10" />
        </svg>

        <svg class="banner-shape-2" width="39" height="39" viewBox="0 0 39 39" fill="none"
            xmlns="http://www.w3.org/2000/svg">
            <g filter="url(#filter0_d)">
                <path class="path"
                    d="M24.1587 21.5623C30.02 21.3764 34.6209 16.4742 34.435 10.6128C34.2491 4.75147 29.3468 0.1506 23.4855 0.336498C17.6241 0.522396 13.0233 5.42466 13.2092 11.286C13.3951 17.1474 18.2973 21.7482 24.1587 21.5623Z" />
                <path
                    d="M5.64626 20.0297C11.1568 19.9267 15.7407 24.2062 16.0362 29.6855L24.631 29.4616L24.1476 10.8081L5.41797 11.296L5.64626 20.0297Z"
                    stroke="#040306" stroke-miterlimit="10" />
            </g>
            <defs>
                <filter id="filter0_d" x="0.905273" y="0" width="37.8663" height="38.1979" filterUnits="userSpaceOnUse"
                    color-interpolation-filters="sRGB">
                    <feFlood flood-opacity="0" result="BackgroundImageFix" />
                    <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" />
                    <feOffset dy="4" />
                    <feGaussianBlur stdDeviation="2" />
                    <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.25 0" />
                    <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow" />
                    <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow" result="shape" />
                </filter>
            </defs>
        </svg>


        <svg class="banner-shape-3" width="39" height="40" viewBox="0 0 39 40" fill="none"
            xmlns="http://www.w3.org/2000/svg">
            <path d="M0.965848 20.6397L0.943848 38.3906L18.6947 38.4126L18.7167 20.6617L0.965848 20.6397Z" stroke="#040306"
                stroke-miterlimit="10" />
            <path class="path" d="M10.4966 11.1283L10.4746 28.8792L28.2255 28.9012L28.2475 11.1503L10.4966 11.1283Z" />
            <path d="M20.0078 1.62949L19.9858 19.3804L37.7367 19.4024L37.7587 1.65149L20.0078 1.62949Z" stroke="#040306"
                stroke-miterlimit="10" />
        </svg>


        <svg class="banner-border" height="240" viewBox="0 0 2202 240" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path
                d="M1 123.043C67.2858 167.865 259.022 257.325 549.762 188.784C764.181 125.427 967.75 112.601 1200.42 169.707C1347.76 205.869 1901.91 374.562 2201 1"
                stroke-width="2" />
        </svg>
    </div>
    <section class="section pb-0">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-5">
                    <h2 class="h5 section-title">New Post</h2>
                    <article class="card">
                        <div class="post-slider slider-sm">
                            @php
                                $url_post_new = Storage::url($post_new->image);
                            @endphp
                            @if ($post_new->image)
                                <img src="{{ $url_post_new }}" class="card-img-top" alt="post-thumb">
                            @endif

                        </div>
                        <div class="card-body">
                            <h3 class="h4 mb-3"><a class="post-title"
                                    href="{{ route('post.detail', ['id' => $post_new->id, 'slug' => $post_new->slug]) }}">{{ $post_new->title }}</a>
                            </h3>
                            <ul class="card-meta list-inline">
                                <li class="list-inline-item">
                                    <a href="author-single.html" class="card-meta-author">
                                        @php
                                            $url_user_create_post = Storage::url($post_new->user->image);
                                        @endphp
                                        <img src="{{ $url_user_create_post }}">
                                        <span>{{ $post_new->user->name }}</span>
                                    </a>
                                </li>
                                <li class="list-inline-item">
                                    <i class="fas fa-eye"></i>
                                    @if (count($post_new->views) > 0)
                                        @php
                                            $view = 0;
                                            foreach ($post_new->views as $item) {
                                                $view += $item->views;
                                            }
                                        @endphp
                                        {{ $view }}
                                    @else
                                        0
                                    @endif
                                </li>

                                <li class="list-inline-item">
                                    <i class="ti-calendar"></i>{{ $date_new }}
                                </li>
                                <li class="list-inline-item">
                                    <ul class="card-meta-tag list-inline">
                                        @foreach ($post_new->tags as $item)
                                            <li class="list-inline-item"><a href="tags.html">{{ $item->name }}</a></li>
                                        @endforeach
                                    </ul>
                                </li>
                            </ul>
                            <p>{!! $post_new_content !!}</p>
                            <a href="{{ route('post.detail', ['id' => $post_new->id, 'slug' => $post_new->slug]) }}"
                                class="btn btn-outline-primary">Read
                                More</a>
                        </div>
                    </article>
                </div>
                <div class="col-lg-4 mb-5">
                    <h2 class="h5 section-title">Trending Post</h2>
                    @foreach ($list_post_trend as $post)
                        @php
                            $url_post_trend = Storage::url($post->image);
                        @endphp
                        <article class="card mb-4">
                            <div class="card-body d-flex">
                                @if ($post->image)
                                    <img class="card-img-sm" src="{{ $url_post_trend }}">
                                @endif
                                
                                <div class="ml-3">
                                    <h4><a href="{{ route('post.detail', ['id' => $post->id, 'slug' => $post->slug]) }}"
                                            class="post-title">{{ $post->title }}</a>
                                    </h4>
                                    <ul class="card-meta list-inline mb-0">
                                        <li class="list-inline-item mb-0">
                                            <i class="ti-calendar"></i>{{ date('d-m-Y', strtotime($post->created_at)) }}
                                        </li>
                                        <li class="list-inline-item mb-0">
                                            <i class="fas fa-eye"></i>
                                            @if (count($post->views) > 0)
                                                @php
                                                    $view = 0;
                                                    foreach ($post->views as $item) {
                                                        $view += $item->views;
                                                    }
                                                @endphp
                                                {{ $view }}
                                            @else
                                                0
                                            @endif
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>

                <div class="col-lg-4 mb-5">
                    <h2 class="h5 section-title">Popular Post</h2>
                    @php
                        $url_post_popular = Storage::url($post_popular->image);
                    @endphp
                    <article class="card">
                        <div class="post-slider slider-sm">
                            <img src="{{ $url_post_popular }}" class="card-img-top" alt="post-thumb">
                        </div>
                        <div class="card-body">
                            <h3 class="h4 mb-3"><a class="post-title"
                                    href="{{ route('post.detail', ['id' => $post_popular->id, 'slug' => $post_popular->slug]) }}">{{ $post_popular->title }}</a>
                            </h3>
                            <ul class="card-meta list-inline">
                                <li class="list-inline-item">
                                    @php
                                        $author_post_popular = Storage::url($post_popular->user->image);
                                    @endphp
                                    <a href="author-single.html" class="card-meta-author">
                                        <img src="{{ $author_post_popular }}" alt="Kate Stone">
                                        <span>{{ $post_popular->user->name }}</span>
                                    </a>
                                </li>
                                <li class="list-inline-item">
                                    <i class="fas fa-eye"></i>
                                    @if (count($post_popular->views) > 0)
                                        @php
                                            $view = 0;
                                            foreach ($post_popular->views as $item) {
                                                $view += $item->views;
                                            }
                                        @endphp
                                        {{ $view }}
                                    @else
                                        0
                                    @endif
                                </li>
                                <li class="list-inline-item">
                                    <i class="ti-calendar"></i>{{ $date_popular }}
                                </li>
                                <li class="list-inline-item">
                                    <ul class="card-meta-tag list-inline">
                                        @foreach ($post_popular->tags as $tag)
                                            <li class="list-inline-item"><a href="tags.html">{{ $tag->name }}</a></li>
                                        @endforeach
                                    </ul>
                                </li>
                            </ul>
                            <p>{{ $post_popular_content }}</p>
                            <a href="{{ route('post.detail', ['id' => $post_popular->id, 'slug' => $post_popular->slug]) }}"
                                class="btn btn-outline-primary">Read
                                More</a>
                        </div>
                    </article>
                </div>
                <div class="col-12">
                    <div class="border-bottom border-default"></div>
                </div>
            </div>
        </div>
    </section>

    <section class="section-sm" style="padding:30px 20px!important">
        <div class="container">
            <div class="row mb-5">
                <div class="post-slider">
                    @foreach ($slides as $slide)
                        @php
                            $url_slide = Storage::url($slide->image);
                        @endphp
                        <img src="{{ $url_slide }}" class="card-img-top" alt="post-thumb">
                    @endforeach
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-8  mb-5 mb-lg-0">
                    <h2 class="h5 section-title">Recent Post</h2>
                    @foreach ($get_list_recent_post as $post)
                        @php
                            $url_post_recent = Storage::url($post->image);
                        @endphp


                        <article class="card mb-4">
                            <div class="post-slider">
                                @if ($post->image)
                                    <img src="{{ $url_post_recent }}" class="card-img-top" alt="post-thumb">
                                @endif
                                
                            </div>
                            <div class="card-body">
                                <h3 class="mb-3"><a class="post-title"
                                        href="{{ route('post.detail', ['id' => $post->id, 'slug' => $post->slug]) }}">{{ $post->title }}</a>
                                </h3>
                                <ul class="card-meta list-inline">
                                    <li class="list-inline-item">
                                        @php
                                            $url_recent = Storage::url($post->user->image);
                                        @endphp
                                        <a href="author-single.html" class="card-meta-author">
                                            <img src="{{ $url_recent }}">
                                            <span>{{ $post->user->name }}</span>
                                        </a>
                                    </li>
                                    <li class="list-inline-item">
                                        <i class="fas fa-eye"></i>
                                        @if (count($post->views) > 0)
                                            @php
                                                $view = 0;
                                                foreach ($post->views as $item) {
                                                    $view += $item->views;
                                                }
                                            @endphp
                                            {{ $view }}
                                        @else
                                            0
                                        @endif
                                    </li>
                                    <li class="list-inline-item">
                                        <i class="ti-calendar"></i>{{ date('d-m-Y', strtotime($post->created_at)) }}
                                    </li>
                                    <li class="list-inline-item">
                                        <ul class="card-meta-tag list-inline">
                                            <li class="list-inline-item"><a href="tags.html">Decorate</a></li>
                                            <li class="list-inline-item"><a href="tags.html">Creative</a></li>
                                        </ul>
                                    </li>
                                </ul>
                                <p>{{ Str::words($post->excerpt, 50, '...') }}</p>
                                <a href="{{ route('post.detail', ['id' => $post->id, 'slug' => $post->slug]) }}"
                                    class="btn btn-outline-primary">Read
                                    More</a>
                            </div>
                        </article>
                    @endforeach

                    <ul class="pagination justify-content-center">
                        {{ $get_list_recent_post->links() }}
                    </ul>
                </div>
                @include('layouts.sidebar')
            </div>
        </div>
    </section>
@endsection
