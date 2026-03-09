<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Kesiswaan</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        .info { margin-bottom: 15px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; font-weight: bold; }
        .text-center { text-align: center; }
        .stats { display: flex; justify-content: space-between; margin-bottom: 20px; }
        .stat-box { border: 1px solid #ddd; padding: 10px; width: 30%; text-align: center; }
    </style>
</head>
<body>
    <div class="header">
        <h2>LAPORAN DATA KESISWAAN</h2>
        <h3>SMK SURYA NUSANTARA</h3>
        <p>Tanggal: {{ date('d/m/Y') }}</p>
    </div>

    <div class="stats">
        <div class="stat-box">
            <h4>Total Pelanggaran</h4>
            <h2>{{ $pelanggaran->count() }}</h2>
        </div>
        <div class="stat-box">
            <h4>Total Prestasi</h4>
            <h2>{{ $prestasi->count() }}</h2>
        </div>
        <div class="stat-box">
            <h4>Total Poin Pelanggaran</h4>
            <h2>{{ $pelanggaran->sum('poin') }}</h2>
        </div>
    </div>

    <h4>Data Pelanggaran</h4>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Siswa</th>
                <th>Kelas</th>
                <th>Jenis Pelanggaran</th>
                <th>Poin</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pelanggaran as $index => $p)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $p->siswa->nama_siswa ?? '-' }}</td>
                <td>{{ $p->siswa->kelas->nama_kelas ?? '-' }}</td>
                <td>{{ $p->jenisPelanggaran->nama_pelanggaran ?? '-' }}</td>
                <td class="text-center">{{ $p->poin }}</td>
                <td class="text-center">{{ $p->created_at->format('d/m/Y') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center">Tidak ada data pelanggaran</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <h4>Data Prestasi</h4>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Siswa</th>
                <th>Kelas</th>
                <th>Jenis Prestasi</th>
                <th>Poin</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @forelse($prestasi as $index => $pr)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $pr->siswa->nama_siswa ?? '-' }}</td>
                <td>{{ $pr->siswa->kelas->nama_kelas ?? '-' }}</td>
                <td>{{ $pr->jenisPrestasi->nama_prestasi ?? '-' }}</td>
                <td class="text-center">{{ $pr->poin }}</td>
                <td class="text-center">{{ $pr->created_at->format('d/m/Y') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center">Tidak ada data prestasi</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>