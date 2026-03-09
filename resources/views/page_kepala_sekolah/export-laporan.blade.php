@extends('layouts.kepala_sekolah')

@section('title', 'Export Laporan')
@section('page-title', 'Export Laporan')

@section('content')
    <!-- Filter dan Export -->
    <div class="card mb-4" style="border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
        <div class="card-header bg-success text-white">
            <h5 class="mb-0"><i class="fas fa-file-export me-2"></i>Export Laporan Sekolah</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Jenis Laporan</label>
                        <select class="form-control" id="filterJenis">
                            <option value="semua">Semua Data</option>
                            <option value="pelanggaran">Pelanggaran</option>
                            <option value="prestasi">Prestasi</option>
                            <option value="bimbingan">Bimbingan Konseling</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Periode</label>
                        <select class="form-control" id="filterPeriode">
                            <option value="">Semua Periode</option>
                            <option value="7">7 Hari Terakhir</option>
                            <option value="30">30 Hari Terakhir</option>
                            <option value="90">3 Bulan Terakhir</option>
                            <option value="365">1 Tahun Terakhir</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Format</label>
                        <div class="d-flex gap-2">
                            <button class="btn btn-success" onclick="exportExcel()">
                                <i class="fas fa-file-excel me-1"></i>Excel
                            </button>
                            <button class="btn btn-danger" onclick="exportPDF()">
                                <i class="fas fa-file-pdf me-1"></i>PDF
                            </button>
                            <button class="btn btn-info" onclick="printReport()">
                                <i class="fas fa-print me-1"></i>Print
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Ringkasan Statistik -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-center" style="border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                <div class="card-body">
                    <i class="fas fa-users fs-2 text-primary mb-2"></i>
                    <h6 class="card-title">Total Siswa</h6>
                    <h3 class="text-primary">{{ $siswa->count() }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center" style="border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                <div class="card-body">
                    <i class="fas fa-exclamation-triangle fs-2 text-danger mb-2"></i>
                    <h6 class="card-title">Total Pelanggaran</h6>
                    <h3 class="text-danger">{{ $pelanggaran->count() }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center" style="border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                <div class="card-body">
                    <i class="fas fa-trophy fs-2 text-success mb-2"></i>
                    <h6 class="card-title">Total Prestasi</h6>
                    <h3 class="text-success">{{ $prestasi->count() }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center" style="border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                <div class="card-body">
                    <i class="fas fa-user-friends fs-2 text-info mb-2"></i>
                    <h6 class="card-title">Bimbingan Konseling</h6>
                    <h3 class="text-info">{{ $bimbinganKonseling->count() }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Preview Laporan -->
    <div class="card" style="border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
        <div class="card-header bg-warning text-white">
            <h5 class="mb-0"><i class="fas fa-eye me-2"></i>Preview Laporan</h5>
        </div>
        <div class="card-body">
            <!-- Tabs -->
            <ul class="nav nav-tabs" id="laporanTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="pelanggaran-tab" data-bs-toggle="tab" data-bs-target="#pelanggaran" type="button">
                        Pelanggaran ({{ $pelanggaran->count() }})
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="prestasi-tab" data-bs-toggle="tab" data-bs-target="#prestasi" type="button">
                        Prestasi ({{ $prestasi->count() }})
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="bimbingan-tab" data-bs-toggle="tab" data-bs-target="#bimbingan" type="button">
                        Bimbingan ({{ $bimbinganKonseling->count() }})
                    </button>
                </li>
            </ul>

            <div class="tab-content" id="laporanTabsContent">
                <!-- Tab Pelanggaran -->
                <div class="tab-pane fade show active" id="pelanggaran" role="tabpanel">
                    <div class="table-responsive mt-3">
                        <table class="table table-striped table-sm">
                            <thead class="table-dark">
                                <tr>
                                    <th>No</th>
                                    <th>Siswa</th>
                                    <th>Kelas</th>
                                    <th>Jenis</th>
                                    <th>Poin</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pelanggaran->take(10) as $index => $p)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $p->siswa->nama_siswa ?? '-' }}</td>
                                    <td>{{ $p->siswa->kelas->nama_kelas ?? '-' }}</td>
                                    <td>{{ $p->jenisPelanggaran->nama_pelanggaran ?? '-' }}</td>
                                    <td><span class="badge bg-danger">{{ $p->poin }}</span></td>
                                    <td>{{ $p->created_at->format('d/m/Y') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @if($pelanggaran->count() > 10)
                        <p class="text-muted">Menampilkan 10 dari {{ $pelanggaran->count() }} data</p>
                        @endif
                    </div>
                </div>

                <!-- Tab Prestasi -->
                <div class="tab-pane fade" id="prestasi" role="tabpanel">
                    <div class="table-responsive mt-3">
                        <table class="table table-striped table-sm">
                            <thead class="table-dark">
                                <tr>
                                    <th>No</th>
                                    <th>Siswa</th>
                                    <th>Kelas</th>
                                    <th>Jenis</th>
                                    <th>Poin</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($prestasi->take(10) as $index => $p)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $p->siswa->nama_siswa ?? '-' }}</td>
                                    <td>{{ $p->siswa->kelas->nama_kelas ?? '-' }}</td>
                                    <td>{{ $p->jenisPrestasi->nama_prestasi ?? '-' }}</td>
                                    <td><span class="badge bg-success">{{ $p->poin }}</span></td>
                                    <td>{{ $p->created_at->format('d/m/Y') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @if($prestasi->count() > 10)
                        <p class="text-muted">Menampilkan 10 dari {{ $prestasi->count() }} data</p>
                        @endif
                    </div>
                </div>

                <!-- Tab Bimbingan -->
                <div class="tab-pane fade" id="bimbingan" role="tabpanel">
                    <div class="table-responsive mt-3">
                        <table class="table table-striped table-sm">
                            <thead class="table-dark">
                                <tr>
                                    <th>No</th>
                                    <th>Siswa</th>
                                    <th>Kelas</th>
                                    <th>Topik</th>
                                    <th>Status</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($bimbinganKonseling->take(10) as $index => $bk)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $bk->siswa->nama_siswa ?? '-' }}</td>
                                    <td>{{ $bk->siswa->kelas->nama_kelas ?? '-' }}</td>
                                    <td>{{ $bk->topik }}</td>
                                    <td>
                                        <span class="badge 
                                            @if($bk->status == 'selesai') bg-success
                                            @elseif($bk->status == 'berlangsung') bg-warning
                                            @else bg-info
                                            @endif">
                                            {{ ucfirst($bk->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $bk->created_at->format('d/m/Y') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @if($bimbinganKonseling->count() > 10)
                        <p class="text-muted">Menampilkan 10 dari {{ $bimbinganKonseling->count() }} data</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    function exportExcel() {
        alert('Fitur export Excel akan segera tersedia');
    }
    
    function exportPDF() {
        alert('Fitur export PDF akan segera tersedia');
    }
    
    function printReport() {
        window.print();
    }
</script>
@endsection