@extends('user.layouts.master')
@section('title') Dashboard @endsection
@section('css')

    <link href="{{ URL::asset('assets/libs/jsvectormap/jsvectormap.min.css') }}" rel="stylesheet">
    <style type="text/css">
/*        .row {
  display: -webkit-box;
  display: -webkit-flex;
  display: -ms-flexbox;
  display:         flex;
  flex-wrap: wrap;
}*/
.flex-col-row > [class*='col-'] {
  display: flex;
  /*flex-direction: column;*/
}
.position-top{
    bottom: 100% !important;
    right: 0%;
    top: unset !important;
}
.tooltip-active .valid-tooltip{
   display: block;
}
.social-share-btns{
    display: inline-flex;
}
.social-share-btns .avatar-xs{
  width: 3rem !important;
  height: 3rem !important;
}
.social-share-btns .avatar-xs .avatar-title{
  font-size: 24px;
}
.social-share-btns a{
    margin-left: 5px;
}
.bg-linkedin{
    background-color:#0677b5 !important;
}
.bg-whatsapp{
   background-color:#0d9f16 !important; 
}
.bg-copylink{
    background: none !important;
    border: 1px solid grey;
    color: black !important;
    cursor: pointer;
}
.activelink .bg-copylink{
  border-color: green;
  color: green !important;
}


