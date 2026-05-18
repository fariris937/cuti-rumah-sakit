@extends('layouts.app')

@section('title', 'Edit Divisi')
@section('page-title', 'Edit Divisi')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header"><i class="fas fa-edit me-2"></i>Form Divisi</div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.divisi.update', $divisi) }}">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label">Nama Divisi</label>
                        <input type="text" name="nama_divisi" value="{{ $divisi->nama_divisi }}" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kepala Divisi (opsional)</label>
                        <input type="text" name="kepala_divisi" value="{{ $divisi->kepala_divisi }}" class="form-control">
                    </div>
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.divisi.index') }}" class="btn btn-secondary">Kembali</a>
                        <button class="btn btn-primary" type="submit">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection




