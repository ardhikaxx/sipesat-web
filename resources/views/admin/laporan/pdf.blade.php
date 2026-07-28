<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Sampah</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
        }
        h2, h3 {
            text-align: center;
            margin: 5px 0;
        }
        .header {
            margin-bottom: 20px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .text-center {
            text-align: center;
        }
        .meta-info {
            margin-bottom: 15px;
            font-size: 11px;
        }
    </style>
</head>
<body>

    <div class="header">
        <h2>SIPESAT - KABUPATEN MAGETAN</h2>
        <h3>Rekapitulasi Data Laporan Sampah Liar</h3>
    </div>

    <div class="meta-info">
        <strong>Tanggal Cetak:</strong> {{ \Carbon\Carbon::now()->format('d M Y H:i:s') }} <br>
        @if($request->filled('tanggal_mulai') && $request->filled('tanggal_akhir'))
            <strong>Periode:</strong> {{ $request->tanggal_mulai }} s.d {{ $request->tanggal_akhir }} <br>
        @endif
        @if($request->filled('status'))
            <strong>Status Filter:</strong> {{ strtoupper(str_replace('_', ' ', $request->status)) }} <br>
        @endif
        <strong>Total Data:</strong> {{ $laporans->count() }} Laporan
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%" class="text-center">No</th>
                <th width="15%">Pelapor</th>
                <th width="15%">Kategori</th>
                <th width="15%">Kecamatan</th>
                <th width="20%">Deskripsi Singkat</th>
                <th width="15%" class="text-center">Status</th>
                <th width="15%">Waktu Lapor</th>
            </tr>
        </thead>
        <tbody>
            @forelse($laporans as $index => $l)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $l->user ? $l->user->name : 'Anonim' }}</td>
                <td>{{ $l->kategoriSampah ? $l->kategoriSampah->nama_kategori : '-' }}</td>
                <td>{{ $l->kecamatan ? $l->kecamatan->nama_kecamatan : '-' }}</td>
                <td>{{ \Illuminate\Support\Str::limit($l->deskripsi, 40) }}</td>
                <td class="text-center">{{ strtoupper(str_replace('_', ' ', $l->status)) }}</td>
                <td>{{ $l->created_at->format('d/m/Y H:i') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center">Tidak ada data laporan yang sesuai dengan kriteria.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>
