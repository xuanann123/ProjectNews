@extends('admin.layouts.master')
@section('title')
    Quản lý người dùng
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Quản lý người dùng</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Quản lý tài người</a></li>
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
                        <div class="col-sm-auto me-5">
                            <div>
                                <a href="{{ route('admin.users.create') }}">
                                    <button type="button" class="btn btn-success add-btn" id="create-btn"
                                        data-bs-target="#showModal"><i class="ri-add-line align-bottom me-1"></i> Thêm
                                        người dùng </button>
                                </a>
                            </div>
                        </div>
                        <div class="col-sm-auto d-flex ms-5">

                            <h5 class="mt-2">Chọn trạng thái của người dùng</h5>
                            <ul>
                                <li><a href="{{ request()->fullUrlWithQuery(['status' => 'active']) }}">Kích
                                        hoạt({{ $count[0] }})</a></li>
                                <li><a href="{{ request()->fullUrlWithQuery(['status' => 'trash']) }}">Vô hiệu
                                        hoá({{ $count[1] }})</a></li>
                            </ul>
                        </div>


                        <div class="col-sm">
                            <form action="{{ route('admin.users.list') }}">
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
                <form action="{{ route('admin.users.action') }}" method="get">
                    @csrf
                    <div class="card-body">
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
                        <table id="example" class="table table-bordered dt-responsive nowrap table-striped align-middle"
                            style="width:100%">
                            <thead>
                                <tr>

                                    <th scope="col" style="width: 50px;">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="selectAll" value="option">
                                        </div>
                                    </th>
                                    <th data-ordering="false">SR No.</th>

                                    <th>Họ tên</th>
                                    <th>Email</th>
                                    <th>Vai trò</th>
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

                                            <td>
                                                @php
                                                    $url = Storage::url($item->image);
                                                @endphp
                                                <div>
                                                    <a class="d-flex gap-2 align-items-center"
                                                        href="{{ route('admin.users.detail', $item->id) }}">
                                                        <div class="flex-shrink-0">
                                                            @if ($item->image)
                                                                <img src="{{ $url }}" alt=""
                                                                class="avatar-xs rounded-circle" />
                                                            @else
                                                                 <img src="{{ url("image/notimage.webp") }}" alt=""
                                                                class="avatar-xs rounded-circle" />
                                                            @endif
                                                            
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            {{ $item->name }}
                                                        </div>
                                                    </a>
                                                </div>
                                            </td>
                                            <td><span class="badge bg-info-subtle text-info">{{ $item->email }}</span>
                                            </td>
                                            <td>
                                                @if (count($item->roles) > 0)
                                                    @foreach ($item->roles as $role)
                                                        <a href="{{ route('admin.roles.edit', $role->id) }}"><span
                                                                class="badge bg-danger">{{ $role->name }}</span></a>
                                                    @endforeach
                                                @else
                                                    <span class="badge bg-primary">Member</span>
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
                                                            @can('user.show')
                                                                <li><a href="{{ route('admin.users.detail', $item->id) }}"
                                                                        class="dropdown-item"><i
                                                                            class="ri-eye-fill align-bottom me-2 text-muted"></i>
                                                                        View</a>
                                                                </li>
                                                            @endcan
                                                            @can('user.edit')
                                                                <li><a href="{{ route('admin.users.edit', $item->id) }}"
                                                                        class="dropdown-item edit-item-btn"><i
                                                                            class="ri-pencil-fill align-bottom me-2 text-muted"></i>
                                                                        Edit</a></li>
                                                            @endcan
                                                            @can('user.delete')
                                                                @if (Auth::id() != $item->id)
                                                                    <li>
                                                                        <a onclick='return confirm("Bạn có muốn xoá đi người dùng {{ $item->name }} không ?")'
                                                                            href="{{ route('admin.users.destroy', $item->id) }}"
                                                                            class="dropdown-item remove-item-btn">
                                                                            <i
                                                                                class="ri-delete-bin-fill align-bottom me-2 text-muted"></i>
                                                                            Delete
                                                                        </a>
                                                                    </li>
                                                                @endif
                                                            @endcan


                                                        </ul>
                                                    @else
                                                        <ul class="dropdown-menu dropdown-menu-end">
                                                            @if (Auth::id() != $item->id)
                                                                @can('user.edit')
                                                                    <li>
                                                                        <a onclick='return confirm("Bạn có muốn khôi phục người dùng {{ $item->name }} không ?")'
                                                                            href="{{ route('admin.users.restore', $item->id) }}"
                                                                            class="dropdown-item remove-item-btn">
                                                                            <i
                                                                                class="ri-restart-line align-bottom me-2 text-muted"></i>
                                                                            Restore
                                                                        </a>
                                                                    </li>
                                                                @endcan
                                                                @can('user.delete')
                                                                    <li>
                                                                        <a onclick='return confirm("Bạn có muốn xoá đi người dùng {{ $item->name }} không ?")'
                                                                            href="{{ route('admin.users.forceDelete', $item->id) }}"
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
                                        <td colspan="7">Không tồi tại tài khoản User nào trong hệ thống</td>
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
