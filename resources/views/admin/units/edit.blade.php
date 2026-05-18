@extends('layouts.app')

@section('title', 'Edit Unit')
@section('page-title', 'Edit Unit')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header"><i class="fas fa-edit me-2"></i>Form Unit</div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.units.update', $unit) }}">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label">Nama Unit</label>
                        <input type="text" name="nama_unit" value="{{ $unit->nama_unit }}" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tipe Unit</label>
                        <select name="tipe_unit" class="form-select" required>
                            <option value="medis" {{ $unit->tipe_unit==='medis' ? 'selected' : '' }}>Medis</option>
                            <option value="non-medis" {{ $unit->tipe_unit==='non-medis' ? 'selected' : '' }}>Non-Medis</option>
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




