
<?php $__env->startSection('css'); ?>
  <link rel="stylesheet" href="<?php echo e(asset('front/styles/pricing.css')); ?>" />
  <link rel="stylesheet" href="<?php echo e(asset('front/payment.css')); ?>" />
  <script type="text/javascript">
      
      var full_name_user = '<?php echo e(auth()->user()->name); ?>';
      var payment_card_error="An error has occurred, try again";
  </script>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>


<nav class="text-center py-4 mb-6">
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
<div class="pricing form-wizard" id="form-wizard">
    <div class="row">
        <div class="col-md-6 m-auto text-center">
            <div class="d-inline-flex tab-span">
                <a href="javascript:;" onclick="infomsg('You are already registered please choose a plan to continue!')" class="tab-btn">Register</a>
                <a href="<?php echo e(route('front.pricing')); ?>" class="tab-btn active">Pricing</a>
            </div> 
        </div>    
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-4 m-auto text-center">
           <?php echo $__env->make('front.includes.alerts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> 
        </div>       
    </div>
    <div class="pricing-group row row-cols-lg-3 mb-7 gap-5 gap-lg-0 w-100 mx-auto">
        <?php $__currentLoopData = $datas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

            <div class="pricing-table m-auto <?php echo e($data->is_featured==1?'pricing-table--primary':''); ?>">
                <div class="d-flex justify-content-between align-items-baseline"> 
                    <h6 class="ts-heading-6 mb-3 fw-bold"><?php echo e($data->second_name); ?></h6>
                    <?php if(isset($checkSubscription) && $data->name==$checkSubscription->stripe_price): ?>  
                    <span class="badge bg-success">Active Plan</span>
                    <?php endif; ?>
                </div>
              
                <p class="mb-4">
                   <?php echo e($data->details); ?>

                </p>
                <?php if($data->free_trial>0): ?>   
                <div class="d-flex flex-wrap align-items-center gap-2 mb-0">            
                    <h1 class="fw-bold">Free</h1>
                    <p class="mb-0"> <?php echo e($data->free_trial); ?> days Free Trial</p>
                </div>

                <div class="d-flex flex-wrap align-items-center gap-2 mb-4">            
                    <p class="fw-bold mb-0"><?php echo e(AppHelper::setCurrency($data->price)); ?></p>
                    <p class="mb-0">/ <?php echo e(AppHelper::setInterval($data->interval)); ?></p>
                </div>

                <?php else: ?>
                <div class="d-flex flex-wrap align-items-center gap-2 mb-4">            
                    <h1 class="fw-bold"><?php echo e(AppHelper::setCurrency($data->price)); ?></h1>
                    <p class="mb-0">/ <?php echo e(AppHelper::setInterval($data->interval)); ?></p>
                </div>
                <?php endif; ?>

                <?php if(isset($checkSubscription) && $data->name==$checkSubscription->stripe_price): ?>                    
                        <a href="javascript:;" data-planName="<?php echo e($data->second_name); ?>" data-bs-toggle="modal" data-bs-target="#cancelSubscription" data-cancelhref="<?php echo e(route('front.subplan.cancel',$checkSubscription->id)); ?>" class="btn btn-outline-primary w-100 mb-5 fw-bold packagedetails">
                            Cancel Subscription
                        </a>
                <?php else: ?>
                 <button type="button" data-planName="<?php echo e($data->second_name); ?>" data-bs-toggle="modal" data-bs-target="#subplanModal" data-href="<?php echo e(route('front.subplan.detail',$data->id)); ?>" class="btn btn-outline-primary w-100 mb-5 fw-bold packagedetails">
                        Get Started Now
                    </button>
                <?php endif; ?>

                <ul class="pricing-table__list">                   
                    <?php $arr=json_decode($data->features);?>
                    <?php $__currentLoopData = $subfeatures; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$subfeature): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if(in_array($subfeature->id,$arr)): ?>
                        <li class="yes"><?php echo e($subfeature->name); ?></li>
                        <?php else: ?>
                        <li class="not"><?php echo e($subfeature->name); ?></li>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        


        <!-- The Modal For Subscription -->
        <div class="modal fade" id="subplanModal">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

              <!-- Modal Header -->
              <div class="modal-header">
                <h6 class="modal-title ts-heading-6  fw-bold">Subscribe</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
              </div>

              <!-- Modal body -->
              <div class="jq-loader mt-1">
                <div class="d-flex justify-content-center">
                  <div class="spinner-border" role="status">
                    <span class="sr-only">Loading...</span>
                  </div>
                </div>
              </div>
              <div class="modal-body">
                
              </div>

              <!-- Modal footer -->
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
              </div>

            </div>
          </div>
        </div>

         <!-- The Modal For SubscriptionCancel -->
        <div class="modal fade" id="cancelSubscription">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

              <!-- Modal Header -->
              <div class="modal-header">
                <h6 class="modal-title ts-heading-6  fw-bold">Cancel Subscription</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
              </div>

              <!-- Modal body -->
              
              <div class="modal-body">
                 <h6 class="ts-heading-6  fw-bold">You are going to unsubscribe this package! Are u sure?</h6>
              </div>

   
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <a href=""  class="btn btn-primary btn-ok">Continue</a>
              </div>

            </div>
          </div>
        </div>

    </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
   <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>
    <script src="https://js.stripe.com/v3/"></script>
    <script type="text/javascript">
        function infomsg(msg) {
            toastr.info(msg);
        }
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('front.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Projects\Velzon Admin Dashboard\resources\views/front/pricing.blade.php ENDPATH**/ ?>