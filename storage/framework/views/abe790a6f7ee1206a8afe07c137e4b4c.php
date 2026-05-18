

<?php $__env->startSection('title', 'Daftar Cuti'); ?>
<?php $__env->startSection('page-title', 'Daftar Cuti'); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-calendar-alt me-2"></i>
                    Daftar Cuti Saya
                </h5>
                <a href="<?php echo e(route('cuti.create')); ?>" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>
                    Ajukan Cuti Baru
                </a>
            </div>
            <div class="card-body">
                <?php if($cutis->count() > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Tanggal Mulai</th>
                                    <th>Tanggal Selesai</th>
                                    <th>Lama Cuti</th>
                                    <th>Status</th>
                                    <th>Disetujui Oleh</th>
                                    <th>Tanggal Persetujuan</th>
                                    <th>Dibuat</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $cutis; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cuti): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e(\Carbon\Carbon::parse($cuti->tanggal_mulai)->format('d/m/Y')); ?></td>
                                    <td><?php echo e(\Carbon\Carbon::parse($cuti->tanggal_selesai)->format('d/m/Y')); ?></td>
                                    <td>
                                        <span class="badge bg-info">
                                            <?php echo e(\Carbon\Carbon::parse($cuti->tanggal_mulai)->diffInDays(\Carbon\Carbon::parse($cuti->tanggal_selesai)) + 1); ?> hari
                                        </span>
                                    </td>
                                    <td>
                                        <span class="status-badge status-<?php echo e($cuti->status); ?>">
                                            <?php echo e(ucfirst($cuti->status)); ?>

                                        </span>
                                    </td>
                                    <td><?php echo e($cuti->disetujuiOleh->nama ?? '-'); ?></td>
                                    <td>
                                        <?php if($cuti->updated_at != $cuti->created_at): ?>
                                            <?php echo e($cuti->updated_at->format('d/m/Y H:i')); ?>

                                        <?php else: ?>
                                            -
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo e($cuti->created_at->format('d/m/Y H:i')); ?></td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="text-center py-5">
                        <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">Belum ada pengajuan cuti</h5>
                        <p class="text-muted">Silakan ajukan cuti baru untuk memulai</p>
                        <a href="<?php echo e(route('cuti.create')); ?>" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>
                            Ajukan Cuti Baru
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\farir\cuti-rumah-sakit\resources\views/user/cuti/index.blade.php ENDPATH**/ ?>