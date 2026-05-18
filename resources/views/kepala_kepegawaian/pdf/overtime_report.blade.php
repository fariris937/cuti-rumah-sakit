@extends('layouts.pdf')

@section('title', $title)

@section('content')
    <h2>{{ $title }}</h2>
    <p>Periode: {{ $period }}</p>
    <p>Jumlah Lembur Disetujui: {{ $total_overtimes }}</p>
    <p>Dicetak pada: {{ $generated_at }}</p>

    <table border="1" cellspacing="0" cellpadding="5" width="100%">
        <thead>
            <tr>
                <th>Nama Karyawan</th>
                <th>Divisi</th>
                <th>Tanggal Lembur</th>
                <th>Jam Mulai</th>
                <th>Jam Selesai</th>
                <th>Keterangan</th>
                <th>Disetujui Oleh</th>
            </tr>
        </thead>
        <tbody>
            @foreach($overtimes as $overtime)
            <tr>
                <td>{{ $overtime->user->nama }}</td>
                <td>{{ $overtime->user->divisi->nama_divisi ?? '-' }}</td>
                <td>{{ \Carbon\Carbon::parse($overtime->tanggal)->format('d/m/Y') }}</td>
                <td>{{ $overtime->jam_mulai }}</td>
                <td>{{ $overtime->jam_selesai }}</td>
                <td>{{ $overtime->keterangan }}</td>
                <td>{{ $overtime->approvedBy->nama ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endsection
