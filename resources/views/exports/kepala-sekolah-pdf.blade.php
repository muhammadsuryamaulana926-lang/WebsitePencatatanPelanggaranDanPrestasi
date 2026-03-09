<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Kepala Sekolah</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        .summary { background-color: #f9f9f9; padding: 15px; margin: 15px 0; }
        .section { margin-bottom: 25px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 6px; text-align: left; font-size: 11px; }
        th { background-color: #f2f2f2; font-weight: bold; }
        .text-center { text-align: center; }
        .page-break { page-break-before: always; }
    </style>
</head>
<body>
    <div class="header">
        <h2>LAPORAN KESISWAAN SEKOLAH</h2>
        <h3>KEPALA SEKOLAH</h3>
        <p>Periode: {{ date('Y') }} | Tanggal: {{ date('d/m/Y') }}</p>
    </div>

    <div class="summary">
        <h3>RINGKASAN EKSEKUTIF</h3>
        <p><strong>Total Siswa:</strong> {{ $siswa->count() }}</p>
        <p><strong>Total Pelanggaran:</strong> {{ $pelanggaran->count() }} ({{ $pelanggaran->sum('poin') }} poin)</p>
        <p><strong>Total Prestasi:</strong> {{ $prestasi->count() }} ({{ $prestasi->sum('poin') }} poin)</p>
        <p><strong>Total Bimbingan Konseling:</strong> {{ $bimbinganKonseling->count() }}</p>
        <p><strong>Rasio Prestasi vs Pelanggaran:</strong> 
            {{ $pelanggaran->count() > 0 ? round($prestasi->count() / $pelanggaran->count(), 2) : 'N/A' }}
        </p>
    </div>

    <div class="section">
        <h3>TOP 10 SISWA DENGAN PELANGGARAN TERBANYAK</h3>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Siswa</th>
                    <th>Kelas</th>
                    <th>Total Poin Pelanggaran</th>
                    <th>Total Poin Prestasi</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $topPelanggaran = $siswa->sortByDesc(function($s) { return $s->pelanggaran->sum('poin'); })->take(10);
                @endphp
                @foreach($topPelanggaran as $index => $s)
                @php
                    $poinPelanggaran = $s->pelanggaran->sum('poin');
                    $poinPrestasi = $s->prestasi->sum('poin');
                @endphp
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $s->nama_siswa }}</td>
                    <td>{{ $s->kelas->nama_kelas }}</td>
                    <td class="text-center">{{ $poinPelanggaran }}</td>
                    <td class="text-center">{{ $poinPrestasi }}</td>
                    <td class="text-center">
                        @if($poinPelanggaran >= 100)
                            <span style="color: red;">Critical</span>
                        @elseif($poinPelanggaran >= 50)
                            <span style="color: orange;">Warning</span>
                        @else
                            <span style="color: green;">Normal</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="page-break"></div>

    <div class="section">
        <h3>STATISTIK PER KELAS</h3>
        <table>
            <thead>
                <tr>
                    <th>Kelas</th>
                    <th>Jumlah Siswa</th>
                    <th>Total Pelanggaran</th>
                    <th>Total Prestasi</th>
                    <th>Rata-rata Poin Pelanggaran</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $kelasStats = $siswa->groupBy('kelas.nama_kelas');
                @endphp
                @foreach($kelasStats as $namaKelas => $siswaDiKelas)
                @php
                    $totalPelanggaran = $siswaDiKelas->sum(function($s) { return $s->pelanggaran->count(); });
                    $totalPrestasi = $siswaDiKelas->sum(function($s) { return $s->prestasi->count(); });
                    $totalPoinPelanggaran = $siswaDiKelas->sum(function($s) { return $s->pelanggaran->sum('poin'); });
                    $rataRata = $siswaDiKelas->count() > 0 ? round($totalPoinPelanggaran / $siswaDiKelas->count(), 1) : 0;
                @endphp
                <tr>
                    <td>{{ $namaKelas }}</td>
                    <td class="text-center">{{ $siswaDiKelas->count() }}</td>
                    <td class="text-center">{{ $totalPelanggaran }}</td>
                    <td class="text-center">{{ $totalPrestasi }}</td>
                    <td class="text-center">{{ $rataRata }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="section">
        <h3>REKOMENDASI</h3>
        <ul>
            @if($pelanggaran->count() > $prestasi->count())
            <li>Perlu peningkatan program pembinaan karakter siswa</li>
            <li>Intensifkan program bimbingan konseling</li>
            @endif
            @if($bimbinganKonseling->count() > 50)
            <li>Evaluasi efektivitas program bimbingan konseling</li>
            @endif
            <li>Tingkatkan program penghargaan untuk prestasi siswa</li>
            <li>Lakukan monitoring berkala terhadap siswa dengan poin pelanggaran tinggi</li>
        </ul>
    </div>

    <div style="margin-top: 40px; text-align: right;">
        <p>{{ date('d F Y') }}</p>
        <p style="margin-top: 60px;">Kepala Sekolah</p>
    </div>
</body>
</html>