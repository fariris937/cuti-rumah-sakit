

<?php $__env->startSection('title', 'Dashboard Kepala Kepegawaian'); ?>
<?php $__env->startSection('page-title', 'Dashboard Kepala Kepegawaian'); ?>

<?php $__env->startSection('content'); ?>

<div class="text-center mb-4">
    <img src="<?php echo e(asset('images/logo_rs_wates_husada.png')); ?>" alt="Logo RS Wates Husada" style="height: 80px;">
</div>

<div class="row mb-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-calendar-alt me-2"></i>Laporan Cuti Bulanan</h5>
                <div class="d-flex align-items-center gap-2">
                    <form id="cutiFilterForm" class="d-flex align-items-center" method="GET" action="<?php echo e(route('kepala-kepegawaian.dashboard')); ?>">
                        <select name="cuti_year" class="form-select form-select-sm me-2" style="width: auto;">
                            <?php $__currentLoopData = range(date('Y') - 2, date('Y')); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $y): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($y); ?>" <?php echo e(request('cuti_year', date('Y')) == $y ? 'selected' : ''); ?>>
                                    <?php echo e($y); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <select name="cuti_month" class="form-select form-select-sm me-2" style="width: auto;">
                            <?php $__currentLoopData = range(1, 12); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($m); ?>" <?php echo e(request('cuti_month', date('m')) == $m ? 'selected' : ''); ?>>
                                    <?php echo e(DateTime::createFromFormat('!m', $m)->format('F')); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <select name="cuti_day" class="form-select form-select-sm me-2" style="width: auto;">
                            <option value="">Semua Hari</option>
                            <?php $__currentLoopData = range(1, 31); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($d); ?>" <?php echo e(request('cuti_day') == $d ? 'selected' : ''); ?>>
                                    <?php echo e($d); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <button type="submit" class="btn btn-sm btn-primary me-2">Filter</button>
                        <a href="<?php echo e(route('kepala-kepegawaian.download.monthly', [
                            'year' => request('cuti_year', date('Y')),
                            'month' => request('cuti_month', date('m')),
                            'day' => request('cuti_day')
                        ])); ?>" class="btn btn-sm btn-success">
                            <i class="fas fa-download me-1"></i>Download PDF
                        </a>
                    </form>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-4">
                        <div class="text-center">
                            <h3 class="text-primary"><?php echo e($monthlyReports['total_leaves']); ?></h3>
                            <small class="text-muted">Total Cuti</small>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="text-center">
                            <h3 class="text-success"><?php echo e($monthlyReports['total_days']); ?></h3>
                            <small class="text-muted">Total Hari</small>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="text-center">
                            <h5 class="text-info"><?php echo e($monthlyReports['month']); ?></h5>
                            <small class="text-muted">Bulan</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-calendar-check me-2"></i>Rekap Cuti Tahunan</h5>
                <div class="d-flex align-items-center gap-2">
                    <form id="annualCutiFilterForm" class="d-flex align-items-center" method="GET" action="<?php echo e(route('kepala-kepegawaian.dashboard')); ?>">
                        <select name="annual_cuti_year" class="form-select form-select-sm me-2" style="width: auto;">
                            <?php $__currentLoopData = range(date('Y') - 2, date('Y')); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $y): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($y); ?>" <?php echo e(request('annual_cuti_year', date('Y')) == $y ? 'selected' : ''); ?>>
                                    <?php echo e($y); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <button type="submit" class="btn btn-sm btn-primary me-2">Filter</button>
                        <a href="<?php echo e(route('kepala-kepegawaian.download.annual', [
                            'year' => request('annual_cuti_year', date('Y'))
                        ])); ?>" class="btn btn-sm btn-success">
                            <i class="fas fa-download me-1"></i>Download PDF
                        </a>
                    </form>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-4">
                        <div class="text-center">
                            <h3 class="text-primary"><?php echo e($annualReports['total_leaves']); ?></h3>
                            <small class="text-muted">Total Cuti</small>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="text-center">
                            <h3 class="text-success"><?php echo e($annualReports['total_days']); ?></h3>
                            <small class="text-muted">Total Hari</small>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="text-center">
                            <h5 class="text-info"><?php echo e($annualReports['year']); ?></h5>
                            <small class="text-muted">Tahun</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Laporan Ijin Bulanan -->
