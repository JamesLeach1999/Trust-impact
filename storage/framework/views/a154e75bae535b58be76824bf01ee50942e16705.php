

<?php $__env->startSection("content"); ?>
<?php $__currentLoopData = $uri; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    

    <h1><?php echo e(var_dump(file("C:\wamp64\www\Trust impact\prac\public\storage\cover_images/" . end($uri[10])))); ?></h1>
    
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make("layouts.app", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\Trust impact\prac\resources\views/pages/test.blade.php ENDPATH**/ ?>