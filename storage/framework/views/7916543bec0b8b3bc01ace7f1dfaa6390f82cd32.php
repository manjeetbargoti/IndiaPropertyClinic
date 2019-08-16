<?php $__env->startSection('content'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Listed Property</h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">View Property</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-purple">
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="allusers-table" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Property Image</th>
                                    <th>Property Name</th>
                                    <th>Service Name</th>
                                    <th>Location</th>
                                    <th>Property Price</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $properties; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $property): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($property->id); ?></td>
                                    <?php if(!empty($property->image_name)): ?>
                                    <td><img width="60px" class="thumb"
                                            src="<?php echo e(asset('/images/backend_images/property_images/large/'.$property->image_name)); ?>">
                                    </td>
                                    <?php else: ?>
                                    <td><img width="60px" class="thumb"
                                            src="<?php echo e(asset('/images/backend_images/property_images/large/default.jpg')); ?>">
                                    </td>
                                    <?php endif; ?>
                                    <td><a target="_blank"
                                            href="<?php echo e(url('/properties/'.$property->property_url)); ?>"><?php echo e($property->property_name); ?></a>
                                    </td>
                                    <td><span class="label label-md label-success"><?php echo e($property->service_name); ?></span></td>
                                    <td><?php if(!empty($property->city)): ?><?php $__currentLoopData = \App\Cities::where('id', $property->city)->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $city): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php echo e($city->name); ?>,<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> <?php endif; ?> <?php if(!empty($property->country)): ?><?php $__currentLoopData = \App\Country::where('iso2', $property->country)->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php echo e($country->name); ?> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> <?php endif; ?></td>
                                    <td><?php if($property->property_price): ?><?php echo e($property->currency); ?> <?php echo e($property->property_price); ?><?php endif; ?></td>
                                    <td>
                                        <a data-target="#property_<?php echo e($property->id); ?>" data-toggle="modal"
                                            title="Detail" class="btn btn-success btn-xs"><i class="fa fa-info-circle"
                                                aria-hidden="true"></i></a>
                                        <?php if(Auth::user()->admin  == 1): ?>
                                        <a href="<?php echo e(url('/admin/property/'.$property->id.'/edit')); ?>" title="Edit"
                                            class="btn btn-warning btn-xs"><i class="fa fa-pencil-square-o"
                                                aria-hidden="true"></i></a>
                                        <a href="<?php echo e(url('/admin/property/'.$property->id.'/delete')); ?>" title="Delete"
                                            class="btn btn-danger btn-xs"><i class="fa fa-trash"
                                                aria-hidden="true"></i></a>
                                        <?php endif; ?>
                                    </td>
                                </tr>

                                <!-- Property Information Model -->
                                <div class="modal fade bs-example-modal-lg" id="property_<?php echo e($property->id); ?>"
                                    tabindex="-1" role="dialog" aria-labelledby="propertyView">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content row">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title" id="myModalLabel"><?php echo e($property->property_name); ?>

                                                    | Full Details</h4>
                                            </div>
                                            <div class="modal-body col-sm-12">
                                                <div class="col-sm-6">
                                                    <?php if(!empty($property->image_name)): ?>
                                                    <img width="320" class="img-responsive"
                                                        src="<?php echo e(asset('/images/backend_images/property_images/large/'.$property->image_name)); ?>">
                                                    <?php endif; ?>
                                                </div>
                                                <div class="col-sm-6">
                                                    <p><strong>Property Code:</strong> <?php echo e($property->property_code); ?>

                                                    </p>
                                                    <p><strong>Description:</strong>
                                                        <?php echo e(strip_tags(str_limit($property->description, $limit=80))); ?>

                                                    </p>
                                                    <h5><strong>Price:</strong> <span
                                                            style="color: #e60f0f;"><?php if($property->property_price): ?><?php echo e($property->currency); ?>

                                                            <?php echo e($property->property_price); ?><?php endif; ?></span></h5>
                                                    <p><strong>Category:</strong> <?php echo e($property->service_name); ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /. Property information Model -->
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-sm-5">
                            <div class="dataTables_info_1" id="allusers-table_info_1" role="status" aria-live="polite">
                                Showing 1 to 10 of 10 entries</div>
                        </div>
                        <div class="col-sm-7">
                            <div class="dataTables_paginate paging_simple_numbers_1" id="allusers-table_paginate_1">
                                <?php echo $properties->render(); ?>

                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<style>
.dataTables_info,
.paging_simple_numbers {
    display: none;
}

.pagination {
    margin: 10px 20px 20px 0px;
    float: right;
}

.dataTables_info_1 {
    margin: 20px;
}
</style>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.adminLayout.admin_design', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\GIT_Code\IndiaPropertyClinic\resources\views/admin/property/view-property.blade.php ENDPATH**/ ?>