@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Daftar Pengajuan Cuti - Kepala Bagian Kepegawaian</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Tanggal Mulai</th>
                <th>Tanggal Selesai</th>
                <th>Keterangan</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cutis as $cuti)
            <tr>
                <td>{{ $cuti->user->nama }}</td>
                <td>{{ $cuti->tanggal_mulai }}</td>
                <td>{{ $cuti->tanggal_selesai }}</td>
                <td>{{ $cuti->keterangan }}</td>
                <td>{{ ucfirst($cuti->status) }}</td>
                <td>
                    @if($cuti->status === 'pending')
                        <form action="{{ route('cuti.approve', $cuti->id) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn btn-success btn-sm">Approve</button>
                        </form>
                        <form action="{{ route('cuti.reject', $cuti->id) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-sm">Reject</button>
                        </form>
                    @else
                        <span class="text-muted">Sudah diproses</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
