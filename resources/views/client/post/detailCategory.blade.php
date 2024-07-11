@extends('layouts.master')
@section('title')
    Chi tiết danh mục
@endsection
@section('content')
    <section class="section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-12 mb-4">
                    <nav class="navbar navbar-expand-lg navbar-light">
                        <h4><a class="navbar-brand"
                                href="{{ route('post.detail.cat', ['category' => $category->id, 'slug' => $category->slug]) }}">{{ $category->name }}</a>
                        </h4>
                        <div class="collapse navbar-collapse" id="navbarNav">
                            <ul class="navbar-nav">
                                @foreach ($category->children as $cat)
                                    <li class="nav-item">
                                        <a class="nav-link"
                                            href="{{ route('post.detail.cat', ['category' => $cat->id, 'slug' => $cat->slug]) }}">{{ $cat->name }}</a>
                                    </li>
                                @endforeach

                            </ul>
                        </div>
                    </nav>
                </div>
                <div class="col-lg-10">
                    @foreach ($category->posts as $post)
                        <article class="card mb-4">
                            <div class="row card-body">
                                <div class="col-md-4 mb-4 mb-md-0">
                                    @php
                                        $url = Storage::url($post->image);
                                    @endphp
                                    <div class="post-slider slider-sm">
                                        <img src="{{ $url }}" class="card-img" alt="post-thumb"
                                            style="height:200px; object-fit: cover;">
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <h3 class="h4 mb-3"><a class="post-title"
                                            href="{{ route('post.detail', ['id' => $post->id, 'slug' => $post->slug]) }}">{{ $post->title }}</a>
                                    </h3>
                                    @php
                                        $url_author = Storage::url($post->user->image);
                                    @endphp
                                    <ul class="card-meta list-inline">
                                        <li class="list-inline-item">
                                            <a href="author-single.html" class="card-meta-author">
                                                @if ($post->user->image)
                                                    <img src="{{ $url_author }}">
                                                @else
                                                    <img src="{{ url('image/notimage.webp') }}">
                                                @endif

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
                                            <i
                                                class="ti-calendar"></i>{{ date('d-m-Y H:i', strtotime($post->created_at)) }}
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
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endsection
