

<?php $__env->startSection('title', 'Laporan Lembur'); ?>
<?php $__env->startSection('page-title', 'Laporan Lembur'); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
    <h2>Laporan Lembur</h2>

    <form method="GET" action="<?php echo e(route('overtime.report')); ?>" class="mb-3">
        <div class="row g-3 align-items-center">
            <div class="col-auto">
                <label for="month" class="col-form-label">Bulan</label>
            </div>
            <div class="col-auto">
                <select name="month" id="month" class="form-select">
                    <option value="">Semua</option>
                    <?php $__currentLoopData = range(1, 12); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($m); ?>" <?php echo e(request('month') == $m ? 'selected' : ''); ?>><?php echo e(DateTime::createFromFormat('!m', $m)->format('F')); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="col-auto">
                <label for="year" class="col-form-label">Tahun</label>
            </div>
            <div class="col-auto">
                <select name="year" id="year" class="form-select">
                    <option value="">Semua</option>
                    <?php $__currentLoopData = range(date('Y'), date('Y') - 5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $y): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($y); ?>" <?php echo e(request('year') == $y ? 'selected' : ''); ?>><?php echo e($y); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary">Filter</button>
            </div>
        </div>
    </form>

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
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>

        <?php if($overtimes instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator): ?>
            <?php echo e($overtimes->appends(request()->query())->links()); ?>

        <?php endif; ?>
    <?php else: ?>
        <p>Tidak ada data lembur.</p>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\farir\cuti-rumah-sakit\resources\views/overtime/report.blade.php ENDPATH**/ ?>