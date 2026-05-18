<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $title }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        h1, h2, h3, h4, h5, h6 { margin: 0; padding: 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
        th { background-color: #f2f2f2; }
        .header { text-align: center; margin-bottom: 20px; }
        .footer { position: fixed; bottom: 0; width: 100%; text-align: right; font-size: 10px; color: #666; }
    </style>
</head>
<body>
    <div class="header">
        <h2>{{ $title }}</h2>
        <p>Tahun: {{ $year }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Nama Karyawan</th>
                <th>Unit</th>
                <th>Tanggal Mulai</th>
                <th>Tanggal Selesai</th>
                <th>Status</th>
                <th>Disetujui Oleh</th>
                <th>Tanggal Persetujuan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cutis as $cuti)
            <tr>
                <td>{{ $cuti->user->nama }}</td>
                <td>
                    @php
                        $units = $cuti->user->units;
                        $unitNames = $units->pluck('nama_unit')->toArray();
                    @endphp
                    {{ count($unitNames) > 0 ? implode(', ', $unitNames) : '-' }}
                    <br>
                    <pre style="font-size: 8px;">{{ print_r($units->toArray(), true) }}</pre>
                </td>
                <td>{{ $cuti->tanggal_mulai->format('d/m/Y') }}</td>
                <td>{{ $cuti->tanggal_selesai->format('d/m/Y') }}</td>
                <td>{{ ucfirst($cuti->status) }}</td>
                <td>
                    @if($cuti->disetujui_oleh_kepala_bagian)
                        {{ $cuti->disetujuiOlehKepalaBagian->nama ?? '-' }}
                    @elseif($cuti->disetujui_oleh_kepala_ruangan)
                        {{ $cuti->disetujuiOlehKepalaRuangan->nama ?? '-' }}
                    @else
                        -
                    @endif
                </td>
                <td>{{ $cuti->updated_at->format('d/m/Y H:i') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <p><strong>Total Cuti:</strong> {{ $total_leaves }}</p>
    <p><strong>Total Hari Cuti:</strong> {{ $total_days }}</p>

    <div class="footer">
        <p>Dicetak pada: {{ $generated_at }}</p>
    </div>
</body>
</html>
