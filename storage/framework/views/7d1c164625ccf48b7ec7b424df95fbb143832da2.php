<?php $__env->startSection('content'); ?>

<style>
.serview_container {
    background-image: url('../../bg-tan.webp');
    background-attachment: fixed;
    background-repeat: no-repeat;
    background-position: center center;
    background-size: cover;
}

#PPCLeadForm {
    background: #f15a27;
    border: 1px solid #f15a27;
    border-radius: 0.3em;
    padding: 1em 1em 0em 1em;
}

#PPCLeadForm h4 {
    color: #fff;
    text-transform: uppercase;
    font-size: 2em;
    font-weight: bold;
}

#PPCLeadForm #SubmitForm {
    background: #171747;
    border: 1px solid #171747;
}

.overlay_services {
    width: 100%;
    background: rgba(46,47,58);
    z-index: 1;
    position: absolute;
    height: 100%;
    opacity: 0.78;
}

.services_viewbannertxt{
    padding: 2em 0em;
}
.services_viewbannertxt ul, .services_viewbannertxt p {
    color: #fff;
    font-size: 16px;
    font-weight: 300;
}
</style>
<?php $__currentLoopData = $ppcPageData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pd): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<div class="smart_container">
    <div class="services_viewsec">
        <div class="services_viewbanner background-image"
            style="background-image:url('<?php echo e(url('images/backend_images/ppc_images/large/'.$pd->banner_image)); ?>')">
            <span role="img" aria-label="Plumbing Services"> </span>
            <div class="overlay_services"></div>
            <div class="services_viewbannertxt">
                <div class="container">
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-6 col-xl-6">
                            <h1 style="padding-top: 0.5em;font-size: 3em;"><?php echo e($pd->title); ?></h1>
                            <?php echo $pd->banner_content; ?>

                            
                            <a href="tel:<?php echo e($pd->phone); ?>" role="button" class="btn btn-lg btn-info"><span class="spinner-grow spinner-grow-sm"></span> Call Now</a>
                        </div>
                        <div class="col-12 col-sm-12 col-md-6 col-xl-6">
                            <div class="ser_prcessing">
                                <!-- MultiStep Form -->
                                <form id="PPCLeadForm" name="ppc_lead_form" method="post"
                                    action="<?php echo e(url('/ipc/'.$pd->url)); ?>">
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
                                    <?php echo e(csrf_field()); ?>

                                    <h4 class="text-center">Submit Service Request</h4>
                                    <div class="row">
                                        <div class="form-group col-12 col-sm-6">
                                            <label for="Full Name" class="sr-only">Full Name</label>
                                            <input type="text" name="full_name" id="FullName" class="form-control"
                                                placeholder="Full Name" required>
                                        </div>
                                        <div class="form-group col-12 col-sm-6">
                                            <label for="Email Address" class="sr-only">Email Address</label>
                                            <input type="email" name="email" id="EmailAddress" class="form-control"
                                                placeholder="Email Address" required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-12 col-sm-6">
                                            <label for="Phone no." class="sr-only">Phone no.</label>
                                            <input type="tel" name="phone" id="PhoneNo" class="form-control"
                                                placeholder="Phone no." required>
                                        </div>
                                        <div class="d-none">
                                            <input type="text" class="form-control" name="main_service" value="6">
                                        </div>
                                        <div class="form-group col-12 col-sm-6">
                                            <label for="Country" class="sr-only">Country</label>
                                            <select name="country" id="country" class="form-control">
                                                <option value="" selected>Select Country</option>
                                                <?php $__currentLoopData = \App\Country::orderBy('name', 'asc')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($c->iso2); ?>"><?php echo e($c->name); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-12 col-sm-6">
                                            <label for="State" class="sr-only">State</label>
                                            <select name="state" id="state" class="form-control">

                                            </select>
                                        </div>
                                        <div class="form-group col-12 col-sm-6">
                                            <label for="City" class="sr-only">City</label>
                                            <select name="city" id="city" class="form-control">

                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div id="SubServiceOn" class="form-group col-12 col-sm-6">
                                            <label for="Main Query Service" class="sr-only">Main Service</label>
                                            <select name="sub_service" id="SubServiceOnList" class="form-control">
                                                <option value="" selected>Select main service</option>
                                                <?php $__currentLoopData = \App\OtherServices::where('parent_id', $pd->main_service)->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $oths): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($oths->id); ?>"><?php echo e($oths->service_name); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                        <div id="SubsServiceOn" class="form-group col-12 col-sm-6">
                                            <select name="subs_service" id="SubsServiceOnList" class="form-control">
                                                <!-- <option value="test">Test</option> -->
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-12 col-sm-12">
                                            <label for="Query Message" class="sr-only">Query Message</label>
                                            <textarea name="message" id="QueryMessage" cols="30"
                                                placeholder="Query Message" class="form-control" required></textarea>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-sm-12">
                                            <input type="submit" name="submit" id="SubmitForm"
                                                class="form-control btn btn-info">
                                        </div>
                                    </div>
                                </form>
                                <!-- /.MultiStep Form -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="services_viewsec">
        <div class="serview_container">
            <div class="container">
                <div id="ser_howitwork" class="serview_conbox">
                    <div class="container">
                        <div class="col-12 col-sm-12 col-xl-12">
                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-xl-12">
                                    <?php echo $pd->description; ?>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.frontLayout.frontend_design2', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\GIT_Code\IndiaPropertyClinic\resources\views/frontend/ppc_pages/basic_template.blade.php ENDPATH**/ ?>