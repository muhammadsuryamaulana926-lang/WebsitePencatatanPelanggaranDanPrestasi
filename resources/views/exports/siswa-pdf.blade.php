<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Siswa</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        .info { margin-bottom: 15px; }
        .section { margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; font-weight: bold; }
        .text-center { text-align: center; }
        .summary { background-color: #f9f9f9; padding: 10px; margin: 10px 0; }
    </style>
</head>
<body>
    <div class="header">
        <h2>LAPORAN KESISWAAN</h2>
        <h3>DATA PELANGGARAN & PRESTASI SISWA</h3>
        <p>Tanggal: {{ date('d/m/Y') }}</p>
    </div>

    <div class="info">
        <p><strong>Nama:</strong> {{ $siswa->nama_siswa }}</p>
        <p><strong>NIS:</strong> {{ $siswa->nis }}</p>
        <p><strong>Kelas:</strong> {{ $siswa->kelas->nama_kelas }}</p>
    </div>

    <div class="summary">
        <p><strong>Ringkasan:</strong></p>
        <p>Total Pelanggaran: {{ $pelanggaran->count() }} ({{ $pelanggaran->sum('poin') }} poin)</p>
        <p>Total Prestasi: {{ $prestasi->count() }} ({{ $prestasi->sum('poin') }} poin)</p>
    </div>

    <div class="section">
        <h3>RIWAYAT PELANGGARAN</h3>
        @if($pelanggaran->count() > 0)
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Jenis Pelanggaran</th>
                    <th>Poin</th>
                    <th>Guru Pencatat</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pelanggaran as $index => $p)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $p->created_at->format('d/m/Y') }}</td>
                    <td>{{ $p->jenisPelanggaran->nama_pelanggaran }}</td>
                    <td class="text-center">{{ $p->poin }}</td>
                    <td>{{ $p->guruPencatat->nama_guru ?? 'Tidak Diketahui' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <p>Tidak ada riwayat pelanggaran.</p>
        @endif
    </div>

    <div class="section">
        <h3>RIWAYAT PRESTASI</h3>
        @if($prestasi->count() > 0)
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Jenis Prestasi</th>
                    <th>Poin</th>
                    <th>Guru Pencatat</th>
                </tr>
            </thead>
            <tbody>
                @foreach($prestasi as $index => $pr)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $pr->created_at->format('d/m/Y') }}</td>
                    <td>{{ $pr->jenisPrestasi->nama_prestasi }}</td>
                    <td class="text-center">{{ $pr->poin }}</td>
                    <td>{{ $pr->guruPencatat->nama_guru ?? 'Tidak Diketahui' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <p>Tidak ada riwayat prestasi.</p>
        @endif
    </div>
</body>
</html>