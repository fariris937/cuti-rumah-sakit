

<?php $__env->startSection('title', 'Dashboard Kepala Ruangan'); ?>
<?php $__env->startSection('page-title', 'Dashboard Kepala Ruangan'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <!-- Widget Persetujuan Lembur -->
        <div class="col-md-3 mb-4">
            <div class="card bg-primary text-white shadow">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-clock me-2"></i>Persetujuan Lembur
                    </h5>
                </div>
                <div class="card-body">
                    <p class="card-text">Kelola permintaan lembur dari karyawan di unit Anda</p>
                    <a href="<?php echo e(route('overtime.approval')); ?>" class="btn btn-primary">
                        <i class="fas fa-check-circle me-2"></i>Lihat Permintaan Lembur
                    </a>
                </div>
            </div>
        </div>

        <!-- Widget Laporan Lembur -->
        <div class="col-md-3 mb-4">
            <div class="card bg-info text-white shadow">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-chart-bar me-2"></i>Laporan Lembur
                    </h5>
                </div>
                <div class="card-body">
                    <p class="card-text">Lihat laporan lembur yang telah Anda setujui</p>
                    <a href="<?php echo e(route('overtime.report')); ?>" class="btn btn-info">
                        <i class="fas fa-file-alt me-2"></i>Lihat Laporan
                    </a>
                </div>
            </div>
        </div>

        <!-- Widget Pengelolaan Cuti -->
        <div class="col-md-3 mb-4">
            <div class="card bg-success text-white shadow">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-calendar-check me-2"></i>Pengelolaan Cuti
                    </h5>
                </div>
                <div class="card-body">
                    <p class="card-text">Kelola permintaan cuti karyawan</p>
                    <a href="<?php echo e(route('kepala-ruangan.cuti.index')); ?>" class="btn btn-success">
                        <i class="fas fa-calendar-alt me-2"></i>Kelola Cuti
                    </a>
                </div>
            </div>
        </div>

        <!-- Widget Persetujuan Ijin -->
        <div class="col-md-3 mb-4">
            <div class="card bg-info text-white shadow">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-file-signature me-2"></i>Persetujuan Ijin
                    </h5>
                </div>
                <div class="card-body">
                    <p class="card-text">Kelola permintaan ijin karyawan</p>
                    <div class="row text-center mb-2">
                        <div class="col-6">
                            <h6 class="text-white"><?php echo e($pendingIjinCount ?? 0); ?></h6>
                            <small>Pending</small>
                        </div>
                        <div class="col-6">
                            <h6 class="text-white"><?php echo e($approvedIjinCount ?? 0); ?></h6>
                            <small>Disetujui</small>
                        </div>
                    </div>
                    <a href="<?php echo e(route('kepala-ruangan.ijin.index')); ?>" class="btn btn-info">
                        <i class="fas fa-file-alt me-2"></i>Kelola Ijin
                    </a>
                </div>
            </div>
        </div>

        <!-- Widget Statistik Unit -->
        <div class="col-md-3 mb-4">
            <div class="card bg-warning text-white shadow">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-users me-2"></i>Statistik Unit
                    </h5>
                </div>
                <div class="card-body">
                    <p class="card-text">Lihat informasi karyawan di unit Anda</p>
                    <div class="row text-center">
                        <div class="col-6">
                            <h4 class="text-white"><?php echo e(Auth::user()->unitAktif->count() ?? 0); ?></h4>
                            <small>Unit Aktif</small>
                        </div>
                        <div class="col-6">
                            <h4 class="text-white"><?php echo e(\App\Models\User::where('role', 'karyawan')->count()); ?></h4>
                            <small>Total Karyawan</small>
                        </div>
                    </div>
                    <?php if(Auth::user()->unitAktif && Auth::user()->unitAktif->count() > 0): ?>
                        <div class="mt-2">
                            <small class="text-white-50">Unit Anda:</small>
                            <div class="text-white">
                                <?php $__currentLoopData = Auth::user()->unitAktif; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $unit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <small class="d-block"><?php echo e($unit->nama_unit); ?></small>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="card shadow">
        <div class="card-header">
            <h5 class="mb-0"><i class="fas fa-bolt me-2"></i>Aksi Cepat</h5>
        </div>
        <div class="card-body">
            <div class="row text-center">
                <div class="col-md-3 mb-3">
                    <a href="<?php echo e(route('overtime.approval')); ?>" class="btn btn-outline-primary btn-lg w-100">
                        <i class="fas fa-clock fa-2x mb-2"></i><br>
                        Persetujuan Lembur
                    </a>
                </div>
                <div class="col-md-3 mb-3">
                    <a href="<?php echo e(route('overtime.report')); ?>" class="btn btn-outline-info btn-lg w-100">
                        <i class="fas fa-chart-bar fa-2x mb-2"></i><br>
                        Laporan Lembur
                    </a>
                </div>
                <div class="col-md-3 mb-3">
                    <a href="<?php echo e(route('kepala-ruangan.cuti.index')); ?>" class="btn btn-outline-success btn-lg w-100">
                        <i class="fas fa-calendar-check fa-2x mb-2"></i><br>
                        Kelola Cuti
                    </a>
                </div>
                <div class="col-md-3 mb-3">
                    <a href="<?php echo e(route('kepala-ruangan.ijin.index')); ?>" class="btn btn-outline-warning btn-lg w-100">
                        <i class="fas fa-file-signature fa-2x mb-2"></i><br>
                        Kelola Ijin
                    </a>
                </div>
            </div>
            <div class="row text-center mt-3">
                <div class="col-md-6 mb-3">
                    <a href="<?php echo e(route('kepala-ruangan.ijin.create')); ?>" class="btn btn-outline-primary btn-lg w-100">
                        <i class="fas fa-plus-circle fa-2x mb-2"></i><br>
                        Ajukan Ijin
                    </a>
                </div>
                <div class="col-md-6 mb-3">
                    <a href="<?php echo e(route('user.dashboard')); ?>" class="btn btn-outline-secondary btn-lg w-100">
                        <i class="fas fa-home fa-2x mb-2"></i><br>
                        Dashboard Utama
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\farir\cuti-rumah-sakit\resources\views/kepala_ruangan/dashboard.blade.php ENDPATH**/ ?>