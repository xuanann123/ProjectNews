@extends('admin.layouts.master')
@section('title')
    Quản lý bài viết
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Quản lý nội dung</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="j{{ route('admin.posts.index') }}">Quản lý bài viết</a></li>
                        <li class="breadcrumb-item active">Danh sách</li>
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
                <div class="card-header">
                    <div class="row g-3">
                        @can('post.add')
                            <div class="col-sm-auto">
                                <div>
                                    <a href="{{ route('admin.posts.create') }}">
                                        <button type="button" class="btn btn-success add-btn" id="create-btn"
                                            data-bs-target="#showModal"><i class="ri-add-line align-bottom me-1"></i> Thêm
                                            bài viết </button>
                                    </a>
                                </div>
                            </div>
                        @endcan
                        @can('post.edit')
                            <div class="col-sm-auto d-flex ms-1">
                                <h5 class="mt-2"> Trạng thái</h5>
                                <ul class="d-flex mt-2">
                                    <li class="list-unstyled me-3"><a
                                            href="{{ request()->fullUrlWithQuery(['status' => 'all']) }}">All({{ $count[0] }})</a>
                                    </li>
                                    <li class="list-unstyled me-3"><a
                                            href="{{ request()->fullUrlWithQuery(['status' => 'active']) }}">Active({{ $count[1] }})</a>
                                    </li>
                                    <li class="list-unstyled me-3"><a
                                            href="{{ request()->fullUrlWithQuery(['status' => 'showHome']) }}">Show
                                            Home({{ $count[2] }})</a>
                                    </li>
                                    <li class="list-unstyled me-3"><a
                                            href="{{ request()->fullUrlWithQuery(['status' => 'new']) }}">New({{ $count[3] }})</a>
                                    </li>
                                    <li class="list-unstyled me-3"><a
                                            href="{{ request()->fullUrlWithQuery(['status' => 'trend']) }}">Trending({{ $count[4] }})</a>
                                    </li>
                                    <li class="list-unstyled me-3"><a
                                            href="{{ request()->fullUrlWithQuery(['status' => 'pending']) }}">Pending({{ $count[5] }})</a>
                                    </li>
                                    <li class="list-unstyled me-3"><a
                                            href="{{ request()->fullUrlWithQuery(['status' => 'trash']) }}">Trash({{ $count[6] }})</a>
                                    </li>
                                </ul>
                            </div>
                        @endcan
                        <div class="col-sm">
                            <form action="{{ route('admin.posts.index') }}">
                                <div class="d-flex justify-content-sm-end">
                                    <div class="search-box me-2">
                                        <input type="text" name="keyword" class="form-control search"
                                            placeholder="Search..." value="{{ request()->input('keyword') }}">
                                        <i class="ri-search-line search-icon"></i>
                                    </div>
                                    <input type="text" hidden name="status" value="{{ request()->input('status') }}">
                                    <button class="btn btn-primary">Tìm kiếm</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <form action="{{ route('admin.posts.action') }}" method="get">
                    @csrf
                    <div class="card-body">
                        <div class="row mb-3">
                            @can('post.edit')
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
                            @endcan

                        </div>
                        <table id="example" class="table table-bordered dt-responsive nowrap table-striped align-middle"
                            style="width:100%">
                            <thead>
                                <tr>

                                    <th scope="col" style="width: 15px;">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="selectAll" value="option">
                                        </div>
                                    </th>
                                    <th data-ordering="false" style="width: 15px;">SR</th>

                                    <th>Tiêu đề</th>
                                    <th>Hình ảnh</th>
                                    <th>Người tạo</th>
                                    <th>Danh mục</th>
                                    <th>New</th>
                                    <th>Show Home</th>
                                    <th>Trending</th>
                                    <th>Status</th>
                                    <th>Tags</th>
                                    <th>Ngày tạo</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
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
                                            <td>{{ $t }}</td>
                                            <td><a
                                                    href="{{ route('admin.posts.detail', $item->id) }}">{{ $item->title }}</a>
                                            </td>

                                            <td>
                                                @php
                                                    $url = Storage::url($item->image);
                                                @endphp
                                                <div class="d-flex align-items-center">
                                                    <img src="{{ $url }}" alt="" width="100px" />
                                                </div>
                                            </td>
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

                                            <td><span style="font-size: 12px"
                                                    class="badge bg-primary text-white p-2">{{ $item->category ? $item->category->name : 'Không phân loại' }}</span>
                                            </td>
                                            <td class="phone">
                                                {!! $item->is_new
                                                    ? '<span class="badge bg-danger text-uppercase">Kích hoạt</span>'
                                                    : '<span class="badge bg-info">Chờ duyệt</span>' !!}
                                            </td>
                                            <td class="phone">
                                                {!! $item->is_show_home
                                                    ? '<span class="badge bg-danger text-uppercase">Kích hoạt</span>'
                                                    : '<span class="badge bg-info">Chờ duyệt</span>' !!}
                                            </td>
                                            <td class="phone">
                                                {!! $item->is_trending
                                                    ? '<span class="badge bg-danger text-uppercase">Kích hoạt</span>'
                                                    : '<span class="badge bg-info">Chờ duyệt</span>' !!}
                                            </td>
                                            <td class="phone">
                                                {!! $item->is_active
                                                    ? '<span class="badge bg-danger text-uppercase">Kích hoạt</span>'
                                                    : '<span class="badge bg-info">Chờ duyệt</span>' !!}
                                            </td>
                                            <td>
                                                @if ($item->tags->count() > 0)
                                                    @foreach ($item->tags as $tag)
                                                        <span
                                                            class="badge bg-danger text-uppercase">{{ $tag->name }}</span>
                                                    @endforeach
                                                @endif
                                            </td>



                                            <td>{{ $item->created_at }}</td>
                                            <td>
                                                <div class="dropdown d-inline-block">
                                                    <button class="btn btn-soft-secondary btn-sm dropdown" type="button"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="ri-more-fill align-middle"></i>
                                                    </button>
                                                    @if (request()->input('status') !== 'trash')
                                                        <ul class="dropdown-menu dropdown-menu-end">
                                                            @can('post.show')
                                                                <li><a href="{{ route('admin.posts.detail', $item->id) }}"
                                                                        class="dropdown-item"><i
                                                                            class="ri-eye-fill align-bottom me-2 text-muted"></i>
                                                                        View</a>
                                                                </li>
                                                            @endcan

                                                            @can('post.edit')
                                                                <li><a href="{{ route('admin.posts.edit', $item->id) }}"
                                                                        class="dropdown-item edit-item-btn"><i
                                                                            class="ri-pencil-fill align-bottom me-2 text-muted"></i>
                                                                        Edit</a></li>
                                                            @endcan

                                                            @can('post.delete')
                                                                <li>
                                                                    <a onclick='return confirm("Bạn có muốn xoá đi bài viết {{ $item->title }} không ?")'
                                                                        href="{{ route('admin.posts.destroy', $item->id) }}"
                                                                        class="dropdown-item remove-item-btn">
                                                                        <i
                                                                            class="ri-delete-bin-fill align-bottom me-2 text-muted"></i>
                                                                        Delete
                                                                    </a>
                                                                </li>
                                                            @endcan


                                                        </ul>
                                                    @else
                                                        <ul class="dropdown-menu dropdown-menu-end">
                                                            @if (Auth::id() != $item->id)
                                                                @can('post.edit')
                                                                    <li>
                                                                        <a onclick='return confirm("Bạn có muốn khôi phục bài viết {{ $item->name }} không ?")'
                                                                            href="{{ route('admin.posts.restore', $item->id) }}"
                                                                            class="dropdown-item remove-item-btn">
                                                                            <i
                                                                                class="ri-restart-line align-bottom me-2 text-muted"></i>
                                                                            Restore
                                                                        </a>
                                                                    </li>
                                                                @endcan
                                                                @can('post.delete')
                                                                    <li>
                                                                        <a onclick='return confirm("Bạn có muốn xoá đi bài viết {{ $item->name }} không ?")'
                                                                            href="{{ route('admin.posts.forceDelete', $item->id) }}"
                                                                            class="dropdown-item remove-item-btn">
                                                                            <i
                                                                                class="ri-delete-bin-fill align-bottom me-2 text-muted"></i>
                                                                            Delete
                                                                        </a>
                                                                    </li>
                                                                @endcan
                                                            @endif
                                                        </ul>
                                                    @endif

                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="13">
                                            <div class="text-center">
                                                <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop"
                                                    colors="primary:#121331,secondary:#08a88a"
                                                    style="width:75px;height:75px"></lord-icon>
                                                <h5 class="mt-2">Xin lỗi chúng tôi không tìm thấy bản ghi nào</h5>
                                                <p class="text-muted mb-0">Bạn có thể đi thêm hoặc kiểm tra lại phần tìm
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
                    </div>
                </form>
            </div>
        </div><!--end col-->
    </div><!--end row-->
@endsection
@section('style-libs')
    <!--datatable css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
    <!--datatable responsive css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" />

    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
@endsection


@section('script-libs')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <!--datatable js-->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>

    <script src="{{ asset('assets/js/pages/datatables.init.js') }}"></script>
@endsection
