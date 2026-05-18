@extends('layouts.app')

@section('title', 'Dashboard Kepala Bagian')
@section('page-title', 'Dashboard Kepala Bagian')

@section('content')

<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card">
            <div class="card-header"><i class="fas fa-clock me-2"></i>Lembur</div>
            <div class="card-body">
                <a href="{{ route('overtime.create') }}" class="btn btn-outline-success btn-sm me-2">Ajukan Lembur</a>
                <a href="{{ route('overtime.report') }}" class="btn btn-success btn-sm">Riwayat Lembur</a>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="card-header"><i class="fas fa-file-alt me-2"></i>Ijin</div>
            <div class="card-body">
                <a href="{{ route('kepala-bagian.ijin.create') }}" class="btn btn-outline-primary btn-sm">Ajukan Ijin</a>
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
                    {{ $divisi->nama_divisi ?? 'Divisi' }}
                </h5>
                <a href="{{ Auth::user()->role === 'kepala_bagian' ? route('kepala-bagian.cuti.create') : route('kepala-bagian-kepegawaian.cuti.create') }}" class="btn btn-primary btn-sm">Ajukan Cuti</a>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="text-center">
                            <h3 class="text-primary">{{ $users->count() }}</h3>
                            <p class="text-muted">Total Karyawan</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-center">
                            <h3 class="text-warning">{{ $cutiPending->count() }}</h3>
                            <p class="text-muted">Cuti Menunggu</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-center">
                            <h3 class="text-success">{{ $cutiHistory->where('status', 'disetujui')->count() }}</h3>
                            <p class="text-muted">Cuti Disetujui</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-center">
                            <h3 class="text-danger">{{ $cutiHistory->where('status', 'ditolak')->count() }}</h3>
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
                @if($cutiPending->count() > 0)
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
                                @foreach($cutiPending->unique('id') as $cuti)
                                <tr>
                                    <td>{{ $cuti->user->nama }}</td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($cuti->tanggal_mulai)->format('d/m/Y') }} - 
                                        {{ \Carbon\Carbon::parse($cuti->tanggal_selesai)->format('d/m/Y') }}
                                    </td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($cuti->tanggal_mulai)->diffInDays(\Carbon\Carbon::parse($cuti->tanggal_selesai)) + 1 }} hari
                                    </td>
                                    <td>
                                        <form method="POST" action="{{ route('kepala-bagian.cuti.approve', $cuti->id) }}" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm" 
                                                    onclick="return confirm('Setujui cuti ini?')">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </form>
                                        <form method="POST" action="{{ route('kepala-bagian.cuti.reject', $cuti->id) }}" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-danger btn-sm" 
                                                    onclick="return confirm('Tolak cuti ini?')">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted text-center">Tidak ada cuti yang menunggu persetujuan</p>
                @endif
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
                <form method="POST" action="{{ route('kepala-bagian.mutasi') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="user_id" class="form-label">Pilih Karyawan</label>
                        <select class="form-select" id="user_id" name="user_id" required>
                            <option value="">-- Pilih Karyawan --</option>
                            @foreach($usersForMutasi as $user)
                                <option value="{{ $user->id }}">
                                    {{ $user->nama }} ({{ ucfirst($user->jenis_karyawan) }})
                                    @if($user->unitAktif->count() > 0)
                                        - {{ $user->unitAktif->first()->nama_unit }}
                                    @endif
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="unit_id" class="form-label">Unit Tujuan</label>
                        <select class="form-select" id="unit_id" name="unit_id" required>
                            <option value="">-- Pilih Unit --</option>
                            @foreach($units as $unit)
                                <option value="{{ $unit->id }}">{{ $unit->nama_unit }} ({{ ucfirst($unit->tipe_unit) }})</option>
                            @endforeach
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
                            @foreach($users as $user)
                            <tr>
                                <td>{{ $user->nama }}</td>
                                <td>{{ $user->jabatan }}</td>
                                <td>
                                    <span class="badge {{ $user->jenis_karyawan == 'medis' ? 'bg-primary' : 'bg-secondary' }}">
                                        {{ ucfirst($user->jenis_karyawan) }}
                                    </span>
                                </td>
                                <td>
                                    @if($user->unitAktif->count() > 0)
                                        {{ $user->unitAktif->first()->nama_unit }}
                                    @else
                                        <span class="text-muted">Belum ada unit</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-info">{{ $user->sisa_cuti }} hari</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Riwayat Cuti -->
@if($cutiHistory->count() > 0)
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
                        @foreach($cutiHistory as $cuti)
                        <tr>
                            <td>{{ $cuti->user->nama }}</td>
                            <td>
                                {{ \Carbon\Carbon::parse($cuti->tanggal_mulai)->format('d/m/Y') }} - 
                                {{ \Carbon\Carbon::parse($cuti->tanggal_selesai)->format('d/m/Y') }}
                            </td>
                            <td>
                                <span class="status-badge status-{{ $cuti->status }}">
                                    {{ ucfirst($cuti->status) }}
                                </span>
                            </td>
                            <td>{{ $cuti->disetujuiOleh->nama ?? '-' }}</td>
                            <td>{{ $cuti->updated_at->format('d/m/Y H:i') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


</div>
@endif

<!-- Laporan Lembur Disetujui -->
@if(isset($overtimeApproved) && $overtimeApproved->count() > 0)
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
                            @foreach($overtimeApproved as $overtime)
                            <tr>
                                <td>{{ $overtime->user->nama }}</td>
                                <td>{{ \Carbon\Carbon::parse($overtime->tanggal)->format('d/m/Y') }}</td>
                                <td>{{ $overtime->jam_mulai }}</td>
                                <td>{{ $overtime->jam_selesai }}</td>
                                <td>{{ ucfirst($overtime->status) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

@endsection
