<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?php echo e($title); ?></title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        h1, h2, h3, h4, h5, h6 { margin: 0; padding: 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; word-wrap: break-word; table-layout: fixed; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; vertical-align: top; }
        th { background-color: #f2f2f2; }
        .header { text-align: center; margin-bottom: 20px; }
        .footer { position: fixed; bottom: 0; width: 100%; text-align: right; font-size: 10px; color: #666; }
    </style>
</head>
<body>
    <div class="header">
        <h2><?php echo e($title); ?></h2>
        <p>Periode: <?php echo e($period); ?></p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Nama Karyawan</th>
                <th>Divisi</th>
                <th>Unit</th>
                <th>Tanggal Ijin</th>
                <th>Jenis Ijin</th>
                <th>Status</th>
                <th>Disetujui Oleh</th>
                <th>Tanggal Persetujuan</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $ijins; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ijin): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($ijin->user->nama); ?></td>
                <td><?php echo e($ijin->user->divisi->nama_divisi ?? '-'); ?></td>
                <td>
                    <?php
                        $units = $ijin->user->units;
                        $unitNames = $units->pluck('nama_unit')->toArray();
                    ?>
                    <?php echo e(count($unitNames) > 0 ? implode(', ', $unitNames) : '-'); ?>

                </td>
                <td><?php echo e(\Carbon\Carbon::parse($ijin->tanggal_ijin)->format('d/m/Y')); ?></td>
                <td><?php echo e(ucfirst($ijin->jenis_ijin)); ?></td>
                <td><?php echo e(ucfirst($ijin->status)); ?></td>
                <td><?php echo e($ijin->disetujuiOlehKepalaRuangan->nama ?? '-'); ?></td>
                <td><?php echo e($ijin->updated_at->format('d/m/Y H:i')); ?></td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>

    <p><strong>Total Ijin:</strong> <?php echo e($total_ijins); ?></p>

    <div class="footer">
        <p>Dicetak pada: <?php echo e($generated_at); ?></p>
    </div>
</body>
</html>
<?php /**PATH C:\Users\farir\cuti-rumah-sakit\resources\views/kepala_kepegawaian/pdf/ijin_monthly_report.blade.php ENDPATH**/ ?>