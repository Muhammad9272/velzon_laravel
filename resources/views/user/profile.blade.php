@extends('user.layouts.master')
@section('title')
    @lang('translation.settings')
@endsection
@section('content')
    <div class="position-relative mx-n4 mt-n4">
        <div class="profile-wid-bg profile-setting-img">
            <img src="{{ URL::asset('assets/images/profile-bg.jpg') }}" class="profile-wid-img" alt="">
            <div class="overlay-content">
                <div class="text-end p-3">
                    <div class="p-0 ms-auto rounded-circle profile-photo-edit">
                       {{--  <input id="profile-foreground-img-file-input" type="file" class="profile-foreground-img-file-input">
                        <label for="profile-foreground-img-file-input" class="profile-photo-edit btn btn-light">
                            <i class="ri-image-edit-line align-bottom me-1"></i> Change Cover
                        </label> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-3">
            <div class="card mt-n5">
                <div class="card-body p-4">
                    <div class="text-center">
                        <div class="profile-user position-relative d-inline-block mx-auto  mb-4">
                            <img src="{{Auth::user()->avatar?asset('assets/front/images/users/'.Auth::user()->avatar):URL::asset('assets/images/users/user-dummy-img.jpg')}}"
                                class="  rounded-circle avatar-xl img-thumbnail user-profile-image"
                                alt="user-profile-image">
                            <div class="avatar-xs p-0 rounded-circle profile-photo-edit">
                               {{--  <input id="profile-img-file-input" type="file" class="profile-img-file-input"> --}}
                                <label for="profile-img-file-input" class="profile-photo-edit avatar-xs">
                                    <span class="avatar-title rounded-circle bg-light text-body">
                                        <i class="ri-camera-fill"></i>
                                    </span>
                                </label>
                            </div>
                        </div>
                        <h5 class="fs-16 mb-1">{{$data->name}}</h5>
                       
                    </div>
                </div>
            </div>
            <!--end card-->
        </div>
        <!--end col-->
        <div class="col-xl-9">
            <div class="card mt-xl-n5">
                <div class="card-header">
                    <ul class="nav nav-tabs-custom rounded card-header-tabs border-bottom-0" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active personalDetails" data-bs-toggle="tab" href="#personalDetails" role="tab">
                                <i class="fas fa-home"></i>
                                Personal Details
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link changePassword" data-bs-toggle="tab"  href="#changePassword" role="tab">
                                <i class="far fa-user"></i>
                                Change Password
                            </a>
                        </li>
                        
                    </ul>
                </div>
                <div class="card-body p-4">
                    <div class="tab-content">
                        <div class="tab-pane active" id="personalDetails" role="tabpanel">
                            @include('user.includes.alerts')
                            <form action="{{ route('user.profile.update') }}" method="post" enctype="multipart/form-data">
                                @csrf  
                                <div class="row">
                                    <input id="profile-img-file-input" type="file" class="profile-img-file-input" style="display:none;" name="avatar" accept="image/png, image/gif, image/jpeg"  >

                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label for="firstnameInput" class="form-label">
                                                Name</label>
                                            <input type="text" class="form-control" id="firstnameInput"
                                                placeholder="Enter your name" name="name" value="{{$data->name}}">
                                        </div>
                                    </div>

                                    <!--end col-->
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label for="emailInput" class="form-label">Email
                                                Address</label>
                                            <input type="email" class="form-control" id="emailInput"
                                                placeholder="Enter your email" name="email" value="{{$data->email}}">
                                        </div>
                                    </div>

                                     <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label for="phone" class="form-label">
                                                Contact No</label>
                                            <input type="text" class="form-control" id="phone"
                                                placeholder="Enter your Contact No" name="phone" value="{{$data->phone}}">
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
                            <form action="{{ route('user.reset.submit') }}" method="post">
                                @csrf
                                <div class="row g-2">
                                    <div class="col-lg-4">
                                        <div>
                                            <label for="oldpasswordInput" class="form-label">Old
                                                Password*</label>
                                            <input type="password" class="form-control" id="oldpasswordInput"
                                                placeholder="Enter current password" name="cpass" required>
                                        </div>
                                    </div>
                                    <!--end col-->
                                    <div class="col-lg-4">
                                        <div>
                                            <label for="newpasswordInput" class="form-label">New
                                                Password*</label>
                                            <input type="password" class="form-control" id="newpasswordInput"
                                                placeholder="Enter new password" name="newpass" required>
                                        </div>
                                    </div>
                                    <!--end col-->
                                    <div class="col-lg-4">
                                        <div>
                                            <label for="confirmpasswordInput" class="form-label">Confirm
                                                Password*</label>
                                            <input type="password" class="form-control" id="confirmpasswordInput"
                                                placeholder="Confirm password" name="renewpass" required>
                                        </div>
                                    </div>
                                    <!--end col-->
                                    <div class="col-lg-12">
                                       {{--  <div class="mb-3">
                                            <a href="javascript:void(0);"
                                                class="link-primary text-decoration-underline">Forgot
                                                Password ?</a>
                                        </div> --}}
                                    </div>
                                    <!--end col-->
                                    <div class="col-lg-12">
                                        <div class="text-end">
                                            <button type="submit" class="btn btn-success">Change
                                                Password</button>
                                        </div>
                                    </div>
                                    <!--end col-->
                                </div>
                                <!--end row-->
                            </form>

                        </div>
                        <!--end tab-pane-->
                       
                    </div>
                </div>
            </div>
        </div>
        <!--end col-->
    </div>
    <!--end row-->
@endsection
@section('script')
    <script src="{{ URL::asset('assets/js/pages/profile-setting.init.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
    <script type="text/javascript">

    $(document).ready(function(){
         var hash = location.hash.substr(1);
         console.log(hash);
         if(hash){
             $('.tab-pane,.nav-link').removeClass("active show");
             $("#"+hash).toggleClass("active show");
             $("."+hash).addClass('active'); 
         }

        
    });
    </script>
@endsection
