@extends('admin.layouts.master')
@section('title')
    Chi tiết bài viết
@endsection
@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Quản lý nội dung</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Quản lý bài viết</a></li>
                        <li class="breadcrumb-item active">Chi tiết</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row gx-lg-5">
                        <div class="col-xl-4 col-md-8 mx-auto">
                            <div class="product-img-slider sticky-side-div">
                                <div class="swiper product-thumbnail-slider p-2 rounded bg-light">
                                    <div class="swiper-wrapper">
                                        <div class="swiper-slide">
                                            @php
                                                $url = Storage::url($post->image);
                                            @endphp
                                            <img src="{{ $url }}" alt="" class="img-fluid d-block" />
                                        </div>
                                    </div>
                                </div>
                                <!-- end swiper thumbnail slide -->

                                <!-- end swiper nav slide -->
                                <div class="mt-4 text-muted">
                                    <h5 class="fs-14">Mô tả ngắn: </h5>
                                    <p>{{ $post->excerpt }}</p>
                                </div>
                            </div>
                        </div>
                        <!-- end col -->

                        <div class="col-xl-8">
                            <div class="mt-xl-0 mt-5">
                                <div class="d-flex">
                                    <div class="flex-grow-1">
                                        <h4>{{ $post->title }}</h4>
                                        <div class="hstack gap-3 flex-wrap">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0">
                                                    @php
                                                        $url_created = Storage::url($post->user->image)
                                                    @endphp
                                                    <img src="{{ $url_created }}" alt=""
                                                        class="avatar-xs rounded-circle" />
                                                </div>

                                                <a href="#" style="margin-top: 7px" class="text-primary d-block ms-2">{{ $post->user->name }}</a>
                                            </div>
                                            <div class="vr"></div>
                                            <div class="text-muted">Chức vụ : <span
                                                    class="text-body fw-medium">{{ $post->user->type }}</span></div>
                                            <div class="vr"></div>
                                            <div class="text-muted">Published : <span
                                                    class="text-body fw-medium">{{ $post->created_at }}</span></div>
                                        </div>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <div>
                                            <a href="{{ route("admin.posts.edit", $post->id) }}" class="btn btn-light"
                                                data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"><i
                                                    class="ri-pencil-fill align-bottom"></i></a>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex flex-wrap gap-2 align-items-center mt-3">
                                    <div class="text-muted fs-16">
                                        <span class="mdi mdi-star text-warning"></span>
                                        <span class="mdi mdi-star text-warning"></span>
                                        <span class="mdi mdi-star text-warning"></span>
                                        <span class="mdi mdi-star text-warning"></span>
                                        <span class="mdi mdi-star text-warning"></span>
                                    </div>
                                    <div class="text-muted">( 5.50k Customer Review )</div>
                                </div>

                                <div class="row mt-4">
                                    <div class="col-lg-12 col-sm-12">
                                        <div class="p-2 border border-dashed rounded">
                                            <div class="d-flex align-items-center gap-3">
                                                @foreach ($post->tags as $tag)
                                                    <span class="mb-1 rounded-2 border btn btn-outline-primary">{{ $tag->name }}</span>                       
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                   
                                </div>






                                <div class="product-content mt-3">
                                    <h5 class="fs-14 mb-3">Nội dung bài viết: </h5>
                                    <nav>
                                        <ul class="nav nav-tabs nav-tabs-custom nav-success" id="nav-tab" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link active" id="nav-speci-tab" data-bs-toggle="tab"
                                                    href="#nav-speci" role="tab" aria-controls="nav-speci"
                                                    aria-selected="true">Trạng thái</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="nav-detail-tab" data-bs-toggle="tab"
                                                    href="#nav-detail" role="tab" aria-controls="nav-detail"
                                                    aria-selected="false">Nội dung</a>
                                            </li>
                                        </ul>
                                    </nav>
                                    <div class="tab-content border border-top-0 p-4" id="nav-tabContent">
                                        <div class="tab-pane fade show active" id="nav-speci" role="tabpanel"
                                            aria-labelledby="nav-speci-tab">
                                            <div class="table-responsive">
                                                <table class="table mb-0">
                                                    <tbody>
                                                        <tr>
                                                            <th scope="row" style="width: 200px;">Danh Mục</th>
                                                            <td>{{ $post->category->name }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">Bài viết mới</th>
                                                            <td>{{ $post->is_new ? 'YES' : 'NO' }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">Hiển thị trang chủ</th>
                                                            <td>{{ $post->is_show_home ? 'YES' : 'NO' }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">Hoạt Động</th>
                                                            <td>{{ $post->is_active ? 'YES' : 'NO' }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">Thịnh hành</th>
                                                            <td>{{ $post->is_trending ? 'YES' : 'NO' }}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade w-100" id="nav-detail" role="tabpanel"
                                            aria-labelledby="nav-detail-tab">
                                            <div>
                                                <h5 class="font-size-16 mb-3">{{ $post->name }}</h5>
                                                <p class="w-100">{!! $post->content !!} </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <!-- end col -->
                    </div>
                    <!-- end row -->
                </div>
                <!-- end card body -->
            </div>
            <!-- end card -->
        </div>
        <!-- end col -->
    </div>
    <!-- end row -->
@endsection
@section('style-libs')
    <!--Swiper slider css-->
    <link href="{{ asset('assets/libs/swiper/swiper-bundle.min.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('script')
    <!--Swiper slider js-->
    <script src="{{ asset('assets/libs/swiper/swiper-bundle.min.js') }}"></script>

    <!-- ecommerce product details init -->
    <script src="{{ asset('assets/js/pages/ecommerce-product-details.init.js') }}"></script>
@endsection
