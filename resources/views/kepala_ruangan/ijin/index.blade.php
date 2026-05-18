@extends('layouts.app')

@section('title', 'Kelola Ijin')
@section('page-title', 'Kelola Ijin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-file-signature me-2"></i>Daftar Permintaan Ijin
                    </h5>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i>{{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Karyawan</th>
                                    <th>Tanggal Ijin</th>
                                    <th>Keterangan</th>
                                    <th>Jenis Ijin</th>
                                    <th>Berkas</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($ijin as $index => $item)
                                    <tr>
                                        <td>{{ $ijin->firstItem() + $index }}</td>
                                        <td>{{ $item->user->nama }}</td>
                                        <td>{{ \Carbon\Carbon::parse($item->tanggal_ijin)->format('d/m/Y') }}</td>
                                        <td>{{ Str::limit($item->keterangan, 50) }}</td>
                                        <td>
                                            <span class="badge bg-secondary">{{ ucfirst($item->jenis_ijin) }}</span>
                                        </td>
                                        <td>
                                            @if($item->berkas_pendukung)
                                                <a href="{{ asset('storage/berkas_pendukung/' . $item->berkas_pendukung) }}"
                                                   target="_blank"
                                                   class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-download me-1"></i>Lihat Berkas
                                                </a>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($item->disetujui_oleh_kepala_ruangan)
                                                <span class="badge bg-success">
                                                    <i class="fas fa-check me-1"></i>Disetujui
                                                </span>
                                            @else
                                                <span class="badge bg-warning">
                                                    <i class="fas fa-clock me-1"></i>Pending
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            @if(!$item->disetujui_oleh_kepala_ruangan)
                                                <div class="btn-group" role="group">
                                                    <form action="{{ route('kepala-ruangan.ijin.approve', $item->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <div class="mb-2">
                                                            <textarea class="form-control form-control-sm" name="catatan_persetujuan" rows="2" placeholder="Catatan persetujuan (opsional)"></textarea>
                                                        </div>
                                                        <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('Apakah Anda yakin ingin menyetujui ijin ini?')">
                                                            <i class="fas fa-check me-1"></i>Setujui
                                                        </button>
                                                    </form>
                                                    <form action="{{ route('kepala-ruangan.ijin.reject', $item->id) }}" method="POST" class="d-inline ms-1">
                                                        @csrf
                                                        <div class="mb-2">
                                                            <textarea class="form-control form-control-sm" name="catatan_persetujuan" rows="2" placeholder="Catatan penolakan (opsional)"></textarea>
                                                        </div>
                                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menolak ijin ini?')">
                                                            <i class="fas fa-times me-1"></i>Tolak
                                                        </button>
                                                    </form>
                                                </div>
                                            @else
                                                <span class="text-success">
                                                    <i class="fas fa-check-circle me-1"></i>Disetujui pada {{ \Carbon\Carbon::parse($item->tanggal_persetujuan)->format('d/m/Y H:i') }}
                                                </span>
                                                @if($item->catatan_persetujuan)
                                                    <br><small class="text-muted">Catatan: {{ $item->catatan_persetujuan }}</small>
                                                @endif
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4">
                                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                            <p class="text-muted">Belum ada permintaan ijin</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($ijin->hasPages())
                        <div class="d-flex justify-content-center mt-4">
                            {{ $ijin->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-12 text-center">
            <a href="{{ route('kepala-ruangan.dashboard') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Kembali ke Dashboard
            </a>
        </div>
    </div>
</div>
@endsection
