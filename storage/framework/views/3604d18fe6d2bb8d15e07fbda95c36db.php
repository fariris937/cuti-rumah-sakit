

<?php $__env->startSection('title', 'Ajukan Cuti'); ?>
<?php $__env->startSection('page-title', 'Ajukan Cuti Baru'); ?>

<?php $__env->startSection('content'); ?>
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-calendar-plus me-2"></i>
                    Form Pengajuan Cuti
                </h5>
            </div>
            <div class="card-body">
                <form method="POST" action="<?php echo e(route('cuti.store')); ?>" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="tanggal_mulai" class="form-label">Tanggal Mulai <span class="text-danger">*</span></label>
                            <input type="date" class="form-control <?php $__errorArgs = ['tanggal_mulai'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   id="tanggal_mulai" name="tanggal_mulai" 
                                   value="<?php echo e(old('tanggal_mulai')); ?>" 
                                   min="<?php echo e(date('Y-m-d')); ?>" required>
                            <?php $__errorArgs = ['tanggal_mulai'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="col-md-6">
                            <label for="tanggal_selesai" class="form-label">Tanggal Selesai <span class="text-danger">*</span></label>
                            <input type="date" class="form-control <?php $__errorArgs = ['tanggal_selesai'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   id="tanggal_selesai" name="tanggal_selesai" 
                                   value="<?php echo e(old('tanggal_selesai')); ?>" required>
                            <?php $__errorArgs = ['tanggal_selesai'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>Informasi:</strong>
                            <ul class="mb-0 mt-2">
                                <li>Sisa cuti Anda: <strong><?php echo e($user->sisa_cuti); ?> hari</strong></li>
                                <li>Lama cuti akan dihitung otomatis setelah Anda memilih tanggal</li>
                                <li>Pastikan tanggal tidak bertabrakan dengan cuti yang sudah diajukan</li>
                            </ul>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Lama Cuti</label>
                        <div class="form-control-plaintext" id="lama-cuti">
                            Pilih tanggal untuk menghitung lama cuti
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <textarea class="form-control <?php $__errorArgs = ['keterangan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                  id="keterangan" name="keterangan" rows="3"
                                  placeholder="Jelaskan alasan pengajuan cuti..."><?php echo e(old('keterangan')); ?></textarea>
                        <?php $__errorArgs = ['keterangan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>



                    <div class="d-flex justify-content-between">
                        <a href="<?php echo e(route('cuti.index')); ?>" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>
                            Kembali
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane me-2"></i>
                            Ajukan Cuti
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const tanggalMulai = document.getElementById('tanggal_mulai');
    const tanggalSelesai = document.getElementById('tanggal_selesai');
    const lamaCuti = document.getElementById('lama-cuti');
    const sisaCuti = "<?php echo e($user->sisa_cuti ?? 0); ?>";

    function calculateDays() {
        if (tanggalMulai.value && tanggalSelesai.value) {
            const start = new Date(tanggalMulai.value);
            const end = new Date(tanggalSelesai.value);
            
            if (end >= start) {
                const diffTime = Math.abs(end - start);
                const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;
                
                lamaCuti.innerHTML = `<strong>${diffDays} hari</strong>`;
                
                if (diffDays > sisaCuti) {
                    lamaCuti.innerHTML += ` <span class="text-danger">(Sisa cuti tidak mencukupi!)</span>`;
                } else {
                    lamaCuti.innerHTML += ` <span class="text-success">(Sisa cuti mencukupi)</span>`;
                }
            } else {
                lamaCuti.innerHTML = '<span class="text-danger">Tanggal selesai harus setelah tanggal mulai</span>';
            }
        } else {
            lamaCuti.innerHTML = 'Pilih tanggal untuk menghitung lama cuti';
        }
    }

    tanggalMulai.addEventListener('change', function() {
        tanggalSelesai.min = this.value;
        calculateDays();
    });

    tanggalSelesai.addEventListener('change', calculateDays);
});
</script>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\farir\cuti-rumah-sakit\resources\views/user/cuti/create.blade.php ENDPATH**/ ?>