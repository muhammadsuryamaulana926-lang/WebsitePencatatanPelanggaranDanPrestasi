<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Pelanggaran</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        .info { margin-bottom: 15px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; font-weight: bold; }
        .text-center { text-align: center; }
    </style>
</head>
<body>
    <div class="header">
        <h2>LAPORAN DATA PELANGGARAN</h2>
        <h3>SMK SURYA NUSANTARA</h3>
        @if($guru)
            <p>Guru: {{ $guru->nama_guru }}</p>
        @endif
        <p>Tanggal: {{ date('d/m/Y') }}</p>
    </div>

    @if($guru)
    <div class="info">
        <strong>Informasi Guru:</strong><br>
        Nama: {{ $guru->nama_guru }}<br>
        NIP: {{ $guru->nip ?? '-' }}<br>
        Mata Pelajaran: {{ $guru->mata_pelajaran ?? '-' }}
    </div>
    @endif

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

    <div style="margin-top: 30px;">
        <p><strong>Ringkasan:</strong></p>
        <p>Total Pelanggaran: {{ $pelanggaran->count() }}</p>
        <p>Total Prestasi: {{ $prestasi->count() }}</p>
    </div>
</body>
</html>