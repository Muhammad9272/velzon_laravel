<!-- ========== App Menu ========== -->
<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <!-- Dark Logo-->
        <a href="<?php echo e(route('admin.dashboard')); ?>" class="logo logo-dark">
            <span class="logo-sm">
                <img src="<?php echo e(URL::asset('assets/images/logo-sm.png')); ?>" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="<?php echo e($gs->admin_logo?asset('/assets/images/logo/'.$gs->admin_logo):URL::asset('assets/images/users/user-dummy-img.jpg')); ?>" alt="" height="" width="100%">
            </span>
        </a>
        <!-- Light Logo-->
        <a href="<?php echo e(route('admin.dashboard')); ?>" class="logo logo-light">
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
                    <a class="nav-link menu-link" href="<?php echo e(route('admin.dashboard')); ?>" >
                        <i class="ri-dashboard-2-line"></i> <span><?php echo app('translator')->get('translation.dashboards'); ?></span>
                    </a>
                    
                </li> <!-- end Dashboard Menu -->


                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarPagesUsers" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarPagesUsers">
                        <i class="ri-user-line"></i> <span>Users</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarPagesUsers">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="<?php echo e(route('admin.users.index')); ?>" class="nav-link">Users</a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo e(route('admin.users.subscribed.index')); ?>" class="nav-link"> Subscribed Users
                                </a>
                            </li>
                             <li class="nav-item">
                                <a href="<?php echo e(route('admin.users.transactions.index')); ?>" class="nav-link">  User Transactions
                                </a>
                            </li>

                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarPages" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarPages">
                        <i class="ri-pages-line"></i> <span>Subscriptions</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarPages">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="<?php echo e(route('admin.subplan.index')); ?>" class="nav-link">Add Subscriptions</a>
                            </li>
                           
                            <li class="nav-item">
                                <a href="<?php echo e(route('admin.subfeature.index')); ?>" class="nav-link"> Subscription Features
                                </a>
                            </li>
                           
                        </ul>
                    </div>
                </li>
                 <li class="nav-item">
                    <a class="nav-link menu-link" href="<?php echo e(route('admin.category.index')); ?>" >
                        <i class="ri-stack-line"></i> <span>Listing Categories </span>
                    </a>                    
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarListingPages" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarListingPages">
                        <i class="ri-pages-line"></i> <span>Listing</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarListingPages">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="<?php echo e(route('admin.product.index')); ?>" class="nav-link">Listing</a>
                            </li>
                           
                            <li class="nav-item">
                                <a href="<?php echo e(route('admin.product.import.create')); ?>" class="nav-link">Import Listing</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="menu-title"><span>Settings</span></li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="<?php echo e(route('admin.profile')); ?>" >
                        <i class="ri-user-settings-fill"></i> <span>Profile </span>
                    </a>                    
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="<?php echo e(route('admin.social')); ?>" >
                        <i class="ri-team-fill"></i> <span>Social </span>
                    </a>                    
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="<?php echo e(route('admin.generalsettings')); ?>" >
                        <i class=" ri-settings-2-fill"></i> <span>General</span>
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
<?php /**PATH C:\xampp\htdocs\Projects\Velzon Admin Dashboard\resources\views/admin/layouts/sidebar.blade.php ENDPATH**/ ?>