</style>
@endsection
@section('content')

    <div class="profile-foreground position-relative mx-n4 mt-n4">
        <div class="profile-wid-bg">
            <img src="{{Auth::user()->foreground?URL::asset('images/' . Auth::user()->foreground):URL::asset('assets/images/profile-bg.jpg')}}" alt="" class="profile-wid-img" />
        </div>
    </div>
    <div class="pt-4 mb-4 mb-lg-3 pb-lg-4">
        <div class="row g-4">
            <div class="col-auto">
                <div class="avatar-lg">
                    <img src="{{Auth::user()->avatar?asset('assets/front/images/users/'.Auth::user()->avatar):URL::asset('assets/images/users/user-dummy-img.jpg')}}"
                        alt="user-img" class="img-thumbnail rounded-circle" />
                </div>
            </div>
            <!--end col-->
            <div class="col">
                <div class="p-2">
                    <h3 class="text-white mb-1">{{Auth::user()->name}}</h3>
                    {{-- <p class="text-white-75"><a href="{{$data->marketplace_link}}" class="fw-semibold">{{$data->marketplace_link}}</a></p> --}}
                   
                </div>
            </div>

            <!--end col-->

            <!--end col-->

        </div>
        <!--end row-->
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div>
                <div class="d-flex">
                    <!-- Nav tabs -->
                    <ul class="nav nav-pills animation-nav profile-nav gap-2 gap-lg-3 flex-grow-1" role="tablist">

                        <li class="nav-item">
                            <a class="nav-link fs-14 active" data-bs-toggle="tab" href="#overview-tab" role="tab">
                                <i class="ri-airplay-fill d-inline-block d-md-none"></i> <span
                                    class="d-none d-md-inline-block">Profile</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fs-14 " data-bs-toggle="tab" href="#tab-dao" role="tab">
                                <i class="ri-airplay-fill d-inline-block d-md-none"></i> <span
                                    class="d-none d-md-inline-block">DAO</span>
                            </a>
                        </li>

                       {{--  <li class="nav-item">
                            <a class="nav-link fs-14 " data-bs-toggle="tab" href="#tab-ar" role="tab">
                                <i class="ri-airplay-fill d-inline-block d-md-none"></i> <span
                                    class="d-none d-md-inline-block">AR VIEWER</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fs-14" data-bs-toggle="tab" href="#activities" role="tab">
                                <i class="ri-list-unordered d-inline-block d-md-none"></i> <span
                                    class="d-none d-md-inline-block">Hootie-Verse</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fs-14" data-bs-toggle="tab" href="#projects" role="tab">
                                <i class="ri-price-tag-line d-inline-block d-md-none"></i> <span
                                    class="d-none d-md-inline-block">My Stats</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fs-14" data-bs-toggle="tab" href="#documents" role="tab">
                                <i class="ri-folder-4-line d-inline-block d-md-none"></i> <span
                                    class="d-none d-md-inline-block">Control Panel</span>
                            </a>
                        </li> --}}
                    </ul>
                    <div class="flex-shrink-0">
                        <a href="{{ route('user.profile') }}" class="btn btn-success">
                            <i
                                class="ri-edit-box-line align-bottom"></i> Edit Profile</a>
                    </div>
                </div>
                <!-- Tab panes -->
                <div class="tab-content pt-4 text-muted">
                    <div class="tab-pane active" id="overview-tab" role="tabpanel">
                        <div class="row flex-col-row">
                            @if($gs->is_affilate==1)
                            <div class="col-xl-4">                               
                                <div class="card text-center">
                                            <div class="card-body">
                                                <img src="{{ URL::asset('assets/images/giftbox.png') }}" alt="">
                                                <div class="mt-4">
                                                    <h5>Invite New Seller</h5>
                                                    <p class="text-muted lh-base">Refer a new seller to us and earn $100 per refer.</p>
                                                    <button type="button" class="btn btn-primary btn-label rounded-pill" data-bs-toggle="modal" data-bs-target="#socialShare"><i class="ri-share-fill label-icon align-middle rounded-pill fs-16 me-2"></i> Invite Now</button>


                                                   {{--  <div class="col-md-10 position-relative">
                                                        <div class="input-group has-validation copy-text">
                                                            <input type="text" class="form-control link" id=""
                                                                aria-describedby="" value="http://localhost:8000/user/dashboard" readonly>
                                                            <button class="input-group-text" id=""><i class="ri-file-copy-line"></i></button>
                                                            <div class="valid-tooltip position-top" >
                                                                Copied!
                                                            </div>
                                                        </div>
                                                    </div> --}}
                                                </div>
                                            </div>
                                </div>
                                <!--end card-->
                            </div>
                            @endif
                            <!--end col-->
                            <div class="col-xl-8">
                                @include('user.includes.alerts')
                                <div class="card">
                                    <div class="card-body">
                                       <div class="row align-items-center">
                                            <div class="col-sm-8">
                                                <div class="p-3">
                                                    <p class="fs-16 lh-base">Hi {{Auth::guard('web')->user()->name }}, Welcome To <strong> {{$gs->name}} </strong> User Dashboard</p>
                                                    
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="px-3">
                                                    <img src="{{ URL::asset('assets/images/user-illustarator-2.png') }}"
                                                        class="img-fluid" alt="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end card-body-->
                                </div>

                               {{--  <div class="card mt-10">
                                    <div class="card-body">
                                        <h5 class="card-title mb-3">About</h5>
                                        {!! $data->details !!}
                                        <div class="row">
                                            <!--end col-->
                                            @if($data->marketplace_link)
                                            <div class="col-6 col-md-4">
                                                <div class="d-flex mt-4">
                                                    <div class="flex-shrink-0 avatar-xs align-self-center me-3">
                                                        <div
                                                            class="avatar-title bg-light rounded-circle fs-16 text-primary">
                                                            <i class="ri-global-line"></i>
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1 overflow-hidden">
                                                        <p class="mb-1">Marketplace Link :</p>
                                                        <a href="{{$data->marketplace_link}}" class="fw-semibold">{{$data->marketplace_link}}</a>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                            <!--end col-->
                                        </div>
                                        <!--end row-->
                                    </div>
                                    <!--end card-body-->
                                </div> --}}<!-- end card -->



                            </div>
                            <!--end col-->
                        </div>
                        <!--end row-->
                    </div>
                    <div class="tab-pane fade" id="tab-dao" role="tabpanel">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                  <h1>Additional Details</h1>
                                </div>
                                <!--end row-->
                            </div>
                            <!--end card-body-->
                        </div>
                        <!--end card-->
                    </div>
                   {{--  <div class="tab-pane fade" id="tab-ar" role="tabpanel">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                   <h2>Additional Details</h2>
                                </div>
                                <!--end row-->
                            </div>
                            <!--end card-body-->
                        </div>
                        <!--end card-->
                    </div> --}}

                    <!--end tab-pane-->
                </div>
                <!--end tab-content-->
            </div>
        </div>
        <!--end col-->
    </div>
    <!--end row-->


