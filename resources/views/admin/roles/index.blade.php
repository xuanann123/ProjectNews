@extends('admin.layouts.master')
@section('title')
    Danh sách danh mục
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
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Danh sách vai trò</h4>
                </div><!-- end card header -->

                <div class="card-body">
                    <div class="listjs-table" id="customerList">
                        <div class="row g-3 mb-3">
                            @can('role.add')
                                <div class="col-sm-auto">
                                <div>
                                    <a href="{{ route('admin.roles.create') }}">
                                        <button type="button" class="btn btn-success add-btn" id="create-btn"
                                            data-bs-target="#showModal"><i class="ri-add-line align-bottom me-1"></i> Thêm
                                            vai trò </button>
                                    </a>
                                </div>
                            </div>
                            @endcan
                            


                            <div class="col-sm">
                                <form action="{{ route('admin.categories.list') }}">
                                    <div class="d-flex justify-content-sm-end">
                                        <div class="search-box me-2">
                                            <input type="text" name="keyword" class="form-control"
                                                placeholder="Search..." value="{{ request()->input('keyword') }}">
                                            <i class="ri-search-line search-icon"></i>
                                        </div>
                                        <input type="text" hidden name="status"
                                            value="{{ request()->input('status') }}">
                                        <button class="btn btn-primary">Tìm kiếm</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <form action="{{ route('admin.categories.action') }}" method="get">
                            @csrf
                            <div class="table-responsive table-card mt-3 mb-1">
                                <table class="table align-middle table-nowrap" id="customerTable">
                                    <thead class="table-light">
                                        <tr>
                                            <th scope="col" style="width: 50px;">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="selectAll"
                                                        value="option">
                                                </div>
                                            </th>
                                            <th class="sort" data-sort="id">STT</th>
                                            <th class="sort" data-sort="customer_name">Vai trò</th>
                                            <th class="sort" data-sort="email">Mô tả vai trò</th>
                                            <th class="sort" data-sort="date">Ngày sửa</th>
                                            <th class="sort" data-sort="status">Ngày tạo</th>
                                            <th class="sort" data-sort="action">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="list form-check-all">
                                        @php
                                            $t = 0;
                                        @endphp
                                        @if ($data->count() > 0)
                                            @foreach ($data as $item)
                                                @php
                                                    $t++;
                                                @endphp
                                                <tr>
                                                    <th scope="row">
                                                        <div class="form-check">
                                                            <input class="form-check-input checkbox" type="checkbox"
                                                                name="list_check[]" value="{{ $item->id }}">
                                                        </div>
                                                    </th>
                                                    <td class="id">{{ $t }}</td>

                                                    <td class="customer_name"><a href="{{ route("admin.roles.edit", $item->id) }}">{{ $item->name }}</a></td>
                                                    <td class="email">{{ $item->description }}</td>


                                                    <td class="date">{{ $item->updated_at }}</td>
                                                    <td class="status">{{ $item->created_at }} </td>
                                                    <td>
                                                        @if (request()->status !== 'trash')
                                                            <div class="d-flex gap-2">
                                                                @can('role.edit')
                                                                    <div class="edit">
                                                                        <a href="{{ route('admin.roles.edit', $item->id) }}">
                                                                            <span
                                                                                class="btn btn-sm btn-success edit-item-btn">Sửa
                                                                            </span>
                                                                        </a>
                                                                    </div>
                                                                @endcan

                                                                @can('role.delete')
                                                                    <div class="remove">
                                                                        <span class="btn btn-sm btn-danger remove-item-btn"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#deleteRecordModal2">Xoá</span>
                                                                    </div>
                                                                    <div class="modal fade zoomIn" id="deleteRecordModal2"
                                                                        tabindex="-1" aria-hidden="true">
                                                                        <div class="modal-dialog modal-dialog-centered">
                                                                            <div class="modal-content">
                                                                                <div class="modal-header">
                                                                                    <button type="button" class="btn-close"
                                                                                        data-bs-dismiss="modal"
                                                                                        aria-label="Close"
                                                                                        id="btn-close"></button>
                                                                                </div>
                                                                                <div class="modal-body">
                                                                                    <div class="mt-2 text-center">
                                                                                        <lord-icon
                                                                                            src="https://cdn.lordicon.com/gsqxdxog.json"
                                                                                            trigger="loop"
                                                                                            colors="primary:#f7b84b,secondary:#f06548"
                                                                                            style="width:100px;height:100px"></lord-icon>
                                                                                        <div
                                                                                            class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                                                                                            <h4>Bạn chắc chắn không?</h4>
                                                                                            <p class="text-muted mx-4 mb-0">Bạn
                                                                                                có
                                                                                                muốn
                                                                                                xoá quyền
                                                                                                {{ $item->name }}
                                                                                            </p>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div
                                                                                        class="d-flex gap-2 justify-content-center mt-4 mb-2">
                                                                                        <button type="button"
                                                                                            class="btn w-sm btn-light"
                                                                                            data-bs-dismiss="modal">Tôi
                                                                                            không</button>
                                                                                        <a
                                                                                            href="{{ route('admin.roles.destroy', $item->id) }}"><button
                                                                                                type="button"
                                                                                                class="btn w-sm btn-danger ">Vâng,
                                                                                                xoá
                                                                                                nó!</button></a>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endcan

                                                            </div>
                                                        @else
                                                            <div class="d-flex gap-2">

                                                                <div class="remove">
                                                                    <span class="btn btn-sm btn-primary remove-item-btn"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#deleteRecordModal2">Khôi
                                                                        phục</span>
                                                                </div>
                                                                <div class="modal fade zoomIn" id="deleteRecordModal2"
                                                                    tabindex="-1" aria-hidden="true">
                                                                    <div class="modal-dialog modal-dialog-centered">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <button type="button" class="btn-close"
                                                                                    data-bs-dismiss="modal"
                                                                                    aria-label="Close"
                                                                                    id="btn-close"></button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <div class="mt-2 text-center">
                                                                                    <lord-icon
                                                                                        src="https://cdn.lordicon.com/gsqxdxog.json"
                                                                                        trigger="loop"
                                                                                        colors="primary:#f7b84b,secondary:#f06548"
                                                                                        style="width:100px;height:100px"></lord-icon>
                                                                                    <div
                                                                                        class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                                                                                        <h4>Bạn chắc chắn không?</h4>
                                                                                        <p class="text-muted mx-4 mb-0">Bạn
                                                                                            có
                                                                                            muốn
                                                                                            khôi phục {{ $item->name }}
                                                                                        </p>
                                                                                    </div>
                                                                                </div>
                                                                                <div
                                                                                    class="d-flex gap-2 justify-content-center mt-4 mb-2">
                                                                                    <button type="button"
                                                                                        class="btn w-sm btn-light"
                                                                                        data-bs-dismiss="modal">Tôi
                                                                                        không</button>
                                                                                    <a
                                                                                        href="{{ route('admin.categories.restore', $item->id) }}"><button
                                                                                            type="button"
                                                                                            class="btn w-sm btn-danger ">Vâng,
                                                                                            khôi phục nó!</button></a>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>





                                                                <div class="remove">
                                                                    <span class="btn btn-sm btn-danger remove-item-btn"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#deleteRecordModal3">Xoá vĩnh
                                                                        viễn</span>
                                                                </div>
                                                                <div class="modal fade zoomIn" id="deleteRecordModal3"
                                                                    tabindex="-1" aria-hidden="true">
                                                                    <div class="modal-dialog modal-dialog-centered">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <button type="button" class="btn-close"
                                                                                    data-bs-dismiss="modal"
                                                                                    aria-label="Close"
                                                                                    id="btn-close"></button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <div class="mt-2 text-center">
                                                                                    <lord-icon
                                                                                        src="https://cdn.lordicon.com/gsqxdxog.json"
                                                                                        trigger="loop"
                                                                                        colors="primary:#f7b84b,secondary:#f06548"
                                                                                        style="width:100px;height:100px"></lord-icon>
                                                                                    <div
                                                                                        class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                                                                                        <h4>Bạn chắc chắn không?</h4>
                                                                                        <p class="text-muted mx-4 mb-0">Bạn
                                                                                            có
                                                                                            muốn
                                                                                            xoá vĩnh viễn
                                                                                            {{ $item->name }}
                                                                                        </p>
                                                                                    </div>
                                                                                </div>
                                                                                <div
                                                                                    class="d-flex gap-2 justify-content-center mt-4 mb-2">
                                                                                    <button type="button"
                                                                                        class="btn w-sm btn-light"
                                                                                        data-bs-dismiss="modal">Tôi
                                                                                        không</button>
                                                                                    <a
                                                                                        href="{{ route('admin.categories.forceDelete', $item->id) }}"><button
                                                                                            type="button"
                                                                                            class="btn w-sm btn-danger ">Vâng,
                                                                                            xoá nó!</button></a>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif

                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="7">
                                                    <div class="d-flex gap-2 ">
                                                        <p>Không có danh mục nào tồn tại</p>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                                <script>
                                    document.getElementById('selectAll').addEventListener('change', function() {
                                        var checkboxes = document.querySelectorAll('.checkbox');
                                        for (var checkbox of checkboxes) {
                                            checkbox.checked = this.checked;
                                        }
                                    });
                                </script>
                                <div class="noresult" style="display: none">
                                    <div class="text-center">
                                        <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop"
                                            colors="primary:#121331,secondary:#08a88a"
                                            style="width:75px;height:75px"></lord-icon>
                                        <h5 class="mt-2">Sorry! No Result Found</h5>
                                        <p class="text-muted mb-0">We've searched more than 150+ Orders We did not find any
                                            orders for you search.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end">
                                <div class="pagination-wrap hstack gap-2">
                                    <a class="page-item pagination-prev disabled" href="javascript:void(0);">
                                        Previous
                                    </a>
                                    <ul class="pagination listjs-pagination mb-0"></ul>
                                    <a class="page-item pagination-next" href="javascript:void(0);">
                                        Next
                                    </a>
                                </div>
                            </div>

                        </form>
                    </div>
                </div><!-- end card -->
            </div>
            <!-- end col -->
        </div>
        <!-- end col -->
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
