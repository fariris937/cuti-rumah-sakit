

<?php $__env->startSection('title', 'Persetujuan Lembur'); ?>
<?php $__env->startSection('page-title', 'Persetujuan Lembur'); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
    <h2>Daftar Persetujuan Lembur</h2>

    <?php if(session('success')): ?>
        <div class="alert alert-success"><?php echo e(session('success')); ?></div>
    <?php endif; ?>

    <?php if($overtimes->count() > 0): ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Karyawan</th>
                    <th>Tanggal</th>
                    <th>Jam Mulai</th>
                    <th>Jam Selesai</th>
                    <th>Keterangan</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $overtimes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $overtime): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($overtime->user->nama); ?></td>
                    <td><?php echo e(\Carbon\Carbon::parse($overtime->tanggal)->format('d/m/Y')); ?></td>
                    <td><?php echo e(\Carbon\Carbon::parse($overtime->jam_mulai)->format('H:i')); ?></td>
                    <td><?php echo e(\Carbon\Carbon::parse($overtime->jam_selesai)->format('H:i')); ?></td>
                    <td><?php echo e($overtime->keterangan); ?></td>
                    <td>
                        <?php if($overtime->status == 'pending'): ?>
                            <span class="badge bg-warning">Pending</span>
                        <?php elseif($overtime->status == 'approved'): ?>
                            <span class="badge bg-success">Disetujui</span>
                        <?php elseif($overtime->status == 'rejected'): ?>
                            <span class="badge bg-danger">Ditolak</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if($overtime->status == 'pending'): ?>
                            <form action="<?php echo e(route('overtime.approve', $overtime->id)); ?>" method="POST" class="d-inline">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="btn btn-success btn-sm">Setujui</button>
                            </form>
                            <form action="<?php echo e(route('overtime.reject', $overtime->id)); ?>" method="POST" class="d-inline">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="btn btn-danger btn-sm">Tolak</button>
                            </form>
                        <?php else: ?>
                            -
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Tidak ada permintaan lembur yang menunggu persetujuan.</p>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\farir\cuti-rumah-sakit\resources\views/overtime/approval.blade.php ENDPATH**/ ?>