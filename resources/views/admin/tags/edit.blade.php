@extends('Admin.layouts.master')
@section('title')
    Sửa thẻ bài viết
@endsection
@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Sửa mới thẻ</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.tags.index') }}">Quản lý thẻ</a></li>

                        <li class="breadcrumb-item active">Sửa thẻ</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <!-- end page title -->

    <form action="{{ route('admin.tags.update', $tag->id) }}" method="POST" enctype="multipart/form-data"
        class="needs-validation">
        @csrf
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label" for="product-title-input">Tên thẻ</label>
                            <input type="text" class="form-control d-none" id="product-id-input">

                            <input type="text" name="name" class="form-control" id="catalogue-title-input"
                                value="{{ $tag->name }}" placeholder="Nhập tên thẻ">
                            @error('name')
                                <span class="text-danger m-2">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="text-end mb-3">
                    <button type="submit" class="btn btn-primary w-sm">Đăng</button>
                </div>
            </div>
            <!-- end col -->

            <div class="col-lg-4">


                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Danh sách thẻ</h5>
                    </div>
                    <div class="card-body">
                        <select class="form-select" id="choices-category-input" data-choices data-choices-search-false
                            multiple disabled>
                            <option value="0">--Danh sách thẻ--</option>
                            @foreach ($tags as $tag)
                                <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <!-- end card body -->
                </div>
                <!-- end card -->
                <!-- end card -->


                <!-- end card -->
            </div>
            <!-- end col -->
        </div>
        <!-- end row -->
    </form>
@endsection
