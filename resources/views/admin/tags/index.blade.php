@extends('admin.layouts.master')
@section('title')
    Danh sách thẻ
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Quản nội dung</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.tags.index') }}">Quản lý thẻ</a></li>
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
                    <h4 class="card-title mb-0">Danh sách thẻ</h4>
                </div><!-- end card header -->

                <div class="card-body">
                    <div class="listjs-table" id="customerList">
                        <div class="row g-3 mb-3">
                            @can('tag.add')
                                <div class="col-sm-auto me-5">
                                    <div>
                                        <a href="{{ route('admin.tags.create') }}">
                                            <button type="button" class="btn btn-success add-btn" id="create-btn"
                                                data-bs-target="#showModal"><i class="ri-add-line align-bottom me-1"></i> Thêm
                                                thẻ </button>
                                        </a>
                                    </div>
                                </div>
                            @endcan
                            @can('tag.edit')
                                <div class="col-sm-auto d-flex ms-5">
                                    <h5 class="mt-2">Chọn trạng thái thẻ</h5>
                                    <ul class="d-flex gap-3 mt-2">
                                        <li><a href="{{ request()->fullUrlWithQuery(['status' => 'all']) }}">Tất
                                                cả({{ $count[0] }})</a></li>
                                        <li><a href="{{ request()->fullUrlWithQuery(['status' => 'trash']) }}">Thùng
                                                rác({{ $count[1] }})</a></li>
                                    </ul>
                                </div>
                            @endcan

                            <div class="col-sm">
                                <form action="{{ route('admin.tags.index') }}">
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
                        <form action="{{ route('admin.tags.action') }}" method="get">
                            @csrf
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <div class="col-sm-auto d-flex  justify-content-end gap-2 h-100">
                                        <select class="form-select" name="act">
                                            <option value="0">Chọn thao tác trên nhiều bản ghi</option>
                                            @foreach ($list_act as $key => $value)
                                                <option value="{{ $key }}">{{ $value }}</option>
                                            @endforeach
                                        </select>
                                        <button type="submit" class="btn btn-secondary">Done</button>
                                    </div>
                                </div>
                            </div>
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
                                            <th class="sort" data-sort="customer_name">Tên thẻ</th>
                                            <th class="sort" data-sort="status">Ngày tạo</th>
                                            <th class="sort" data-sort="status">Ngày Sửa</th>
                                            <th class="sort" data-sort="action">Hoạt động</th>
                                        </tr>
                                    </thead>
                                    <tbody class="list form-check-all">
                                        @if ($data->count() > 0)
                                            @foreach ($data as $item)
                                                <tr>
                                                    <th scope="row">
                                                        <div class="form-check">
                                                            <input class="form-check-input checkbox" type="checkbox"
                                                                name="list_check[]" value="{{ $item->id }}">
                                                        </div>
                                                    </th>

                                                    <td class="customer_name"><a class="cursor-pointer"
                                                            style="cursor: pointer!important"
                                                            href="{{ route('admin.tags.edit', $item->id) }}">{{ $item->name }}</a>
                                                    </td>
                                                    <td class="status">{{ $item->created_at }} </td>
                                                    <td class="status">{{ $item->updated_at }} </td>
                                                    <td>
                                                        @if (request()->status !== 'trash')
                                                            <div class="d-flex gap-2">
                                                                @can('tag.edit')
                                                                    <div class="edit">
                                                                        <a href="{{ route('admin.tags.edit', $item->id) }}">
                                                                            <span
                                                                                class="btn btn-sm btn-success edit-item-btn">Sửa
                                                                            </span>
                                                                        </a>
                                                                    </div>
                                                                @endcan
                                                                @can('tag.delete')
                                                                    <div class="remove">
                                                                        <a href="{{ route('admin.tags.destroy', $item->id) }}"
                                                                            class="btn btn-sm btn-danger remove-item-btn"
                                                                            onclick="return confirm('Bạn có muốn xoá thẻ {{ $item->name }} không?')">Xoá</a>
                                                                    </div>
                                                                @endcan
                                                            </div>
                                                        @else
                                                            <div class="d-flex gap-2">
                                                                @can('tag.edit')
                                                                    <div class="remove">
                                                                        <a href="{{ route('admin.tags.restore', $item->id) }}"
                                                                            onclick="return confirm('Bạn có muốn khôi phục thẻ <br> {{ $item->name }} không?')"
                                                                            class="btn btn-sm btn-primary remove-item-btn">Khôi
                                                                            phục</a>
                                                                    </div>
                                                                @endcan
                                                                @can('tag.delete')
                                                                    <div class="remove">
                                                                        <a href="{{ route('admin.tags.forceDelete', $item->id) }}" class="btn btn-sm btn-danger remove-item-btn"
                                                                         onclick="return confirm('Bạn có muốn xoá vĩnh viễn thẻ <br> {{ $item->name }} không?')">Xoá vĩnh viễn</a>
                                                                    </div>
                                                                @endcan


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
                                                                                            xoá vĩnh viễn <br>
                                                                                            {{ $item->name }} không?
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
                                                                                        href="{{ route('admin.tags.forceDelete', $item->id) }}"><button
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
                                                <td colspan="4">
                                                    <div class="text-center">
                                                        <lord-icon src="https://cdn.lordicon.com/msoeawqm.json"
                                                            trigger="loop" colors="primary:#121331,secondary:#08a88a"
                                                            style="width:75px;height:75px"></lord-icon>
                                                        <h5 class="mt-2">Xin lỗi chúng tôi không tìm thấy bản ghi nào
                                                        </h5>
                                                        <p class="text-muted mb-0">Bạn có thể đi thêm hoặc kiểm tra lại
                                                            phần tìm kiếm!</p>
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
