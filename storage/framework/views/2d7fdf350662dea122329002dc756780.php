

<?php $__env->startSection('title', 'Cuti Bawahan'); ?>
<?php $__env->startSection('page-title', 'Cuti Bawahan'); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="fas fa-users me-2"></i>Daftar Cuti Bawahan</h5>
        <a href="<?php echo e(route('kepala-ruangan.cuti.create')); ?>" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Ajukan Cuti untuk Bawahan
        </a>
    </div>
    <div class="card-body">
        <?php if($cutis->count() > 0): ?>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Tanggal</th>
                            <th>Lama</th>
                            <th>Status</th>
                            <th>Disetujui Oleh</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $cutis; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cuti): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($cuti->user->nama); ?></td>
                            <td><?php echo e(\Carbon\Carbon::parse($cuti->tanggal_mulai)->format('d/m/Y')); ?> - <?php echo e(\Carbon\Carbon::parse($cuti->tanggal_selesai)->format('d/m/Y')); ?></td>
                            <td><?php echo e(\Carbon\Carbon::parse($cuti->tanggal_mulai)->diffInDays(\Carbon\Carbon::parse($cuti->tanggal_selesai)) + 1); ?> hari</td>
                            <td><span class="status-badge status-<?php echo e($cuti->status); ?>"><?php echo e(ucfirst($cuti->status)); ?></span></td>
                            <td><?php echo e($cuti->disetujuiOleh->nama ?? '-'); ?></td>
                            <td>
                                <?php if($cuti->status === 'pending'): ?>
                                    <form action="<?php echo e(route('kepala-ruangan.cuti.approve', $cuti->id)); ?>" method="POST" style="display:inline;">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" class="btn btn-success btn-sm">Approve</button>
                                    </form>
                                    <form action="<?php echo e(route('kepala-ruangan.cuti.reject', $cuti->id)); ?>" method="POST" style="display:inline;">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" class="btn btn-danger btn-sm">Reject</button>
                                    </form>
                                <?php else: ?>
                                    <span class="text-muted">Sudah diproses</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p class="text-muted mb-0">Belum ada pengajuan cuti bawahan.</p>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>




<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\farir\cuti-rumah-sakit\resources\views/kepala_ruangan/cuti/index.blade.php ENDPATH**/ ?>