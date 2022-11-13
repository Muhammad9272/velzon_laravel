      <footer class="ts-footer">
        <div class="container">
          <div class="ts-footer__main text-center">
            <a href="<?php echo e(route('front.index')); ?>">
              <img
                class="mb-4"
                width="132"
                src="<?php echo e(asset('front/assets/images/logo-white.png')); ?>"
                alt="..."
              />
            </a>
            <hr />
            <nav
              class="ts-footer__links d-flex gap-4 justify-content-center mb-5"
            >
              <a href="<?php echo e(route('front.index')); ?>" class="ts-footer__link">Home</a>
              <a href="<?php echo e(route('front.category')); ?>" class="ts-footer__link">Category</a>
              <a href="<?php echo e(route('front.pricing')); ?>" class="ts-footer__link">Membership</a>
            </nav>
          </div>
        </div>

        <nav class="ts-footer__footer d-flex justify-content-center gap-5 py-4">
          <?php if($gs->facebook): ?>
          <a href="<?php echo e($gs->facebook); ?>">
            <img width="15" src="<?php echo e(asset('front/assets/icons/facebook.svg')); ?>" alt="..." />
          </a>
          <?php endif; ?>
          <?php if($gs->twitter): ?>
          <a href="<?php echo e($gs->twitter); ?>">
            <img width="30" src="<?php echo e(asset('front/assets/icons/twitter.svg')); ?>" alt="..." />
          </a>
          <?php endif; ?>
          <?php if($gs->instagram): ?>
          <a href="<?php echo e($gs->instagram); ?>">
            <img width="30" src="<?php echo e(asset('front/assets/icons/instagram.svg')); ?>" alt="..." />
          </a>
          <?php endif; ?>
          <?php if($gs->youtube): ?>
          <a href="<?php echo e($gs->youtube); ?>">
            <img width="30" src="<?php echo e(asset('front/assets/icons/youtube.svg')); ?>" alt="..." />
          </a>
          <?php endif; ?>
        </nav>
      </footer><?php /**PATH C:\xampp\htdocs\Projects\Velzon Admin Dashboard\resources\views/front/layouts/footer.blade.php ENDPATH**/ ?>