@extends('layouts.walikelas')

@section('title', 'Export Laporan')
@section('page-title', 'Export Laporan')

@section('content')
    <!-- Filter dan Export -->
    <div class="card mb-4" style="border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
        <div class="card-header bg-success text-white">
            <h5 class="mb-0"><i class="fas fa-file-export me-2"></i>Export Laporan Kelas</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Pilih Kelas</label>
                        <select class="form-control" id="filterKelas">
                            <option value="">Semua Kelas</option>
                            @foreach($kelasWali as $kelas)
                            <option value="{{ $kelas->id }}">{{ $kelas->nama_kelas }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Periode</label>
                        <select class="form-control" id="filterPeriode">
                            <option value="">Semua Periode</option>
                            <option value="7">7 Hari Terakhir</option>
                            <option value="30">30 Hari Terakhir</option>
                            <option value="90">3 Bulan Terakhir</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="d-flex gap-2">
                <button class="btn btn-success" onclick="exportExcel()">
                    <i class="fas fa-file-excel me-1"></i>Export Excel
                </button>
                <button class="btn btn-danger" onclick="exportPDF()">
                    <i class="fas fa-file-pdf me-1"></i>Export PDF
                </button>
                <button class="btn btn-info" onclick="printReport()">
                    <i class="fas fa-print me-1"></i>Print
                </button>
            </div>
        </div>
    </div>

    <!-- Preview Laporan -->
    <div class="card" style="border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
        <div class="card-header bg-warning text-white">
            <h5 class="mb-0"><i class="fas fa-eye me-2"></i>Preview Laporan</h5>
        </div>
        <div class="card-body">
            <!-- Ringkasan -->
            <div class="row mb-4">
                @foreach($kelasWali as $kelas)
                <div class="col-md-4 mb-3">
                    <div class="card border-primary">
                        <div class="card-body text-center">
                            <h6 class="card-title">{{ $kelas->nama_kelas }}</h6>
                            <p class="card-text">
                                <strong>{{ $kelas->siswa->count() }}</strong> Siswa<br>
                                <strong>{{ $kelas->siswa->sum(function($s) { return $s->pelanggaran->count(); }) }}</strong> Pelanggaran
                            </p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Detail Pelanggaran -->
            <div class="table-responsive">
                <table class="table table-striped" id="laporanTable">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Nama Siswa</th>
                            <th>Kelas</th>
                            <th>Jenis Pelanggaran</th>
                            <th>Poin</th>
                            <th>Guru Pencatat</th>
                            <th>Tanggal</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $no = 1; @endphp
                        @forelse($pelanggaran as $p)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $p->siswa->nama_siswa ?? '-' }}</td>
                            <td>{{ $p->siswa->kelas->nama_kelas ?? '-' }}</td>
                            <td>{{ $p->jenisPelanggaran->nama_pelanggaran ?? '-' }}</td>
                            <td><span class="badge bg-danger">{{ $p->poin }}</span></td>
                            <td>{{ $p->guruPencatat->nama_guru ?? '-' }}</td>
                            <td>{{ $p->created_at->format('d/m/Y') }}</td>
                            <td>{{ $p->keterangan ?? '-' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted">Belum ada data pelanggaran</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
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