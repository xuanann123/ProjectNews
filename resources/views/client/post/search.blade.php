@extends('layouts.master')
@section('title')
    Tìm kiếm bài viết
@endsection
@section('content')
    <section class="section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10 mb-4">
                    <h4 class="h3 mb-4">Kết quả tìm kiếm cụm từ :
                        <mark>{{ request()->input('keyword') }}</mark>
                    </h4>
                </div>
                <div class="col-lg-10">
                    @if ($list_post_search->count() > 0)
                        @foreach ($list_post_search as $post)
                            <article class="card mb-4">
                                <div class="row card-body">
                                    @php
                                        $post_image = Storage::url($post->image);
                                    @endphp
                                    <div class="col-md-4 mb-4 mb-md-0">
                                        <div class="post-slider slider-sm">
                                            <img src="{{ $post_image }}" class="card-img" alt="post-thumb"
                                                style="height:200px; object-fit: cover;">
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <h3 class="h4 mb-3"><a class="post-title"
                                                href="{{ route('post.detail', ['id' => $post->id, 'slug' => $post->slug]) }}">{{ $post->title }}</a>
                                        </h3>
                                        <ul class="card-meta list-inline">
                                            <li class="list-inline-item">
                                                @php
                                                    $url_recent = Storage::url($post->user->image);
                                                @endphp
                                                <a href="author-single.html" class="card-meta-author">
                                                @if ($post->user->image)
                                                    <img src="{{ $url_recent }}">
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
                    @else
                        <div class="text-center">
                            <img class="mb-5" src="{{ url('theme/fontend/images/no-search-found.svg') }}" alt="">
                            <h4>Không tìm thấy bài viết nào</h4>
                        </div>
                    @endif



                </div>
            </div>
        </div>
    </section>
@endsection
