@extends('admin.layouts.master')
@section('title')
   {{--  @lang('translation.basic-elements') --}}
   General Settings
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
              <a href="{{ route('admin.generalsettings') }}"> General  </a>
        @endslot
        @slot('title')
            Settings
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">General Settings </h4>
                    <div class="flex-shrink-0">
                       
                    </div>
                </div><!-- end card header -->
                <div class="card-body">
                    <div class="live-preview">
                         @include('admin.includes.alerts')
                        <form action="{{ route('admin.generalsettings.update') }}" method="post" enctype="multipart/form-data" >
                            @csrf
                            <div class="row gy-4">
 
                              {{--   <div class="col-lg-4"> 
                                    <h5 class="fw-semibold mb-3">Website Favicon</h5>                       
                                    <div class="profile-user position-relative d-inline-block mx-auto  mb-4">
                                        <img src="{{$data->favicon?asset('/assets/images/'.$data->favicon):URL::asset('assets/images/users/user-dummy-img.jpg')}}"
                                            class="  rounded-circle avatar-xl img-thumbnail user-profile-image"
                                            alt="user-profile-image">
                                        <div class="avatar-xs p-0 rounded-circle profile-photo-edit">
                                            <input id="profile-img-file-input" type="file" class="profile-img-file-input" name="favicon" accept="image/png, image/gif, image/jpeg" />
                                            <label for="profile-img-file-input" class="profile-photo-edit avatar-xs">
                                                <span class="avatar-title rounded-circle bg-light text-body">
                                                    <i class="ri-camera-fill"></i>
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4"> 
                                    <h5 class="fw-semibold mb-3">Website Logo</h5>
                                    <div class="profile-user position-relative d-inline-block mx-auto  mb-4">
                                         <img src="{{$data->logo?asset('/assets/images/logo/'.$data->logo):URL::asset('assets/images/users/user-dummy-img.jpg')}}"
                                            class="rounded-circle avatar-xl img-thumbnail user-profile-image1"
                                            alt="user-profile-image">
                                        <div class="avatar-xs p-0 rounded-circle profile-photo-edit">
                                            <input id="profile-img-file-input1" style="display: none;" type="file" class="profile-img-file-input1" name="logo" accept="image/png, image/gif, image/jpeg" />
                                            <label for="profile-img-file-input1" class="profile-photo-edit avatar-xs">
                                                <span class="avatar-title rounded-circle bg-light text-body">
                                                    <i class="ri-camera-fill"></i>
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                </div> --}}
                                <div class="col-lg-12"> 
                                    <h5 class="fw-semibold mb-3">Admin Panel Logo</h5>
                                    <div class="profile-user position-relative d-inline-block mx-auto  mb-4">
                                         <img src="{{$data->admin_logo?asset('/assets/images/logo/'.$data->admin_logo):URL::asset('assets/images/users/user-dummy-img.jpg')}}"
                                            class="rounded-circle avatar-xl img-thumbnail user-profile-image2"
                                            alt="user-profile-image">
                                        <div class="avatar-xs p-0 rounded-circle profile-photo-edit">
                                            <input id="profile-img-file-input2" style="display: none;" type="file" class="profile-img-file-input2" name="admin_logo" accept="image/png, image/gif, image/jpeg" />
                                            <label for="profile-img-file-input2" class="profile-photo-edit avatar-xs">
                                                <span class="avatar-title rounded-circle bg-light text-body">
                                                    <i class="ri-camera-fill"></i>
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-md-6">
                                    <div>
                                        <label for="basiInput" class="form-label"> Website Name</label>
                                        <input type="text" class="form-control" id="basiInput" name="name" value="{{$data->name}}" required>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-md-6">
                                    <div>
                                        <label for="basiInput" class="form-label"> Website Slogan</label>
                                        <input type="text" class="form-control" id="basiInput" value="{{$data->slogan}}"  name="slogan" required>
                                    </div>
                                </div>


                              
                               
                                <!--end col-->
                                <div class="col-12">
                                    <button class="btn btn-primary" type="submit">Submit form</button>
                                </div>
                                <!--end col-->
                            </div>
                        </form>
                        <!--end row-->
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
    <script src="{{ URL::asset('/assets/libs/prismjs/prismjs.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection
