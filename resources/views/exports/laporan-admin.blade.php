<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Admin - Sistem Kesiswaan</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 30px; }
        .header h1 { margin: 0; font-size: 18px; }
        .header h2 { margin: 5px 0; font-size: 14px; color: #666; }
        .info { margin-bottom: 20px; }
        .stats { display: flex; justify-content: space-between; margin-bottom: 20px; }
        .stat-box { text-align: center; padding: 10px; border: 1px solid #ddd; width: 23%; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f5f5f5; font-weight: bold; }
        .section-title { font-size: 14px; font-weight: bold; margin: 20px 0 10px 0; color: #333; }
        .no-data { text-align: center; color: #666; font-style: italic; }
        .footer { margin-top: 30px; text-align: right; }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN SISTEM KESISWAAN</h1>
        <h2>SMK Negeri Surya</h2>
        <p>Periode: {{ $periode }}</p>
        <p>Tanggal Cetak: {{ $tanggal_cetak }}</p>
    </div>

    <div class="info">
        <div class="stats">
            <div class="stat-box">
                <strong>{{ $totalSiswa }}</strong><br>
                Total Siswa
            </div>
            <div class="stat-box">
                <strong>{{ $totalGuru }}</strong><br>
                Total Guru
            </div>
            <div class="stat-box">
                <strong>{{ $totalPelanggaran }}</strong><br>
                Total Pelanggaran
            </div>
            <div class="stat-box">
                <strong>{{ $totalPrestasi }}</strong><br>
                Total Prestasi
            </div>
        </div>
    </div>

    <div class="section-title">DATA PELANGGARAN</div>
    @if($pelanggaran->count() > 0)
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Siswa</th>
                <th>Kelas</th>
                <th>Jenis Pelanggaran</th>
                <th>Poin</th>
                <th>Guru Pencatat</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pelanggaran as $index => $p)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ date('d/m/Y', strtotime($p->created_at)) }}</td>
                <td>{{ $p->siswa->nama_siswa ?? '-' }}</td>
                <td>{{ $p->siswa->kelas->nama_kelas ?? '-' }}</td>
                <td>{{ $p->jenisPelanggaran->nama ?? '-' }}</td>
                <td>{{ $p->poin }}</td>
                <td>{{ $p->guruPencatat->nama_guru ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <p class="no-data">Tidak ada data pelanggaran</p>
    @endif

    <div class="section-title">DATA PRESTASI</div>
    @if($prestasi->count() > 0)
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Siswa</th>
                <th>Kelas</th>
                <th>Jenis Prestasi</th>
                <th>Tingkat</th>
                <th>Juara</th>
            </tr>
        </thead>
        <tbody>
            @foreach($prestasi as $index => $p)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ date('d/m/Y', strtotime($p->created_at)) }}</td>
                <td>{{ $p->siswa->nama_siswa ?? '-' }}</td>
                <td>{{ $p->siswa->kelas->nama_kelas ?? '-' }}</td>
                <td>{{ $p->jenisPrestasi->nama ?? '-' }}</td>
                <td>{{ $p->tingkat ?? '-' }}</td>
                <td>{{ $p->juara ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <p class="no-data">Tidak ada data prestasi</p>
    @endif

    <div class="section-title">DATA MONITORING PELANGGARAN</div>
    @if($monitoring->count() > 0)
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Siswa</th>
                <th>Jenis Pelanggaran</th>
                <th>Poin</th>
                <th>Guru Kepsek</th>
                <th>Status</th>
                <th>Catatan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($monitoring as $index => $m)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $m->pelanggaran->siswa->nama_siswa ?? '-' }}</td>
                <td>{{ $m->pelanggaran->jenisPelanggaran->nama ?? '-' }}</td>
                <td>{{ $m->pelanggaran->poin ?? 0 }}</td>
                <td>{{ $m->guruKepsek->nama_guru ?? '-' }}</td>
                <td>{{ ucfirst($m->status) }}</td>
                <td>{{ $m->catatan ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <p class="no-data">Tidak ada data monitoring</p>
    @endif

    <div class="section-title">DATA BIMBINGAN KONSELING</div>
    @if($bimbingan->count() > 0)
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Siswa</th>
                <th>Kelas</th>
                <th>Topik</th>
                <th>Guru Konselor</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bimbingan as $index => $b)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ date('d/m/Y', strtotime($b->created_at)) }}</td>
                <td>{{ $b->siswa->nama_siswa ?? '-' }}</td>
                <td>{{ $b->siswa->kelas->nama_kelas ?? '-' }}</td>
                <td>{{ $b->topik }}</td>
                <td>{{ $b->guruKonselor->nama_guru ?? '-' }}</td>
                <td>{{ ucfirst($b->status) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <p class="no-data">Tidak ada data bimbingan konseling</p>
    @endif

    <div class="footer">
        <p>Dicetak pada: {{ date('d F Y H:i:s') }}</p>
        <p>Administrator Sistem</p>
    </div>
</body>
</html>