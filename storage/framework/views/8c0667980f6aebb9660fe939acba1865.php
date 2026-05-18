

<?php $__env->startSection('title', 'Kelola Ijin'); ?>
<?php $__env->startSection('page-title', 'Kelola Ijin'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-file-signature me-2"></i>Daftar Permintaan Ijin
                    </h5>
                </div>
                <div class="card-body">
                    <?php if(session('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i><?php echo e(session('success')); ?>

                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <?php if(session('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i><?php echo e(session('error')); ?>

                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Karyawan</th>
                                    <th>Tanggal Ijin</th>
                                    <th>Keterangan</th>
                                    <th>Jenis Ijin</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $ijin; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td><?php echo e($ijin->firstItem() + $index); ?></td>
                                        <td><?php echo e($item->user->nama); ?></td>
                                        <td><?php echo e(\Carbon\Carbon::parse($item->tanggal_ijin)->format('d/m/Y')); ?></td>
                                        <td><?php echo e(Str::limit($item->keterangan, 50)); ?></td>
                                        <td>
                                            <span class="badge bg-secondary"><?php echo e(ucfirst($item->jenis_ijin)); ?></span>
                                        </td>
                                        <td>
                                            <?php if($item->disetujui_oleh_kepala_ruangan): ?>
                                                <span class="badge bg-success">
                                                    <i class="fas fa-check me-1"></i>Disetujui
                                                </span>
                                            <?php else: ?>
                                                <span class="badge bg-warning">
                                                    <i class="fas fa-clock me-1"></i>Pending
                                                </span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if(!$item->disetujui_oleh_kepala_ruangan): ?>
                                                <div class="btn-group" role="group">
                                                    <form action="<?php echo e(route('kepala-ruangan.ijin.approve', $item->id)); ?>" method="POST" class="d-inline">
                                                        <?php echo csrf_field(); ?>
                                                        <div class="mb-2">
                                                            <textarea class="form-control form-control-sm" name="catatan_persetujuan" rows="2" placeholder="Catatan persetujuan (opsional)"></textarea>
                                                        </div>
                                                        <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('Apakah Anda yakin ingin menyetujui ijin ini?')">
                                                            <i class="fas fa-check me-1"></i>Setujui
                                                        </button>
                                                    </form>
                                                    <form action="<?php echo e(route('kepala-ruangan.ijin.reject', $item->id)); ?>" method="POST" class="d-inline ms-1">
                                                        <?php echo csrf_field(); ?>
                                                        <div class="mb-2">
                                                            <textarea class="form-control form-control-sm" name="catatan_persetujuan" rows="2" placeholder="Catatan penolakan (opsional)"></textarea>
                                                        </div>
                                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menolak ijin ini?')">
                                                            <i class="fas fa-times me-1"></i>Tolak
                                                        </button>
                                                    </form>
                                                </div>
                                            <?php else: ?>
                                                <span class="text-success">
                                                    <i class="fas fa-check-circle me-1"></i>Disetujui pada <?php echo e(\Carbon\Carbon::parse($item->tanggal_persetujuan)->format('d/m/Y H:i')); ?>

                                                </span>
                                                <?php if($item->catatan_persetujuan): ?>
                                                    <br><small class="text-muted">Catatan: <?php echo e($item->catatan_persetujuan); ?></small>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="7" class="text-center py-4">
                                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                            <p class="text-muted">Belum ada permintaan ijin</p>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <?php if($ijin->hasPages()): ?>
                        <div class="d-flex justify-content-center mt-4">
                            <?php echo e($ijin->links()); ?>

                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-12 text-center">
            <a href="<?php echo e(route('kepala-ruangan.dashboard')); ?>" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Kembali ke Dashboard
            </a>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\farir\cuti-rumah-sakit\resources\views/kepala_ruangan/ijin/index.blade.php ENDPATH**/ ?>