@extends('layouts.app')

@section('title', 'Register')
@section('page-title', 'Register')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6 col-lg-4">
        <div class="card">
            <div class="card-header text-center">
                <h4>Daftar Akun Karyawan</h4>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                               id="name" name="name" value="{{ old('name') }}" required autofocus>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                               id="email" name="email" value="{{ old('email') }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="divisi_id" class="form-label">Divisi</label>
                        <select name="divisi_id" id="divisi_id" class="form-control" required>
                            <option value="">-- Pilih Divisi --</option>
                            @foreach(\App\Models\Divisi::where('nama_divisi', '!=', 'Administrasi Sistem')->get() as $divisi)
                                <option value="{{ $divisi->id }}" {{ old('divisi_id') == $divisi->id ? 'selected' : '' }}>{{ $divisi->nama_divisi }}</option>
                            @endforeach
                        </select>
                        @error('divisi_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="unit_id" class="form-label">Unit</label>
                        <select name="unit_id" id="unit_id" class="form-control" required>
                            <option value="">-- Pilih Unit --</option>
                            @foreach(\App\Models\Unit::all() as $unit)
                                <option value="{{ $unit->id }}" {{ old('unit_id') == $unit->id ? 'selected' : '' }}>{{ $unit->nama_unit }}</option>
                            @endforeach
                        </select>
                        @error('unit_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="jenis_karyawan" class="form-label">Jenis Karyawan</label>
                        <select name="jenis_karyawan" id="jenis_karyawan" class="form-control" required>
                            <option value="">-- Pilih Jenis Karyawan --</option>
                            <option value="medis" {{ old('jenis_karyawan') == 'medis' ? 'selected' : '' }}>Medis</option>
                            <option value="non-medis" {{ old('jenis_karyawan') == 'non-medis' ? 'selected' : '' }}>Non-Medis</option>
                        </select>
                        @error('jenis_karyawan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                               id="password" name="password" required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                        <input type="password" class="form-control"
                               id="password_confirmation" name="password_confirmation" required>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Daftar</button>
                </form>

                <div class="text-center mt-3">
                    <a href="{{ route('login') }}" class="btn btn-secondary">Kembali ke Login</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
