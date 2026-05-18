<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'Sistem Cuti Rumah Sakit'); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .sidebar .nav-link {
            color: rgba(255,255,255,0.8);
            border-radius: 8px;
            margin: 2px 0;
        }
        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            color: white;
            background-color: rgba(255,255,255,0.1);
        }
        .main-content {
            background-color: #f8f9fa;
            min-height: 100vh;
        }
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .card-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 15px 15px 0 0 !important;
        }
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
        }
        .btn-success {
            background: linear-gradient(135deg, #56ab2f 0%, #a8e6cf 100%);
            border: none;
        }
        .btn-danger {
            background: linear-gradient(135deg, #ff416c 0%, #ff4b2b 100%);
            border: none;
        }
        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.85em;
            font-weight: 500;
        }
        .status-pending {
            background-color: #fff3cd;
            color: #856404;
        }
        .status-disetujui {
            background-color: #d4edda;
            color: #155724;
        }
        .status-ditolak {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-3 col-lg-2 d-md-block sidebar collapse">
                <div class="position-sticky pt-3">
                    <div class="text-center mb-4">
                        <h4 class="text-white">
                            <i class="fas fa-hospital"></i>
                            RS Dashboard
                        </h4>
                    </div>
                    
                    <ul class="nav flex-column">
                        <?php if(auth()->guard()->check()): ?>
                            <?php if(auth()->user()->isKepalaBagian()): ?>
                                <li class="nav-item">
                                    <a class="nav-link <?php echo e(request()->routeIs('kepala-bagian.dashboard') ? 'active' : ''); ?>" href="<?php echo e(route('kepala-bagian.dashboard')); ?>">
                                        <i class="fas fa-tachometer-alt me-2"></i>
                                        Dashboard
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link <?php echo e(request()->routeIs('kepala-bagian.cuti.*') ? 'active' : ''); ?>" href="<?php echo e(route('kepala-bagian.cuti.index')); ?>">
                                        <i class="fas fa-calendar-check me-2"></i>
                                        Cuti
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link <?php echo e(request()->routeIs('user.mutasi.history') ? 'active' : ''); ?>" href="<?php echo e(route('user.mutasi.history')); ?>">
                                        <i class="fas fa-exchange-alt me-2"></i>
                                        Riwayat Mutasi
                                    </a>
                                </li>
                            <?php elseif(auth()->user()->isKepalaKepegawaian()): ?>
                                <li class="nav-item">
                                    <a class="nav-link <?php echo e(request()->routeIs('kepala-kepegawaian.dashboard') ? 'active' : ''); ?>" href="<?php echo e(route('kepala-kepegawaian.dashboard')); ?>">
                                        <i class="fas fa-tachometer-alt me-2"></i>
                                        Dashboard
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link <?php echo e(request()->routeIs('cuti.index') ? 'active' : ''); ?>" href="<?php echo e(route('cuti.index')); ?>">
                                        <i class="fas fa-calendar-check me-2"></i>
                                        Cuti
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link <?php echo e(request()->routeIs('user.mutasi.history') ? 'active' : ''); ?>" href="<?php echo e(route('user.mutasi.history')); ?>">
                                        <i class="fas fa-exchange-alt me-2"></i>
                                        Riwayat Mutasi
                                    </a>
                                </li>
                            <?php elseif(auth()->user()->isKepalaRuangan()): ?>
                                <li class="nav-item">
                                    <a class="nav-link <?php echo e(request()->routeIs('kepala-ruangan.dashboard') ? 'active' : ''); ?>" href="<?php echo e(route('kepala-ruangan.dashboard')); ?>">
                                        <i class="fas fa-tachometer-alt me-2"></i>
                                        Dashboard
                                    </a>
                                </li>
                            <?php else: ?>
                                <li class="nav-item">
                                    <a class="nav-link <?php echo e(request()->routeIs('user.dashboard') ? 'active' : ''); ?>" href="<?php echo e(route('user.dashboard')); ?>">
                                        <i class="fas fa-tachometer-alt me-2"></i>
                                        Dashboard
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link <?php echo e(request()->routeIs('cuti.index') ? 'active' : ''); ?>" href="<?php echo e(route('cuti.index')); ?>">
                                        <i class="fas fa-calendar-check me-2"></i>
                                        Cuti
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link <?php echo e(request()->routeIs('user.mutasi.history') ? 'active' : ''); ?>" href="<?php echo e(route('user.mutasi.history')); ?>">
                                        <i class="fas fa-exchange-alt me-2"></i>
                                        Riwayat Mutasi
                                    </a>
                                </li>
                            <?php endif; ?>
                            
                            <?php if(auth()->user()->isAdmin() || auth()->user()->isKepalaKepegawaian()): ?>
                            <li class="nav-item">
                                <a class="nav-link <?php echo e(request()->routeIs('admin.divisi.*') ? 'active' : ''); ?>" href="<?php echo e(route('admin.divisi.index')); ?>">
                                    <i class="fas fa-building me-2"></i>
                                    Kelola Divisi
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link <?php echo e(request()->routeIs('admin.units.*') ? 'active' : ''); ?>" href="<?php echo e(route('admin.units.index')); ?>">
                                    <i class="fas fa-industry me-2"></i>
                                    Kelola Unit
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link <?php echo e(request()->routeIs('admin.users.*') ? 'active' : ''); ?>" href="<?php echo e(route('admin.users.index')); ?>">
                                    <i class="fas fa-users me-2"></i>
                                    Kelola User
                                </a>
                            </li>
                            <?php endif; ?>

                            <li class="nav-item mt-4">
                                <form method="POST" action="<?php echo e(route('logout')); ?>">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="nav-link btn btn-link text-start w-100">
                                        <i class="fas fa-sign-out-alt me-2"></i>
                                        Logout
                                    </button>
                                </form>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </nav>

            <!-- Main content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 main-content">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2"><?php echo $__env->yieldContent('page-title', 'Dashboard'); ?></h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <?php if(auth()->guard()->check()): ?>
                            <div class="dropdown">
                                <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-user me-2"></i>
                                    <?php echo e(auth()->user()->nama); ?>

                                </button>
                                <ul class="dropdown-menu">
                                    <li><span class="dropdown-item-text"><?php echo e(auth()->user()->jabatan); ?></span></li>
                                    <li><span class="dropdown-item-text"><?php echo e(auth()->user()->divisi->nama_divisi ?? auth()->user()->divisi); ?></span></li>
                                    <?php if(auth()->user()->unitAktif && auth()->user()->unitAktif->count() > 0): ?>
                                        <li><span class="dropdown-item-text">Unit: <?php echo e(auth()->user()->unitAktif->pluck('nama_unit')->join(', ')); ?></span></li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <?php if(session('success')): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        <?php echo e(session('success')); ?>

                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <?php if(session('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        <?php echo e(session('error')); ?>

                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <?php echo $__env->yieldContent('content'); ?>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <?php echo $__env->yieldContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\Users\farir\cuti-rumah-sakit\resources\views/layouts/app.blade.php ENDPATH**/ ?>