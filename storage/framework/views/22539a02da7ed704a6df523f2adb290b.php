

<?php $__env->startSection('title', 'Kelola Unit'); ?>
<?php $__env->startSection('page-title', 'Kelola Unit'); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="fas fa-hospital me-2"></i>Daftar Unit</h5>
        <a href="<?php echo e(route('admin.units.create')); ?>" class="btn btn-primary"><i class="fas fa-plus me-2"></i>Tambah Unit</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Nama Unit</th>
                        <th>Tipe</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $units; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($u->nama_unit); ?></td>
                        <td><span class="badge <?php echo e($u->tipe_unit==='medis' ? 'bg-primary' : 'bg-secondary'); ?>"><?php echo e(ucfirst($u->tipe_unit)); ?></span></td>
                        <td>
                            <a class="btn btn-sm btn-outline-primary" href="<?php echo e(route('admin.units.edit', $u)); ?>"><i class="fas fa-edit"></i></a>
                            <form action="<?php echo e(route('admin.units.destroy', $u)); ?>" method="POST" class="d-inline" onsubmit="return confirm('Hapus unit ini?')">
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




<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\farir\cuti-rumah-sakit\resources\views/admin/units/index.blade.php ENDPATH**/ ?>