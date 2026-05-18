@extends('layouts.app')

@section('title', 'Kelola User')
@section('page-title', 'Kelola User')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="fas fa-users me-2"></i>Daftar User</h5>
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary"><i class="fas fa-plus me-2"></i>Tambah User</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
<thead>
    <tr>
        <th>Nama</th>
        <th>Email</th>
        <th>Divisi</th>
        <th>Unit</th>
        <th>Jabatan</th>
        <th>Role</th>
        <th>Jenis</th>
        <th class="text-end">Jumlah Cuti</th>
        <th class="text-end">Sisa Cuti</th>
        <th>Aksi</th>
    </tr>
</thead>
<tbody>
    @foreach($users as $u)
    <tr>
        <td class="align-middle">{{ $u->nama }}</td>
        <td class="align-middle">{{ $u->email }}</td>
        <td class="align-middle">{{ $u->divisi->nama_divisi ?? '-' }}</td>
        <td class="align-middle">
@if($u->unitAktif && $u->unitAktif->count() > 0)
    {{ $u->unitAktif->pluck('nama_unit')->join(', ') }}
@else
    -
@endif
        </td>
        <td class="align-middle">{{ $u->jabatan }}</td>
        <td class="align-middle"><span class="badge bg-dark px-2 py-1">{{ $u->role }}</span></td>
        <td class="align-middle">
            <span class="badge {{ $u->jenis_karyawan === 'medis' ? 'bg-primary' : 'bg-secondary' }} px-2 py-1">
                {{ ucfirst($u->jenis_karyawan) }}
            </span>
        </td>
        <td class="align-middle text-end">{{ $u->jumlah_cuti }}</td>
        <td class="align-middle text-end">{{ $u->sisa_cuti }}</td>
        <td class="align-middle">
            <a class="btn btn-sm btn-outline-primary me-1" href="{{ route('admin.users.edit', $u) }}"><i class="fas fa-edit"></i></a>
            <form action="{{ route('admin.users.destroy', $u) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus user ini?')">
                @csrf
                @method('DELETE')
                <button class="btn btn-sm btn-outline-danger" type="submit"><i class="fas fa-trash"></i></button>
            </form>
        </td>
    </tr>
    @endforeach
</tbody>
            </table>
        </div>
    </div>
  </div>
@endsection




