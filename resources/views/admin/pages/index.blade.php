@extends('admin.layouts.master')
@section('title')
    Danh sách page
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Quản lý giao diện</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.pages.index') }}">Quản lý page</a></li>
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
                    <h4 class="card-title mb-0">Danh sách Page</h4>
                </div><!-- end card header -->

                <div class="card-body">
                    <div class="listjs-table" id="customerList">
                        <div class="row g-3 mb-3">
                            @can('page.add')
                                <div class="col-sm-auto me-5">
                                    <div>
                                        <a href="{{ route('admin.pages.create') }}">
                                            <button type="button" class="btn btn-success add-btn" id="create-btn"
                                                data-bs-target="#showModal"><i class="ri-add-line align-bottom me-1"></i> Thêm
                                                page </button>
                                        </a>
                                    </div>
                                </div>
                            @endcan

                            <div class="col-sm-auto d-flex ms-5">

                                <h5 class="mt-2">Trạng thái page</h5>
                                <ul class="d-flex gap-3 mt-2">
                                    <li><a href="{{ request()->fullUrlWithQuery(['status' => 'all']) }}">Tất
                                            cả({{ $count[0] }})</a></li>
                                    <li><a href="{{ request()->fullUrlWithQuery(['status' => 'active']) }}">Kích
                                            hoạt({{ $count[1] }})</a></li>
                                    <li><a href="{{ request()->fullUrlWithQuery(['status' => 'pending']) }}">Chờ xác
                                            nhận({{ $count[2] }})</a></li>
                                    <li><a href="{{ request()->fullUrlWithQuery(['status' => 'trash']) }}">Vô hiệu
                                            hoá({{ $count[3] }})</a></li>
                                </ul>
                            </div>

                            <div class="col-sm">
                                <form action="{{ route('admin.pages.index') }}">
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
                        <form action="{{ route('admin.pages.action') }}" method="get">
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
                                            <th class="sort" data-sort="stt">STT</th>
                                            <th class="sort" data-sort="customer_name">Tiêu đề</th>
                                            <th class="sort" data-sort="phone">Nội dung</th>
                                            <th class="sort" data-sort="member">Người tạo</th>
                                            <th class="sort" data-sort="status">Trạng thái</th>
                                            <th class="sort" data-sort="status">Ngày tạo</th>
                                            <th class="sort" data-sort="action">Hoạt động</th>
                                        </tr>
                                    </thead>
                                    <tbody class="list form-check-all">
                                        @if ($data->count() > 0)
                                            @php
                                                $t = 0;
                                            @endphp
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
                                                    <td class="stt">{{ $t }}</td>

                                                    <td class="customer_name"><a
                                                            href="{{ route('admin.pages.edit', $item->id) }}">{{ $item->title }}</a>
                                                    </td>
                                                 
                                                    <td class="description">{!! $item->content !!}</td>

                                                    <td>
                                                        @php
                                                            $url = Storage::url($item->user->image);
                                                        @endphp
                                                        <a href="{{ route('admin.users.detail', $item->user->id) }}">
                                                            <div class="d-flex gap-2 align-items-center">
                                                                <div class="flex-shrink-0">
                                                                    <img src="{{ $url }}" alt=""
                                                                        class="avatar-xs rounded-circle" />
                                                                </div>
                                                                <div class="flex-grow-1">
                                                                    {{ $item->user->name }}
                                                                </div>
                                                            </div>
                                                        </a>

                                                    </td>
                                                    {{-- <td class="description">{{ $item->user->name }}</td> --}}
                                                    <td class="phone">
                                                        {!! $item->is_active
                                                            ? '<span class="badge bg-danger text-uppercase">Hoạt động</span>'
                                                            : '<span class="badge bg-info">Chờ duyệt</span>' !!}
                                                    </td>
                                                    <td class="status">{{ $item->created_at }} </td>
                                                    <td>
                                                        @if (request()->status !== 'trash')
                                                            <div class="d-flex gap-2">
                                                                @can('page.edit')
                                                                    <div class="edit">
                                                                        <a href="{{ route('admin.pages.edit', $item->id) }}">
                                                                            <span
                                                                                class="btn btn-sm btn-success edit-item-btn">Sửa
                                                                            </span>
                                                                        </a>
                                                                    </div>
                                                                @endcan
                                                                @can('page.delete')
                                                                    <div class="remove">

                                                                        <a onclick="return confirm('Bạn có muốn xoá {{ $item->title }} không?')"
                                                                            href="{{ route('admin.pages.destroy', $item->id) }}"
                                                                            class="btn btn-sm btn-danger remove-item-btn">Xoá</a>
                                                                    </div>
                                                                @endcan

                                                            </div>
                                                        @else
                                                            <div class="d-flex gap-2">

                                                                @can('page.delete')
                                                                    <div class="restore">
                                                                        <a onclick="return confirm('Bạn có muốn khôi phục {{ $item->title }} không?')"
                                                                            href="{{ route('admin.pages.restore', $item->id) }}"><button
                                                                                type="button" class="btn w-sm btn-success ">
                                                                                Khôi phục</button></a>
                                                                    </div>
                                                                @endcan


                                                                @can('page.delete')
                                                                    <div class="remove">
                                                                        <a onclick="return confirm('Bạn có muốn xoá vĩnh viễn {{ $item->title }} không?')"
                                                                            href="{{ route('admin.pages.forceDelete', $item->id) }}"><button
                                                                                type="button"
                                                                                class="btn w-sm btn-danger ">Xoá</button></a>
                                                                    </div>
                                                                @endcan

                                                            </div>
                                                        @endif

                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="9">
                                                    <div class="text-center">
                                                        <lord-icon src="https://cdn.lordicon.com/msoeawqm.json"
                                                            trigger="loop" colors="primary:#121331,secondary:#08a88a"
                                                            style="width:75px;height:75px"></lord-icon>
                                                        <h5 class="mt-2">Xin lỗi chúng tôi không tìm thấy bản ghi nào
                                                        </h5>
                                                        <p class="text-muted mb-0">Bạn có thể đi thêm hoặc kiểm tra lại
                                                            phần tìm
                                                            kiếm!</p>
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
