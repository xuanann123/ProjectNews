@extends('admin.layouts.master')
@section('title')
    Danh sách quyền
@endsection
@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Quản lý quyền</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Quản lý quyền</a></li>
                        <li class="breadcrumb-item active">Thao tác quyền</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <!-- end page title -->

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
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row gx-lg-5">
                        <div class="col-xl-4 col-md-8 mx-auto">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="text-uppercase">Sửa quyền</h5>
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('admin.permissions.update', $permission->id) }}" method="post">
                                        @csrf
                                        @method('put')
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="mb-3">
                                                    <label for="firstNameinput" class="form-label">Tên quyền</label>
                                                    <input type="text" class="form-control" name="name"
                                                        placeholder="Thêm bài viết" id="firstNameinput"
                                                        value="{{ $permission->name }}">
                                                    @error('name')
                                                        <span class="text-danger m-2">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div><!--end col-->

                                            <div class="col-12">
                                                <div class="mb-3">
                                                    <label for="compnayNameinput" class="form-label d-block">Slug</label>
                                                    <i class="text-muted ">Ví dụ: post.add</i>
                                                    <input type="text" class="form-control" name="slug"
                                                        placeholder="post.add" id="compnayNameinput"
                                                        value="{{ $permission->slug }}">
                                                    @error('slug')
                                                        <span class="text-danger m-2">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="mb-3">
                                                    <label for="citynameInput" class="form-label">Mô tả quyền</label>
                                                    <textarea name="description" rows="5" class="form-control">{{ $permission->description }}</textarea>
                                                </div>
                                            </div><!--end col-->

                                            <div class="col-lg-12">
                                                <div class="text-end">
                                                    <button type="submit" class="btn btn-primary">Submit</button>
                                                </div>
                                            </div><!--end col-->
                                        </div><!--end row-->
                                    </form>
                                </div>
                            </div>

                        </div>
                        <!-- end col -->

                        <div class="col-xl-8">
                            <div class="mt-xl-0 mt-5">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="text-uppercase">Danh sách quyền</h5>
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th scope="col">STT</th>
                                                    <th scope="col">Tên quyền</th>
                                                    <th scope="col">Slug</th>
                                                    <th scope="col">Mô tả quyền</th>
                                                    <th scope="col">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody class="align-items-center">
                                                @php
                                                    $t = 0;
                                                @endphp
                                                @if (count($list_permission) > 0)
                                                    @foreach ($list_permission as $nameSlugPermission => $arrayPermission)
                                                        <tr>
                                                            <td></td>
                                                            <td colspan="4">
                                                                <span class="text-uppercase font-weight-bold"
                                                                    style="font-weight: 800">
                                                                    Module {{ $nameSlugPermission }}
                                                                </span>
                                                            </td>
                                                        </tr>
                                                        @foreach ($arrayPermission as $permission)
                                                            @php
                                                                $t++;
                                                            @endphp
                                                            <tr>
                                                                <th scope="row">{{ $t }}</th>
                                                                <td>|---{{ $permission->name }}</td>
                                                                <td><span
                                                                        class="badge bg-primary-subtle text-primary">{{ $permission->slug }}</span>
                                                                </td>
                                                                <td>{{ $permission->description }}</td>
                                                                <td class="d-flex gap-2">
                                                                    @can('permission.delete')
                                                                        <a onclick="return confirm('Bạn có muốn xoá quyền {{ $permission->name }} hay không?')"
                                                                            href="{{ route('admin.permissions.destroy', $permission->id) }}"
                                                                            class="p-1 bg-danger rounded-3 text-white font-weight-bold"><i
                                                                                class="ri-delete-bin-line"></i></a>
                                                                    @endcan
                                                                    @can('permission.edit')
                                                                        <a href="{{ route('admin.permissions.edit', $permission->id) }}"
                                                                            class="p-1 bg-primary rounded-3 text-white font-weight-bold"><i
                                                                                class="ri-pencil-fill"></i></a>
                                                                    @endcan

                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @endforeach
                                                @else
                                                    <tr>
                                                        <td colspan="5">Không có bản ghi nào tồn tại</td>
                                                    </tr>
                                                @endif

                                            </tbody>
                                        </table>
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
@endsection
@section('script')
    <script src="{{ asset('assets/js/pages/ecommerce-product-details.init.js') }}"></script>
@endsection