<div class="row mb-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-file-alt me-2"></i>Laporan Ijin Bulanan</h5>
                <div class="d-flex align-items-center gap-2">
                    <form id="ijinFilterForm" class="d-flex align-items-center" method="GET" action="<?php echo e(route('kepala-kepegawaian.dashboard')); ?>">
                        <select name="ijin_year" class="form-select form-select-sm me-2" style="width: auto;">
                            <?php $__currentLoopData = range(date('Y') - 2, date('Y')); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $y): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($y); ?>" <?php echo e(request('ijin_year', date('Y')) == $y ? 'selected' : ''); ?>>
                                    <?php echo e($y); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <select name="ijin_month" class="form-select form-select-sm me-2" style="width: auto;">
                            <?php $__currentLoopData = range(1, 12); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($m); ?>" <?php echo e(request('ijin_month', date('m')) == $m ? 'selected' : ''); ?>>
                                    <?php echo e(DateTime::createFromFormat('!m', $m)->format('F')); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <select name="ijin_day" class="form-select form-select-sm me-2" style="width: auto;">
                            <option value="">Semua Hari</option>
                            <?php $__currentLoopData = range(1, 31); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($d); ?>" <?php echo e(request('ijin_day') == $d ? 'selected' : ''); ?>>
                                    <?php echo e($d); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <button type="submit" class="btn btn-sm btn-primary me-2">Filter</button>
                        <a href="<?php echo e(route('kepala-kepegawaian.download.ijin.monthly', [
                            'year' => request('ijin_year', date('Y')),
                            'month' => request('ijin_month', date('m')),
                            'day' => request('ijin_day')
                        ])); ?>" class="btn btn-sm btn-success">
                            <i class="fas fa-download me-1"></i>Download PDF
                        </a>
                    </form>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-4">
                        <div class="text-center">
                            <h3 class="text-primary"><?php echo e(isset($ijins) ? $ijins->where('tanggal_ijin', '>=', now()->startOfMonth())->where('tanggal_ijin', '<=', now()->endOfMonth())->count() : 0); ?></h3>
                            <small class="text-muted">Total Ijin</small>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="text-center">
                            <h3 class="text-warning"><?php echo e(isset($ijins) ? $ijins->where('status', 'pending')->count() : 0); ?></h3>
                            <small class="text-muted">Pending</small>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="text-center">
                            <h5 class="text-info"><?php echo e(now()->format('M Y')); ?></h5>
                            <small class="text-muted">Bulan</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-file-check me-2"></i>Rekap Ijin Tahunan</h5>
                <div class="d-flex align-items-center gap-2">
                    <form id="annualIjinFilterForm" class="d-flex align-items-center" method="GET" action="<?php echo e(route('kepala-kepegawaian.dashboard')); ?>">
                        <select name="annual_ijin_year" class="form-select form-select-sm me-2" style="width: auto;">
                            <?php $__currentLoopData = range(date('Y') - 2, date('Y')); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $y): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($y); ?>" <?php echo e(request('annual_ijin_year', date('Y')) == $y ? 'selected' : ''); ?>>
                                    <?php echo e($y); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <button type="submit" class="btn btn-sm btn-primary me-2">Filter</button>
                        <a href="<?php echo e(route('kepala-kepegawaian.download.ijin.annual', [
                            'year' => request('annual_ijin_year', date('Y'))
                        ])); ?>" class="btn btn-sm btn-success">
                            <i class="fas fa-download me-1"></i>Download PDF
                        </a>
                    </form>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-4">
                        <div class="text-center">
                            <h3 class="text-primary"><?php echo e(isset($ijins) ? $ijins->where('tanggal_ijin', '>=', now()->startOfYear())->where('tanggal_ijin', '<=', now()->endOfYear())->count() : 0); ?></h3>
                            <small class="text-muted">Total Ijin</small>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="text-center">
                            <h3 class="text-success"><?php echo e(isset($ijins) ? $ijins->where('status', 'disetujui')->count() : 0); ?></h3>
                            <small class="text-muted">Disetujui</small>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="text-center">
                            <h5 class="text-info"><?php echo e(now()->format('Y')); ?></h5>
                            <small class="text-muted">Tahun</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Laporan Cuti Karyawan -->
