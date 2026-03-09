<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Wali Kelas</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        .info { margin-bottom: 15px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; font-weight: bold; }
        .text-center { text-align: center; }
    </style>
</head>
<body>
    <div class="header">
        <h2>LAPORAN PELANGGARAN SISWA</h2>
        <h3>WALI KELAS</h3>
        <p>Tanggal: {{ date('d/m/Y') }}</p>
    </div>

    <div class="info">
        <p><strong>Wali Kelas:</strong> {{ $guru->nama_guru ?? 'Tidak Diketahui' }}</p>
        <p><strong>Kelas yang Diwali:</strong> 
            @foreach($kelasWali as $kelas)
                {{ $kelas->nama_kelas }}@if(!$loop->last), @endif
            @endforeach
        </p>
        <p><strong>Total Pelanggaran:</strong> {{ $pelanggaran->count() }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Nama Siswa</th>
                <th>Kelas</th>
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
                <td>{{ $p->siswa->nama_siswa }}</td>
                <td>{{ $p->siswa->kelas->nama_kelas }}</td>
                <td>{{ $p->jenisPelanggaran->nama_pelanggaran }}</td>
                <td class="text-center">{{ $p->poin }}</td>
                <td>{{ $p->guruPencatat->nama_guru ?? 'Tidak Diketahui' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div style="margin-top: 30px;">
        <p><strong>Catatan:</strong> Laporan ini berisi data pelanggaran siswa dari kelas yang diwali.</p>
    </div>
</body>
</html>