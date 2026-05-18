@extends('layouts.app')

@section('title', 'Riwayat Cuti')
@section('page-title', 'Riwayat Cuti')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-history me-2"></i>
                    Riwayat Cuti Lengkap
                </h5>
            </div>
            <div class="card-body">
                @if($cutis->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Tanggal Mulai</th>
                                    <th>Tanggal Selesai</th>
                                    <th>Lama Cuti</th>
                                    <th>Status</th>
                                    <th>Disetujui Oleh</th>
                                    <th>Tanggal Persetujuan</th>
                                    <th>Dibuat</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cutis as $cuti)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($cuti->tanggal_mulai)->format('d/m/Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($cuti->tanggal_selesai)->format('d/m/Y') }}</td>
                                    <td>
                                        <span class="badge bg-info">
                                            {{ \Carbon\Carbon::parse($cuti->tanggal_mulai)->diffInDays(\Carbon\Carbon::parse($cuti->tanggal_selesai)) + 1 }} hari
                                        </span>
                                    </td>
                                    <td>
                                        <span class="status-badge status-{{ $cuti->status }}">
                                            {{ ucfirst($cuti->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $cuti->disetujuiOleh->nama ?? '-' }}</td>
                                    <td>
                                        @if($cuti->updated_at != $cuti->created_at)
                                            {{ $cuti->updated_at->format('d/m/Y H:i') }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>{{ $cuti->created_at->format('d/m/Y H:i') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">Belum ada riwayat cuti</h5>
                        <p class="text-muted">Riwayat cuti akan muncul setelah Anda mengajukan cuti</p>
                        <a href="{{ route('cuti.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>
                            Ajukan Cuti Baru
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection



