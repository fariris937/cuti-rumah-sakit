

<?php $__env->startSection('title', 'Ajukan Cuti Bawahan'); ?>
<?php $__env->startSection('page-title', 'Ajukan Cuti untuk Bawahan'); ?>

<?php $__env->startSection('content'); ?>
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-calendar-plus me-2"></i>Form Pengajuan Cuti</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="<?php echo e(route('kepala-ruangan.cuti.store')); ?>">
                    <?php echo csrf_field(); ?>

                    <div class="mb-3">
                        <label for="user_id" class="form-label">Pilih Karyawan</label>
                        <select id="user_id" name="user_id" class="form-select" required>
                            <option value="">-- Pilih --</option>
                            <option value="<?php echo e($user->id); ?>">
                                <?php echo e($user->nama); ?> (Diri Sendiri) - Sisa cuti: <?php echo e($user->sisa_cuti); ?> hari
                            </option>
                            <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $emp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $unit = $emp->unitAktif->first();
                                ?>
                                <option value="<?php echo e($emp->id); ?>">
                                    <?php echo e($emp->nama); ?>

                                    <?php if($unit): ?>
                                        (<?php echo e($unit->nama_unit); ?> - <?php echo e(ucfirst($unit->tipe_unit)); ?>)
                                    <?php endif; ?>
                                    - Sisa cuti: <?php echo e($emp->sisa_cuti); ?> hari
                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                            <input type="date" id="tanggal_mulai" name="tanggal_mulai" class="form-control" min="<?php echo e(date('Y-m-d')); ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
                            <input type="date" id="tanggal_selesai" name="tanggal_selesai" class="form-control" required>
                        </div>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                        <a href="<?php echo e(route('kepala-ruangan.cuti.index')); ?>" class="btn btn-outline-secondary btn-lg me-md-2">
                            <i class="fas fa-arrow-left me-2"></i>Batal
                        </a>
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-paper-plane me-2"></i>Ajukan Cuti
                        </button>
                    </div>
                </form>
                <div class="mt-3 text-muted small">
                    - Jika unit karyawan bertipe Medis, pengajuan akan diarahkan untuk disetujui oleh Kepala Bagian divisi yang sama.
                    <br>
                    - Jika unit Non-Medis, pengajuan langsung ke Kepegawaian.
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>




<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\farir\cuti-rumah-sakit\resources\views/kepala_ruangan/cuti/create.blade.php ENDPATH**/ ?>