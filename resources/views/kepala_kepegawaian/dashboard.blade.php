@extends('layouts.app')

@section('title', 'Dashboard Kepala Kepegawaian')
@section('page-title', 'Dashboard Kepala Kepegawaian')

@section('content')

<div class="text-center mb-4">
    <img src="{{ asset('images/logo_rs_wates_husada.png') }}" alt="Logo RS Wates Husada" style="height: 80px;">
</div>

<div class="row mb-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-calendar-alt me-2"></i>Laporan Cuti Bulanan</h5>
                <div class="d-flex align-items-center gap-2">
                    <form id="cutiFilterForm" class="d-flex align-items-center" method="GET" action="{{ route('kepala-kepegawaian.dashboard') }}">
                        <select name="cuti_year" class="form-select form-select-sm me-2" style="width: auto;">
                            @foreach(range(date('Y') - 2, date('Y')) as $y)
                                <option value="{{ $y }}" {{ request('cuti_year', date('Y')) == $y ? 'selected' : '' }}>
                                    {{ $y }}
                                </option>
                            @endforeach
                        </select>
                        <select name="cuti_month" class="form-select form-select-sm me-2" style="width: auto;">
                            @foreach(range(1, 12) as $m)
                                <option value="{{ $m }}" {{ request('cuti_month', date('m')) == $m ? 'selected' : '' }}>
                                    {{ DateTime::createFromFormat('!m', $m)->format('F') }}
                                </option>
                            @endforeach
                        </select>
                        <select name="cuti_day" class="form-select form-select-sm me-2" style="width: auto;">
                            <option value="">Semua Hari</option>
                            @foreach(range(1, 31) as $d)
                                <option value="{{ $d }}" {{ request('cuti_day') == $d ? 'selected' : '' }}>
                                    {{ $d }}
                                </option>
                            @endforeach
                        </select>
                        <button type="submit" class="btn btn-sm btn-primary me-2">Filter</button>
                        <a href="{{ route('kepala-kepegawaian.download.monthly', [
                            'year' => request('cuti_year', date('Y')),
                            'month' => request('cuti_month', date('m')),
                            'day' => request('cuti_day')
                        ]) }}" class="btn btn-sm btn-success">
                            <i class="fas fa-download me-1"></i>Download PDF
                        </a>
                    </form>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-4">
                        <div class="text-center">
                            <h3 class="text-primary">{{ $monthlyReports['total_leaves'] }}</h3>
                            <small class="text-muted">Total Cuti</small>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="text-center">
                            <h3 class="text-success">{{ $monthlyReports['total_days'] }}</h3>
                            <small class="text-muted">Total Hari</small>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="text-center">
                            <h5 class="text-info">{{ $monthlyReports['month'] }}</h5>
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
                    <form id="annualCutiFilterForm" class="d-flex align-items-center" method="GET" action="{{ route('kepala-kepegawaian.dashboard') }}">
                        <select name="annual_cuti_year" class="form-select form-select-sm me-2" style="width: auto;">
                            @foreach(range(date('Y') - 2, date('Y')) as $y)
                                <option value="{{ $y }}" {{ request('annual_cuti_year', date('Y')) == $y ? 'selected' : '' }}>
                                    {{ $y }}
                                </option>
                            @endforeach
                        </select>
                        <button type="submit" class="btn btn-sm btn-primary me-2">Filter</button>
                        <a href="{{ route('kepala-kepegawaian.download.annual', [
                            'year' => request('annual_cuti_year', date('Y'))
                        ]) }}" class="btn btn-sm btn-success">
                            <i class="fas fa-download me-1"></i>Download PDF
                        </a>
                    </form>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-4">
                        <div class="text-center">
                            <h3 class="text-primary">{{ $annualReports['total_leaves'] }}</h3>
                            <small class="text-muted">Total Cuti</small>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="text-center">
                            <h3 class="text-success">{{ $annualReports['total_days'] }}</h3>
                            <small class="text-muted">Total Hari</small>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="text-center">
                            <h5 class="text-info">{{ $annualReports['year'] }}</h5>
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
                    <form id="ijinFilterForm" class="d-flex align-items-center" method="GET" action="{{ route('kepala-kepegawaian.dashboard') }}">
                        <select name="ijin_year" class="form-select form-select-sm me-2" style="width: auto;">
                            @foreach(range(date('Y') - 2, date('Y')) as $y)
                                <option value="{{ $y }}" {{ request('ijin_year', date('Y')) == $y ? 'selected' : '' }}>
                                    {{ $y }}
                                </option>
                            @endforeach
                        </select>
                        <select name="ijin_month" class="form-select form-select-sm me-2" style="width: auto;">
                            @foreach(range(1, 12) as $m)
                                <option value="{{ $m }}" {{ request('ijin_month', date('m')) == $m ? 'selected' : '' }}>
                                    {{ DateTime::createFromFormat('!m', $m)->format('F') }}
                                </option>
                            @endforeach
                        </select>
                        <select name="ijin_day" class="form-select form-select-sm me-2" style="width: auto;">
                            <option value="">Semua Hari</option>
                            @foreach(range(1, 31) as $d)
                                <option value="{{ $d }}" {{ request('ijin_day') == $d ? 'selected' : '' }}>
                                    {{ $d }}
                                </option>
                            @endforeach
                        </select>
                        <button type="submit" class="btn btn-sm btn-primary me-2">Filter</button>
                        <a href="{{ route('kepala-kepegawaian.download.ijin.monthly', [
                            'year' => request('ijin_year', date('Y')),
                            'month' => request('ijin_month', date('m')),
                            'day' => request('ijin_day')
                        ]) }}" class="btn btn-sm btn-success">
                            <i class="fas fa-download me-1"></i>Download PDF
                        </a>
                    </form>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-4">
                        <div class="text-center">
                            <h3 class="text-primary">{{ isset($ijins) ? $ijins->where('tanggal_ijin', '>=', now()->startOfMonth())->where('tanggal_ijin', '<=', now()->endOfMonth())->count() : 0 }}</h3>
                            <small class="text-muted">Total Ijin</small>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="text-center">
                            <h3 class="text-warning">{{ isset($ijins) ? $ijins->where('status', 'pending')->count() : 0 }}</h3>
                            <small class="text-muted">Pending</small>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="text-center">
                            <h5 class="text-info">{{ now()->format('M Y') }}</h5>
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
                    <form id="annualIjinFilterForm" class="d-flex align-items-center" method="GET" action="{{ route('kepala-kepegawaian.dashboard') }}">
                        <select name="annual_ijin_year" class="form-select form-select-sm me-2" style="width: auto;">
                            @foreach(range(date('Y') - 2, date('Y')) as $y)
                                <option value="{{ $y }}" {{ request('annual_ijin_year', date('Y')) == $y ? 'selected' : '' }}>
                                    {{ $y }}
                                </option>
                            @endforeach
                        </select>
                        <button type="submit" class="btn btn-sm btn-primary me-2">Filter</button>
                        <a href="{{ route('kepala-kepegawaian.download.ijin.annual', [
                            'year' => request('annual_ijin_year', date('Y'))
                        ]) }}" class="btn btn-sm btn-success">
                            <i class="fas fa-download me-1"></i>Download PDF
                        </a>
                    </form>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-4">
                        <div class="text-center">
                            <h3 class="text-primary">{{ isset($ijins) ? $ijins->where('tanggal_ijin', '>=', now()->startOfYear())->where('tanggal_ijin', '<=', now()->endOfYear())->count() : 0 }}</h3>
                            <small class="text-muted">Total Ijin</small>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="text-center">
                            <h3 class="text-success">{{ isset($ijins) ? $ijins->where('status', 'disetujui')->count() : 0 }}</h3>
                            <small class="text-muted">Disetujui</small>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="text-center">
                            <h5 class="text-info">{{ now()->format('Y') }}</h5>
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
        @if($cutis->count() > 0)
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
                        @foreach($cutis as $cuti)
                        <tr>
                            <td>{{ $cuti->user->nama }}</td>
                            <td>{{ $cuti->tanggal_mulai->format('d/m/Y') }}</td>
                            <td>{{ $cuti->tanggal_selesai->format('d/m/Y') }}</td>
                            <td>
                                <span class="badge bg-success">{{ ucfirst($cuti->status) }}</span>
                            </td>
                            <td>
                                @if($cuti->disetujui_oleh_kepala_bagian)
                                    @php
                                        $approver = $cuti->disetujuiOlehKepalaBagian;
                                        if ($approver && $approver->role === 'kepala_bagian_kepegawaian') {
                                            $approverName = $approver->nama . ' (Kepala Bagian Kepegawaian)';
                                        } elseif ($approver) {
                                            $approverName = $approver->nama . ' (Kepala Bagian)';
                                        } else {
                                            $approverName = '-';
                                        }
                                    @endphp
                                    {{ $approverName }}
                                @elseif($cuti->disetujui_oleh_kepala_ruangan)
                                    {{ $cuti->disetujuiOlehKepalaRuangan->nama ?? '-' }} (Kepala Ruangan)
                                @else
                                    -
                                @endif
                            </td>
                            <td>{{ $cuti->updated_at->format('d/m/Y H:i') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">Belum ada laporan cuti karyawan</h5>
                <p class="text-muted">Laporan cuti akan muncul setelah cuti disetujui oleh kepala bagian medis dan kepala ruangan non-medis.</p>
            </div>
        @endif
    </div>
</div>

<!-- Laporan Ijin Karyawan -->
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="fas fa-file-alt me-2"></i>Laporan Ijin Karyawan</h5>
        <a href="{{ route('kepala-kepegawaian.download.ijin.monthly', [
            'year' => request('ijin_year', date('Y')),
            'month' => request('ijin_month', date('m')),
            'day' => request('ijin_day')
        ]) }}" class="btn btn-sm btn-success">
            <i class="fas fa-download me-1"></i>Download PDF
        </a>
    </div>
    <div class="card-body">
        @if(isset($ijins) && $ijins->count() > 0)
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
                        @foreach($ijins as $ijin)
                        <tr>
                            <td>{{ $ijin->user->nama }}</td>
                            <td>{{ $ijin->user->divisi->nama_divisi ?? '-' }}</td>
                            <td>
                                @php
                                    $units = $ijin->user->units;
                                    $unitNames = $units->pluck('nama_unit')->toArray();
                                @endphp
                                {{ count($unitNames) > 0 ? implode(', ', $unitNames) : '-' }}
                            </td>
                            <td>{{ \Carbon\Carbon::parse($ijin->tanggal_ijin)->format('d/m/Y') }}</td>
                            <!-- Removed Jam Mulai and Jam Selesai data cells as per user request -->
                            <td>
                                <span class="badge bg-info">{{ ucfirst($ijin->jenis_ijin) }}</span>
                            </td>
                            <td>
                                @if($ijin->status == 'disetujui')
                                    <span class="badge bg-success">{{ ucfirst($ijin->status) }}</span>
                                @elseif($ijin->status == 'pending')
                                    <span class="badge bg-warning">{{ ucfirst($ijin->status) }}</span>
                                @else
                                    <span class="badge bg-danger">{{ ucfirst($ijin->status) }}</span>
                                @endif
                            </td>
                            <td>
                                @if($ijin->disetujuiOlehKepalaRuangan)
                                    {{ $ijin->disetujuiOlehKepalaRuangan->nama }}
                                @elseif($ijin->disetujuiOlehKepalaBagian)
                                    {{ $ijin->disetujuiOlehKepalaBagian->nama }}
                                @else
                                    -
                                @endif
                            </td>
                            <td>{{ $ijin->updated_at->format('d/m/Y H:i') }}</td>
                            <td>
                                @if($ijin->berkas_pendukung)
                                    <a href="{{ asset('storage/berkas_pendukung/' . $ijin->berkas_pendukung) }}"
                                       target="_blank"
                                       class="btn btn-sm btn-primary">
                                        <i class="fas fa-download me-1"></i>Download
                                    </a>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-file-times fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">Belum ada laporan ijin karyawan</h5>
                <p class="text-muted">Laporan ijin akan muncul setelah ijin disetujui oleh kepala ruangan.</p>
            </div>
        @endif
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
                    <form id="overtimeFilterForm" class="d-flex align-items-center" method="GET" action="{{ route('kepala-kepegawaian.dashboard') }}">
                        <select name="overtime_year" class="form-select form-select-sm me-2" style="width: auto;">
                            @foreach(range(date('Y') - 2, date('Y')) as $y)
                                <option value="{{ $y }}" {{ request('overtime_year', date('Y')) == $y ? 'selected' : '' }}>
                                    {{ $y }}
                                </option>
                            @endforeach
                        </select>
                        <select name="overtime_month" class="form-select form-select-sm me-2" style="width: auto;">
                            @foreach(range(1, 12) as $m)
                                <option value="{{ $m }}" {{ request('overtime_month', date('m')) == $m ? 'selected' : '' }}>
                                    {{ DateTime::createFromFormat('!m', $m)->format('F') }}
                                </option>
                            @endforeach
                        </select>
                        <select name="overtime_day" class="form-select form-select-sm me-2" style="width: auto;">
                            <option value="">Semua Hari</option>
                            @foreach(range(1, 31) as $d)
                                <option value="{{ $d }}" {{ request('overtime_day') == $d ? 'selected' : '' }}>
                                    {{ $d }}
                                </option>
                            @endforeach
                        </select>
                        <button type="submit" class="btn btn-sm btn-primary me-2">Filter</button>
                        <a href="{{ route('kepala-kepegawaian.download.overtime', [
                            'year' => request('overtime_year', date('Y')),
                            'month' => request('overtime_month', date('m')),
                            'day' => request('overtime_day')
                        ]) }}" class="btn btn-sm btn-success">
                            <i class="fas fa-download me-1"></i>Download PDF
                        </a>
                    </form>
                </div>
            </div>
            <div class="card-body">
                @if(isset($overtimeApproved) && $overtimeApproved->count() > 0)
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
                                @foreach($overtimeApproved as $overtime)
                                <tr>
                                    <td>{{ $overtime->user->nama }}</td>
                                    <td>{{ \Carbon\Carbon::parse($overtime->tanggal)->format('d/m/Y') }}</td>
                                    <td>{{ $overtime->jam_mulai }}</td>
                                    <td>{{ $overtime->jam_selesai }}</td>
                                    <td>{{ $overtime->keterangan }}</td>
                                    <td>{{ ucfirst($overtime->status) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-clock fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">Belum ada laporan lembur disetujui</h5>
                        <p class="text-muted">Laporan lembur akan muncul setelah lembur disetujui oleh kepala ruangan.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
