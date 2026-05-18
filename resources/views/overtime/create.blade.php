@extends('layouts.app')

@section('title', 'Ajukan Lembur')
@section('page-title', 'Ajukan Lembur')

@section('content')
<div class="container">
    <h2>Form Ajukan Lembur</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('overtime.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="tanggal" class="form-label">Tanggal Lembur</label>
            <input type="date" name="tanggal" id="tanggal" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="jam_mulai" class="form-label">Jam Mulai</label>
            <input type="time" name="jam_mulai" id="jam_mulai" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="jam_selesai" class="form-label">Jam Selesai</label>
            <input type="time" name="jam_selesai" id="jam_selesai" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="keterangan" class="form-label">Keterangan</label>
            <textarea name="keterangan" id="keterangan" class="form-control" rows="3"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Ajukan</button>
    </form>
</div>
@endsection
