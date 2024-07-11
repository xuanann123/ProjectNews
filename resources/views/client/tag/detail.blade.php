@extends('layouts.master')
@section('title')
    Danh sách bài viết
@endsection
@section('content')
    <section class="section">
        <div class="py-4"></div>
        <div class="container">
            <div class="row">
                <div class="col-lg-8  mb-5 mb-lg-0">
                    <h1 class="h2 mb-4">Showing items from <mark>{{ $tag->name }}</mark></h1>
                    @foreach ($tag->posts as $post)
                        <article class="card mb-4">
                            <div class="post-slider">
                                @php
                                    $url = Storage::url($post->image);
                                @endphp
                                <img src="{{ $url }}" class="card-img-top" alt="post-thumb">
                            </div>
                            <div class="card-body">
                                <h3 class="mb-3"><a class="post-title"
                                        href="{{ route('post.detail', ['id' => $post->id, 'slug' => $post->slug]) }}">{{ $post->title }}</a>
                                </h3>
                                <ul class="card-meta list-inline">
                                    <li class="list-inline-item">
                                        @php
                                            $image_author = Storage::url($post->user->image);
                                        @endphp
                                        <a href="author-single.html" class="card-meta-author">
                                            @if ($post->user->image)
                                                <img src="{{ $image_author }}">
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
                                        <i class="ti-calendar"></i>{{ date('d-m-Y', strtotime($post->created_at)) }}
                                    </li>
                                    <li class="list-inline-item">
                                        <ul class="card-meta-tag list-inline">
                                            <li class="list-inline-item"><a href="tags.html">Color</a></li>
                                            <li class="list-inline-item"><a href="tags.html">Recipe</a></li>
                                            <li class="list-inline-item"><a href="tags.html">Fish</a></li>
                                        </ul>
                                    </li>
                                </ul>
                                <p>{{ Str::words($post->excerpt, 50, '...') }}</p>
                                <a href="{{ route('post.detail', ['id' => $post->id, 'slug' => $post->slug]) }}"
                                    class="btn btn-outline-primary">Read More</a>
                            </div>
                        </article>
                    @endforeach


                </div>

                @include('layouts.sidebar')

            </div>
        </div>
    </section>
@endsection
