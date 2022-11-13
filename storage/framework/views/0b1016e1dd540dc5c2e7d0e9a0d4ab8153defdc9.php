
<?php $__env->startSection('css'); ?>
<link href="<?php echo e(asset('front/thirdparty/plyr/plyr.css')); ?>" rel="stylesheet" />
<link rel="stylesheet" href="<?php echo e(asset('front/styles/register.css')); ?>" />

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
    <nav class="text-center py-4 mb-4">
        <a href="<?php echo e(route('front.index')); ?>">
            <img width="132" class="mb-3" src="<?php echo e(asset('front/assets/images/logo-black.png')); ?>" alt="..." />
        </a>
    </nav>
    <div class="ts-video mb-8">
        <video id="videoDesktop" controls crossorigin playsinline
            poster="<?php echo e(asset('front/assets/images/register-video-poster.jpg')); ?>">
            <source type="video/mp4" src="https://vjs.zencdn.net/v/oceans.mp4" />
            <a>Video not supported</a>
        </video>
    </div>    
    <div class="form-wizard">
        <div class="row">
            <div class="col-md-6 m-auto text-center">
                <div class="d-inline-flex tab-span">
                <a href="<?php echo e(route('user.register')); ?>" class="tab-btn active">Register</a>
                <a href="javascript:;" onclick="infomsg('Please register first to subscribe a plan !')" class="tab-btn ">Pricing</a>
                </div> 
            </div>    
        </div>
    </div>

    <form action="<?php echo e(route('user.register.submit')); ?>" method="post" class="ts-contact-form rounded-3 mb-10">
        <?php echo csrf_field(); ?>
        <?php echo $__env->make('front.includes.alerts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <h1 class="ts-heading-1 fw-bold text-center text-white mb-6">
            Sign up
        </h1>
        <div class="form-floating mb-3">
            <input type="text" class="form-control" id="tsName" name="name" placeholder="name" />
            <label for="floatingInput">Name</label>
        </div>
        <div class="form-floating mb-3">
            <input type="tel" class="form-control" id="tsPhone" name="phone" placeholder="Phone" />
            <label for="floatingInput">Phone</label>
        </div>
        <div class="form-floating mb-3">
            <input type="email" class="form-control" id="useEmail" name="email" placeholder="Email" />
            <label for="floatingInput">Email</label>
        </div>
        <div class="form-floating mb-3">
            <input type="password" class="form-control" name="password" id="floatingInput" placeholder="Password" />
            <label for="floatingInput">Password</label>
        </div>
        <div class="form-floating mb-5">
            <input type="password" class="form-control" name="password_confirmation" id="tsConfirmPassword" placeholder="Confirm Password" />
            <label for="floatingInput">Confirm Password</label>
        </div>

        <button type="submit" class="btn btn-secondary w-100 mb-6 fw-bold">
            Register & Continue
        </button>

        <p class="fw-bold text-medium-gray">
            Already registered ?
            <a class="text-decoration-none text-white" href="<?php echo e(route('user.login')); ?>">
                Login now.</a>
        </p>
    </form>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
<script
    src="https://cdn.polyfill.io/v2/polyfill.min.js?features=es6,Array.prototype.includes,CustomEvent,Object.entries,Object.values,URL"></script>
<script src="https://unpkg.com/plyr@3"></script>
<script src="<?php echo e(asset('front/js/register.js')); ?>"></script>
   <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>
    <script type="text/javascript">
        function infomsg(msg) {
            toastr.info(msg);
        }
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('front.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Projects\Velzon Admin Dashboard\resources\views/front/register.blade.php ENDPATH**/ ?>