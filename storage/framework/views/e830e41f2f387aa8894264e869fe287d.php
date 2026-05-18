

<?php $__env->startSection('title', 'Ajukan Cuti'); ?>
<?php $__env->startSection('page-title', 'Ajukan Cuti'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-gradient-primary text-white">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-calendar-alt fa-2x me-3"></i>
                        <div>
                            <h4 class="mb-0">Pengajuan Cuti</h4>
                            <small>Silakan isi formulir di bawah ini untuk mengajukan cuti</small>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4">
                    <?php if(session('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <?php echo e(session('error')); ?>

                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <form action="<?php echo e(Auth::user()->role === 'kepala_bagian' ? route('kepala-bagian.cuti.store') : route('cuti.store')); ?>" method="POST">
                        <?php echo csrf_field(); ?>

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="tanggal_mulai" class="form-label fw-bold">
                                    <i class="fas fa-calendar-day text-primary me-2"></i>Tanggal Mulai
                                </label>
                                <input type="date" class="form-control form-control-lg" id="tanggal_mulai" name="tanggal_mulai" required>
                                <div class="form-text">Pilih tanggal mulai cuti</div>
                            </div>

                            <div class="col-md-6 mb-4">
                                <label for="tanggal_selesai" class="form-label fw-bold">
                                    <i class="fas fa-calendar-check text-primary me-2"></i>Tanggal Selesai
                                </label>
                                <input type="date" class="form-control form-control-lg" id="tanggal_selesai" name="tanggal_selesai" required>
                                <div class="form-text">Pilih tanggal selesai cuti</div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="keterangan" class="form-label fw-bold">
                                <i class="fas fa-comment text-primary me-2"></i>Keterangan
                            </label>
                            <textarea class="form-control form-control-lg" id="keterangan" name="keterangan" rows="4" placeholder="Jelaskan alasan pengajuan cuti..."></textarea>
                            <div class="form-text">Berikan penjelasan yang jelas tentang alasan cuti</div>
                        </div>

                        <?php if(isset($employees) && $employees->count() > 0): ?>
                        <div class="mb-4">
                            <label for="user_id" class="form-label fw-bold">
                                <i class="fas fa-users text-primary me-2"></i>Pilih Karyawan
                            </label>
                            <select class="form-select form-select-lg" id="user_id" name="user_id">
                                <option value="">Diri Sendiri</option>
                                <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($employee->id); ?>"><?php echo e($employee->nama); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <div class="form-text">Kosongkan untuk mengajukan cuti untuk diri sendiri, atau pilih karyawan untuk mengajukan cuti atas nama mereka</div>
                        </div>
                        <?php endif; ?>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                            <a href="<?php echo e(Auth::user()->role === 'kepala_bagian' ? route('kepala-bagian.cuti.index') : route('kepala-bagian-kepegawaian.cuti.index')); ?>" class="btn btn-outline-secondary btn-lg me-md-2">
                                <i class="fas fa-arrow-left me-2"></i>Batal
                            </a>
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-paper-plane me-2"></i>Ajukan Cuti
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.bg-gradient-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.card {
    border-radius: 15px;
    overflow: hidden;
}

.card-header {
    border-bottom: none;
    padding: 2rem;
}

.form-control-lg, .form-select-lg {
    border-radius: 10px;
    border: 2px solid #e9ecef;
    transition: all 0.3s ease;
}

.form-control-lg:focus, .form-select-lg:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
}

.btn {
    border-radius: 10px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.alert {
    border-radius: 10px;
    border: none;
}
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\farir\cuti-rumah-sakit\resources\views/kepala_bagian/cuti/create.blade.php ENDPATH**/ ?>