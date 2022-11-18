      <header class="text-center py-4 mb-4 fixed-top">
        <div class="container">
          <nav class="navbar navbar-expand-lg bg-white shadow">
            <div class="container-fluid">
              <a class="navbar-brand" href="<?php echo e(route('front.index')); ?>">
                <img
                  width="93"
                  src="<?php echo e(asset('front/assets/images/logo-black.png')); ?>"
                  alt="..."
                />
              </a>
              <button
                class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent"
                aria-expanded="false"
                aria-label="Toggle navigation"
              >
                <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 me-lg-5 mb-lg-0">
                  <?php if(!Auth::check() || (Auth::check() && !Auth::user()->userSubscriptions()->exists())): ?>
                  <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="<?php echo e(route('front.index')); ?>"
                      >Home</a
                    >
                  </li> 
                  <?php endif; ?>                 
                  <?php if(!Auth::check()): ?>
                  <li class="nav-item">
                    <a class="nav-link" href="<?php echo e(route('user.login')); ?>">Login</a>
                  </li>
                  <?php else: ?>
                    <?php if(Auth::user()->userSubscriptions()->exists()): ?>
                    <li class="nav-item">
                      <a class="nav-link" aria-current="page" href="<?php echo e(route('front.category')); ?>">Category</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo e(route('user.dashboard')); ?>">       
                          Affiliate Dashboard
                        </a>
                    </li>
                    <?php endif; ?>
                  <li class="nav-item">
                    <a class="nav-link" href="<?php echo e(route('user.logout')); ?>">Logout</a>
                  </li>
                  <?php endif; ?>
                </ul>
                <?php if(!Auth::check()): ?>
                <a class="btn btn-primary fw-bold" href="<?php echo e(route('user.register')); ?>"
                  >Register</a
                >
                <?php else: ?>
                <a class="btn btn-primary fw-bold" href="<?php echo e(route('front.pricing')); ?>"
                  ><?php echo e(Auth::user()->userSubscriptions()->exists()?'Cancel Subscription':'Start free Trial'); ?></a
                >
                <?php endif; ?>
              </div>
            </div>
          </nav>
        </div>
      </header><?php /**PATH C:\xampp\htdocs\Projects\Velzon Admin Dashboard\resources\views/front/layouts/header.blade.php ENDPATH**/ ?>