@extends('layouts.app')

@section('title', 'Tambah Unit')
@section('page-title', 'Tambah Unit')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header"><i class="fas fa-plus me-2"></i>Form Unit</div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.units.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Nama Unit</label>
                        <input type="text" name="nama_unit" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tipe Unit</label>
                        <select name="tipe_unit" class="form-select" required>
                            <option value="medis">Medis</option>
                            <option value="non-medis">Non-Medis</option>
                        </select>
                    </div>
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.units.index') }}" class="btn btn-secondary">Kembali</a>
                        <button class="btn btn-primary" type="submit">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection




