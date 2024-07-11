@extends('admin.layouts.master')
@section('title')
    Thêm người dùng
@endsection
@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Thêm mới danh mục</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Quản lý nội dung</a></li>
                        <li class="breadcrumb-item"><a href="">Quản lý danh mục</a></li>

                        <li class="breadcrumb-item active">Thêm mới</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <!-- end page title -->

    {{-- <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data" class="needs-validation">
        @csrf
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-5">
                            <label class="form-label" for="product-title-input">Họ và tên</label>
                            <input type="text" name="name" class="form-control" id="catalogue-title-input"
                                value="{{ old('name') }}" placeholder="Nhập họ và tên">
                            @error('name')
                                <span class="text-danger m-2">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-5">
                            <label class="form-label" for="product-title-input">Email</label>
                            <input type="email" name="email" class="form-control" id="catalogue-title-input"
                                value="{{ old('email') }}" placeholder="Email">
                            @error('email')
                                <span class="text-danger m-2">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-5">
                            <label class="form-label" for="product-title-input">Mật khẩu</label>
                            <input type="password" name="password" class="form-control" id="catalogue-title-input"
                                placeholder="Nhập mật khẩu">
                            @error('password')
                                <span class="text-danger m-2">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-2">
                            <label class="form-label" for="product-title-input">Nhập lại mật khẩu</label>
                            <input type="password" name="password_confirmation" class="form-control"
                                id="catalogue-title-input" placeholder="Nhập lại mật khẩu">
                        </div>
                    </div>
                </div>

                <div class="text-end mb-5">
                    <button type="submit" class="btn btn-primary w-sm">Thêm</button>
                </div>
            </div>
            <!-- end col -->

            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Quyền truy cập vào trang quản trị</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-2">
                            <div class="form-check form-switch form-switch-md mb-2" dir="ltr">
                                <input type="checkbox" name="type" value="1" class="form-check-input">
                                <label class="form-check-label" for="customSwitchsizemd">Is Admin</label>
                            </div>
                        </div>


                    </div>
                    <!-- end card body -->
                </div>
                <!-- end card -->
                <!-- end card -->

                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Vai trò của thành viên</h5>
                    </div>
                    <div class="card-body">
                        <select class="form-control" name="list_role[]" data-choices="" data-choices-text-unique-true=""
                            multiple="" id="skillsInput">
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
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
    </form> --}}

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Thêm thành viên</h4>
                </div><!-- end card header -->
                <div class="card-body">
                    <form action="{{ route('admin.users.store') }}" class="form-steps" enctype="multipart/form-data"
                        method="post">
                        @method('post')
                        @csrf
                        <div class="text-center pt-3 pb-4 mb-1">
                            <h5>Đăng kí thành viên</h5>
                        </div>
                        <div id="custom-progress-bar" class="progress-nav mb-4">
                            <div class="progress" style="height: 1px;">
                                <div class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0"
                                    aria-valuemin="0" aria-valuemax="100"></div>
                            </div>

                            <ul class="nav nav-pills progress-bar-tab custom-nav" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link rounded-pill active" data-progressbar="custom-progress-bar"
                                        id="pills-gen-info-tab" data-bs-toggle="pill" data-bs-target="#pills-gen-info"
                                        type="button" role="tab" aria-controls="pills-gen-info"
                                        aria-selected="true">1</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link rounded-pill" data-progressbar="custom-progress-bar"
                                        id="pills-info-desc-tab" data-bs-toggle="pill" data-bs-target="#pills-info-desc"
                                        type="button" role="tab" aria-controls="pills-info-desc"
                                        aria-selected="false">2</button>
                                </li>


                            </ul>
                        </div>

                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="pills-gen-info" role="tabpanel"
                                aria-labelledby="pills-gen-info-tab">
                                <div>
                                    <div class="mb-4">
                                        <div>
                                            <h5 class="mb-1">Thông tin chung</h5>
                                            <p class="text-muted">Điền những trường thông tin dưới đây</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="product-title-input">Email</label>
                                                <input type="email" name="email" class="form-control"
                                                    id="catalogue-title-input" value="{{ old('email') }}"
                                                    placeholder="Nhập email">
                                                @error('email')
                                                    <span class="text-danger m-2">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="product-title-input">Họ và tên</label>
                                                <input type="text" name="name" class="form-control"
                                                    id="catalogue-title-input" value="{{ old('name') }}"
                                                    placeholder="Nhập họ và tên">
                                                @error('name')
                                                    <span class="text-danger m-2">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="product-title-input">Mật khẩu</label>
                                        <input type="password" name="password" class="form-control"
                                            id="catalogue-title-input" placeholder="Nhập mật khẩu">
                                        @error('password')
                                            <span class="text-danger m-2">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="product-title-input">Nhập lại mật khẩu</label>
                                        <input type="password" name="password_confirmation" class="form-control"
                                            id="catalogue-title-input" placeholder="Nhập lại mật khẩu">
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <h5 class="card-title mb-0">Quyền truy cập vào trang quản trị
                                                            </h5>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="mb-2">
                                                                <div class="form-check form-switch form-switch-md mb-2"
                                                                    dir="ltr">
                                                                    <input type="checkbox" name="type" value="1"
                                                                        class="form-check-input">
                                                                    <label class="form-check-label"
                                                                        for="customSwitchsizemd">Is
                                                                        Admin</label>
                                                                </div>
                                                            </div>


                                                        </div>
                                                        <!-- end card body -->
                                                    </div>
                                                    <!-- end card -->
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <h5 class="card-title mb-0">Vai trò của thành viên</h5>
                                                        </div>
                                                        <div class="card-body">
                                                            <select class="form-control" name="list_role[]"
                                                                data-choices="" data-choices-text-unique-true=""
                                                                multiple="" id="skillsInput">
                                                                @foreach ($roles as $role)
                                                                    <option value="{{ $role->id }}">
                                                                        {{ $role->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <!-- end card body -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex align-items-start gap-3 mt-4">
                                    <button type="button" class="btn btn-success btn-label right ms-auto nexttab nexttab"
                                        data-nexttab="pills-info-desc-tab"><i
                                            class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i>Go to more
                                        info</button>
                                </div>


                            </div>
                            <!-- end tab pane -->



                            <div class="tab-pane fade" id="pills-info-desc" role="tabpanel"
                                aria-labelledby="pills-info-desc-tab">
                                <div>
                                    <div class="text-center">
                                        <div class="profile-user position-relative d-inline-block mx-auto mb-2">
                                            <img src="{{ asset('assets/images/users/user-dummy-img.jpg') }}"
                                                class="rounded-circle avatar-lg img-thumbnail user-profile-image"
                                                alt="user-profile-image">
                                            <div class="avatar-xs p-0 rounded-circle profile-photo-edit">
                                                <input id="profile-img-file-input" type="file" name="image"
                                                    class="profile-img-file-input">
                                                <label for="profile-img-file-input" class="profile-photo-edit avatar-xs">
                                                    <span class="avatar-title rounded-circle bg-light text-body">
                                                        <i class="ri-camera-fill"></i>
                                                    </span>
                                                </label>
                                            </div>
                                        </div>
                                        <h5 class="fs-14">Add Image</h5>

                                    </div>
                                    <div>
                                        <label class="form-label" for="gen-info-description-input">Mô tả trong hệ
                                            thống</label>
                                        <input type="text" class="form-control" name="description">
                                    </div>
                                </div>


                                <div class="d-flex align-items-start gap-3 mt-4">
                                    <button type="button" class="btn btn-link text-decoration-none btn-label previestab"
                                        data-previous="pills-gen-info-tab"><i
                                            class="ri-arrow-left-line label-icon align-middle fs-16 me-2"></i> Back
                                        to
                                        General</button>
                                    <button type="submit" class="btn btn-success btn-label right ms-auto nexttab nexttab"
                                        data-nexttab="pills-success-tab"><i
                                            class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i>Submit</button>
                                </div>
                            </div>
                            <!-- end tab pane -->

                            {{-- <div class="tab-pane fade" id="pills-success" role="tabpanel"
                                aria-labelledby="pills-success-tab">
                                <div>
                                    <div class="text-center">

                                        <div class="mb-4">
                                            <lord-icon src="https://cdn.lordicon.com/lupuorrc.json" trigger="loop"
                                                colors="primary:#0ab39c,secondary:#405189"
                                                style="width:120px;height:120px"></lord-icon>
                                        </div>
                                        <h5>Well Done !</h5>
                                        <p class="text-muted">Bạn đã hoàn thành form đăng kí thành viên mới</p>
                                        <div class="d-flex align-items-start gap-3 mt-4">
                                            <button type="button"
                                                class="btn btn-link text-decoration-none btn-label previestab"
                                                data-previous="pills-gen-info-tab"><i
                                                    class="ri-arrow-left-line label-icon align-middle fs-16 me-2"></i> Back
                                                to
                                                General</button>
                                            <button type="submit"
                                                class="btn btn-success btn-label right ms-auto nexttab nexttab"
                                                data-nexttab="pills-success-tab"><i
                                                    class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i>Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end tab pane --> --}}
                        </div>
                        <!-- end tab content -->
                    </form>
                </div>
                <!-- end card body -->
            </div>
            <!-- end card -->
        </div>
        <!-- end col -->

    </div><!-- end row -->
@endsection
@section('script-libs')
    <script src="{{ asset('assets/js/pages/form-wizard.init.js') }}"></script>
@endsection
