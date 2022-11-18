
<?php $__env->startSection('content'); ?>

<div class="container">
    <nav class="text-center py-4 mb-4">
        <a href="<?php echo e(route('front.index')); ?>">
            <img width="132" class="mb-3" src="<?php echo e(asset('front/assets/images/logo-black.png')); ?>" alt="..." />
        </a>
    </nav>

    <form action="<?php echo e(route('user.login.submit')); ?>" method="post" class="ts-contact-form rounded-3 mb-10">
        <?php echo csrf_field(); ?>
        <?php echo $__env->make('admin.includes.alerts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <h1 class="ts-heading-1 text-center text-white mb-6 fw-bold">
            Login
        </h1>
        <div class="form-floating mb-3">
            <input type="email" class="form-control" id="tsEmail" name="email" placeholder="Email" />
            <label for="tsEmail">Email</label>
        </div>
        <div class="form-floating mb-5">
            <input type="password" class="form-control" id="tsPassword" name="password" placeholder="Password" />
            <label for="tsPassword">Password</label>
        </div>

        <button type="submit" class="btn btn-secondary w-100 mb-6 fw-bold">
            Login
        </button>

        <p class="fw-bold text-medium-gray">
            Not Yet registered ?
            <a class="text-decoration-none text-white" href="<?php echo e(route('user.register')); ?>">
                Register now.</a>
        </p>
        <p class="fw-bold text-medium-gray">
            Password not remember me ?
            <a class="text-decoration-none text-white" href="<?php echo e(route('user.forgot')); ?>">
                Forgot Now</a>
        </p>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('front.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Projects\Velzon Admin Dashboard\resources\views/front/login.blade.php ENDPATH**/ ?>