<div class="card mb-4">
    <div class="card-header">
        <h5 class="mb-0"><i class="fas fa-calendar-alt me-2"></i>Laporan Cuti Karyawan</h5>
    </div>
    <div class="card-body">
        <?php if($cutis->count() > 0): ?>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Nama Karyawan</th>
                            <th>Tanggal Mulai</th>
                            <th>Tanggal Selesai</th>
                            <th>Status</th>
                            <th>Disetujui Oleh</th>
                            <th>Tanggal Persetujuan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $cutis; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cuti): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($cuti->user->nama); ?></td>
                            <td><?php echo e($cuti->tanggal_mulai->format('d/m/Y')); ?></td>
                            <td><?php echo e($cuti->tanggal_selesai->format('d/m/Y')); ?></td>
                            <td>
                                <span class="badge bg-success"><?php echo e(ucfirst($cuti->status)); ?></span>
                            </td>
                            <td>
                                <?php if($cuti->disetujui_oleh_kepala_bagian): ?>
                                    <?php
                                        $approver = $cuti->disetujuiOlehKepalaBagian;
                                        if ($approver && $approver->role === 'kepala_bagian_kepegawaian') {
                                            $approverName = $approver->nama . ' (Kepala Bagian Kepegawaian)';
                                        } elseif ($approver) {
                                            $approverName = $approver->nama . ' (Kepala Bagian)';
                                        } else {
                                            $approverName = '-';
                                        }
                                    ?>
                                    <?php echo e($approverName); ?>

                                <?php elseif($cuti->disetujui_oleh_kepala_ruangan): ?>
                                    <?php echo e($cuti->disetujuiOlehKepalaRuangan->nama ?? '-'); ?> (Kepala Ruangan)
                                <?php else: ?>
                                    -
                                <?php endif; ?>
                            </td>
                            <td><?php echo e($cuti->updated_at->format('d/m/Y H:i')); ?></td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="text-center py-5">
                <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">Belum ada laporan cuti karyawan</h5>
                <p class="text-muted">Laporan cuti akan muncul setelah cuti disetujui oleh kepala bagian medis dan kepala ruangan non-medis.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Laporan Ijin Karyawan -->
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="fas fa-file-alt me-2"></i>Laporan Ijin Karyawan</h5>
        <a href="<?php echo e(route('kepala-kepegawaian.download.ijin.monthly', [
            'year' => request('ijin_year', date('Y')),
            'month' => request('ijin_month', date('m')),
            'day' => request('ijin_day')
        ])); ?>" class="btn btn-sm btn-success">
            <i class="fas fa-download me-1"></i>Download PDF
        </a>
    </div>
    <div class="card-body">
        <?php if(isset($ijins) && $ijins->count() > 0): ?>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Nama Karyawan</th>
                            <th>Divisi</th>
                            <th>Unit</th>
                            <th>Tanggal Ijin</th>
                            <!-- Removed Jam Mulai and Jam Selesai columns as per user request -->
                            <th>Jenis Ijin</th>
                            <th>Status</th>
                            <th>Disetujui Oleh</th>
                            <th>Tanggal Persetujuan</th>
                            <th>Berkas</th>
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
                            <!-- Removed Jam Mulai and Jam Selesai data cells as per user request -->
                            <td>
                                <span class="badge bg-info"><?php echo e(ucfirst($ijin->jenis_ijin)); ?></span>
                            </td>
                            <td>
                                <?php if($ijin->status == 'disetujui'): ?>
                                    <span class="badge bg-success"><?php echo e(ucfirst($ijin->status)); ?></span>
                                <?php elseif($ijin->status == 'pending'): ?>
                                    <span class="badge bg-warning"><?php echo e(ucfirst($ijin->status)); ?></span>
                                <?php else: ?>
                                    <span class="badge bg-danger"><?php echo e(ucfirst($ijin->status)); ?></span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if($ijin->disetujuiOlehKepalaRuangan): ?>
                                    <?php echo e($ijin->disetujuiOlehKepalaRuangan->nama); ?>

                                <?php elseif($ijin->disetujuiOlehKepalaBagian): ?>
                                    <?php echo e($ijin->disetujuiOlehKepalaBagian->nama); ?>

                                <?php else: ?>
                                    -
                                <?php endif; ?>
                            </td>
                            <td><?php echo e($ijin->updated_at->format('d/m/Y H:i')); ?></td>
                            <td>
                                <?php if($ijin->berkas_pendukung): ?>
                                    <a href="<?php echo e(asset('storage/berkas_pendukung/' . $ijin->berkas_pendukung)); ?>"
                                       target="_blank"
                                       class="btn btn-sm btn-primary">
                                        <i class="fas fa-download me-1"></i>Download
                                    </a>
                                <?php else: ?>
                                    <span class="text-muted">-</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="text-center py-5">
                <i class="fas fa-file-times fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">Belum ada laporan ijin karyawan</h5>
                <p class="text-muted">Laporan ijin akan muncul setelah ijin disetujui oleh kepala ruangan.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Laporan Lembur Disetujui -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-clock me-2"></i>
                    Laporan Lembur Disetujui
                </h5>
                <div class="d-flex align-items-center gap-2">
                    <form id="overtimeFilterForm" class="d-flex align-items-center" method="GET" action="<?php echo e(route('kepala-kepegawaian.dashboard')); ?>">
                        <select name="overtime_year" class="form-select form-select-sm me-2" style="width: auto;">
                            <?php $__currentLoopData = range(date('Y') - 2, date('Y')); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $y): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($y); ?>" <?php echo e(request('overtime_year', date('Y')) == $y ? 'selected' : ''); ?>>
                                    <?php echo e($y); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <select name="overtime_month" class="form-select form-select-sm me-2" style="width: auto;">
                            <?php $__currentLoopData = range(1, 12); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($m); ?>" <?php echo e(request('overtime_month', date('m')) == $m ? 'selected' : ''); ?>>
                                    <?php echo e(DateTime::createFromFormat('!m', $m)->format('F')); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <select name="overtime_day" class="form-select form-select-sm me-2" style="width: auto;">
                            <option value="">Semua Hari</option>
                            <?php $__currentLoopData = range(1, 31); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($d); ?>" <?php echo e(request('overtime_day') == $d ? 'selected' : ''); ?>>
                                    <?php echo e($d); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <button type="submit" class="btn btn-sm btn-primary me-2">Filter</button>
                        <a href="<?php echo e(route('kepala-kepegawaian.download.overtime', [
                            'year' => request('overtime_year', date('Y')),
                            'month' => request('overtime_month', date('m')),
                            'day' => request('overtime_day')
                        ])); ?>" class="btn btn-sm btn-success">
                            <i class="fas fa-download me-1"></i>Download PDF
                        </a>
                    </form>
                </div>
            </div>
            <div class="card-body">
                <?php if(isset($overtimeApproved) && $overtimeApproved->count() > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Nama Karyawan</th>
                                    <th>Tanggal Lembur</th>
                                    <th>Jam Mulai</th>
                                    <th>Jam Selesai</th>
                                    <th>Keterangan</th>
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
                                    <td><?php echo e($overtime->keterangan); ?></td>
                                    <td><?php echo e(ucfirst($overtime->status)); ?></td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="text-center py-5">
                        <i class="fas fa-clock fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">Belum ada laporan lembur disetujui</h5>
                        <p class="text-muted">Laporan lembur akan muncul setelah lembur disetujui oleh kepala ruangan.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\farir\cuti-rumah-sakit\resources\views/kepala_kepegawaian/dashboard.blade.php ENDPATH**/ ?>