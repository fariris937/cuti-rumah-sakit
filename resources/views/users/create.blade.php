@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Tambah User</h3>
    <form action="{{ route('users.store') }}" method="POST">
        @csrf
        <div class="form-group mb-2">
            <label>Nama</label>
            <input type="text" name="nama" class="form-control" required>
        </div>
        <div class="form-group mb-2">
            <label>Divisi</label>
            <input type="text" name="divisi" class="form-control" required>
        </div>
        <div class="form-group mb-2">
            <label>Jabatan</label>
            <input type="text" name="jabatan" class="form-control" required>
        </div>
        <div class="form-group mb-2">
            <label>Jenis Karyawan</label>
            <select name="jenis_karyawan" class="form-control">
                <option value="medis">Medis</option>
                <option value="non-medis">Non-Medis</option>
            </select>
        </div>
        <div class="form-group mb-2">
            <label>Unit</label>
            <select name="unit_id" class="form-control">
                <option value="">-- Pilih Unit --</option>
                @foreach($units as $unit)
                    <option value="{{ $unit->id }}">{{ $unit->nama_unit }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-success">Simpan</button>
    </form>
</div>
@endsection
