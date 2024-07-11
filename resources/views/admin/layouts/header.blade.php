@php
    #NOTIFICATION COMMENT
    $commentNotifications = \App\Models\CommentNotification::where('is_read', false)
        ->orderBy('created_at', 'desc')
        ->get();
    #NOTIFICATION COMMENT
    $messageNotifications = \App\Models\ContactMessage::where('is_read', false)->orderBy('created_at', 'desc')->get();
@endphp

<header id="page-topbar">
    <div class="layout-width">
        <div class="navbar-header">
            <div class="d-flex">
                <!-- LOGO -->
                <div class="navbar-brand-box horizontal-logo">
                    <a href="{{ route('admin.dashboard') }}" class="logo logo-dark">
                        <span class="logo-sm">
                            <img src="{{ asset('assets/images/logo-sm.png') }}" alt="" height="22">
                        </span>
                        <span class="logo-lg">
                            <img src="{{ asset('assets/images/logo-dark.png') }}" alt="" height="17">
                        </span>
                    </a>

                    <a href="{{ route('admin.dashboard') }}" class="logo logo-light">
                        <span class="logo-sm">
                            <img src="{{ asset('assets/images/logo-sm.png') }}" alt="" height="22">
                        </span>
                        <span class="logo-lg">
                            <img src="{{ asset('assets/images/logo-light.png') }}" alt="" height="17">
                        </span>
                    </a>
                </div>

            </div>

            <div class="d-flex align-items-center">
                <div class="dropdown topbar-head-dropdown ms-1 header-item" id="notificationDropdown">
                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle"
                        id="page-header-notifications-dropdown" data-bs-toggle="dropdown"
                        data-bs-auto-close="outside" aria-haspopup="true" aria-expanded="false">
                        <i class='bx bx-bell fs-22'></i>
                        @php
                            $countNotification = count($messageNotifications) + count($commentNotifications);
                        @endphp
                        <span
                            class="position-absolute topbar-badge fs-10 translate-middle badge rounded-pill bg-danger">{{ $countNotification }}<span
                                class="visually-hidden">unread messages</span></span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                        aria-labelledby="page-header-notifications-dropdown">

                        <div class="dropdown-head bg-primary bg-pattern rounded-top">
                            <div class="p-3">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h6 class="m-0 fs-16 fw-semibold text-white"> Thông báo </h6>
                                    </div>
                                    <div class="col-auto dropdown-tabs">
                                        <span class="badge bg-light-subtle text-body fs-13">
                                            ({{ $countNotification }})</span>
                                    </div>
                                </div>
                            </div>

                            <div class="px-2 pt-2">
                                <ul class="nav nav-tabs dropdown-tabs nav-tabs-custom" data-dropdown-tabs="true"
                                    id="notificationItemsTab" role="tablist">
                                    <li class="nav-item waves-effect waves-light">
                                        <a class="nav-link active" data-bs-toggle="tab" href="#all-noti-tab"
                                            role="tab" aria-selected="true">
                                            Bình luận({{ count($commentNotifications) }})
                                        </a>
                                    </li>
                                    <li class="nav-item waves-effect waves-light">
                                        <a class="nav-link" data-bs-toggle="tab" href="#messages-tab" role="tab"
                                            aria-selected="false">
                                            Tin nhắn mail ({{ count($messageNotifications) }})
                                        </a>
                                    </li>

                                </ul>
                            </div>

                        </div>

                        <div class="tab-content position-relative" id="notificationItemsTabContent">
                            <div class="tab-pane fade show active py-2 ps-2" id="all-noti-tab" role="tabpanel">
                                <div data-simplebar style="max-height: 300px;" class="pe-2">
                                    <form action="{{ route('admin.readed') }}" method="post">
                                        @csrf
                                        <div data-simplebar style="max-height: 300px;" class="pe-2">
                                            @if ($commentNotifications->count() > 0)
                                                @foreach ($commentNotifications as $notication)
                                                    <div class="text-reset notification-item d-block dropdown-item">
                                                        <div class="d-flex">
                                                            @php
                                                                $url = Storage::url($notication->comment->user->image);
                                                            @endphp
                                                            @if ($notication->comment->user->image)
                                                                <img src="{{ $url }}"
                                                                    class="me-3 rounded-circle avatar-xs"
                                                                    alt="user-pic">
                                                            @else
                                                                <img src="{{ url('image/notimage.webp') }}"
                                                                    class="me-3 rounded-circle avatar-xs"
                                                                    alt="user-pic">
                                                            @endif

                                                            <div class="flex-grow-1">
                                                                <a href="{{ route('post.detail', ['id' => $notication->comment->post->id, 'slug' => $notication->comment->post->slug]) }}"
                                                                    class="stretched-link">
                                                                    <h6 class="mt-0 mb-1 fs-13 fw-semibold">
                                                                        {{ $notication->comment->user->name }}</h6>
                                                                </a>
                                                                <div class="fs-13 text-muted">
                                                                    <p class="mb-1">
                                                                        {{ $notication->comment->content }}
                                                                    </p>
                                                                </div>
                                                                <p
                                                                    class="mb-0 fs-11 fw-medium text-uppercase text-muted">
                                                                    <span><i class="mdi mdi-clock-outline"></i>
                                                                        {{ date('d-m-Y', strtotime($notication->created_at)) }}</span>
                                                                </p>
                                                            </div>
                                                            <div class="px-2 fs-15">
                                                                <div class="form-check notification-check">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        name="list_notification_check[]"
                                                                        value="{{ $notication->id }}"
                                                                        id="messages-notification-check01">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @else
                                                <p>Không có thông báo mới nào</p>
                                            @endif

                                            <div class="my-3 text-center view-all">
                                                <button type="submit"
                                                    class="btn btn-soft-success waves-effect waves-light">Đã đọc toàn
                                                    bộ<i class="ri-arrow-right-line align-middle"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div class="tab-pane fade py-2 ps-2" id="messages-tab" role="tabpanel"
                                aria-labelledby="messages-tab">
                                <div data-simplebar style="max-height: 300px;" class="pe-2">
                                    <form action="{{ route('admin.watched') }}" method="post">
                                        @csrf
                                        <div data-simplebar style="max-height: 300px;" class="pe-2">
                                            @if (count($messageNotifications) > 0)
                                                @foreach ($messageNotifications as $notication)
                                                    <div class="text-reset notification-item d-block dropdown-item">
                                                        <div class="d-flex">
                                                            @php
                                                                $user = \App\Models\User::where(
                                                                    'email',
                                                                    $notication->email,
                                                                )->get();
                                                                $url = Storage::url($user['0']->image);
                                                            @endphp
                                                            @if (count($user) > 0)
                                                                <img src="{{ $url }}"
                                                                    class="me-3 rounded-circle avatar-xs"
                                                                    alt="user-pic">
                                                            @endif


                                                            <div class="flex-grow-1">
                                                                <a href="https://mail.google.com/mail/u/0/?hl=vi#inbox"
                                                                    class="stretched-link">
                                                                    <h6 class="mt-0 mb-1 fs-13 fw-semibold">
                                                                        {{ $notication->name }}</h6>
                                                                </a>
                                                                <div class="fs-13 text-muted">
                                                                    <p class="mb-1">{{ $notication->message }}
                                                                    </p>
                                                                </div>
                                                                <p
                                                                    class="mb-0 fs-11 fw-medium text-uppercase text-muted">
                                                                    <span><i class="mdi mdi-clock-outline"></i>
                                                                        {{ date('d-m-Y', strtotime($notication->created_at)) }}</span>
                                                                </p>
                                                            </div>
                                                            <div class="px-2 fs-15">
                                                                <div class="form-check notification-check">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        name="list_notification_check[]"
                                                                        value="{{ $notication->id }}"
                                                                        id="messages-notification-check01">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @else
                                                <p>Không có thông báo mới nào</p>
                                            @endif

                                            <div class="my-3 text-center view-all">
                                                <button type="submit"
                                                    class="btn btn-soft-success waves-effect waves-light">Đã đọc toàn
                                                    bộ<i class="ri-arrow-right-line align-middle"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="tab-pane fade p-4" id="alerts-tab" role="tabpanel"
                                aria-labelledby="alerts-tab"></div>

                            <div class="notification-actions" id="notification-actions">
                                <div class="d-flex text-muted justify-content-center">
                                    Select <div id="select-content" class="text-body fw-semibold px-1">0</div>
                                    Result <button type="button" class="btn btn-link link-danger p-0 ms-3"
                                        data-bs-toggle="modal"
                                        data-bs-target="#removeNotificationModal">Remove</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="dropdown ms-sm-3 header-item topbar-user">
                    <button type="button" class="btn" id="page-header-user-dropdown" data-bs-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <span class="d-flex align-items-center">
                            @if (Auth::user()->image)
                                @php
                                    $url = Storage::url(Auth::user()->image);
                                @endphp

                                <img style="height: 3.4rem!important;width: auto!important;"
                                    class="rounded-circle header-profile-user" src="{{ $url }}"
                                    alt="Header Avatar">
                            @else
                                <img style="height: 3.4rem!important;width: auto!important;"
                                    class="rounded-circle header-profile-user" src="{{ url('image/notimage.webp') }}"
                                    alt="Header Avatar">
                            @endif

                            <span class="text-start ms-xl-2">
                                <span
                                    class="d-none d-xl-inline-block ms-1 fw-medium user-name-text">{{ Auth::user()->name }}</span>
                                <span
                                    class="d-none d-xl-block ms-1 fs-12 user-name-sub-text">{{ Auth::user()->type }}</span>
                            </span>
                        </span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        <!-- item-->
                        <h6 class="dropdown-header">Welcome {{ Auth::user()->name }}!</h6>
                        <a class="dropdown-item" href="{{ route('admin.users.detail', Auth::user()->id) }}"><i
                                class="mdi mdi-account-circle text-muted fs-16 align-middle me-1"></i> <span
                                class="align-middle">Profile</span></a>
                        <a class="dropdown-item" href="{{ route('admin.users.edit', Auth::user()->id) }}"><span
                                class="badge bg-success-subtle text-success mt-1 float-end">New</span><i
                                class="mdi mdi-cog-outline text-muted fs-16 align-middle me-1"></i> <span
                                class="align-middle">Settings</span></a>
                        <div class="dropdown-divider"></div>

                        <a class="dropdown-item" href="{{ route('home') }}"><i
                                class="mdi mdi-home text-muted fs-16 align-middle me-1"></i> <span
                                class="align-middle">Home</span></a>
                        <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                            <i class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i>
                            {{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
