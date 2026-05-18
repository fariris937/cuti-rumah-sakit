@extends('layouts.app')

@section('title', 'Persetujuan Lembur')
@section('page-title', 'Persetujuan Lembur')

@section('content')
<div class="container">
    <h2>Daftar Persetujuan Lembur</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($overtimes->count() > 0)
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Karyawan</th>
                    <th>Tanggal</th>
                    <th>Jam Mulai</th>
                    <th>Jam Selesai</th>
                    <th>Keterangan</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($overtimes as $overtime)
                <tr>
                    <td>{{ $overtime->user->nama }}</td>
                    <td>{{ \Carbon\Carbon::parse($overtime->tanggal)->format('d/m/Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($overtime->jam_mulai)->format('H:i') }}</td>
                    <td>{{ \Carbon\Carbon::parse($overtime->jam_selesai)->format('H:i') }}</td>
                    <td>{{ $overtime->keterangan }}</td>
                    <td>
                        @if($overtime->status == 'pending')
                            <span class="badge bg-warning">Pending</span>
                        @elseif($overtime->status == 'approved')
                            <span class="badge bg-success">Disetujui</span>
                        @elseif($overtime->status == 'rejected')
                            <span class="badge bg-danger">Ditolak</span>
                        @endif
                    </td>
                    <td>
                        @if($overtime->status == 'pending')
                            <form action="{{ route('overtime.approve', $overtime->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm">Setujui</button>
                            </form>
                            <form action="{{ route('overtime.reject', $overtime->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm">Tolak</button>
                            </form>
                        @else
                            -
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Tidak ada permintaan lembur yang menunggu persetujuan.</p>
    @endif
</div>
@endsection
