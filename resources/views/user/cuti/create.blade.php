@extends('layouts.app')

@section('title', 'Ajukan Cuti')
@section('page-title', 'Ajukan Cuti Baru')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-calendar-plus me-2"></i>
                    Form Pengajuan Cuti
                </h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('cuti.store') }}" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="tanggal_mulai" class="form-label">Tanggal Mulai <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('tanggal_mulai') is-invalid @enderror" 
                                   id="tanggal_mulai" name="tanggal_mulai" 
                                   value="{{ old('tanggal_mulai') }}" 
                                   min="{{ date('Y-m-d') }}" required>
                            @error('tanggal_mulai')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="tanggal_selesai" class="form-label">Tanggal Selesai <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('tanggal_selesai') is-invalid @enderror" 
                                   id="tanggal_selesai" name="tanggal_selesai" 
                                   value="{{ old('tanggal_selesai') }}" required>
                            @error('tanggal_selesai')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>Informasi:</strong>
                            <ul class="mb-0 mt-2">
                                <li>Sisa cuti Anda: <strong>{{ $user->sisa_cuti }} hari</strong></li>
                                <li>Lama cuti akan dihitung otomatis setelah Anda memilih tanggal</li>
                                <li>Pastikan tanggal tidak bertabrakan dengan cuti yang sudah diajukan</li>
                            </ul>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Lama Cuti</label>
                        <div class="form-control-plaintext" id="lama-cuti">
                            Pilih tanggal untuk menghitung lama cuti
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <textarea class="form-control @error('keterangan') is-invalid @enderror"
                                  id="keterangan" name="keterangan" rows="3"
                                  placeholder="Jelaskan alasan pengajuan cuti...">{{ old('keterangan') }}</textarea>
                        @error('keterangan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>



                    <div class="d-flex justify-content-between">
                        <a href="{{ route('cuti.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>
                            Kembali
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane me-2"></i>
                            Ajukan Cuti
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const tanggalMulai = document.getElementById('tanggal_mulai');
    const tanggalSelesai = document.getElementById('tanggal_selesai');
    const lamaCuti = document.getElementById('lama-cuti');
    const sisaCuti = "{{ $user->sisa_cuti ?? 0 }}";

    function calculateDays() {
        if (tanggalMulai.value && tanggalSelesai.value) {
            const start = new Date(tanggalMulai.value);
            const end = new Date(tanggalSelesai.value);
            
            if (end >= start) {
                const diffTime = Math.abs(end - start);
                const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;
                
                lamaCuti.innerHTML = `<strong>${diffDays} hari</strong>`;
                
                if (diffDays > sisaCuti) {
                    lamaCuti.innerHTML += ` <span class="text-danger">(Sisa cuti tidak mencukupi!)</span>`;
                } else {
                    lamaCuti.innerHTML += ` <span class="text-success">(Sisa cuti mencukupi)</span>`;
                }
            } else {
                lamaCuti.innerHTML = '<span class="text-danger">Tanggal selesai harus setelah tanggal mulai</span>';
            }
        } else {
            lamaCuti.innerHTML = 'Pilih tanggal untuk menghitung lama cuti';
        }
    }

    tanggalMulai.addEventListener('change', function() {
        tanggalSelesai.min = this.value;
        calculateDays();
    });

    tanggalSelesai.addEventListener('change', calculateDays);
});
</script>
@endsection



