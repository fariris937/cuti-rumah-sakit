@extends('layouts.app')

@section('title', 'Cuti Bawahan')
@section('page-title', 'Cuti Bawahan')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="fas fa-users me-2"></i>Daftar Cuti Bawahan</h5>
        <a href="{{ route('kepala-ruangan.cuti.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Ajukan Cuti untuk Bawahan
        </a>
    </div>
    <div class="card-body">
        @if($cutis->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Tanggal</th>
                            <th>Lama</th>
                            <th>Status</th>
                            <th>Disetujui Oleh</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cutis as $cuti)
                        <tr>
                            <td>{{ $cuti->user->nama }}</td>
                            <td>{{ \Carbon\Carbon::parse($cuti->tanggal_mulai)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($cuti->tanggal_selesai)->format('d/m/Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($cuti->tanggal_mulai)->diffInDays(\Carbon\Carbon::parse($cuti->tanggal_selesai)) + 1 }} hari</td>
                            <td><span class="status-badge status-{{ $cuti->status }}">{{ ucfirst($cuti->status) }}</span></td>
                            <td>{{ $cuti->disetujuiOleh->nama ?? '-' }}</td>
                            <td>
                                @if($cuti->status === 'pending')
                                    <form action="{{ route('kepala-ruangan.cuti.approve', $cuti->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm">Approve</button>
                                    </form>
                                    <form action="{{ route('kepala-ruangan.cuti.reject', $cuti->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-sm">Reject</button>
                                    </form>
                                @else
                                    <span class="text-muted">Sudah diproses</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-muted mb-0">Belum ada pengajuan cuti bawahan.</p>
        @endif
    </div>
</div>
@endsection




