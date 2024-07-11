@extends('layouts.master')
@section('title')
    Thông tin cá nhân
@endsection
@section('content')
    <style>
        .rounded-circle-img {
            border-radius: 50%;
            object-fit: cover;
            border: 8px solid darkcyan;
        }
    </style>
    <section class="section">
        <div class="py-4"></div>
        <div class="container">
            <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <h2 class="text-center">Update User Information</h2>
                    <div class="col-lg-8 mb-5 mb-lg-0">
                        <div class="form-group">
                            <label for="name">Họ và tên</label>
                            <input type="text" class="form-control" id="name" name="name"
                                value="{{ Auth::user()->name }}" placeholder="Enter your name">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email"
                                value="{{ Auth::user()->email }}" readonly placeholder="Enter your email">
                        </div>

                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="image">Thông tin hình ảnh</label>
                                    <input type="file" name="image" class="form-control" id="image">
                                </div>
                            </div>
                            <div class="col-md-4">
                                @php
                                    $url = Storage::url(Auth::user()->image);
                                @endphp
                                @if (Auth::user()->image)
                                    <img class="rounded-circle-img" src="{{ $url }}" width="100%" alt="">
                                @else
                                    <i>Vui lòng cập nhật ảnh của bạn</i>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="address">Địa chỉ</label>
                            <input type="text" class="form-control" id="address" name="address"
                                value="{{ Auth::user()->address }}" placeholder="Enter your address">
                        </div>
                    </div>
                    <div class="col-lg-4 mb-5 mb-lg-0">
                        <div class="form-group">
                            <label for="age">Tuổi</label>
                            <input type="number" class="form-control" id="age" name="age"
                                placeholder="Enter your age" value="{{ Auth::user()->age }}">
                        </div>
                        <div class="form-group">
                            <label for="phone">Số điện thoại</label>
                            <input type="text" class="form-control" id="phone" name="phone"
                                value="{{ Auth::user()->phone }}" placeholder="Enter your phone number">
                        </div>
                        <div class="form-group">
                            <label for="work">Công việc</label>
                            <input type="text" class="form-control" id="work" name="work"
                                value="{{ Auth::user()->work }}" placeholder="Enter your work">
                        </div>
                        <div class="float-right">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection
