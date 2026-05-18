

<?php $__env->startSection('title', 'Tambah Unit'); ?>
<?php $__env->startSection('page-title', 'Tambah Unit'); ?>

<?php $__env->startSection('content'); ?>
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header"><i class="fas fa-plus me-2"></i>Form Unit</div>
            <div class="card-body">
                <form method="POST" action="<?php echo e(route('admin.units.store')); ?>">
                    <?php echo csrf_field(); ?>
                    <div class="mb-3">
                        <label class="form-label">Nama Unit</label>
                        <input type="text" name="nama_unit" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tipe Unit</label>
                        <select name="tipe_unit" class="form-select" required>
                            <option value="medis">Medis</option>
                            <option value="non-medis">Non-Medis</option>
                        </select>
                    </div>
                    <div class="d-flex justify-content-between">
                        <a href="<?php echo e(route('admin.units.index')); ?>" class="btn btn-secondary">Kembali</a>
                        <button class="btn btn-primary" type="submit">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>




<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\farir\cuti-rumah-sakit\resources\views/admin/units/create.blade.php ENDPATH**/ ?>