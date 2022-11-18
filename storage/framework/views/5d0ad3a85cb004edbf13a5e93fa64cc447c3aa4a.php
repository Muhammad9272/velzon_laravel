<!-- ========== App Menu ========== -->
<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <!-- Dark Logo-->
        <a href="<?php echo e(route('user.dashboard')); ?>" class="logo logo-dark">
            <span class="logo-sm">
                <img src="<?php echo e(URL::asset('assets/images/logo-sm.png')); ?>" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="<?php echo e($gs->admin_logo?asset('/assets/images/logo/'.$gs->admin_logo):URL::asset('assets/images/users/user-dummy-img.jpg')); ?>" alt="" height="" width="100%">
            </span>
        </a>
        <!-- Light Logo-->
        <a href="<?php echo e(route('user.dashboard')); ?>" class="logo logo-light">
            <span class="logo-sm">
                <img src="<?php echo e(URL::asset('assets/images/logo-sm.png')); ?>" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="<?php echo e($gs->admin_logo?asset('/assets/images/logo/'.$gs->admin_logo):URL::asset('assets/images/users/user-dummy-img.jpg')); ?>" alt="" height="" width="100%">
            </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">

            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav">
                <li class="menu-title"><span><?php echo app('translator')->get('translation.menu'); ?></span></li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="<?php echo e(route('user.dashboard')); ?>" >
                        <i class="ri-dashboard-2-line"></i> <span><?php echo app('translator')->get('translation.dashboards'); ?></span>
                    </a>
                    
                </li> <!-- end Dashboard Menu -->
                <li class="nav-item">
                    <a class="nav-link menu-link" href="<?php echo e(route('user.earnings')); ?>" >
                        <i class="ri-team-fill"></i> <span>Earnings </span>
                    </a>                    
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="<?php echo e(route('front.category')); ?>" >
                        <i class="bx bxs-category"></i> <span>Categories </span>
                    </a>                    
                </li>


                



            </ul>
        </div>
        <!-- Sidebar -->
    </div>
    <div class="sidebar-background"></div>
</div>
<!-- Left Sidebar End -->
<!-- Vertical Overlay-->
<div class="vertical-overlay"></div>
<?php /**PATH C:\xampp\htdocs\Projects\Velzon Admin Dashboard\resources\views/user/layouts/sidebar.blade.php ENDPATH**/ ?>