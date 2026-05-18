@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Mutasi Karyawan</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('mutasi.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="user_id" class="form-label">Pilih Karyawan</label>
            <select name="user_id" id="user_id" class="form-control" required>
                <option value="">-- Pilih --</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->nama }} ({{ $user->jenis_karyawan }})</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="unit_id" class="form-label">Unit Tujuan</label>
            <select name="unit_id" id="unit_id" class="form-control" required>
                <option value="">-- Pilih --</option>
                @foreach($units as $unit)
                    <option value="{{ $unit->id }}">{{ $unit->nama_unit }} ({{ $unit->tipe_unit }})</option>
                @endforeach
            </select>
        </div>

        <button class="btn btn-primary" type="submit">Mutasi</button>
    </form>

    <hr>

    <h4>Riwayat Penempatan</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Karyawan</th>
                <th>Unit</th>
                <th>Tanggal Mulai</th>
                <th>Tanggal Selesai</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                @foreach($user->units as $unit)
                    <tr>
                        <td>{{ $user->nama }}</td>
                        <td>{{ $unit->nama_unit }}</td>
                        <td>{{ $unit->pivot->tanggal_mulai }}</td>
                        <td>{{ $unit->pivot->tanggal_selesai ?? '-' }}</td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
</div>
@endsection
