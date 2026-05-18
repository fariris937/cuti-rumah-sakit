@extends('layouts.app')

@section('title', 'Dashboard Saya')
@section('page-title', 'Dashboard Saya')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Profil -->
        <div class="col-md-4 mb-4">
            <div class="card border-primary">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0"><i class="fas fa-user me-2"></i>Profil</h5>
                </div>
                <div class="card-body">
                    <p><strong>Nama:</strong> {{ $user->nama }}</p>
                    <p><strong>Jabatan:</strong> {{ $user->jabatan ?? 'Pelaksana' }}</p>
                    <p><strong>Divisi:</strong> {{ $user->divisi ? $user->divisi->nama_divisi ?? $user->divisi : '-' }}</p>
                    <p><strong>Unit Aktif:</strong> 
                        @if($user->unitAktif && $user->unitAktif->count() > 0)
                            {{ $user->unitAktif->pluck('nama')->join(', ') }}
                        @else
                            -
                        @endif
                    </p>
                    <p><strong>Unit Asal:</strong>
                        @if($user->unitAsal && $user->unitAsal->count() > 0)
                            {{ $user->unitAsal->first()->nama ?? '-' }}
                        @else
                            -
                        @endif
                    </p>
                </div>
            </div>
        </div>

        <!-- Cuti -->
        <div class="col-md-4 mb-4">
            <div class="card border-success">
                <div class="card-header bg-success text-white">
                    <h5 class="card-title mb-0"><i class="fas fa-calendar-check me-2"></i>Cuti</h5>
                </div>
                <div class="card-body">
                    <p><strong>Sisa cuti:</strong> <span class="badge bg-info">{{ $sisaCuti }} hari</span></p>
                    <a href="{{ route('cuti.index') }}" class="btn btn-outline-primary">Daftar Cuti</a>
                    <a href="{{ route('cuti.create') }}" class="btn btn-primary">Ajukan Cuti</a>
                </div>
            </div>
        </div>

        <!-- Lembur -->
        <div class="col-md-4 mb-4">
            <div class="card border-warning">
                <div class="card-header bg-warning text-white">
                    <h5 class="card-title mb-0"><i class="fas fa-clock me-2"></i>Lembur</h5>
                </div>
                <div class="card-body">
                    <a href="{{ route('overtime.create') }}" class="btn btn-outline-success">Ajukan Lembur</a>
                    <a href="{{ route('overtime.report') }}" class="btn btn-success">Riwayat Lembur</a>
                </div>
            </div>
        </div>

        <!-- Ijin -->
        <div class="col-md-4 mb-4">
            <div class="card border-warning">
                <div class="card-header bg-warning text-white">
                    <h5 class="card-title mb-0"><i class="fas fa-file-signature me-2"></i>Ijin</h5>
                </div>
                <div class="card-body">
                    <a href="{{ route('ijin.create') }}" class="btn btn-outline-warning">Ajukan Ijin</a>
                </div>
            </div>
        </div>

        <!-- Mutasi -->
        <div class="col-md-4 mb-4">
            <div class="card border-info">
                <div class="card-header bg-info text-white">
                    <h5 class="card-title mb-0"><i class="fas fa-exchange-alt me-2"></i>Mutasi</h5>
                </div>
                <div class="card-body">
                    <a href="{{ route('user.mutasi.history') }}" class="btn btn-outline-secondary">Riwayat Mutasi</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

