

<?php $__env->startSection('title', $title); ?>

<?php $__env->startSection('content'); ?>
    <h2><?php echo e($title); ?></h2>
    <p>Periode: <?php echo e($period); ?></p>
    <p>Jumlah Lembur Disetujui: <?php echo e($total_overtimes); ?></p>
    <p>Dicetak pada: <?php echo e($generated_at); ?></p>

    <table border="1" cellspacing="0" cellpadding="5" width="100%">
        <thead>
            <tr>
                <th>Nama Karyawan</th>
                <th>Divisi</th>
                <th>Tanggal Lembur</th>
                <th>Jam Mulai</th>
                <th>Jam Selesai</th>
                <th>Keterangan</th>
                <th>Disetujui Oleh</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $overtimes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $overtime): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($overtime->user->nama); ?></td>
                <td><?php echo e($overtime->user->divisi->nama_divisi ?? '-'); ?></td>
                <td><?php echo e(\Carbon\Carbon::parse($overtime->tanggal)->format('d/m/Y')); ?></td>
                <td><?php echo e($overtime->jam_mulai); ?></td>
                <td><?php echo e($overtime->jam_selesai); ?></td>
                <td><?php echo e($overtime->keterangan); ?></td>
                <td><?php echo e($overtime->approvedBy->nama ?? '-'); ?></td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.pdf', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\farir\cuti-rumah-sakit\resources\views/kepala_kepegawaian/pdf/overtime_report.blade.php ENDPATH**/ ?>