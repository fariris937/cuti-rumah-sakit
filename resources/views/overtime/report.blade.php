@extends('layouts.app')

@section('title', 'Laporan Lembur')
@section('page-title', 'Laporan Lembur')

@section('content')
<div class="container">
    <h2>Laporan Lembur</h2>

    <form method="GET" action="{{ route('overtime.report') }}" class="mb-3">
        <div class="row g-3 align-items-center">
            <div class="col-auto">
                <label for="month" class="col-form-label">Bulan</label>
            </div>
            <div class="col-auto">
                <select name="month" id="month" class="form-select">
                    <option value="">Semua</option>
                    @foreach(range(1, 12) as $m)
                        <option value="{{ $m }}" {{ request('month') == $m ? 'selected' : '' }}>{{ DateTime::createFromFormat('!m', $m)->format('F') }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-auto">
                <label for="year" class="col-form-label">Tahun</label>
            </div>
            <div class="col-auto">
                <select name="year" id="year" class="form-select">
                    <option value="">Semua</option>
                    @foreach(range(date('Y'), date('Y') - 5) as $y)
                        <option value="{{ $y }}" {{ request('year') == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary">Filter</button>
            </div>
        </div>
    </form>

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
                </tr>
                @endforeach
            </tbody>
        </table>

        @if($overtimes instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator)
            {{ $overtimes->appends(request()->query())->links() }}
        @endif
    @else
        <p>Tidak ada data lembur.</p>
    @endif
</div>
@endsection
