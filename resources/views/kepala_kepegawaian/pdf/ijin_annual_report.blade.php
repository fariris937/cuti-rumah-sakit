<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $title }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        h1, h2, h3, h4, h5, h6 { margin: 0; padding: 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; word-wrap: break-word; table-layout: fixed; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; vertical-align: top; }
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
                <th>Divisi</th>
                <th>Unit</th>
                <th>Tanggal Ijin</th>
                <th>Jenis Ijin</th>
                <th>Status</th>
                <th>Disetujui Oleh</th>
                <th>Tanggal Persetujuan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($ijins as $ijin)
            <tr>
                <td>{{ $ijin->user->nama }}</td>
                <td>{{ $ijin->user->divisi->nama_divisi ?? '-' }}</td>
                <td>
                    @php
                        $units = $ijin->user->units;
                        $unitNames = $units->pluck('nama_unit')->toArray();
                    @endphp
                    {{ count($unitNames) > 0 ? implode(', ', $unitNames) : '-' }}
                </td>
                <td>{{ \Carbon\Carbon::parse($ijin->tanggal_ijin)->format('d/m/Y') }}</td>
                <td>{{ ucfirst($ijin->jenis_ijin) }}</td>
                <td>{{ ucfirst($ijin->status) }}</td>
                <td>{{ $ijin->disetujuiOlehKepalaRuangan->nama ?? '-' }}</td>
                <td>{{ $ijin->updated_at->format('d/m/Y H:i') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <p><strong>Total Ijin:</strong> {{ $total_ijins }}</p>

    <div class="footer">
        <p>Dicetak pada: {{ $generated_at }}</p>
    </div>
</body>
</html>
