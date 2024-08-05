@extends('admin.layouts.master')
@section('title')
    Danh sách danh mục
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Quản lý nội dung</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.categories.list') }}">Quản lý danh mục</a></li>
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
                    <h4 class="card-title mb-0">Danh sách danh mục bài viết</h4>
                </div><!-- end card header -->

                <div class="card-body">
                    <div class="listjs-table" id="customerList">
                        <div class="row g-3 mb-3">
                            @can('category.add')
                                <div class="col-sm-auto">
                                    <div>
                                        <a href="{{ route('admin.categories.create') }}">
                                            <button type="button" class="btn btn-success add-btn" id="create-btn"
                                                data-bs-target="#showModal"><i class="ri-add-line align-bottom me-1"></i> Thêm
                                                danh mục </button>
                                        </a>
                                    </div>
                                </div>
                            @endcan

                            <div class="col-sm-auto d-flex ms-2">

                                <h5 class="mt-2">Trạng thái danh mục</h5>
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
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <div class="col-sm-auto d-flex  justify-content-end gap-2 h-100">
                                        <select class="form-select" name="act">
                                            <option value="0">Chọn thao tác trên nhiều bản ghi</option>
                                            @foreach ($listAction as $key => $value)
                                                <option value="{{ $key }}">{{ $value }}</option>
                                            @endforeach
                                        </select>
                                        <button type="submit" class="btn btn-secondary">Done</button>
                                    </div>
                                </div>
                            </div>
                            <div class="">
                                <table class="table align-middle table-nowrap">
                                    <thead class="table-light">
                                        <tr>
                                            <th scope="col" style="width: 50px;">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="selectAll"
                                                        value="option">
                                                </div>
                                            </th>
                                            <th class="sort" data-sort="customer_name">Tên danh mục</th>
                                            <th class="sort" data-sort="email">Mô tả danh mục</th>
                                            <th class="sort" data-sort="phone">Trạng thái</th>
                                            <th class="sort" data-sort="date">Ngày sửa</th>
                                            <th class="sort" data-sort="status">Ngày tạo</th>
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
                                                                name="listCheck[]" value="{{ $item->id }}">
                                                        </div>
                                                    </th>

                                                    <td class="customer_name"><a
                                                            href="{{ route('admin.categories.edit', $item->id) }}">{{ $item->name }}</a>
                                                    </td>
                                                    <td class="email">{{ $item->description }}</td>

                                                    <td class="phone">
                                                        {!! $item->is_active
                                                            ? '<span class="badge bg-danger text-uppercase">Hoạt động</span>'
                                                            : '<span class="badge bg-info">Chờ duyệt</span>' !!}
                                                    </td>
                                                    <td class="date">{{ $item->updated_at }}</td>
                                                    <td class="status">{{ $item->created_at }} </td>
                                                    <td>
                                                        @if (request()->status !== 'trash')
                                                            <div class="d-flex gap-2">
                                                                @can('category.edit')
                                                                    <div class="edit">
                                                                        <a
                                                                            href="{{ route('admin.categories.edit', $item->id) }}">
                                                                            <span
                                                                                class="btn btn-sm btn-success edit-item-btn">Sửa
                                                                            </span>
                                                                        </a>
                                                                    </div>
                                                                @endcan
                                                                @can('category.delete')
                                                                    <div class="remove">
                                                                        <a href="{{ route('admin.categories.destroy', $item->id) }}"
                                                                            onclick="return confirm('Bạn có muốn xoá danh mục {{ $item->name }} không?')"
                                                                            class="btn btn-sm btn-danger remove-item-btn">
                                                                            Xoá</a>
                                                                    </div>
                                                                @endcan

                                                            </div>
                                                        @else
                                                            <div class="d-flex gap-2">

                                                                @can('category.delete')
                                                                    <div class="remove">
                                                                        <a onclick="return confirm('Bạn có muốn khôi phục {{ $item->name }} không?')"
                                                                            href="{{ route('admin.categories.restore', $item->id) }}"
                                                                            class="btn btn-sm btn-primary remove-item-btn">Khôi
                                                                            phục</a>
                                                                    </div>
                                                                @endcan
                                                                @can('category.delete')
                                                                    <div class="remove">
                                                                        <a onclick="return confirm('Bạn có muốn xoá vĩnh viễn {{ $item->name }} không?')"
                                                                            href="{{ route('admin.categories.forceDelete', $item->id) }}"
                                                                            class="btn btn-sm btn-danger remove-item-btn">Xoá
                                                                            vĩnh
                                                                            viễn</a>
                                                                    </div>
                                                                @endcan
                                                            </div>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="7">
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
<div class="d-none">
    {{ $data->links() }}
</div>
                         
                        </form>
                           <div class="d-flex justify-content-end">
                            <div>
                                {{ $data->links() }}
                            </div>
                            </div>
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
