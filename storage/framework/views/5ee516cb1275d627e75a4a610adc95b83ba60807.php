
<?php $__env->startSection('css'); ?>
<link rel="stylesheet" href="<?php echo e(asset('front/styles/category.css')); ?>" />
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<?php echo $__env->make('front.layouts.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<div class="ts-wrapper">


    <main class="ts-category-main">
        <div class="container">
            <h1 class="ts-heading-1 text-uppercase text-center fw-bold mb-6">
                Categories
            </h1>

            <div class="mw-1000 mx-auto">
                <div class="ts-categories">
                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a class="text-dark nounderline" href="<?php echo e(route('front.category.detail',$data->slug)); ?>">
                    <div class="ts-category px-0">
                        <img class="w-100 rounded-3" src="<?php echo e($data->photo?asset('/assets/images/category/'.$data->photo):URL::asset('front/assets/images/CategoryCart.png')); ?>" alt="..." />
                        <div class="ts-category__category">
                            <img src="<?php echo e(asset('front/assets/icons/icon-globe.svg')); ?>" alt="..." />
                        </div>

                        <h3 class="text-center fw-bold mt-3">
                            <?php echo e($data->name); ?>

                           
                        </h3>
                    </div>
                    </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    

                </div>
            </div>
        </div>
    </main>

</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('front.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Projects\Velzon Admin Dashboard\resources\views/front/categories.blade.php ENDPATH**/ ?>