@extends('layouts.app')

@section('title', 'Kelola Unit')
@section('page-title', 'Kelola Unit')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="fas fa-hospital me-2"></i>Daftar Unit</h5>
        <a href="{{ route('admin.units.create') }}" class="btn btn-primary"><i class="fas fa-plus me-2"></i>Tambah Unit</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Nama Unit</th>
                        <th>Tipe</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($units as $u)
                    <tr>
                        <td>{{ $u->nama_unit }}</td>
                        <td><span class="badge {{ $u->tipe_unit==='medis' ? 'bg-primary' : 'bg-secondary' }}">{{ ucfirst($u->tipe_unit) }}</span></td>
                        <td>
                            <a class="btn btn-sm btn-outline-primary" href="{{ route('admin.units.edit', $u) }}"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('admin.units.destroy', $u) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus unit ini?')">
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




