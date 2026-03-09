@extends('layouts.guru')

@section('title', 'Export Laporan')
@section('page-title')
    Export Laporan - {{ $guru->nama_guru ?? "Guru" }}
@endsection

@section('content')
    <div class="card" style="border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
        <div class="card-header bg-success text-white">
            <h5 class="mb-0"><i class="fas fa-file-export me-2"></i>Laporan Data {{ $guru->nama_guru ?? "Guru" }}</h5>
        </div>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-6">
                    <h6>Informasi Guru:</h6>
                    <p><strong>Nama:</strong> {{ $guru->nama_guru ?? '-' }}</p>
                    <p><strong>NIP:</strong> {{ $guru->nip ?? '-' }}</p>
                    <p><strong>Mata Pelajaran:</strong> {{ $guru->mata_pelajaran ?? '-' }}</p>
                </div>
                <div class="col-md-6">
                    <div class="text-end">
                        <a href="/guru/export-excel/{{ $guru->id }}" class="btn btn-success me-2">
                            <i class="fas fa-file-excel me-1"></i>Export Excel
                        </a>
                        <a href="/guru/export-pdf/{{ $guru->id }}" class="btn btn-danger me-2">
                            <i class="fas fa-file-pdf me-1"></i>Export PDF
                        </a>
                        <button onclick="window.print()" class="btn btn-primary">
                            <i class="fas fa-print me-1"></i>Cetak Laporan
                        </button>
                    </div>
                </div>
            </div>

            <!-- Data Pelanggaran -->
            <div class="mb-4">
                <h6 class="text-danger"><i class="fas fa-exclamation-triangle me-2"></i>Data Pelanggaran yang Dicatat</h6>
                <div class="table-responsive">
                    <table class="table table-striped table-sm">
                        <thead class="table-dark">
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
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $p->siswa->nama_siswa ?? '-' }}</td>
                                <td>{{ $p->siswa->kelas->nama_kelas ?? '-' }}</td>
                                <td>{{ $p->jenisPelanggaran->nama_pelanggaran ?? '-' }}</td>
                                <td><span class="badge bg-danger">{{ $p->poin }}</span></td>
                                <td>{{ $p->created_at->format('d/m/Y') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center">Tidak ada data pelanggaran</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Data Prestasi -->
            <div class="mb-4">
                <h6 class="text-success"><i class="fas fa-trophy me-2"></i>Data Prestasi yang Dicatat</h6>
                <div class="table-responsive">
                    <table class="table table-striped table-sm">
                        <thead class="table-dark">
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
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $pr->siswa->nama_siswa ?? '-' }}</td>
                                <td>{{ $pr->siswa->kelas->nama_kelas ?? '-' }}</td>
                                <td>{{ $pr->jenisPrestasi->nama_prestasi ?? '-' }}</td>
                                <td><span class="badge bg-success">{{ $pr->poin }}</span></td>
                                <td>{{ $pr->created_at->format('d/m/Y') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center">Tidak ada data prestasi</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Ringkasan -->
            <div class="row">
                <div class="col-md-6">
                    <div class="card bg-light">
                        <div class="card-body text-center">
                            <h5 class="text-danger">{{ $pelanggaran->count() }}</h5>
                            <p class="mb-0">Total Pelanggaran Dicatat</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card bg-light">
                        <div class="card-body text-center">
                            <h5 class="text-success">{{ $prestasi->count() }}</h5>
                            <p class="mb-0">Total Prestasi Dicatat</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles')
<style>
@media print {
    .btn, .card-header, .navbar, .sidebar {
        display: none !important;
    }
    .card {
        border: none !important;
        box-shadow: none !important;
    }
}
</style>
@endsection