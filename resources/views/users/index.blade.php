@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Daftar Karyawan</h3>
    <a href="{{ route('users.create') }}" class="btn btn-primary mb-3">Tambah User</a>
    <table class="table table-bordered">
        <tr>
            <th>Nama</th>
            <th>Divisi</th>
            <th>Unit</th>
            <th>Jabatan</th>
            <th>Jenis</th>
            <th>Unit Aktif</th>
        </tr>
        @foreach($users as $user)
        <tr>
            <td>{{ $user->nama }}</td>
            <td>{{ $user->divisi }}</td>
            <td>
                @if($user->unitAktif && $user->unitAktif->count() > 0)
                    {{ $user->unitAktif->pluck('nama')->join(', ') }}
                @else
                    -
                @endif
            </td>
            <td>{{ $user->jabatan }}</td>
            <td>{{ $user->jenis_karyawan }}</td>
            <td>{{ $user->unitAktif->first()->nama_unit ?? '-' }}</td>
        </tr>
        @endforeach
    </table>
</div>
@endsection
