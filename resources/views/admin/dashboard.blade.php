@extends('admin.layouts.master')
@section('title') Dashboard @endsection
@section('css')

    <link href="{{ URL::asset('assets/libs/jsvectormap/jsvectormap.min.css') }}" rel="stylesheet">

@endsection
@section('content')

    @component('components.breadcrumb')
        @slot('li_1') Dashboards @endslot
        @slot('title')  @endslot
    @endcomponent

    <div class="row">
        <div class="col-xxl-5">
            <div class="d-flex flex-column h-100">
                <div class="row h-100">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body p-0">
                               
                                <div class="row align-items-center">
                                    <div class="col-sm-8">
                                        <div class="p-3">
                                            <p class="fs-16 lh-base">Hi {{Auth::guard('admin')->user()->name }}, Welcome To <strong> {{$gs->name}} </strong> Admin Dashboard</p>
                                            
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="px-3">
                                            <img src="{{ URL::asset('assets/images/user-illustarator-2.png') }}"
                                                class="img-fluid" alt="">
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- end card-body-->
                        </div>
                    </div> <!-- end col-->
                </div> <!-- end row-->

                <div class="row">
                    <div class="col-md-6">
                        <div class="card card-animate">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <p class="fw-medium text-muted mb-0">Users</p>
                                        <h2 class="mt-4 ff-secondary fw-semibold"><span
                                                class="counter-value" data-target="{{$usercount}}">{{$usercount}}</span></h2>
                                        {{-- <p class="mb-0 text-muted"><span
                                                class="badge bg-light text-success mb-0">
                                                <i class="ri-arrow-up-line align-middle"></i> 16.24 %
                                            </span> vs. previous month</p> --}}
                                    </div>
                                    <div>
                                        <div class="avatar-sm flex-shrink-0">
                                            <span class="avatar-title bg-soft-info rounded-circle fs-2">
                                                <i data-feather="users" class="text-info"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- end card body -->
                        </div> <!-- end card-->
                    </div> <!-- end col-->

                    <div class="col-md-6">
                        <div class="card card-animate">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <p class="fw-medium text-muted mb-0">Admin Earnings</p>
                                        <h2 class="mt-4 ff-secondary fw-semibold">
                                            {{AppHelper::setCurrency($earning_net_admin)}}
                                        </h2>
                                        {{-- <p class="mb-0 text-muted"><span
                                                class="badge bg-light text-danger mb-0">
                                                <i class="ri-arrow-down-line align-middle"></i> 3.96 %
                                            </span> vs. previous month</p> --}}
                                    </div>
                                    <div>
                                        <div class="avatar-sm flex-shrink-0">
                                            <span class="avatar-title bg-soft-info rounded-circle fs-2">
                                                <i data-feather="activity" class="text-info"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- end card body -->
                        </div> <!-- end card-->
                    </div> <!-- end col-->
                </div> <!-- end row-->

                <div class="row">
                    <div class="col-md-6">
                        <div class="card card-animate">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <p class="fw-medium text-muted mb-0">User Earnings</p>
                                        <h2 class="mt-4 ff-secondary fw-semibold">
                                            {{AppHelper::setCurrency($earning_net_user)}}
                                        </h2>
                                       
                                    </div>
                                    <div>
                                        <div class="avatar-sm flex-shrink-0">
                                            <span class="avatar-title bg-soft-info rounded-circle fs-2">
                                                <i data-feather="activity" class="text-info"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- end card body -->
                        </div> <!-- end card-->
                    </div> <!-- end col-->

                    <div class="col-md-6">
                        <div class="card card-animate">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <p class="fw-medium text-muted mb-0">Listings</p>
                                        <h2 class="mt-4 ff-secondary fw-semibold"><span
                                                class="counter-value" data-target="{{$listing_count}}">{{$listing_count}}</span></h2>
                                      
                                    </div>
                                    <div>
                                        <div class="avatar-sm flex-shrink-0">
                                            <span class="avatar-title bg-soft-info rounded-circle fs-2">
                                                <i data-feather="external-link" class="text-info"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- end card body -->
                        </div> <!-- end card-->
                    </div> <!-- end col-->
                </div> <!-- end row-->
            </div>
        </div> <!-- end col-->

    </div> <!-- end row-->

@endsection
@section('script')
    <!-- apexcharts -->
    <script src="{{ URL::asset('/assets/libs/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/jsvectormap/jsvectormap.min.js') }}"></script>
    {{-- <script src="{{ URL::asset('assets/libs/jsvectormap//world-merc.js') }}"></script> --}}

    <!-- dashboard init -->
    <script src="{{ URL::asset('/assets/js/pages/dashboard-analytics.init.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection
