@extends('admin.layouts.master')
@section('title')
    Thông tin cá nhân
@endsection

@section('content')
    <div class="profile-foreground position-relative mx-n4 mt-n4">
        <div class="profile-wid-bg">
            <img src="{{ asset('assets/images/profile-bg.jpg') }}" alt="" class="profile-wid-img">
        </div>
    </div>
    <div class="pt-4 mb-4 mb-lg-3 pb-lg-4 profile-wrapper">

        <!--end row-->
    </div>
    <form action="{{ route('admin.users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
        @method('put')
        @csrf
        <div class="row" style="margin-top: 250px">
            <div class="col-xxl-3">
                <div class="card mt-n5">
                    <div class="card-body p-4">
                        <div class="text-center">
                            @php
                                $url = Storage::url($user->image);
                            @endphp
                            <div class="profile-user position-relative d-inline-block mx-auto  mb-4">
                                @if ($user->image)
                                    <img src="{{ $url }}"
                                        class="rounded-circle avatar-xl img-thumbnail user-profile-image"
                                        alt="user-profile-image">
                                @else
                                    <p class="mt-2 me-5">Chọn ảnh đại diện</p>
                                @endif

                                <div class="avatar-xs p-0 rounded-circle profile-photo-edit">
                                    <input id="profile-img-file-input" type="file" name="image"
                                        class="profile-img-file-input">
                                    <label for="profile-img-file-input" class="profile-photo-edit avatar-xs">
                                        <span class="avatar-title rounded-circle bg-light text-body">
                                            <i class="ri-camera-fill"></i>
                                        </span>
                                    </label>
                                </div>
                            </div>
                            <h5 class="fs-16 mb-1">{{ $user->name }}</h5>
                            <p class="text-muted mb-0">INTERN BACKEND PHP</p>
                        </div>
                    </div>
                </div>
                <!--end card-->
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-5">
                            <div class="flex-grow-1">
                                <h5 class="card-title mb-0">Complete Your Profile</h5>
                            </div>
                            <div class="flex-shrink-0">
                                <a href="javascript:void(0);" class="badge bg-light text-primary fs-12"><i
                                        class="ri-edit-box-line align-bottom me-1"></i> Edit</a>
                            </div>
                        </div>
                        <div class="progress animated-progress custom-progress progress-label">
                            <div class="progress-bar bg-danger" role="progressbar" style="width: 30%" aria-valuenow="30"
                                aria-valuemin="0" aria-valuemax="100">
                                <div class="label">30%</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-4">
                            <div class="flex-grow-1">
                                <h5 class="card-title mb-0">Portfolio</h5>
                            </div>
                            <div class="flex-shrink-0">
                                <a href="javascript:void(0);" class="badge bg-light text-primary fs-12"><i
                                        class="ri-add-fill align-bottom me-1"></i> Add</a>
                            </div>
                        </div>
                        <div class="mb-3 d-flex">
                            <div class="avatar-xs d-block flex-shrink-0 me-3">
                                <span class="avatar-title rounded-circle fs-16 bg-body text-body">
                                    <i class="ri-github-fill"></i>
                                </span>
                            </div>
                            <input type="email" class="form-control" id="gitUsername" placeholder="Username"
                                value="{{ $user->email }}">
                        </div>
                        <div class="mb-3 d-flex">
                            <div class="avatar-xs d-block flex-shrink-0 me-3">
                                <span class="avatar-title rounded-circle fs-16 bg-primary">
                                    <i class="ri-global-fill"></i>
                                </span>
                            </div>
                            <input type="text" class="form-control" id="websiteInput" placeholder="www.example.com"
                                value="{{ asset('/') }}">
                        </div>
                        <div class="mb-3 d-flex">
                            <div class="avatar-xs d-block flex-shrink-0 me-3">
                                <span class="avatar-title rounded-circle fs-16 bg-success">
                                    <i class="ri-dribbble-fill"></i>
                                </span>
                            </div>
                            <input type="text" class="form-control" id="dribbleName" placeholder="Username"
                                value="{{ asset('/') }}">
                        </div>
                        <div class="d-flex">
                            <div class="avatar-xs d-block flex-shrink-0 me-3">
                                <span class="avatar-title rounded-circle fs-16 bg-danger">
                                    <i class="ri-pinterest-fill"></i>
                                </span>
                            </div>
                            <input type="text" class="form-control" id="pinterestName" placeholder="Username"
                                value="{{ $user->name }}">
                        </div>
                    </div>
                </div>
                <!--end card-->
            </div>
            <!--end col-->
            <div class="col-xxl-9">
                <div class="card mt-xxl-n5">
                    <div class="card-header">
                        <ul class="nav nav-tabs-custom rounded card-header-tabs border-bottom-0" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" data-bs-toggle="tab" href="#personalDetails" role="tab"
                                    aria-selected="true">
                                    <i class="fas fa-home"></i> Personal Details
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" data-bs-toggle="tab" href="#changePassword" role="tab"
                                    aria-selected="false" tabindex="-1">
                                    <i class="far fa-user"></i> Change Password
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" data-bs-toggle="tab" href="#experience" role="tab"
                                    aria-selected="false" tabindex="-1">
                                    <i class="far fa-envelope"></i> Experience
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" data-bs-toggle="tab" href="#privacy" role="tab"
                                    aria-selected="false" tabindex="-1">
                                    <i class="far fa-envelope"></i> Privacy Policy
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body p-4">
                        <div class="tab-content">
                            <div class="tab-pane active" id="personalDetails" role="tabpanel">
                                <form action="javascript:void(0);">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="mb-3">
                                                <label for="firstnameInput" class="form-label">Fullname</label>
                                                <input type="text" class="form-control" id="firstnameInput"
                                                    name="name" placeholder="Enter your firstname"
                                                    value="{{ $user->name }}">
                                            </div>
                                        </div>


                                        <!--end col-->
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="phonenumberInput" class="form-label">Phone Number</label>
                                                <input type="text" class="form-control" name="phone"
                                                    id="phonenumberInput" placeholder="Enter your phone number"
                                                    value="{{ $user->phone }}">
                                            </div>
                                        </div>
                                        <!--end col-->
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="emailInput" class="form-label">Email Address</label>
                                                <input type="email" class="form-control" disabled id="emailInput"
                                                    placeholder="Enter your email" value="{{ $user->email }}">
                                            </div>
                                        </div>
                                        <!--end col-->
                                        <div class="col-lg-12">
                                            <div class="mb-3">
                                                <label for="JoiningdatInput" class="form-label">Joining Date</label>
                                                <input type="text" class="form-control" data-provider="flatpickr"
                                                    id="JoiningdatInput" data-date-format="d M, Y"
                                                    data-deafult-date="24 Nov, 2021" value="{{ $user->created_at }}"
                                                    disabled placeholder="Select date">
                                            </div>
                                        </div>
                                        @php
                                            $work = [
                                                'Inter' => 'Inter PHP Laravel',
                                                'Fresher' => 'Fresher PHP Laravel',
                                                'Junior' => 'Junior PHP Laravel',
                                                'Master' => 'Master PHP Laravel',
                                            ];
                                        @endphp
                                        <!--end col-->
                                        <div class="col-lg-12">
                                            <div class="mb-3">
                                                <label for="skillsInput" class="form-label">Công việc hiện tại</label>
                                                <select class="form-select" name="work" data-choices=""
                                                    data-choices-text-unique-true="" id="skillsInput">
                                                    @foreach ($work as $key => $value)
                                                        <option value="{{ $key }}"
                                                            {{ $user->work == $key ? 'selected' : '' }}>
                                                            {{ $value }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <!--end col-->
                                        <div class="col-lg-12">
                                            <div class="mb-3">
                                                <label for="skillsInput" class="form-label">Vai trò trên hệ thống</label>
                                                <select class="form-control" name="list_role[]" data-choices=""
                                                    data-choices-text-unique-true="" multiple="" id="skillsInput">
                                                    @foreach ($roles as $role)
                                                        <option value="{{ $role->id }}"
                                                            {{ in_array($role->id, $list_role_user) ? 'selected' : '' }}>
                                                            {{ $role->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <!--end col-->

                                        <!--end col-->
                                        <div class="col-lg-4">
                                            <div class="mb-3">
                                                <label for="cityInput" class="form-label">City</label>
                                                <input type="text" class="form-control" name="address" id="cityInput"
                                                    placeholder="City" value="{{ $user->address }}">
                                            </div>
                                        </div>
                                        <!--end col-->
                                        <div class="col-lg-4">
                                            <div class="mb-3">
                                                <label for="countryInput" class="form-label">Country</label>
                                                <input type="text" class="form-control" id="countryInput"
                                                    placeholder="Country" value="Việt Nam">
                                            </div>
                                        </div>
                                        <!--end col-->
                                        <div class="col-lg-4">
                                            <div class="mb-3">
                                                <label for="zipcodeInput" class="form-label">Zip Code</label>
                                                <input type="text" class="form-control" minlength="5" maxlength="6"
                                                    id="zipcodeInput" placeholder="Enter zipcode" value="100">
                                            </div>
                                        </div>
                                        <!--end col-->
                                        <div class="col-lg-12">
                                            <div class="mb-3 pb-2">
                                                <label for="exampleFormControlTextarea"
                                                    class="form-label">Description</label>
                                                <textarea name="description" class="form-control" id="exampleFormControlTextarea"
                                                    placeholder="Enter your description" rows="3">{{ $user->description }}</textarea>
                                            </div>
                                        </div>
                                        <!--end col-->
                                        <div class="col-lg-12">
                                            <div class="hstack gap-2 justify-content-end">
                                                <button type="submit" class="btn btn-primary">Updates</button>
                                                <button type="button" class="btn btn-soft-success">Cancel</button>
                                            </div>
                                        </div>
                                        <!--end col-->
                                    </div>
                                    <!--end row-->
                                </form>
                            </div>
                            <!--end tab-pane-->
                            <div class="tab-pane" id="changePassword" role="tabpanel">
                                <form action="javascript:void(0);">
                                    <div class="row g-2">
                                        <div class="col-lg-4">
                                            <div>
                                                <label for="oldpasswordInput" class="form-label">Old Password*</label>
                                                <input type="password" class="form-control" id="oldpasswordInput"
                                                    placeholder="Enter current password">
                                            </div>
                                        </div>
                                        <!--end col-->
                                        <div class="col-lg-4">
                                            <div>
                                                <label for="newpasswordInput" class="form-label">New Password*</label>
                                                <input type="password" class="form-control" id="newpasswordInput"
                                                    placeholder="Enter new password">
                                            </div>
                                        </div>
                                        <!--end col-->
                                        <div class="col-lg-4">
                                            <div>
                                                <label for="confirmpasswordInput" class="form-label">Confirm
                                                    Password*</label>
                                                <input type="password" class="form-control" id="confirmpasswordInput"
                                                    placeholder="Confirm password">
                                            </div>
                                        </div>
                                        <!--end col-->
                                        <div class="col-lg-12">
                                            <div class="mb-3">
                                                <a href="javascript:void(0);"
                                                    class="link-primary text-decoration-underline">Forgot Password ?</a>
                                            </div>
                                        </div>
                                        <!--end col-->
                                        <div class="col-lg-12">
                                            <div class="text-end">
                                                <button type="submit" class="btn btn-success">Change Password</button>
                                            </div>
                                        </div>
                                        <!--end col-->
                                    </div>
                                    <!--end row-->
                                </form>
                                <div class="mt-4 mb-3 border-bottom pb-2">
                                    <div class="float-end">
                                        <a href="javascript:void(0);" class="link-primary">All Logout</a>
                                    </div>
                                    <h5 class="card-title">Login History</h5>
                                </div>
                                <div class="d-flex align-items-center mb-3">
                                    <div class="flex-shrink-0 avatar-sm">
                                        <div class="avatar-title bg-light text-primary rounded-3 fs-18">
                                            <i class="ri-smartphone-line"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6>iPhone 12 Pro</h6>
                                        <p class="text-muted mb-0">Los Angeles, United States - March 16 at 2:47PM</p>
                                    </div>
                                    <div>
                                        <a href="javascript:void(0);">Logout</a>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center mb-3">
                                    <div class="flex-shrink-0 avatar-sm">
                                        <div class="avatar-title bg-light text-primary rounded-3 fs-18">
                                            <i class="ri-tablet-line"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6>Apple iPad Pro</h6>
                                        <p class="text-muted mb-0">Washington, United States - November 06 at 10:43AM</p>
                                    </div>
                                    <div>
                                        <a href="javascript:void(0);">Logout</a>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center mb-3">
                                    <div class="flex-shrink-0 avatar-sm">
                                        <div class="avatar-title bg-light text-primary rounded-3 fs-18">
                                            <i class="ri-smartphone-line"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6>Galaxy S21 Ultra 5G</h6>
                                        <p class="text-muted mb-0">Conneticut, United States - June 12 at 3:24PM</p>
                                    </div>
                                    <div>
                                        <a href="javascript:void(0);">Logout</a>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0 avatar-sm">
                                        <div class="avatar-title bg-light text-primary rounded-3 fs-18">
                                            <i class="ri-macbook-line"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6>Dell Inspiron 14</h6>
                                        <p class="text-muted mb-0">Phoenix, United States - July 26 at 8:10AM</p>
                                    </div>
                                    <div>
                                        <a href="javascript:void(0);">Logout</a>
                                    </div>
                                </div>
                            </div>
                            <!--end tab-pane-->
                            <div class="tab-pane" id="experience" role="tabpanel">
                                <form>
                                    <div id="newlink">
                                        <div id="1">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="mb-3">
                                                        <label for="jobTitle" class="form-label">Job Title</label>
                                                        <input type="text" class="form-control" id="jobTitle"
                                                            placeholder="Job title" value="Lead Designer / Developer">
                                                    </div>
                                                </div>
                                                <!--end col-->
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label for="companyName" class="form-label">Company Name</label>
                                                        <input type="text" class="form-control" id="companyName"
                                                            placeholder="Company name" value="Themesbrand">
                                                    </div>
                                                </div>
                                                <!--end col-->
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label for="experienceYear" class="form-label">Experience
                                                            Years</label>
                                                        <div class="row">
                                                            <div class="col-lg-5">
                                                                <select class="form-control" data-choices=""
                                                                    data-choices-search-false="" name="experienceYear"
                                                                    id="experienceYear">
                                                                    <option value="">Select years</option>
                                                                    <option value="Choice 1">2001</option>
                                                                    <option value="Choice 2">2002</option>
                                                                    <option value="Choice 3">2003</option>
                                                                    <option value="Choice 4">2004</option>
                                                                    <option value="Choice 5">2005</option>
                                                                    <option value="Choice 6">2006</option>
                                                                    <option value="Choice 7">2007</option>
                                                                    <option value="Choice 8">2008</option>
                                                                    <option value="Choice 9">2009</option>
                                                                    <option value="Choice 10">2010</option>
                                                                    <option value="Choice 11">2011</option>
                                                                    <option value="Choice 12">2012</option>
                                                                    <option value="Choice 13">2013</option>
                                                                    <option value="Choice 14">2014</option>
                                                                    <option value="Choice 15">2015</option>
                                                                    <option value="Choice 16">2016</option>
                                                                    <option value="Choice 17" selected="">2017</option>
                                                                    <option value="Choice 18">2018</option>
                                                                    <option value="Choice 19">2019</option>
                                                                    <option value="Choice 20">2020</option>
                                                                    <option value="Choice 21">2021</option>
                                                                    <option value="Choice 22">2022</option>
                                                                </select>
                                                            </div>
                                                            <!--end col-->
                                                            <div class="col-auto align-self-center">
                                                                to
                                                            </div>
                                                            <!--end col-->
                                                            <div class="col-lg-5">
                                                                <select class="form-control" data-choices=""
                                                                    data-choices-search-false=""
                                                                    name="choices-single-default2">
                                                                    <option value="">Select years</option>
                                                                    <option value="Choice 1">2001</option>
                                                                    <option value="Choice 2">2002</option>
                                                                    <option value="Choice 3">2003</option>
                                                                    <option value="Choice 4">2004</option>
                                                                    <option value="Choice 5">2005</option>
                                                                    <option value="Choice 6">2006</option>
                                                                    <option value="Choice 7">2007</option>
                                                                    <option value="Choice 8">2008</option>
                                                                    <option value="Choice 9">2009</option>
                                                                    <option value="Choice 10">2010</option>
                                                                    <option value="Choice 11">2011</option>
                                                                    <option value="Choice 12">2012</option>
                                                                    <option value="Choice 13">2013</option>
                                                                    <option value="Choice 14">2014</option>
                                                                    <option value="Choice 15">2015</option>
                                                                    <option value="Choice 16">2016</option>
                                                                    <option value="Choice 17">2017</option>
                                                                    <option value="Choice 18">2018</option>
                                                                    <option value="Choice 19">2019</option>
                                                                    <option value="Choice 20" selected="">2020</option>
                                                                    <option value="Choice 21">2021</option>
                                                                    <option value="Choice 22">2022</option>
                                                                </select>
                                                            </div>
                                                            <!--end col-->
                                                        </div>
                                                        <!--end row-->
                                                    </div>
                                                </div>
                                                <!--end col-->
                                                <div class="col-lg-12">
                                                    <div class="mb-3">
                                                        <label for="jobDescription" class="form-label">Job
                                                            Description</label>
                                                        <textarea class="form-control" id="jobDescription" name="description" rows="3"
                                                            placeholder="Enter description">{{ $user->description }}</textarea>
                                                    </div>
                                                </div>
                                                <!--end col-->
                                                <div class="hstack gap-2 justify-content-end">
                                                    <a class="btn btn-success" href="javascript:deleteEl(1)">Delete</a>
                                                </div>
                                            </div>
                                            <!--end row-->
                                        </div>
                                    </div>
                                    <div id="newForm" style="display: none;">

                                    </div>
                                    <div class="col-lg-12">
                                        <div class="hstack gap-2">
                                            <button type="submit" class="btn btn-success">Update</button>
                                            <a href="javascript:new_link()" class="btn btn-primary">Add New</a>
                                        </div>
                                    </div>
                                    <!--end col-->
                                </form>
                            </div>
                            <!--end tab-pane-->
                            <div class="tab-pane" id="privacy" role="tabpanel">
                                <div class="mb-4 pb-2">
                                    <h5 class="card-title text-decoration-underline mb-3">Security:</h5>
                                    <div class="d-flex flex-column flex-sm-row mb-4 mb-sm-0">
                                        <div class="flex-grow-1">
                                            <h6 class="fs-14 mb-1">Two-factor Authentication</h6>
                                            <p class="text-muted">Two-factor authentication is an enhanced security
                                                meansur. Once enabled, you'll be required to give two types of
                                                identification when you log into Google Authentication and SMS are
                                                Supported.</p>
                                        </div>
                                        <div class="flex-shrink-0 ms-sm-3">
                                            <a href="javascript:void(0);" class="btn btn-sm btn-primary">Enable Two-facor
                                                Authentication</a>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-column flex-sm-row mb-4 mb-sm-0 mt-2">
                                        <div class="flex-grow-1">
                                            <h6 class="fs-14 mb-1">Secondary Verification</h6>
                                            <p class="text-muted">The first factor is a password and the second commonly
                                                includes a text with a code sent to your smartphone, or biometrics using
                                                your fingerprint, face, or retina.</p>
                                        </div>
                                        <div class="flex-shrink-0 ms-sm-3">
                                            <a href="javascript:void(0);" class="btn btn-sm btn-primary">Set up secondary
                                                method</a>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-column flex-sm-row mb-4 mb-sm-0 mt-2">
                                        <div class="flex-grow-1">
                                            <h6 class="fs-14 mb-1">Backup Codes</h6>
                                            <p class="text-muted mb-sm-0">A backup code is automatically generated for you
                                                when you turn on two-factor authentication through your iOS or Android
                                                Twitter app. You can also generate a backup code on twitter.com.</p>
                                        </div>
                                        <div class="flex-shrink-0 ms-sm-3">
                                            <a href="javascript:void(0);" class="btn btn-sm btn-primary">Generate backup
                                                codes</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <h5 class="card-title text-decoration-underline mb-3">Application Notifications:</h5>
                                    <ul class="list-unstyled mb-0">
                                        <li class="d-flex">
                                            <div class="flex-grow-1">
                                                <label for="directMessage" class="form-check-label fs-14">Direct
                                                    messages</label>
                                                <p class="text-muted">Messages from people you follow</p>
                                            </div>
                                            <div class="flex-shrink-0">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" role="switch"
                                                        id="directMessage" checked="">
                                                </div>
                                            </div>
                                        </li>
                                        <li class="d-flex mt-2">
                                            <div class="flex-grow-1">
                                                <label class="form-check-label fs-14" for="desktopNotification">
                                                    Show desktop notifications
                                                </label>
                                                <p class="text-muted">Choose the option you want as your default setting.
                                                    Block a site: Next to "Not allowed to send notifications," click Add.
                                                </p>
                                            </div>
                                            <div class="flex-shrink-0">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" role="switch"
                                                        id="desktopNotification" checked="">
                                                </div>
                                            </div>
                                        </li>
                                        <li class="d-flex mt-2">
                                            <div class="flex-grow-1">
                                                <label class="form-check-label fs-14" for="emailNotification">
                                                    Show email notifications
                                                </label>
                                                <p class="text-muted"> Under Settings, choose Notifications. Under Select
                                                    an account, choose the account to enable notifications for. </p>
                                            </div>
                                            <div class="flex-shrink-0">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" role="switch"
                                                        id="emailNotification">
                                                </div>
                                            </div>
                                        </li>
                                        <li class="d-flex mt-2">
                                            <div class="flex-grow-1">
                                                <label class="form-check-label fs-14" for="chatNotification">
                                                    Show chat notifications
                                                </label>
                                                <p class="text-muted">To prevent duplicate mobile notifications from the
                                                    Gmail and Chat apps, in settings, turn off Chat notifications.</p>
                                            </div>
                                            <div class="flex-shrink-0">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" role="switch"
                                                        id="chatNotification">
                                                </div>
                                            </div>
                                        </li>
                                        <li class="d-flex mt-2">
                                            <div class="flex-grow-1">
                                                <label class="form-check-label fs-14" for="purchaesNotification">
                                                    Show purchase notifications
                                                </label>
                                                <p class="text-muted">Get real-time purchase alerts to protect yourself
                                                    from fraudulent charges.</p>
                                            </div>
                                            <div class="flex-shrink-0">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" role="switch"
                                                        id="purchaesNotification">
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <div>
                                    <h5 class="card-title text-decoration-underline mb-3">Delete This Account:</h5>
                                    <p class="text-muted">Go to the Data &amp; Privacy section of your profile Account.
                                        Scroll to "Your data &amp; privacy options." Delete your Profile Account. Follow the
                                        instructions to delete your account :</p>
                                    <div>
                                        <input type="password" class="form-control" id="passwordInput"
                                            placeholder="Enter your password" value="make@321654987"
                                            style="max-width: 265px;">
                                    </div>
                                    <div class="hstack gap-2 mt-3">
                                        <a href="javascript:void(0);" class="btn btn-soft-danger">Close &amp; Delete This
                                            Account</a>
                                        <a href="javascript:void(0);" class="btn btn-light">Cancel</a>
                                    </div>
                                </div>
                            </div>
                            <!--end tab-pane-->
                        </div>
                    </div>
                </div>
            </div>
            <!--end col-->
        </div>
        <!--end row-->
    </form>
@endsection
@section('style-libs')
    <!-- swiper css -->
    <link rel="stylesheet" href="{{ asset('assets/libs/swiper/swiper-bundle.min.css') }}">
@endsection
@section('script-libs')
    <!-- swiper js -->
    <script src="{{ asset('assets/libs/swiper/swiper-bundle.min.js') }}"></script>

    <!-- profile init js -->
    <script src="{{ asset('assets/js/pages/profile.init.js') }}"></script>

    <!-- App js -->
    <script src="{{ asset('assets/js/app.js') }}"></script>
@endsection
