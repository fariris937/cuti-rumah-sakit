@extends('layouts.app')

@section('title', 'Kelola Divisi')
@section('page-title', 'Kelola Divisi')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="fas fa-sitemap me-2"></i>Daftar Divisi</h5>
        <a href="{{ route('admin.divisi.create') }}" class="btn btn-primary"><i class="fas fa-plus me-2"></i>Tambah Divisi</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Nama Divisi</th>
                        <th>Kepala Divisi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($divisis as $d)
                    <tr>
                        <td>{{ $d->nama_divisi }}</td>
                        <td>{{ $d->kepala_divisi ?? '-' }}</td>
                        <td>
                            <a class="btn btn-sm btn-outline-primary" href="{{ route('admin.divisi.edit', $d) }}"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('admin.divisi.destroy', $d) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus divisi ini?')">
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




