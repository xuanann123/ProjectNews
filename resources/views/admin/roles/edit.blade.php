@extends('admin.layouts.master')
@section('title')
    Sửa vai trò
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Quản lý tài khoản và quyền</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Quản lý vai trò</a></li>
                        <li class="breadcrumb-item active">Danh sách</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    @if (Session('status'))
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <p class="alert alert-danger">{{ Session('status') }}</p>
                    </div>
                </div>
            </div><!--end col-->
        </div><!--end row-->
    @endif
    <div class="row">
        <div id="content" class="container-fluid">
            <div class="card">
                <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
                    <h5 class="m-0 ">Sửa mới vai trò</h5>
                    <div class="form-search form-inline">
                        <form action="">
                            <div class="d-flex">
                                <input type="" name="search" class="form-control form-search me-3"
                                    placeholder="Tìm kiếm" value="">
                                <input type="submit" name="btn-search" value="Tìm kiếm" class="btn btn-primary">
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.roles.update', $role->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <div class="form-group">
                            <label class="font-weight-bold form-label" for="name"><strong>Tên vai trò</strong></label>
                            <input class="form-control" type="text" name="name" id="name"
                                value="{{ $role->name }}">
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror

                        </div>
                        <div class="form-group mt-5">
                            <label class="font-weight-bold form-label" for="description"><strong>Mô tả</strong></label>
                            <textarea class="form-control" type="text" name="description" id="description"> {{ $role->description }}</textarea>
                            @error('description')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <h5 class="mt-5"><strong>Vai trò này có quyền gì?</strong></h5>
                        <small class="form-text text-muted pb-2">Check vào module hoặc các hành động bên dưới để chọn
                            quyền.</small>
                        <!-- List Permission  -->
                        @foreach ($permissions as $moduleName => $modulePermissions)
                            <div class="card my-4 border">
                                <div class="card-header">
                                    {{-- input id và label for thì name phải trùng nhau -> vì nó sẽ chose được danh sách cần chọ nàl gì --}}
                                    <input type="checkbox" class="check-all" name="" id="{{ $moduleName }}">
                                    <label for="{{ $moduleName }}" class="m-0 text-uppercase  font-weight-bold">Module
                                        {{ $moduleName }}</label>
                                </div>
                                @php

                                    //Kiểm tra vai trò này có những quyền nào in
                                @endphp
                                <div class="card-body">
                                    <div class="row">
                                        @foreach ($modulePermissions as $permission)
                                            <div class="col-md-3">
                                                {{-- Đi check trong từng id của per xem có id nào tồn tại trong mảng role_permission chính role đấy k --}}
                                                <input type="checkbox"
                                                    {{ in_array($permission->id, $role_have_id_permission) ? 'checked' : '' }}
                                                    class="permission" value="{{ $permission->id }}" name="permission_id[]"
                                                    id="{{ $permission->slug }}">

                                                <label for="{{ $permission->slug }}">{{ $permission->name }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach


                        <input type="submit" name="btn-add" class="btn btn-primary" value="Sửa">
                    </form>
                </div>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            $('.check-all').click(function() {
                $(this).closest('.card').find('.permission').prop('checked', this.checked)
            })
        </script>
    </div>
    <!-- end row -->
    <!-- Modal -->
    <!--end modal -->
@endsection
@section('style-libs')
    <!-- Sweet Alert css-->
    <link href="{{ asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection


@section('script-libs')
    <!-- prismjs plugin -->
    <script src="{{ asset('assets/libs/prismjs/prism.js') }}"></script>
    <script src="{{ asset('assets/libs/list.js/list.min.js') }}"></script>
    <script src="{{ asset('assets/libs/list.pagination.js/list.pagination.min.js') }}"></script>

    <!-- listjs init -->
    <script src="{{ asset('assets/js/pages/listjs.init.js') }}"></script>

    <!-- Sweet Alerts js -->
    <script src="{{ asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
@endsection
