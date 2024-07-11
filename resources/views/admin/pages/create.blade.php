@extends('Admin.layouts.master')
@section('title')
    Thêm page
@endsection
@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Quan lý giao diện</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.slides.index') }}">Quản lý page</a></li>
                        <li class="breadcrumb-item active">Thêm mới</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <!-- end page title -->

    <form action="{{ route('admin.pages.store') }}" method="POST" enctype="multipart/form-data" class="needs-validation">
        @csrf
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label" for="product-title-input">Tiêu đề trang</label>
                            <input type="text" class="form-control d-none" id="product-id-input">

                            <input type="text" name="title" class="form-control" id="catalogue-title-input"
                                value="" placeholder="Nhập tiêu đề">
                            @error('title')
                                <span class="text-danger m-2">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label>Nội dung trang</label>
                            <textarea rows="10" cols="10" class="form-control" name="content"></textarea>
                            @error('content')
                                <span class="text-danger m-2">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>    
            </div>
            <!-- end col -->
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Trạng thái hoạt động</h5>
                    </div>

                    <div class="card-body">
                        <div class="mb-3">
                            <h6>Trang có hoạt động không</h6>
                            <div class="form-check form-switch form-switch-md me-1" dir="ltr">
                                <input type="checkbox" name="is_active" checked value="1" class="form-check-input">
                                <label class="form-check-label" for="customSwitchsizemd">Is Acitve</label>
                            </div>
                             @error('is_active')
                                <span class="text-danger m-2">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Người tạo trang</h5>
                    </div>
                    <div class="card-body">
                        <select class="form-select" id="choices-category-input" name="user_id" data-choices
                            data-choices-search-false>
                            <option value="">--Chọn người tạo--</option>
                            @foreach ($listUser as $user)
                                <option value="{{ $user->id }}" {{ Auth::user()->id == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}</option>
                            @endforeach
                        </select>
                        @error('user_id')
                            <span class="text-danger m-2">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                 <div class="text-end mb-3 float-right gap-2">
                    <a href="{{ route('admin.slides.index') }}" class="btn btn-info">Quay lại</a>
                    <button type="submit" class="btn btn-primary w-sm">Đăng</button>
                </div>
            </div>
        </div>

        <!-- end row -->
    </form>
@endsection
@section('style-libs')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.tiny.cloud/1/yrczlu8vtw371hex5ans6vy683h0hi4o6uj09y13o0kcx3ri/tinymce/7/tinymce.min.js"
        referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: 'textarea#mce',
            plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount linkchecker',
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
        });
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.css">
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $('input[data-role="tagsinput"]').tagsinput();
        });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.min.js"></script>
    <!--jquery cdn-->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <!--select2 cdn-->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script src="{{ asset('assets/js/pages/select2.init.js') }}"></script>
@endsection
