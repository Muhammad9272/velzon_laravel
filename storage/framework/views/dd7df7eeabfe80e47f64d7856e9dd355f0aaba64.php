
<?php $__env->startSection('title'); ?>
   
   General Settings
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <?php $__env->startComponent('components.breadcrumb'); ?>
        <?php $__env->slot('li_1'); ?>
              <a href="<?php echo e(route('admin.generalsettings')); ?>"> General  </a>
        <?php $__env->endSlot(); ?>
        <?php $__env->slot('title'); ?>
            Settings
        <?php $__env->endSlot(); ?>
    <?php echo $__env->renderComponent(); ?>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">General Settings </h4>
                    <div class="flex-shrink-0">
                       
                    </div>
                </div><!-- end card header -->
                <div class="card-body">
                    <div class="live-preview">
                         <?php echo $__env->make('admin.includes.alerts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        <form action="<?php echo e(route('admin.generalsettings.update')); ?>" method="post" enctype="multipart/form-data" >
                            <?php echo csrf_field(); ?>
                            <div class="row gy-4">
 
                              
                                <div class="col-lg-12"> 
                                    <h5 class="fw-semibold mb-3">Admin Panel Logo</h5>
                                    <div class="profile-user position-relative d-inline-block mx-auto  mb-4">
                                         <img src="<?php echo e($data->admin_logo?asset('/assets/images/logo/'.$data->admin_logo):URL::asset('assets/images/users/user-dummy-img.jpg')); ?>"
                                            class="rounded-circle avatar-xl img-thumbnail user-profile-image2"
                                            alt="user-profile-image">
                                        <div class="avatar-xs p-0 rounded-circle profile-photo-edit">
                                            <input id="profile-img-file-input2" style="display: none;" type="file" class="profile-img-file-input2" name="admin_logo" accept="image/png, image/gif, image/jpeg" />
                                            <label for="profile-img-file-input2" class="profile-photo-edit avatar-xs">
                                                <span class="avatar-title rounded-circle bg-light text-body">
                                                    <i class="ri-camera-fill"></i>
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-md-6">
                                    <div>
                                        <label for="basiInput" class="form-label"> Website Name</label>
                                        <input type="text" class="form-control" id="basiInput" name="name" value="<?php echo e($data->name); ?>" required>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-md-6">
                                    <div>
                                        <label for="basiInput" class="form-label"> Website Slogan</label>
                                        <input type="text" class="form-control" id="basiInput" value="<?php echo e($data->slogan); ?>"  name="slogan" required>
                                    </div>
                                </div>


                              
                               
                                <!--end col-->
                                <div class="col-12">
                                    <button class="btn btn-primary" type="submit">Submit form</button>
                                </div>
                                <!--end col-->
                            </div>
                        </form>
                        <!--end row-->
                    </div>
                </div>
            </div>
        </div>
        <!--end col-->
    </div>
    <!--end row-->
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
    <script src="<?php echo e(URL::asset('assets/js/pages/profile-setting.init.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('/assets/libs/prismjs/prismjs.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('/assets/js/app.min.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Projects\Velzon Admin Dashboard\resources\views/admin/generalsettings.blade.php ENDPATH**/ ?>