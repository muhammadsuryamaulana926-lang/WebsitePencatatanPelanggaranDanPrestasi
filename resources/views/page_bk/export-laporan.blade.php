@extends('layouts.bk')

@section('title', 'Export Laporan')
@section('page-title', 'Export Laporan')

@section('content')
    <!-- Filter dan Export -->
    <div class="card mb-4" style="border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
        <div class="card-header bg-success text-white">
            <h5 class="mb-0"><i class="fas fa-file-export me-2"></i>Export Laporan Bimbingan Konseling</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Status Kasus</label>
                        <select class="form-control" id="filterStatus">
                            <option value="">Semua Status</option>
                            <option value="terjadwal">Terjadwal</option>
                            <option value="berlangsung">Berlangsung</option>
                            <option value="selesai">Selesai</option>
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
                <div class="col-md-3">
                    <div class="card border-success">
                        <div class="card-body text-center">
                            <h6 class="card-title">Total Bimbingan</h6>
                            <h3 class="text-success">{{ ($data ?? $bimbinganKonseling ?? collect())->count() }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-info">
                        <div class="card-body text-center">
                            <h6 class="card-title">Terjadwal</h6>
                            <h3 class="text-info">{{ ($data ?? $bimbinganKonseling ?? collect())->where('status', 'terjadwal')->count() }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-warning">
                        <div class="card-body text-center">
                            <h6 class="card-title">Berlangsung</h6>
                            <h3 class="text-warning">{{ ($data ?? $bimbinganKonseling ?? collect())->where('status', 'berlangsung')->count() }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-success">
                        <div class="card-body text-center">
                            <h6 class="card-title">Selesai</h6>
                            <h3 class="text-success">{{ ($data ?? $bimbinganKonseling ?? collect())->where('status', 'selesai')->count() }}</h3>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detail Bimbingan -->
            <div class="table-responsive">
                <table class="table table-striped" id="laporanTable">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Nama Siswa</th>
                            <th>Kelas</th>
                            <th>Topik</th>
                            <th>Status</th>
                            <th>Tindakan</th>
                            <th>Konselor</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $no = 1; @endphp
                        @forelse($data ?? $bimbinganKonseling ?? [] as $bk)
                        <tr>
                            <td>{{ $no++ }}</td>
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
                            <td>{{ $bk->tindakan ?? '-' }}</td>
                            <td>{{ $bk->guruKonselor->nama_guru ?? '-' }}</td>
                            <td>{{ $bk->created_at->format('d/m/Y') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted">Belum ada data bimbingan konseling</td>
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
        const status = document.getElementById('filterStatus').value;
        const periode = document.getElementById('filterPeriode').value;
        
        let url = '/bk/export-laporan?export=pdf';
        if (status) url += '&status=' + status;
        if (periode) url += '&periode=' + periode;
        
        window.open(url, '_blank');
    }
    
    function printReport() {
        window.print();
    }
</script>
@endsection