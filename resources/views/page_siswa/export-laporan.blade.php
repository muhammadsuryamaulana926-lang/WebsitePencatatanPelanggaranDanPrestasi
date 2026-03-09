@extends('layouts.siswa')

@section('title', 'Export Laporan')
@section('page-title', 'Export Laporan')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4>Laporan Data Siswa</h4>
        <button class="btn btn-primary" onclick="window.print()">
            <i class="fas fa-print me-2"></i>Cetak Laporan
        </button>
    </div>

    <!-- Info Siswa -->
    <div class="card mb-4" style="border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="fas fa-user me-2"></i>Informasi Siswa</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>NIS:</strong> {{ $siswa->nis }}</p>
                    <p><strong>Nama:</strong> {{ $siswa->nama_siswa }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Kelas:</strong> {{ $siswa->kelas->nama_kelas ?? '-' }}</p>
                    <p><strong>Jenis Kelamin:</strong> {{ $siswa->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Ringkasan -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card text-center" style="border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                <div class="card-body">
                    <h5 class="card-title text-danger">Total Pelanggaran</h5>
                    <h2 class="text-danger">{{ $pelanggaran->count() }}</h2>
                    <p class="text-muted">{{ $pelanggaran->sum('poin') }} Poin</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center" style="border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                <div class="card-body">
                    <h5 class="card-title text-success">Total Prestasi</h5>
                    <h2 class="text-success">{{ $prestasi->count() }}</h2>
                    <p class="text-muted">{{ $prestasi->sum('poin') }} Poin</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center" style="border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                <div class="card-body">
                    @php
                        $totalPoinPelanggaran = $pelanggaran->sum('poin');
                        $status = 'Normal';
                        $statusClass = 'text-success';
                        if ($totalPoinPelanggaran >= 100) {
                            $status = 'Critical';
                            $statusClass = 'text-danger';
                        } elseif ($totalPoinPelanggaran >= 50) {
                            $status = 'Warning';
                            $statusClass = 'text-warning';
                        }
                    @endphp
                    <h5 class="card-title">Status</h5>
                    <h2 class="{{ $statusClass }}">{{ $status }}</h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Detail Pelanggaran -->
    <div class="card mb-4" style="border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
        <div class="card-header bg-danger text-white">
            <h5 class="mb-0"><i class="fas fa-exclamation-triangle me-2"></i>Detail Pelanggaran</h5>
        </div>
        <div class="card-body">
            @if($pelanggaran->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead class="table-dark">
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Jenis Pelanggaran</th>
                                <th>Poin</th>
                                <th>Guru Pencatat</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $no = 1; @endphp
                            @foreach($pelanggaran as $p)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $p->tanggal_pelanggaran ? date('d/m/Y', strtotime($p->tanggal_pelanggaran)) : date('d/m/Y', strtotime($p->created_at)) }}</td>
                                <td>{{ $p->jenisPelanggaran->nama_pelanggaran ?? '-' }}</td>
                                <td><span class="badge bg-danger">{{ $p->poin }}</span></td>
                                <td>{{ $p->guruPencatat->nama_guru ?? '-' }}</td>
                                <td>{{ $p->keterangan ?? '-' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-success">
                    <i class="fas fa-check-circle me-2"></i>Tidak ada data pelanggaran
                </div>
            @endif
        </div>
    </div>

    <!-- Detail Prestasi -->
    <div class="card" style="border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
        <div class="card-header bg-success text-white">
            <h5 class="mb-0"><i class="fas fa-trophy me-2"></i>Detail Prestasi</h5>
        </div>
        <div class="card-body">
            @if($prestasi->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead class="table-dark">
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Jenis Prestasi</th>
                                <th>Poin</th>
                                <th>Guru Pencatat</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $no = 1; @endphp
                            @foreach($prestasi as $pr)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $pr->tanggal_prestasi ? date('d/m/Y', strtotime($pr->tanggal_prestasi)) : date('d/m/Y', strtotime($pr->created_at)) }}</td>
                                <td>{{ $pr->jenisPrestasi->nama_prestasi ?? '-' }}</td>
                                <td><span class="badge bg-success">{{ $pr->poin }}</span></td>
                                <td>{{ $pr->guruPencatat->nama_guru ?? '-' }}</td>
                                <td>{{ $pr->keterangan ?? '-' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>Belum ada data prestasi
                </div>
            @endif
        </div>
    </div>

    <div class="text-center mt-4">
        <p class="text-muted">Laporan dicetak pada: {{ date('d/m/Y H:i:s') }}</p>
    </div>
@endsection

@section('styles')
<style>
    @media print {
        .btn, .navbar, .sidebar {
            display: none !important;
        }
        .card {
            box-shadow: none !important;
            border: 1px solid #ddd !important;
        }
    }
</style>
@endsection