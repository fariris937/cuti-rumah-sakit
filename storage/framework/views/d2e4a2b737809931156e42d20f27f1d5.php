

<?php $__env->startSection('title', 'Kelola User'); ?>
<?php $__env->startSection('page-title', 'Kelola User'); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="fas fa-users me-2"></i>Daftar User</h5>
        <a href="<?php echo e(route('admin.users.create')); ?>" class="btn btn-primary"><i class="fas fa-plus me-2"></i>Tambah User</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
<thead>
    <tr>
        <th>Nama</th>
        <th>Email</th>
        <th>Divisi</th>
        <th>Unit</th>
        <th>Jabatan</th>
        <th>Role</th>
        <th>Jenis</th>
        <th class="text-end">Jumlah Cuti</th>
        <th class="text-end">Sisa Cuti</th>
        <th>Aksi</th>
    </tr>
</thead>
<tbody>
    <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <tr>
        <td class="align-middle"><?php echo e($u->nama); ?></td>
        <td class="align-middle"><?php echo e($u->email); ?></td>
        <td class="align-middle"><?php echo e($u->divisi->nama_divisi ?? '-'); ?></td>
        <td class="align-middle">
<?php if($u->unitAktif && $u->unitAktif->count() > 0): ?>
    <?php echo e($u->unitAktif->pluck('nama_unit')->join(', ')); ?>

<?php else: ?>
    -
<?php endif; ?>
        </td>
        <td class="align-middle"><?php echo e($u->jabatan); ?></td>
        <td class="align-middle"><span class="badge bg-dark px-2 py-1"><?php echo e($u->role); ?></span></td>
        <td class="align-middle">
            <span class="badge <?php echo e($u->jenis_karyawan === 'medis' ? 'bg-primary' : 'bg-secondary'); ?> px-2 py-1">
                <?php echo e(ucfirst($u->jenis_karyawan)); ?>

            </span>
        </td>
        <td class="align-middle text-end"><?php echo e($u->jumlah_cuti); ?></td>
        <td class="align-middle text-end"><?php echo e($u->sisa_cuti); ?></td>
        <td class="align-middle">
            <a class="btn btn-sm btn-outline-primary me-1" href="<?php echo e(route('admin.users.edit', $u)); ?>"><i class="fas fa-edit"></i></a>
            <form action="<?php echo e(route('admin.users.destroy', $u)); ?>" method="POST" class="d-inline" onsubmit="return confirm('Hapus user ini?')">
                <?php echo csrf_field(); ?>
                <?php echo method_field('DELETE'); ?>
                <button class="btn btn-sm btn-outline-danger" type="submit"><i class="fas fa-trash"></i></button>
            </form>
        </td>
    </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</tbody>
            </table>
        </div>
    </div>
  </div>
<?php $__env->stopSection(); ?>




<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\farir\cuti-rumah-sakit\resources\views/admin/users/index.blade.php ENDPATH**/ ?>