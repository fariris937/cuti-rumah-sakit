@extends('layouts.app')

@section('title', 'Tambah User')
@section('page-title', 'Tambah User')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-user-plus me-2"></i>Form Tambah User</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.users.store') }}">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Nama</label>
                        <input type="text" name="nama" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Jumlah Cuti</label>
                        <input type="number" name="jumlah_cuti" class="form-control" min="0" value="0" required>
                    </div>

                    {{-- NIK field removed as per request --}}

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control">
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Divisi</label>
                            <select name="divisi_id" class="form-select" required>
                                <option value="">-- Pilih Divisi --</option>
                                @foreach($divisi as $d)
                                    <option value="{{ $d->id }}">{{ $d->nama_divisi }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Jabatan</label>
                            <input type="text" name="jabatan" class="form-control" value="Pelaksana" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Jenis Karyawan</label>
                            <select name="jenis_karyawan" class="form-select" required>
                                <option value="medis">Medis</option>
                                <option value="non-medis">Non-Medis</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Role</label>
                            <select name="role" class="form-select" required>
                                <option value="karyawan">Karyawan</option>
                                <option value="kepala_ruangan">Kepala Ruangan</option>
                                <option value="kepala_bagian">Kepala Bagian</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Unit Awal (opsional)</label>
                            <select name="unit_id" class="form-select">
                                <option value="">-- Pilih Unit --</option>
                                @foreach($units as $u)
                                    <option value="{{ $u->id }}">{{ $u->nama_unit }} ({{ $u->tipe_unit }})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left me-2"></i>Kembali</a>
                        <button class="btn btn-primary" type="submit"><i class="fas fa-save me-2"></i>Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

