<?php $__env->startSection('content'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Contact List</h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo e(url('/admin')); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Contact List</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-danger">
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="allusers-table" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Name</th>
                                    <th>Parent Category</th>
                                    <th>Status</th>
                                    <th>Publish Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 0 ?>
                                <?php $__currentLoopData = $blog_cat; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bcat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php $i++ ?>
                                <tr>
                                    <td><?php echo e($i); ?></td>
                                    <td><?php echo e($bcat->name); ?></td>
                                    <td><?php echo e($bcat->parent_category); ?></td>
                                    <td><?php if($bcat->status == 1): ?> <label class="label label-sm label-success">Enable</label> <?php elseif($bcat->status == 0): ?> <label class="label label-sm label-danger">Disable</label> <?php endif; ?></td>
                                    <td><?php echo e($bcat->created_at); ?></td>
                                    <td>
                                        <div id="donate">
                                            <a href="/admin/blog/category/<?php echo e($bcat->id); ?>/edit" class="label label-warning label-sm"><i
                                                    class="fa fa-edit"></i></a>
                                            <a href="/admin/blog/category/<?php echo e($bcat->id); ?>/delete" class="label label-danger label-sm"><i
                                                    class="fa fa-trash"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->


<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.adminLayout.admin_design', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\GIT_Code\IndiaPropertyClinic\resources\views/admin/blog/category/view_category.blade.php ENDPATH**/ ?>