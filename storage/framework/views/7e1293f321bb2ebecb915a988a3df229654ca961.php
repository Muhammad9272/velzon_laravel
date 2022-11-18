<script type="text/javascript">
    var key_stripe = "<?php echo e($key); ?>";
</script>
<div class="container">
    <div class="row mx-auto">
        <div class="col-md-12">
            <p class="fw-bold mb-1">You will be Charged <?php echo e(AppHelper::setCurrency($data->price)); ?>

                <?php if(auth()->user()->freetrial() && $data->free_trial>0 ): ?>
                 After Free Trial
                <?php elseif(!auth()->user()->freetrial() && $data->free_trial>0): ?>
                 <br><span class='text-danger'>Important : As You have already Availed free Trial.So you will have to continue without trial</span>
                <?php endif; ?>
            </p>
            
            <form action="javascript:;" method="post" id="activateplan">
                <?php echo csrf_field(); ?>
                <?php echo $__env->make('admin.includes.alerts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <!-- Stripe Elements Placeholder -->
                <div id="card-element"></div>
                <div id="card-errors" class="alert alert-danger display-none" role="alert"></div>
                
                <button id="card-button" data-route="<?php echo e(route('front.subplan.submit',$data->id)); ?>" class="btn btn-primary btn-lg w-100" data-secret="<?php echo e($intent->client_secret); ?>">
                     <i></i>
                    <custext class="addgatewaytext"> Add Payment Method & Continue</custext>
                </button>
                
               
            </form>
            <div class="btn-block text-center mt-2">
            <small><i class="fa fa-lock text-success mr-1"></i>  Your private card number will never touch our servers.</small>
          </div>
        </div>

    </div>
</div>
<script src="<?php echo e(asset('common_assets/js/add-payment-card.js')); ?>"></script>
<?php /**PATH C:\xampp\htdocs\Projects\Velzon Admin Dashboard\resources\views/front/subplandetails.blade.php ENDPATH**/ ?>