<!-- Static Backdrop -->

<!-- staticBackdrop Modal -->
<div class="modal fade" id="socialShare" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center p-5 pt-0">
                <lord-icon
                    src="https://cdn.lordicon.com/lupuorrc.json"
                    trigger="loop"
                    colors="primary:#121331,secondary:#08a88a"
                    style="width:120px;height:120px">
                </lord-icon>
                
                @if($gs->is_affilate==1)
                <div class="mt-4">
                    <h4 class="mb-3">Share It With Your Friends!</h4>
                    <p class="text-muted mb-4"> Earn More. Refer a new seller to us and earn $100 per refer ...</p>
                    <div>
                        <div class="social-share-btns copy-text-in" >                        
                            <a target="_blank" href="{{$socialShare['twitter']}}" class="avatar-xs d-block flex-shrink-0 me-3">
                                <span class="avatar-title rounded-circle  bg-dark text-light">
                                    <i class="ri-twitter-fill"></i>
                                </span>
                            </a>
                            <a target="_blank" href="{{$socialShare['facebook']}}" class="avatar-xs d-block flex-shrink-0 me-3">
                                <span class="avatar-title rounded-circle  bg-primary">
                                    <i class="ri-facebook-fill"></i>
                                </span>
                            </a>
                            <a target="_blank" href="{{$socialShare['linkedin']}}" class="avatar-xs d-block flex-shrink-0 me-3">
                                <span class="avatar-title rounded-circle  bg-linkedin">
                                    <i class="ri-linkedin-fill"></i>
                                </span>
                            </a>
                            <a target="_blank" href="{{$socialShare['whatsapp']}}" class="avatar-xs d-block flex-shrink-0 me-3">
                                <span class="avatar-title rounded-circle  bg-whatsapp">
                                    <i class="ri-whatsapp-fill"></i>
                                </span>
                            </a>
                            <a class="avatar-xs d-block flex-shrink-0 me-3 copy-text">
                                <span class="avatar-title rounded-circle  bg-copylink">
                                    <i class="ri-file-copy-line"></i>
                                </span>
                                <input style="display: block;opacity: 0" class="link" id="sharestorelink" value=" {{ route('front.index') }}?reff={{Auth::user()->affiliate_code}}">
                            </a>
                        </div>
                    </div>
                    {{-- <p> {!! $socialShare !!}
                      <a href="javascript:;" class="copy-link" data-clipboard-target="#sharestorelink"><i class="fa fa-link"></i></a>
                      <input style="display: block;opacity: 0" id="sharestorelink" value=" {{ route('front.index') }}?reff={{Auth::user()->affilate_code}}">
                    </p>  --}}   

                </div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection
@section('script')
    <!-- apexcharts -->
    <script src="{{ URL::asset('/assets/libs/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/jsvectormap/jsvectormap.min.js') }}"></script>
    {{-- <script src="{{ URL::asset('assets/libs/jsvectormap//world-merc.js') }}"></script> --}}

    <!-- dashboard init -->
    <script src="{{ URL::asset('/assets/js/pages/dashboard-analytics.init.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>

    <script type="text/javascript">
        let copyText = document.querySelector(".copy-text-in");
        copyText.querySelector(".copy-text").addEventListener("click", function () { 
            let input = copyText.querySelector("input.link");
            input.select();
            document.execCommand("copy");
            copyText.classList.add("activelink");
            window.getSelection().removeAllRanges();
            setTimeout(function () {
                copyText.classList.remove("activelink");
            }, 2500);
        });

    </script>
@endsection
