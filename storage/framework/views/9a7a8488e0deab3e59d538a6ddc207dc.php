<?php $__env->startSection('title', 'Dashboard Kepala Bagian'); ?>
<?php $__env->startSection('page-title', 'Dashboard Kepala Bagian'); ?>

<?php $__env->startSection('content'); ?>

<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card">
            <div class="card-header"><i class="fas fa-clock me-2"></i>Lembur</div>
            <div class="card-body">
                <a href="<?php echo e(route('overtime.create')); ?>" class="btn btn-outline-success btn-sm me-2">Ajukan Lembur</a>
                <a href="<?php echo e(route('overtime.report')); ?>" class="btn btn-success btn-sm">Riwayat Lembur</a>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="card-header"><i class="fas fa-file-alt me-2"></i>Ijin</div>
            <div class="card-body">
                <a href="<?php echo e(route('kepala-bagian.ijin.create')); ?>" class="btn btn-outline-primary btn-sm">Ajukan Ijin</a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-building me-2"></i>
                    <?php echo e($divisi->nama_divisi ?? 'Divisi'); ?>

                </h5>
                <a href="<?php echo e(Auth::user()->role === 'kepala_bagian' ? route('kepala-bagian.cuti.create') : route('kepala-bagian-kepegawaian.cuti.create')); ?>" class="btn btn-primary btn-sm">Ajukan Cuti</a>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="text-center">
                            <h3 class="text-primary"><?php echo e($users->count()); ?></h3>
                            <p class="text-muted">Total Karyawan</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-center">
                            <h3 class="text-warning"><?php echo e($cutiPending->count()); ?></h3>
                            <p class="text-muted">Cuti Menunggu</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-center">
                            <h3 class="text-success"><?php echo e($cutiHistory->where('status', 'disetujui')->count()); ?></h3>
                            <p class="text-muted">Cuti Disetujui</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-center">
                            <h3 class="text-danger"><?php echo e($cutiHistory->where('status', 'ditolak')->count()); ?></h3>
                            <p class="text-muted">Cuti Ditolak</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Cuti Menunggu Persetujuan -->
    <div class="col-lg-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-clock me-2"></i>
                    Cuti Menunggu Persetujuan
                </h5>
            </div>
            <div class="card-body">
                <?php if($cutiPending->count() > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Tanggal</th>
                                    <th>Lama</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $cutiPending->unique('id'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cuti): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($cuti->user->nama); ?></td>
                                    <td>
                                        <?php echo e(\Carbon\Carbon::parse($cuti->tanggal_mulai)->format('d/m/Y')); ?> - 
                                        <?php echo e(\Carbon\Carbon::parse($cuti->tanggal_selesai)->format('d/m/Y')); ?>

                                    </td>
                                    <td>
                                        <?php echo e(\Carbon\Carbon::parse($cuti->tanggal_mulai)->diffInDays(\Carbon\Carbon::parse($cuti->tanggal_selesai)) + 1); ?> hari
                                    </td>
                                    <td>
                                        <form method="POST" action="<?php echo e(route('kepala-bagian.cuti.approve', $cuti->id)); ?>" class="d-inline">
                                            <?php echo csrf_field(); ?>
                                            <button type="submit" class="btn btn-success btn-sm" 
                                                    onclick="return confirm('Setujui cuti ini?')">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </form>
                                        <form method="POST" action="<?php echo e(route('kepala-bagian.cuti.reject', $cuti->id)); ?>" class="d-inline">
                                            <?php echo csrf_field(); ?>
                                            <button type="submit" class="btn btn-danger btn-sm" 
                                                    onclick="return confirm('Tolak cuti ini?')">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p class="text-muted text-center">Tidak ada cuti yang menunggu persetujuan</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Mutasi Karyawan -->
    <div class="col-lg-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-exchange-alt me-2"></i>
                    Mutasi Karyawan
                </h5>
            </div>
            <div class="card-body">
                <form method="POST" action="<?php echo e(route('kepala-bagian.mutasi')); ?>">
                    <?php echo csrf_field(); ?>
                    <div class="mb-3">
                        <label for="user_id" class="form-label">Pilih Karyawan</label>
                        <select class="form-select" id="user_id" name="user_id" required>
                            <option value="">-- Pilih Karyawan --</option>
                            <?php $__currentLoopData = $usersForMutasi; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($user->id); ?>">
                                    <?php echo e($user->nama); ?> (<?php echo e(ucfirst($user->jenis_karyawan)); ?>)
                                    <?php if($user->unitAktif->count() > 0): ?>
                                        - <?php echo e($user->unitAktif->first()->nama_unit); ?>

                                    <?php endif; ?>
                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="unit_id" class="form-label">Unit Tujuan</label>
                        <select class="form-select" id="unit_id" name="unit_id" required>
                            <option value="">-- Pilih Unit --</option>
                            <?php $__currentLoopData = $units; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $unit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($unit->id); ?>"><?php echo e($unit->nama_unit); ?> (<?php echo e(ucfirst($unit->tipe_unit)); ?>)</option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>
                        Simpan Mutasi
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Daftar Karyawan -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-users me-2"></i>
                    Daftar Karyawan
                </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Jabatan</th>
                                <th>Jenis Karyawan</th>
                                <th>Unit Aktif</th>
                                <th>Sisa Cuti</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($user->nama); ?></td>
                                <td><?php echo e($user->jabatan); ?></td>
                                <td>
                                    <span class="badge <?php echo e($user->jenis_karyawan == 'medis' ? 'bg-primary' : 'bg-secondary'); ?>">
                                        <?php echo e(ucfirst($user->jenis_karyawan)); ?>

                                    </span>
                                </td>
                                <td>
                                    <?php if($user->unitAktif->count() > 0): ?>
                                        <?php echo e($user->unitAktif->first()->nama_unit); ?>

                                    <?php else: ?>
                                        <span class="text-muted">Belum ada unit</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="badge bg-info"><?php echo e($user->sisa_cuti); ?> hari</span>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Riwayat Cuti -->
<?php if($cutiHistory->count() > 0): ?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-history me-2"></i>
                    Riwayat Persetujuan Cuti
                </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th>Disetujui Oleh</th>
                            <th>Tanggal Persetujuan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $cutiHistory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cuti): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($cuti->user->nama); ?></td>
                            <td>
                                <?php echo e(\Carbon\Carbon::parse($cuti->tanggal_mulai)->format('d/m/Y')); ?> - 
                                <?php echo e(\Carbon\Carbon::parse($cuti->tanggal_selesai)->format('d/m/Y')); ?>

                            </td>
                            <td>
                                <span class="status-badge status-<?php echo e($cuti->status); ?>">
                                    <?php echo e(ucfirst($cuti->status)); ?>

                                </span>
                            </td>
                            <td><?php echo e($cuti->disetujuiOleh->nama ?? '-'); ?></td>
                            <td><?php echo e($cuti->updated_at->format('d/m/Y H:i')); ?></td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


</div>
<?php endif; ?>

<!-- Laporan Lembur Disetujui -->
<?php if(isset($overtimeApproved) && $overtimeApproved->count() > 0): ?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-clock me-2"></i>
                    Laporan Lembur Disetujui
                </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Nama Karyawan</th>
                                <th>Tanggal Lembur</th>
                                <th>Jam Mulai</th>
                                <th>Jam Selesai</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $overtimeApproved; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $overtime): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($overtime->user->nama); ?></td>
                                <td><?php echo e(\Carbon\Carbon::parse($overtime->tanggal)->format('d/m/Y')); ?></td>
                                <td><?php echo e($overtime->jam_mulai); ?></td>
                                <td><?php echo e($overtime->jam_selesai); ?></td>
                                <td><?php echo e(ucfirst($overtime->status)); ?></td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\farir\cuti-rumah-sakit\resources\views/kepala_bagian/dashboard.blade.php ENDPATH**/ ?>