<header id="page-topbar">
    <div class="layout-width">
        <div class="navbar-header">
            <div class="d-flex">
                <!-- LOGO -->
                <div class="navbar-brand-box horizontal-logo">
                    <a href="{{ route('user.dashboard') }}" class="logo logo-dark">
                        <span class="logo-sm">
                            <img src="{{ URL::asset('assets/images/logo-sm.png') }}" alt="" height="22">
                        </span>
                        <span class="logo-lg">
                            <img src="{{$gs->admin_logo?asset('/assets/images/logo/'.$gs->admin_logo):URL::asset('assets/images/users/user-dummy-img.jpg')}}" alt="" height="" width="100%">
                        </span>
                    </a>

                    <a href="{{ route('user.dashboard') }}" class="logo logo-light">
                        <span class="logo-sm">
                            <img src="{{ URL::asset('assets/images/logo-sm.png') }}" alt="" height="22">
                        </span>
                        <span class="logo-lg">
                            <img src="{{$gs->admin_logo?asset('/assets/images/logo/'.$gs->admin_logo):URL::asset('assets/images/users/user-dummy-img.jpg')}}" alt="" height="" width="100%">
                        </span>
                    </a>
                </div>

                <button type="button" class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger" id="topnav-hamburger-icon">
                    <span class="hamburger-icon">
                        <span></span>
                        <span></span>
                        <span></span>
                    </span>
                </button>

                <!-- App Search-->
               
            </div>

            <div class="d-flex align-items-center">

              
                <div class="dropdown ms-1 topbar-head-dropdown header-item">
                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img src="{{ URL::asset('/assets/images/flags/us.svg') }}" class="rounded" alt="Header Language" height="20">
                    </button>
                    
                </div>


                <div class="ms-1 header-item d-none d-sm-flex">
                     <div class="text-start ms-xl-2 text-white b-border">
                                {{Auth::user()->userbalance(1)}}
                     </div>
                </div>

                {{-- <div class="ms-1 header-item d-none d-sm-flex">
                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle light-dark-mode">
                        <i class='bx bx-moon fs-22'></i>
                    </button>
                </div> --}}

                <div class="dropdown ms-sm-3 header-item topbar-user">
                    <button type="button" class="btn" id="page-header-user-dropdown" data-bs-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <span class="d-flex align-items-center">
                            <img class="rounded-circle header-profile-user" src="{{Auth::user()->avatar?asset('assets/front/images/users/'.Auth::user()->avatar):URL::asset('assets/images/users/user-dummy-img.jpg')}}"
                                alt="Header Avatar">
                            <span class="text-start ms-xl-2">
                                <span class="d-none d-xl-inline-block ms-1 fw-medium user-name-text">{{Auth::guard('web')->user()->name}}</span>
                                <span class="d-none d-xl-block ms-1 fs-12 text-muted user-name-sub-text">User</span>
                            </span>
                            
                        </span>

                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        <!-- item-->
                        <h6 class="dropdown-header">Welcome {{Auth::guard('web')->user()->name}}!</h6>
                        <a class="dropdown-item" href="{{ route('user.profile') }}"><i
                                class="mdi mdi-account-circle text-muted fs-16 align-middle me-1"></i> <span
                                class="align-middle">Profile</span></a>
                       
                        <div class="dropdown-divider"></div>

                        <a class="dropdown-item" href="{{route('user.earnings')}}"><i class="mdi mdi-wallet text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Balance : <b>{{Auth::user()->userbalance(1)}}</b></span></a>
                    
                        {{-- <a class="dropdown-item" href=""><span
                                class="badge bg-soft-success text-success mt-1 float-end">New</span><i
                                class="mdi mdi-cog-outline text-muted fs-16 align-middle me-1"></i> <span
                                class="align-middle">Settings</span></a> --}}
                        <a class="dropdown-item" href="{{ route('user.profile') }}#changePassword"><i
                                class="mdi mdi-lock text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Change Password</span></a>
                        <a class="dropdown-item " href="javascript:void();"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i
                                class="bx bx-power-off font-size-16 align-middle me-1"></i> <span
                                key="t-logout">@lang('translation.logout')</span></a>
                        <form id="logout-form" action="{{ route('user.logout') }}" method="get" style="display: none;">
                            {{-- @csrf --}}
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
