<!doctype html >
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"  data-layout="vertical" data-topbar="dark" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable" data-layout-mode="dark" data-layout-width="fluid" data-layout-position="scrollable" data-layout-style="default">

<head>
    <meta charset="utf-8" />
    <title>@yield('title')| {{$gs->name}} - Admin Dashboard </title>
    @if($gs->ngrok==1)
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests" />
    @endif
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Maalik Development" name="description" />
    <meta content="Maalik9272@gmail.com" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ URL::asset('assets/images/favicon.ico')}}">
    @include('admin.layouts.head-css')
</head>

@section('body')
    @include('admin.layouts.body')
@show
    <!-- Begin page -->
    <div id="layout-wrapper">
        @include('admin.layouts.topbar')
        @include('admin.layouts.sidebar')
        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    @yield('content')
                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->
            @include('admin.layouts.footer')
        </div>
        <!-- end main content-->
    </div>
    <!-- END layout-wrapper -->

    {{-- @include('admin.layouts.customizer') --}}

    <!-- JAVASCRIPT -->
    @include('admin.layouts.vendor-scripts')
</body>

</html>
