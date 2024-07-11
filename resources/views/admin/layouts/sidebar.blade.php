<!-- ========== App Menu ========== -->
<div class="app-menu navbar-menu" style="background: #000000!important">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <!-- Dark Logo-->
        <a href="{{ route('admin.dashboard') }}" class="logo logo-dark">
            <span class="logo-sm">
                <img src="{{ asset('assets/images/logo-sm.png') }}" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{ asset('assets/images/logo-dark.png') }}" alt="" height="17">
            </span>
        </a>
        <!-- Light Logo-->
        <a href="{{ route('admin.dashboard') }}" class="logo logo-light">
            <span class="logo-sm">
                <img src="{{ asset('assets/images/logo-sm.png') }}" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{ asset('assets/images/logo-light.png') }}" alt="" height="17">
            </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover"
            id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">

            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav">
                <li class="menu-title"><i class="ri-more-fill"></i> <span data-key="t-pages">Quản lý thống kê</span>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ route('admin.dashboard') }}"
                        aria-controls="sidebarDashboards">
                        <i class="ri-dashboard-2-line"></i> <span data-key="t-dashboards">Dashboards</span>
                    </a>
                    <a class="nav-link menu-link" href="#sidebarComment" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebarComment">
                        <i class="ri-account-circle-line"></i> <span data-key="t-authentication">Quản lý comment</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarComment">
                        <ul class="nav nav-sm flex-column">
                            @can('slide.show')
                                <li class="nav-item">
                                    <a href="{{ route('admin.comments.index') }}" class="nav-link" data-key="t-signin"> Danh
                                        sách
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </div>
                </li>
                <li class="menu-title"><i class="ri-more-fill"></i> <span data-key="t-pages">Quản lý giao diện</span>
                </li>
                @canany(['slide.edit', 'slide.add', 'slide.show', 'slide.delete'])
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="#sidebarFontend" data-bs-toggle="collapse" role="button"
                            aria-expanded="false" aria-controls="sidebarFontend">
                            <i class="ri-account-circle-line"></i> <span data-key="t-authentication">Quản lý slider</span>
                        </a>
                        <div class="collapse menu-dropdown" id="sidebarFontend">
                            <ul class="nav nav-sm flex-column">
                                @can('slide.add')
                                    <li class="nav-item">
                                        <a href="{{ route('admin.slides.create') }}" class="nav-link" data-key="t-signin">
                                            Thêm mới
                                        </a>
                                    </li>
                                @endcan
                                @can('slide.show')
                                    <li class="nav-item">
                                        <a href="{{ route('admin.slides.index') }}" class="nav-link" data-key="t-signin"> Danh
                                            sách
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </div>
                    </li>
                @endcanany
                @canany(['page.add', 'page.edit', 'page.delete', 'page.show'])
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="#sidebarPage" data-bs-toggle="collapse" role="button"
                            aria-expanded="false" aria-controls="sidebarPage">
                            <i class="ri-angularjs-line"></i> <span data-key="t-authentication">Quản lý trang</span>
                        </a>
                        <div class="collapse menu-dropdown" id="sidebarPage">
                            <ul class="nav nav-sm flex-column">
                                @can('page.add')
                                    <li class="nav-item">
                                        <a href="{{ route('admin.pages.create') }}" class="nav-link" data-key="t-signin">
                                            Thêm mới
                                        </a>
                                    </li>
                                @endcan
                                @can('page.show')
                                    <li class="nav-item">
                                        <a href="{{ route('admin.pages.index') }}" class="nav-link" data-key="t-signin">
                                            Danh
                                            sách
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </div>
                    </li>
                @endcanany
                <li class="menu-title"><span data-key="t-menu">Quản lý nội dung</span></li>
                @canany(['category.add', 'category.edit', 'category.delete', 'category.show'])
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="#sidebarCategory" data-bs-toggle="collapse" role="button"
                            aria-expanded="false" aria-controls="sidebarCategory">
                            <i class="bx bx-category-alt"></i> <span data-key="t-apps">Quản lý danh mục</span>
                        </a>

                        <div class="collapse menu-dropdown" id="sidebarCategory">
                            <ul class="nav nav-sm flex-column">
                                @can('category.add')
                                    <li class="nav-item">
                                        <a href="{{ route('admin.categories.create') }}" class="nav-link"
                                            data-key="t-one-page">
                                            Thêm danh mục
                                        </a>
                                    </li>
                                @endcan
                                @can('category.show')
                                    <li class="nav-item">
                                        <a href="{{ route('admin.categories.list') }}" class="nav-link"
                                            data-key="t-nft-landing"> Danh sách danh mục
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </div>
                    </li>
                @endcanany

                @canany(['post.add', 'post.edit', 'post.delete', 'post.show'])
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="#sidebarPost" data-bs-toggle="collapse" role="button"
                            aria-expanded="false" aria-controls="sidebarPost">
                            <i class="bx bxs-book-content"></i> <span data-key="t-apps">Quản lý bài viết</span>
                        </a>

                        <div class="collapse menu-dropdown" id="sidebarPost">
                            <ul class="nav nav-sm flex-column">
                                @can('post.add')
                                    <li class="nav-item">
                                        <a href="{{ route('admin.posts.create') }}" class="nav-link" data-key="t-mailbox">
                                            Thêm
                                            bài viết </a>
                                    </li>
                                @endcan
                                @can('post.show')
                                    <li class="nav-item">
                                        <a href="{{ route('admin.posts.index') }}" class="nav-link" data-key="t-mailbox">
                                            Danh
                                            sách bài viết </a>
                                    </li>
                                @endcan
                            </ul>
                        </div>
                    </li>
                @endcanany


                @canany(['tag.add', 'tag.edit', 'tag.delete', 'tag.show'])
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="#sidebarAppsTag" data-bs-toggle="collapse" role="button"
                            aria-expanded="false" aria-controls="sidebarAppsTag">
                            <i class="bx bxs-purchase-tag"></i> <span data-key="t-apps">Quản lý thẻ</span>
                        </a>
                        <div class="collapse menu-dropdown" id="sidebarAppsTag">
                            <ul class="nav nav-sm flex-column">
                                @can('tag.add')
                                    <li class="nav-item">
                                        <a href="{{ route('admin.tags.create') }}" class="nav-link"
                                            data-key="t-main-calender">
                                            Thêm thẻ</a>
                                    </li>
                                @endcan
                                @can('tag.show')
                                    <li class="nav-item">
                                        <a href="{{ route('admin.tags.index') }}" class="nav-link" data-key="t-month-grid">
                                            Danh sách thẻ</a>
                                    </li>
                                @endcan

                            </ul>
                        </div>
                    </li>
                @endcanany
                <li class="menu-title"><i class="ri-more-fill"></i> <span data-key="t-pages">Quản lý tài khoản và
                        quyền</span>
                </li>
                @canany(['user.edit', 'user.add', 'user.show', 'user.delete'])
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="#sidebarAuth" data-bs-toggle="collapse" role="button"
                            aria-expanded="false" aria-controls="sidebarAuth">
                            <i class="ri-account-circle-line"></i> <span data-key="t-authentic ation">Quản lý thành viên</span>
                        </a>
                        <div class="collapse menu-dropdown" id="sidebarAuth">
                            <ul class="nav nav-sm flex-column">
                                @can('user.add')
                                    <li class="nav-item">
                                        <a href="{{ route('admin.users.create') }}" class="nav-link" data-key="t-signin">
                                            Thêm mới
                                        </a>
                                    </li>
                                @endcan
                                @can('user.show')
                                    <li class="nav-item">
                                        <a href="{{ route('admin.users.list') }}" class="nav-link" data-key="t-signin"> Danh
                                            sách
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </div>
                    </li>
                @endcanany
                @canany(['role.add', 'role.edit', 'role.delete', 'role.show', 'permission.add', 'permission.edit',
                    'permission.delete', 'permission.show'])
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="#sidebarPermission" data-bs-toggle="collapse" role="button"
                            aria-expanded="false" aria-controls="sidebarPermission">
                            <i class="ri-angularjs-line"></i> <span data-key="t-authentication">Quản lý quyền</span>
                        </a>
                        <div class="collapse menu-dropdown" id="sidebarPermission">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    @canany(['permission.add', 'permission.show'])
                                        <a href="{{ route('admin.permissions.create') }}" class="nav-link"
                                            data-key="t-signin"> Thêm quyền
                                        </a>
                                    @endcanany


                                    @can('role.add')
                                        <a href="{{ route('admin.roles.create') }}" class="nav-link" data-key="t-signin">
                                            Thêm vai trò
                                        </a>
                                    @endcan
                                    @can('role.show')
                                        <a href="{{ route('admin.roles.index') }}" class="nav-link" data-key="t-signin">
                                            Danh sách vai trò
                                        </a>
                                    @endcan


                                </li>
                            </ul>
                        </div>
                    </li>
                @endcanany
            </ul>
        </div>
        <!-- Sidebar -->
    </div>

    <div class="sidebar-background"></div>
</div>
