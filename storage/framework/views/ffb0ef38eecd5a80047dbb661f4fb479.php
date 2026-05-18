

<?php $__env->startSection('title', 'Kelola Divisi'); ?>
<?php $__env->startSection('page-title', 'Kelola Divisi'); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="fas fa-sitemap me-2"></i>Daftar Divisi</h5>
        <a href="<?php echo e(route('admin.divisi.create')); ?>" class="btn btn-primary"><i class="fas fa-plus me-2"></i>Tambah Divisi</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Nama Divisi</th>
                        <th>Kepala Divisi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $divisis; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($d->nama_divisi); ?></td>
                        <td><?php echo e($d->kepala_divisi ?? '-'); ?></td>
                        <td>
                            <a class="btn btn-sm btn-outline-primary" href="<?php echo e(route('admin.divisi.edit', $d)); ?>"><i class="fas fa-edit"></i></a>
                            <form action="<?php echo e(route('admin.divisi.destroy', $d)); ?>" method="POST" class="d-inline" onsubmit="return confirm('Hapus divisi ini?')">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button class="btn btn-sm btn-outline-danger" type="submit"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>




<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\farir\cuti-rumah-sakit\resources\views/admin/divisi/index.blade.php ENDPATH**/ ?>