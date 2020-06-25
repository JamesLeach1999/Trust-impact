
<script
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC6xrYHhT-_CeoktqgAwGjbOCNrmVUkXno&callback=initMap"
      defer
    ></script>
<?php $__env->startSection("content"); ?>

    
    

    


    <h2>Submit postcodes</h2>
    
    <?php echo Form::open(['action' => "PagesController@parseFile", "method" => "POST", "enctype"=> "multipart/form-data"]); ?>

    <div class="form-group">
    <div>
    <?php echo e(Form::file("cover_image")); ?>

    </div>
    <?php echo e(Form::submit("Submit", ['class' => "btn"])); ?>

    <?php echo Form::close(); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make("layouts.app", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\Trust impact\prac\resources\views/pages/create.blade.php ENDPATH**/ ?>