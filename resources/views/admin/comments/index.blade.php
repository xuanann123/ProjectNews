@extends('admin.layouts.master')
@section('title')
    Danh sách comment
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Quản lý comment</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.comments.index') }}">Quản lý comment</a></li>
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
                    <h4 class="card-title mb-0">Danh sách slider</h4>
                </div><!-- end card header -->

                <div class="card-body">
                    <div class="listjs-table" id="customerList">
                        <div class="row g-3 mb-3">
                            <div class="col-sm">
                                <form action="{{ route('admin.slides.index') }}">
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
                        <form action="{{ route('admin.slides.action') }}" method="get">
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
                                            <th class="sort" data-sort="stt">STT</th>
                                            <th class="sort" data-sort="customer_name">Nội dung</th>
                                            <th class="sort" data-sort="email">Người bình luận</th>
                                            <th class="sort" data-sort="phone">Bài viết</th>
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
                                                    $level = "";
                                                @endphp
                                               @include('admin.layouts.subcomment', ['item'=> $item])
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
