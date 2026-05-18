  <?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\KepalaKepegawaianController;
use App\Http\Controllers\KepalaBagianController;
use App\Http\Controllers\KepalaRuanganController;
use App\Http\Controllers\CutiController;
use App\Http\Controllers\OvertimeController;
use App\Http\Controllers\MutasiController;
use App\Http\Controllers\DivisiController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\IjinController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['web'])->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

Route::middleware(['web', 'auth'])->group(function () {
    // Route untuk kepala kepegawaian
    Route::get('/kepala-kepegawaian/dashboard', [KepalaKepegawaianController::class, 'index'])->name('kepala-kepegawaian.dashboard');

    // Route untuk kepala bagian
    Route::middleware(['role:kepala_bagian'])->group(function () {
        Route::get('/kepala-bagian/dashboard', [KepalaBagianController::class, 'index'])->name('kepala-bagian.dashboard');
        Route::get('/kepala-bagian/cuti/index', [CutiController::class, 'index'])->name('kepala-bagian.cuti.index');
        Route::get('/kepala-bagian/cuti/create', [CutiController::class, 'create'])->name('kepala-bagian.cuti.create');
        Route::post('/kepala-bagian/cuti/store', [CutiController::class, 'store'])->name('kepala-bagian.cuti.store');
        Route::post('/kepala-bagian/cuti/approve/{id}', [KepalaBagianController::class, 'approveCuti'])->name('kepala-bagian.cuti.approve');
        Route::post('/kepala-bagian/cuti/reject/{id}', [KepalaBagianController::class, 'rejectCuti'])->name('kepala-bagian.cuti.reject');
        Route::post('/kepala-bagian/mutasi', [KepalaBagianController::class, 'mutasi'])->name('kepala-bagian.mutasi');

        // Route untuk ijin kepala bagian
        Route::get('/kepala-bagian/ijin/create', [KepalaBagianController::class, 'createIjin'])->name('kepala-bagian.ijin.create');
        Route::post('/kepala-bagian/ijin/store', [KepalaBagianController::class, 'storeIjin'])->name('kepala-bagian.ijin.store');
        Route::get('/kepala-bagian/ijin/index', [KepalaBagianController::class, 'ijinIndex'])->name('kepala-bagian.ijin.index');
        Route::post('/kepala-bagian/ijin/approve/{id}', [KepalaBagianController::class, 'approveIjin'])->name('kepala-bagian.ijin.approve');
        Route::post('/kepala-bagian/ijin/reject/{id}', [KepalaBagianController::class, 'rejectIjin'])->name('kepala-bagian.ijin.reject');
    });

    // Route untuk kepala bagian kepegawaian
    Route::middleware(['role:kepala_bagian_kepegawaian,kepala_bagian'])->group(function () {
        Route::get('/kepala-bagian-kepegawaian/cuti/index', [CutiController::class, 'index'])->name('kepala-bagian-kepegawaian.cuti.index');
        Route::get('/kepala-bagian-kepegawaian/cuti/create', [CutiController::class, 'create'])->name('kepala-bagian-kepegawaian.cuti.create');
        Route::post('/cuti/approve/{id}', [CutiController::class, 'approveCuti'])->name('cuti.approve');
        Route::post('/cuti/reject/{id}', [CutiController::class, 'rejectCuti'])->name('cuti.reject');
    });

    // Route untuk kepala ruangan
    Route::get('/kepala-ruangan/dashboard', [KepalaRuanganController::class, 'dashboard'])->name('kepala-ruangan.dashboard');
    Route::get('/kepala-ruangan/cuti/index', [CutiController::class, 'index'])->name('kepala-ruangan.cuti.index');
    Route::get('/kepala-ruangan/cuti/create', [CutiController::class, 'create'])->name('kepala-ruangan.cuti.create');
    Route::post('/kepala-ruangan/cuti/approve/{id}', [CutiController::class, 'approveCuti'])->name('kepala-ruangan.cuti.approve');
    Route::post('/kepala-ruangan/cuti/reject/{id}', [CutiController::class, 'rejectCuti'])->name('kepala-ruangan.cuti.reject');
    Route::post('/kepala-ruangan/cuti/store', [CutiController::class, 'store'])->name('kepala-ruangan.cuti.store');

    // Route untuk ijin kepala ruangan
    Route::get('/kepala-ruangan/ijin/index', [KepalaRuanganController::class, 'ijinIndex'])->name('kepala-ruangan.ijin.index');
    Route::get('/kepala-ruangan/ijin/create', [KepalaRuanganController::class, 'ijinCreate'])->name('kepala-ruangan.ijin.create');
    Route::post('/kepala-ruangan/ijin/approve/{id}', [KepalaRuanganController::class, 'ijinApprove'])->name('kepala-ruangan.ijin.approve');
    Route::post('/kepala-ruangan/ijin/reject/{id}', [KepalaRuanganController::class, 'ijinReject'])->name('kepala-ruangan.ijin.reject');

    Route::get('/download/monthly', [KepalaKepegawaianController::class, 'downloadMonthly'])->name('kepala-kepegawaian.download.monthly');
    Route::get('/download/annual', [KepalaKepegawaianController::class, 'downloadAnnual'])->name('kepala-kepegawaian.download.annual');
    Route::get('/download/ijin/monthly', [KepalaKepegawaianController::class, 'downloadIjinMonthly'])->name('kepala-kepegawaian.download.ijin.monthly');
    Route::get('/download/ijin/annual', [KepalaKepegawaianController::class, 'downloadIjinAnnual'])->name('kepala-kepegawaian.download.ijin.annual');
    Route::get('/download/overtime', [KepalaKepegawaianController::class, 'downloadOvertime'])->name('kepala-kepegawaian.download.overtime');

    Route::resource('cuti', CutiController::class);

    // Overtime routes
    Route::get('/overtime/create', [OvertimeController::class, 'create'])->name('overtime.create');
    Route::post('/overtime/store', [OvertimeController::class, 'store'])->name('overtime.store');

    Route::get('/overtime/approval', [OvertimeController::class, 'approvalList'])->name('overtime.approval');
    Route::post('/overtime/approve/{id}', [OvertimeController::class, 'approve'])->name('overtime.approve');
    Route::post('/overtime/reject/{id}', [OvertimeController::class, 'reject'])->name('overtime.reject');

    Route::get('/overtime/report', [OvertimeController::class, 'report'])->name('overtime.report');

    // Tambahkan route untuk user.mutasi.history
    Route::get('/user/mutasi/history', [MutasiController::class, 'history'])->name('user.mutasi.history');

    // Tambahkan route untuk user.dashboard
    Route::get('/user/dashboard', [UserController::class, 'dashboard'])->name('user.dashboard');

    // Route untuk ijin
    Route::get('/ijin/create', [IjinController::class, 'create'])->name('ijin.create');
    Route::post('/ijin/store', [IjinController::class, 'store'])->name('ijin.store');

    // Tambahkan route resource untuk admin.divisi.index, hanya untuk admin dan kepala kepegawaian
    Route::middleware(['role:admin,kepala_kepegawaian'])->group(function () {
        Route::resource('admin/divisi', DivisiController::class)->names([
            'index' => 'admin.divisi.index',
            'create' => 'admin.divisi.create',
            'store' => 'admin.divisi.store',
            'show' => 'admin.divisi.show',
            'edit' => 'admin.divisi.edit',
            'update' => 'admin.divisi.update',
            'destroy' => 'admin.divisi.destroy',
        ]);

        // Tambahkan route resource untuk admin.units.index, hanya untuk admin dan kepala kepegawaian
        Route::resource('admin/units', UnitController::class)->names([
            'index' => 'admin.units.index',
            'create' => 'admin.units.create',
            'store' => 'admin.units.store',
            'show' => 'admin.units.show',
            'edit' => 'admin.units.edit',
            'update' => 'admin.units.update',
            'destroy' => 'admin.units.destroy',
        ]);

        // Tambahkan route resource untuk admin.users.index, untuk admin dan kepala kepegawaian
        Route::resource('admin/users', UserController::class)->names([
            'index' => 'admin.users.index',
            'create' => 'admin.users.create',
            'store' => 'admin.users.store',
            'show' => 'admin.users.show',
            'edit' => 'admin.users.edit',
            'update' => 'admin.users.update',
            'destroy' => 'admin.users.destroy',
        ]);
    });
});
