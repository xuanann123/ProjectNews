@extends('Admin.layouts.master')
@section('title')
Chỉnh sửa danh mục
@endsection
@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Sửa danh mục {{ $category->name }}</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Quản lý nội dung</a></li>
                        <li class="breadcrumb-item"><a href="">Quản lý danh mục</a></li>

                        <li class="breadcrumb-item active">Sửa danh mục</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <!-- end page title -->

    <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" enctype="multipart/form-data"
        class="needs-validation">
        @csrf
        @method('put')
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label" for="product-title-input">Tên danh mục</label>
                            <input type="text" class="form-control d-none" id="product-id-input">

                            <input type="text" name="name" class="form-control" id="catalogue-title-input"
                                value="{{ $category->name }}" placeholder="Nhập tên danh mục">
                            @error('name')
                                <span class="text-danger m-2">{{ $message }}</span>
                            @enderror


                        </div>
                        <div>
                            <label>Mô tả danh mục</label>
                            <textarea rows="10" cols="10" class="form-control" name="description">{{ $category->description }}</textarea>
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
                        <h5 class="card-title mb-0">Trạng thái danh mục</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <div class="form-check form-switch form-switch-md mb-3" dir="ltr">
                                <input type="checkbox" name="is_active" {{ $category->is_active == 1? "checked" : "" }} value="1" class="form-check-input">
                                <label class="form-check-label" for="customSwitchsizemd">Is Active</label>
                            </div>
                        </div>


                    </div>
                    <!-- end card body -->
                </div>
                <!-- end card -->
                <!-- end card -->

                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Danh mục cha</h5>
                    </div>
                    <div class="card-body">
                        <select class="form-select" id="choices-category-input" name="parent_id" data-choices
                            data-choices-search-false>
                            <option value="0">--Chọn danh mục--</option>
                            @foreach ($listCategory as $cat)
                                @php
                                    $level = '';
                                @endphp
                                @include('admin.layouts.submenu', [
                                    'cat' => $cat,
                                ]);
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
