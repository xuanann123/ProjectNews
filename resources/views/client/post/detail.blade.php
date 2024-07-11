@extends('layouts.master')
@section('title')
    Chi tiết bài viết
@endsection
@section('content')
    <section class="section">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb" style="background-color: rgb(255, 255, 255)!important">
                    @if ($post->category->parent)
                        <li class="breadcrumb-item"><a class="font-weight-bold text-dark"
                            href="{{ route('post.detail.cat', ['category' => $post->category->parent->id, 'slug' => $post->category->parent->slug]) }}">{{ $post->category->parent->name }}</a>
                    </li>
                    @endif
                    <li class="breadcrumb-item"><a class="text-dark"
                            href="{{ route('post.detail.cat', ['category' => $post->category->id, 'slug' => $post->category->slug]) }}">{{ $post->category->name }}</a>
                    </li>
                </ol>
            </nav>
            <div class="row justify-content-center">
                <div class=" col-lg-9 mb-5 mb-lg-0">
                    <article>
                        @php
                            $url = Storage::url($post->image);
                        @endphp
                        <style>
                            .image_user {
                                width: 20px !important;
                                height: auto;
                            }
                        </style>
                        {{-- <div class="post-slider mb-4">
                            <img src="{{ $url }}" class="card-img" alt="post-thumb">
                        </div> --}}
                        {{-- 
                        <h1 class="h2">{{ $post->title }} </h1> --}}
                        <ul class="card-meta my-3 list-inline">
                            @php
                                $image_author = Storage::url($post->user->image);
                            @endphp
                            <li class="list-inline-item">
                                <a href="author-single.html" class="card-meta-author">
                                    @if ($post->user->image)
                                        <img src="{{ $image_author }}" class="image_user">
                                    @else
                                        <img src="{{ url('image/notimage.webp') }}" class="image_user">
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
                                    @foreach ($post->tags as $tag)
                                        <li class="list-inline-item"><a href="tags.html">{{ $tag->name }}</a></li>
                                    @endforeach
                                </ul>
                            </li>
                        </ul>
                        <div class="content">
                            <style>
                                img {
                                    width: 100% !important;
                                }
                            </style>
                            {!! $post->content !!}
                        </div>
                    </article>

                </div>

                <div class="col-lg-9 col-md-12">
                    <div class="mb-5 border-top mt-4 pt-5">
                        <h3 class="mb-4">Bình luận</h3>
                        @if ($post->comments->count() > 0)
                            @include('layouts.comments', [
                                'comments' => $post->comments,
                                'post_id' => $post->id,
                            ])
                        @else
                            <p>Chưa có bình luận nào tồn tại</p>
                        @endif

                    </div>

                    <div>
                        <h3 class="mb-4">Bình luận bài viết</h3>
                        <form action="{{ route('post.comments.store', $post->id) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <textarea class="form-control" id="content" name="content" rows="3" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection
