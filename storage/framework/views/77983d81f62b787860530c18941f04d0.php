

<?php $__env->startSection('content'); ?>
<div class="container">
    <h3>Daftar Pengajuan Cuti - Kepala Bagian Kepegawaian</h3>

    <?php if(session('success')): ?>
        <div class="alert alert-success"><?php echo e(session('success')); ?></div>
    <?php endif; ?>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Tanggal Mulai</th>
                <th>Tanggal Selesai</th>
                <th>Keterangan</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $cutis; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cuti): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($cuti->user->nama); ?></td>
                <td><?php echo e($cuti->tanggal_mulai); ?></td>
                <td><?php echo e($cuti->tanggal_selesai); ?></td>
                <td><?php echo e($cuti->keterangan); ?></td>
                <td><?php echo e(ucfirst($cuti->status)); ?></td>
                <td>
                    <?php if($cuti->status === 'pending'): ?>
                        <form action="<?php echo e(route('cuti.approve', $cuti->id)); ?>" method="POST" style="display:inline;">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="btn btn-success btn-sm">Approve</button>
                        </form>
                        <form action="<?php echo e(route('cuti.reject', $cuti->id)); ?>" method="POST" style="display:inline;">
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\farir\cuti-rumah-sakit\resources\views/kepala_bagian/cuti/index.blade.php ENDPATH**/ ?>