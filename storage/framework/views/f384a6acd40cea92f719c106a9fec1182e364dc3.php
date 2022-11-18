
<?php $__env->startSection('css'); ?>
<link rel="stylesheet" href="<?php echo e(asset('front/styles/products.css')); ?>" />
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<?php echo $__env->make('front.layouts.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<div class="ts-wrapper">


    <main class="ts-category-main">
        <div class="container">
            <h1 class="ts-heading-1 text-uppercase text-center fw-bold mb-6">
                Our Listings
            </h1>

            <div class="mw-1000 mx-auto">
                <div class="ts-category-filter d-flex flex-column-reverse flex-md-row justify-content-between mb-6">
                    <form action="<?php echo e(route('front.category.detail',[Request::route('category')])); ?>" method="get" id="searchlistForm" class="ts-category-filter__search">
                        <div>
                            <input type="text" class="form-control form-control-lg rounded-pill" id="tsProductSearch"
                                placeholder="Search for your listing" name="name" />
                        </div>

                        <button type="submit" class="btn p-0">
                            <img src="<?php echo e(asset('front/assets/icons/search-icon-circle.svg')); ?>" alt="..." />
                        </button>
                    </form>
                    <div>
                        <select class="form-select form-select-lg rounded-pill" aria-label="Default select example" id="category_select">
                            <option selected disabled value="">Category Filter</option>
                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option <?php echo e(Request::route('category')==$category->slug?'selected':''); ?> value="<?php echo e($category->slug); ?>"><?php echo e($category->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>
                <div class="ts-product-listing mb-10">
                    <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div>
                        <a class="text-decoration-none text-dark-gray" href="<?php echo e(route('front.product.detail',$data->slug)); ?>">
                            <div class="ts-product-card shadow-sm rounded-3 overflow-hidden">
                                <div class="ts-product-card__header">
                                    <img src="<?php echo e(($data->category && $data->category->photo)?asset('/assets/images/category/'.$data->category->photo):URL::asset('front/assets/images/product-card-image.png')); ?>" alt="..." />
                                </div>
                                <div class="ts-product-card__body">
                                    <div class="ts-product-card__content my-auto">
                                        <div class="row row-cols-lg-2 mb-lg-3">
                                            <h5 class="fw-bold ts-heading-6">
                                                COMPANY NAME : <?php echo e($data->name); ?>

                                            </h5>
                                            <h5 class="fw-bold ts-heading-6">
                                                WEBSITE : <?php echo e($data->website); ?>

                                            </h5>
                                        </div>
                                        <div class="row row-cols-lg-2">
                                            <h5 class="fw-bold ts-heading-6">NICHE : <?php echo e($data->category?$data->category->name:''); ?></h5>
                                            <?php if($data->facebook): ?>
                                            <div class="d-flex flex-nowrap">
                                                <h5 class="fw-bold ts-heading-6 text-nowrap">
                                                    SOCIAL MEDIA :
                                                </h5>
                                                <div class="d-flex gap-2">
                                                    <nav class="ts-footer__footer d-flex justify-content-center gap-2">
                                                        <a href="<?php echo e($data->facebook); ?>">
                                                            <img width="10" src="<?php echo e(asset('front/assets/icons/facebook.svg')); ?>"
                                                                alt="..." />
                                                        </a>
                                                        
                                                    </nav>
                                                </div>
                                            </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                   
                                </div>
                            </div>
                        </a>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    
                </div>

                <nav class="ts-pagination" aria-label="Page navigation example">
                     <?php echo e($products->Oneachside(2)->appends($returndata)->links('front.pagination.default')); ?>

                </nav>
            </div>

        </div>
    </main>

</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
<script type="text/javascript">
 $('#category_select').on('change',function(){
  var val = $(this).val();
  let url='<?php echo e(route('front.category.detail',':category')); ?>';
  url=url.replace(':category',val);
  $('#searchlistForm').attr('action',url);
  $('#searchlistForm').submit();
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('front.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Projects\Velzon Admin Dashboard\resources\views/front/products.blade.php ENDPATH**/ ?>