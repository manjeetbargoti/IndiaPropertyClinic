<?php $__env->startSection('content'); ?>

<style>
.list_business_section {
    background-image: url('https://i2.wp.com/ismailandpartners.com/wp-content/uploads/2014/07/real-estate-background-1.jpg');
    background-attachment: fixed;
    background-repeat: no-repeat;
    background-position: center center;
    background-size: cover;
    font-size: 1rem !important;
}

.list_business_section h2 {
    padding-top: 2em;
    text-align: center;
    color: #171747;
    font-size: 22px;
}

.list_business_section h3 {
    padding: 1em 0em;
    color:#171747;
    font-size: 20px;
}
</style>
<section class="list_business_section">

    <div class="vender_formsec">
        <div class="vender_header">
            <a class="backtohome" href="<?php echo e(url('/')); ?>">Back To Home</a>
        </div>
        <div class="container h-100">
            <div class="row h-100">
                <div class="col-12 col-md-12 col-lg-12 col-xl-12 p-0">
                    <h2>List Your Business</h2>
                    <div class="mainform">
                        <?php if(Session::has('flash_message_success')): ?>
                        <div class="alert alert-success alert-dismissible">
                            <button class="close" data-dismiss="alert" aria-label="close">&times;</button>
                            <strong><?php echo session('flash_message_success'); ?></strong>
                        </div>
                        <?php endif; ?>
                        <?php if(Session::has('flash_message_error')): ?>
                        <div class="alert alert-error alert-dismissible">
                            <button class="close" data-dismiss="alert" aria-label="close">&times;</button>
                            <strong><?php echo session('flash_message_error'); ?></strong>
                        </div>
                        <?php endif; ?>

                        <form action="<?php echo e(url('/list-your-business')); ?>" method="POST" id="ListBusiness"
                            name="list_business">
                            <div class="row justify-content-md-center">
                                <div class="form-group col-sm-6 col-md-6 col-lg-6">
                                    <label for="Select Service" class="title_txt">Select Services</label>
                                    <select name="offered_service" id="OfferedBService" class="form-control">
                                        <option value="" selected>-- Select a Service --</option>
                                        <?php $__currentLoopData = \App\OtherServices::where('parent_id', 0)->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rservice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($rservice->id); ?>"><?php echo e($rservice->service_name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>
                            <div id="BusinessInformation" class="d-none">
                                <h3>Business Information</h3>
                                <div class="row">
                                    <!-- Business Name -->
                                    <div class="form-group col-sm-6 col-md-4 col-lg-4">
                                        <label class="title_txt">Business Name</label>
                                        <input type="text" id="ListBusinessName" name="business_name"
                                            class="form-control emptyformvalidation" placeholder="Enter your Business name">
                                    </div>
                                    <!-- Business Description -->
                                    <div class="form-group col-sm-6 col-md-8 col-lg-8">
                                        <label class="title_txt">Business Description</label> <span class="text-success">(max 500 words)</span>
                                        <textarea name="business_description" id="BuainessDescription" class="form-control" cols="30" rows="5" maxlength="500" placeholder="Write summery about your business..."></textarea>
                                    </div>
                                </div>

                                <h3>Business Location</h3>
                                <div class="row">
                                    <!-- Business Country -->
                                    <div class="form-group col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                        <label class="title_txt">Business Country</label>
                                        <select id="ListBusinessCountry" name="business_country" class="form-control emptyformvalidation">
                                            <option value="">-- Select Country --</option>    
                                            <?php $__currentLoopData = \App\Country::orderBy('name', 'asc')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cont): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($cont->iso2); ?>"><?php echo e($cont->name); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                    <!-- Business State -->
                                    <div class="form-group col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                        <label class="title_txt">Business State</label>
                                        <select id="ListBusinessState" name="business_state" class="form-control emptyformvalidation">
                                            <option value="">-- Select State --</option>
                                        </select>
                                    </div>
                                    <!-- Business City -->
                                    <div class="form-group col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                        <label class="title_txt">Business City</label>
                                        <select id="ListBusinessCity" name="business_city" class="form-control emptyformvalidation">
                                            <option value="">-- Select City --</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.frontLayout.frontend_design2', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\GIT_Code\IndiaPropertyClinic\resources\views/frontend/list_business.blade.php ENDPATH**/ ?>