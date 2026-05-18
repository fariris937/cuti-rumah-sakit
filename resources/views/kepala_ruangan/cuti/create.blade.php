@extends('layouts.app')

@section('title', 'Ajukan Cuti Bawahan')
@section('page-title', 'Ajukan Cuti untuk Bawahan')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-calendar-plus me-2"></i>Form Pengajuan Cuti</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('kepala-ruangan.cuti.store') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="user_id" class="form-label">Pilih Karyawan</label>
                        <select id="user_id" name="user_id" class="form-select" required>
                            <option value="">-- Pilih --</option>
                            <option value="{{ $user->id }}">
                                {{ $user->nama }} (Diri Sendiri) - Sisa cuti: {{ $user->sisa_cuti }} hari
                            </option>
                            @foreach($employees as $emp)
                                @php
                                    $unit = $emp->unitAktif->first();
                                @endphp
                                <option value="{{ $emp->id }}">
                                    {{ $emp->nama }}
                                    @if($unit)
                                        ({{ $unit->nama_unit }} - {{ ucfirst($unit->tipe_unit) }})
                                    @endif
                                    - Sisa cuti: {{ $emp->sisa_cuti }} hari
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                            <input type="date" id="tanggal_mulai" name="tanggal_mulai" class="form-control" min="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
                            <input type="date" id="tanggal_selesai" name="tanggal_selesai" class="form-control" required>
                        </div>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                        <a href="{{ route('kepala-ruangan.cuti.index') }}" class="btn btn-outline-secondary btn-lg me-md-2">
                            <i class="fas fa-arrow-left me-2"></i>Batal
                        </a>
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-paper-plane me-2"></i>Ajukan Cuti
                        </button>
                    </div>
                </form>
                <div class="mt-3 text-muted small">
                    - Jika unit karyawan bertipe Medis, pengajuan akan diarahkan untuk disetujui oleh Kepala Bagian divisi yang sama.
                    <br>
                    - Jika unit Non-Medis, pengajuan langsung ke Kepegawaian.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection




