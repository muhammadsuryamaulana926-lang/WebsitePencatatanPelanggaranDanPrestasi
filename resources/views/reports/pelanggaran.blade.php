<!DOCTYPE html>
<html>
<head>
    <title>Laporan Pelanggaran</title>
    <style>
        body { font-family: sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .header { text-align: center; margin-bottom: 30px; }
        .footer { position: fixed; bottom: 0; width: 100%; text-align: right; font-size: 10px; }
    </style>
</head>
<body>
    <div class="header">
        <h2>LAPORAN PELANGGARAN SISWA</h2>
        <p>SMK MUHAMMADIYAH 1 SURYA</p>
        <hr>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Siswa</th>
                <th>Kelas</th>
                <th>Pelanggaran</th>
                <th>Poin</th>
                <th>Guru Pencatat</th>
            </tr>
        </thead>
        <tbody>
            @foreach($records as $index => $record)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $record->created_at->format('d/m/Y') }}</td>
                <td>{{ $record->siswa->nama_siswa }}</td>
                <td>{{ $record->siswa->kelas->nama_kelas }}</td>
                <td>{{ $record->jenisPelanggaran->nama_pelanggaran }}</td>
                <td>{{ $record->poin }}</td>
                <td>{{ $record->guruPencatat->nama_guru }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Dicetak pada: {{ now()->format('d/m/Y H:i') }}
    </div>
</body>
</html>
