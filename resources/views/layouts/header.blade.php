 <!-- navigation -->
 <header class="navigation fixed-top">
     <div class="container-fluid">
         <nav class="navbar navbar-expand-lg navbar-white">
             <a class="navbar-brand order-1" href="{{ route('home') }}">
                 <img class="img-fluid" width="100px" src="{{ url('theme/fontend/images/logo.png') }}"
                     alt="Reader | Hugo Personal Blog Template">
             </a>
             <div class="collapse navbar-collapse text-center order-lg-2 order-3" id="navigation">
                 <ul class="navbar-nav mx-auto">
                     @foreach ($list_category_nav[1] as $category)
                         <li class="nav-item dropdown">
                             <a href="{{ route('post.detail.cat', ['category' => $category->id, 'slug' => $category->slug]) }}"
                                 class="nav-link" role="button" aria-haspopup="true" aria-expanded="false">
                                 {{ $category->name }} <i class="ti-angle-down ml-1"></i>
                             </a>
                             <div class="dropdown-menu">
                                 @foreach ($category->children as $catchild)
                                     <a class="dropdown-item"
                                         href="{{ route('post.detail.cat', ['category' => $catchild->id, 'slug' => $catchild->slug]) }}">{{ $catchild->name }}</a>
                                 @endforeach
                             </div>
                         </li>
                     @endforeach
                     @foreach ($list_category_nav[0] as $page)
                         <li class="nav-item dropdown">
                             <a class="nav-link"
                                 href="{{ route('page.detail', ['page' => $page->id, 'slug' => $page->slug]) }}">{{ $page->title }}</a>
                         </li>
                     @endforeach

                 </ul>
             </div>

             <div class="order-2 order-lg-3 d-flex align-items-center">

                 <form class="search-bar" action="{{ route('post.search') }}" method="get">
                     @csrf
                     <input id="search-query" name="keyword" type="search" value="{{ request()->input('keyword') }}"
                         placeholder="Type &amp; Hit Enter...">
                 </form>

                 <button class="navbar-toggler border-0 order-1" type="button" data-toggle="collapse"
                     data-target="#navigation">
                     <i class="ti-menu"></i>
                 </button>
                 <ul class="navbar-nav ms-auto">
                     <!-- Authentication Links -->
                     @guest
                         @if (Route::has('login'))
                             <li class="nav-item">
                                 <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                             </li>
                         @endif

                         @if (Route::has('register'))
                             <li class="nav-item">
                                 <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                             </li>
                         @endif
                     @else
                         <li class="nav-item dropdown">
                             @php
                                 $url = Storage::url(Auth::user()->image);
                             @endphp

                             <a id="navbarDropdown" class="nav-link dropdown-toggle card-meta-author" href="#"
                                 role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                 @if (Auth::user()->image)
                                     <img style="width: 30px!important; height: 30px!important;" src="{{ $url }}"
                                         alt="">
                                     @if (Auth::user())
                                         {{ Auth::user()->name }}
                                     @endif
                                 @else
                                     <img style="width: 30px!important; height: 30px!important;"
                                         src="{{ url('image/notimage.webp') }}" alt="">
                                     @if (Auth::user())
                                         {{ Auth::user()->name }}
                                     @endif
                                 @endif

                             </a>
                             <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                 @if (Auth::user()->type == 'admin')
                                     <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                         {{ __('Dashboard') }}
                                     </a>
                                 @endif
                                 <a class="dropdown-item" href="{{ route('profile.index') }}"><i
                                         class="ri-dashboard-line"></i> <span class="align-middle">Profile</span></a>
                                 <a class="dropdown-item" href="{{ route('logout') }}"
                                     onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                     {{ __('Logout') }}
                                 </a>

                                 <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                     @csrf
                                 </form>
                             </div>
                         </li>
                     @endguest
                 </ul>

                 <!-- search -->
             </div>

         </nav>
     </div>
 </header>
 <!-- /navigation -->
