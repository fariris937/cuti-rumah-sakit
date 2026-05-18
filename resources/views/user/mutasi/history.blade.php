@extends('layouts.app')

@section('title', 'Riwayat Mutasi')
@section('page-title', 'Riwayat Mutasi')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-exchange-alt me-2"></i>
                    Riwayat Mutasi Unit
                </h5>
            </div>
            <div class="card-body">
                @if($mutasiHistory->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Unit</th>
                                    <th>Tipe Unit</th>
                                    <th>Tanggal Mulai</th>
                                    <th>Tanggal Selesai</th>
                                    <th>Status</th>
                                    <th>Lama di Unit</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($mutasiHistory as $mutasi)
                                <tr>
                                    <td>
                                        <strong>{{ $mutasi->nama_unit }}</strong>
                                    </td>
                                    <td>
                                        <span class="badge {{ $mutasi->tipe_unit == 'medis' ? 'bg-primary' : 'bg-secondary' }}">
                                            {{ ucfirst($mutasi->tipe_unit) }}
                                        </span>
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($mutasi->pivot->tanggal_mulai)->format('d/m/Y') }}</td>
                                    <td>
                                        @if($mutasi->pivot->tanggal_selesai)
                                            {{ \Carbon\Carbon::parse($mutasi->pivot->tanggal_selesai)->format('d/m/Y') }}
                                        @else
                                            <span class="text-success">Masih Aktif</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($mutasi->pivot->tanggal_selesai)
                                            <span class="badge bg-secondary">Selesai</span>
                                        @else
                                            <span class="badge bg-success">Aktif</span>
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            $startDate = \Carbon\Carbon::parse($mutasi->pivot->tanggal_mulai);
                                            $endDate = $mutasi->pivot->tanggal_selesai ? 
                                                \Carbon\Carbon::parse($mutasi->pivot->tanggal_selesai) : 
                                                \Carbon\Carbon::now();
                                            $days = $startDate->diffInDays($endDate);
                                        @endphp
                                        <span class="badge bg-info">
                                            {{ $days }} hari
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-exchange-alt fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">Belum ada riwayat mutasi</h5>
                        <p class="text-muted">Riwayat mutasi akan muncul setelah Anda dipindahkan ke unit lain</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Statistik Mutasi -->
@if($mutasiHistory->count() > 0)
<div class="row mt-4">
    <div class="col-md-4">
        <div class="card text-center">
            <div class="card-body">
                <h3 class="text-primary">{{ $mutasiHistory->count() }}</h3>
                <p class="text-muted mb-0">Total Mutasi</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-center">
            <div class="card-body">
                <h3 class="text-success">{{ $mutasiHistory->where('pivot.tanggal_selesai', null)->count() }}</h3>
                <p class="text-muted mb-0">Unit Aktif</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-center">
            <div class="card-body">
                <h3 class="text-info">{{ $mutasiHistory->where('tipe_unit', 'medis')->count() }}</h3>
                <p class="text-muted mb-0">Unit Medis</p>
            </div>
        </div>
    </div>
</div>
@endif
@endsection



