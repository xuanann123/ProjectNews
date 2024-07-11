@extends('admin.layouts.master')
@section('title')
    Dashboard
@endsection
@section('content')
    <div class="row">
        <div class="col">

            <div class="h-100">
                <div class="row mb-3 pb-1">
                    <div class="col-12">
                        <div class="d-flex align-items-lg-center flex-lg-row flex-column">
                            <div class="flex-grow-1">
                                <h4 class="fs-16 mb-1">Xin chào, {{ Auth::user()->name }}!</h4>
                                <p class="text-muted mb-0">Thống kê trang website tin tức của bạn.</p>
                            </div>
                            <div class="mt-3 mt-lg-0">
                                <form action="javascript:void(0);">
                                    <div class="row g-3 mb-0 align-items-center">
                                        <div class="col-sm-auto">
                                            <div class="input-group">
                                                <input type="text"
                                                    class="form-control border-0 dash-filter-picker shadow"
                                                    data-provider="flatpickr" data-range-date="true"
                                                    data-date-format="d M, Y"
                                                    data-deafult-date="01 Jan 2022 to 31 Jan 2022">
                                                <div class="input-group-text bg-primary border-primary text-white">
                                                    <i class="ri-calendar-2-line"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <!--end col-->
                                        <div class="col-auto">
                                            <a href="{{ route('admin.posts.create') }}"><button type="button"
                                                    class="btn btn-soft-success"><i
                                                        class="ri-add-circle-line align-middle me-1"></i> Thêm bài viết
                                                </button></a>

                                        </div>

                                        <div class="col-auto">
                                            <button type="button"
                                                class="btn btn-soft-info btn-icon waves-effect waves-light layout-rightside-btn"><i
                                                    class="ri-pulse-line"></i></button>
                                        </div>
                                        <!--end col-->
                                    </div>
                                    <!--end row-->
                                </form>
                            </div>
                        </div><!-- end card header -->
                    </div>
                    <!--end col-->
                </div>
                <!--end row-->

                <div class="row">
                    @php
                        $data = [
                            'Tổng bài viết' => [$count[0], '<i class="bx bx-news text-success"></i>', 'posts.index'],
                            'Tổng danh mục' => [$count[1], '<i class="bx bxs-category text-info"></i>','categories.list'],
                            'Tổng người quản trị' => [$count[2], '<i class="bx bx-user-circle text-danger"></i>','users.list'],
                            'Tổng Thành viên' => [$count[3], '<i class="bx bx-user-circle text-dark"></i>','users.list'],
                        ];
                    @endphp
                    @foreach ($data as $key => $value)
                        <div class="col-xl-3 col-md-6">
                            <!-- card -->
                            <div class="card card-animate">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1 overflow-hidden">
                                            <p class="text-uppercase fw-medium text-muted text-truncate mb-0">
                                                {{ $key }}
                                            </p>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <h5 class="text-success fs-14 mb-0">
                                                <i class="ri-arrow-right-up-line fs-13 align-middle"></i> +16.24 %
                                            </h5>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-end justify-content-between mt-4">
                                        <div>
                                            <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value"
                                                    data-target="559.25">{{ $value['0'] }}</span> </h4>
                                            <a href="{{ route("admin.".$value['2']) }}" class="text-decoration-underline">Chi tiết</a>
                                        </div>
                                        <div class="avatar-sm flex-shrink-0">
                                            <span class="avatar-title bg-success-subtle rounded fs-3">
                                                {!! $value['1'] !!}
                                            </span>
                                        </div>
                                    </div>
                                </div><!-- end card body -->
                            </div><!-- end card -->
                        </div><!-- end col -->
                    @endforeach
                </div>

                <div class="row">
                    <script>
                        document.addEventListener("DOMContentLoaded", function() {
                            var commentCounts = @json($countComment);
                            var commentCategories = @json($categoryComment);
                            var viewCounts = @json($countView);
                            var viewCategories = @json($categoryView);
                            var options = {
                                chart: {
                                    height: 350,
                                    type: 'line',
                                    toolbar: {
                                        show: false
                                    }
                                },
                                series: [{
                                        name: 'Comments',
                                        data: commentCounts
                                    },
                                    {
                                        name: 'Views',
                                        data: viewCounts
                                    }
                                ],
                                colors: ['#007bff', '#000000'],
                                dataLabels: {
                                    enabled: true
                                },
                                stroke: {
                                    curve: 'smooth'
                                },
                                title: {
                                    text: 'Statistical Post',
                                    align: 'left'
                                },
                                grid: {
                                    row: {
                                        colors: ['#f3f3f3', 'transparent'],
                                        opacity: 0.5
                                    },
                                },
                                xaxis: {
                                    categories: commentCategories,
                                    categories: viewCategories,
                                },
                                yaxis: [{
                                    title: {
                                        text: 'Comments',
                                    },
                                }]
                            }

                            var chart = new ApexCharts(document.querySelector("#customer_impression_charts"), options);
                            chart.render();
                        });
                    </script>
                    <div class="col-xl-9">
                        <div class="card">
                            <div class="card-body p-0 pb-2">
                                <div class="w-100">
                                    <div id="customer_impression_charts"></div>
                                </div>
                            </div><!-- end card body -->
                        </div><!-- end card -->
                    </div><!-- end col -->


                    <div class="col-xl-3">
                        <!-- card -->
                        <div class="row">
                            <div class="col-md-12 mt-4">
                                <div class="card card-animate">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1 overflow-hidden">
                                                <p class="text-uppercase fw-medium text-muted text-truncate mb-0">
                                                    Tổng số lượng bình luận
                                                </p>
                                            </div>

                                        </div>
                                        <div class="d-flex align-items-end justify-content-between mt-4">
                                            <div>
                                                <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value"
                                                        data-target="559.25">{{ $count_all_comment }}</span> </h4>
                                                <a href="" class="text-decoration-underline">Chi tiết</a>
                                            </div>
                                            <div class="avatar-sm flex-shrink-0">
                                                <span class="avatar-title bg-success-subtle rounded fs-3">
                                                    <i class="bx bx-message text-success"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div><!-- end card body -->
                                </div>
                            </div>
                            <div class="col-md-12 mt-4">
                                <div class="card card-animate">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1 overflow-hidden">
                                                <p class="text-uppercase fw-medium text-muted text-truncate mb-0">
                                                    Tổng số lượng Lượt xem
                                                </p>
                                            </div>

                                        </div>
                                        <div class="d-flex align-items-end justify-content-between mt-4">
                                            <div>
                                                <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value"
                                                        data-target="559.25">{{ $count_all_view }}</span> </h4>
                                                <a href="" class="text-decoration-underline">Chi tiết</a>
                                            </div>
                                            <div class="avatar-sm flex-shrink-0">
                                                <span class="avatar-title bg-success-subtle rounded fs-3">
                                                    <i class="bx bx-show text-success"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div><!-- end card body -->
                                </div>
                            </div>
                        </div>
                        <!-- end card -->
                    </div>

                </div>

            </div>

        </div>


    </div>
@endsection

@section('style-libs')
    <!-- jsvectormap css -->
    <link href="{{ asset('assets/libs/jsvectormap/css/jsvectormap.min.css') }}" rel="stylesheet" type="text/css" />

    <!--Swiper slider css-->
    <link href="{{ asset('assets/libs/swiper/swiper-bundle.min.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('script-libs')
    <!-- apexcharts -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <!-- Vector map-->
    <script src="{{ asset('assets/libs/jsvectormap/js/jsvectormap.min.js') }}"></script>
    <script src="{{ asset('assets/libs/jsvectormap/maps/world-merc.js') }}"></script>

    <!--Swiper slider js-->
    <script src="{{ asset('assets/libs/swiper/swiper-bundle.min.js') }}"></script>

    <!-- Dashboard init -->
    <script src="{{ asset('assets/js/pages/dashboard-ecommerce.init.js') }}"></script>
@endsection
