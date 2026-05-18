

<?php $__env->startSection('title', 'Riwayat Mutasi'); ?>
<?php $__env->startSection('page-title', 'Riwayat Mutasi'); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-exchange-alt me-2"></i>
                    Riwayat Mutasi Unit
                </h5>
            </div>
            <div class="card-body">
                <?php if($mutasiHistory->count() > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Unit</th>
                                    <th>Tipe Unit</th>
                                    <th>Tanggal Mulai</th>
                                    <th>Tanggal Selesai</th>
                                    <th>Status</th>
                                    <th>Lama di Unit</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $mutasiHistory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mutasi): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td>
                                        <strong><?php echo e($mutasi->nama_unit); ?></strong>
                                    </td>
                                    <td>
                                        <span class="badge <?php echo e($mutasi->tipe_unit == 'medis' ? 'bg-primary' : 'bg-secondary'); ?>">
                                            <?php echo e(ucfirst($mutasi->tipe_unit)); ?>

                                        </span>
                                    </td>
                                    <td><?php echo e(\Carbon\Carbon::parse($mutasi->pivot->tanggal_mulai)->format('d/m/Y')); ?></td>
                                    <td>
                                        <?php if($mutasi->pivot->tanggal_selesai): ?>
                                            <?php echo e(\Carbon\Carbon::parse($mutasi->pivot->tanggal_selesai)->format('d/m/Y')); ?>

                                        <?php else: ?>
                                            <span class="text-success">Masih Aktif</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if($mutasi->pivot->tanggal_selesai): ?>
                                            <span class="badge bg-secondary">Selesai</span>
                                        <?php else: ?>
                                            <span class="badge bg-success">Aktif</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php
                                            $startDate = \Carbon\Carbon::parse($mutasi->pivot->tanggal_mulai);
                                            $endDate = $mutasi->pivot->tanggal_selesai ? 
                                                \Carbon\Carbon::parse($mutasi->pivot->tanggal_selesai) : 
                                                \Carbon\Carbon::now();
                                            $days = $startDate->diffInDays($endDate);
                                        ?>
                                        <span class="badge bg-info">
                                            <?php echo e($days); ?> hari
                                        </span>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="text-center py-5">
                        <i class="fas fa-exchange-alt fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">Belum ada riwayat mutasi</h5>
                        <p class="text-muted">Riwayat mutasi akan muncul setelah Anda dipindahkan ke unit lain</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Statistik Mutasi -->
<?php if($mutasiHistory->count() > 0): ?>
<div class="row mt-4">
    <div class="col-md-4">
        <div class="card text-center">
            <div class="card-body">
                <h3 class="text-primary"><?php echo e($mutasiHistory->count()); ?></h3>
                <p class="text-muted mb-0">Total Mutasi</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-center">
            <div class="card-body">
                <h3 class="text-success"><?php echo e($mutasiHistory->where('pivot.tanggal_selesai', null)->count()); ?></h3>
                <p class="text-muted mb-0">Unit Aktif</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-center">
            <div class="card-body">
                <h3 class="text-info"><?php echo e($mutasiHistory->where('tipe_unit', 'medis')->count()); ?></h3>
                <p class="text-muted mb-0">Unit Medis</p>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\farir\cuti-rumah-sakit\resources\views/user/mutasi/history.blade.php ENDPATH**/ ?>