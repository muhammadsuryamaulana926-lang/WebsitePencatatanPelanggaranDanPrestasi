@extends('layouts.kepala_sekolah')

@section('title', 'Monitoring All')
@section('page-title', 'Monitoring Semua Siswa')

@section('content')
    <!-- Filter -->
    <div class="card mb-4" style="border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="fas fa-filter me-2"></i>Filter Monitoring</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <select class="form-control" id="filterStatus">
                        <option value="">Semua Status</option>
                        <option value="normal">Normal</option>
                        <option value="warning">Warning</option>
                        <option value="critical">Critical</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <select class="form-control" id="filterKelas">
                        <option value="">Semua Kelas</option>
                        @foreach($monitoring->pluck('siswa.kelas')->unique('id')->filter() as $kelas)
                        <option value="{{ $kelas->id }}">{{ $kelas->nama_kelas }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <button class="btn btn-primary" onclick="applyFilter()">
                        <i class="fas fa-search me-1"></i>Filter
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Monitoring Data -->
    <div class="card" style="border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
        <div class="card-header bg-success text-white">
            <h5 class="mb-0"><i class="fas fa-chart-line me-2"></i>Monitoring Semua Siswa</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped" id="monitoringTable">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Nama Siswa</th>
                            <th>Kelas</th>
                            <th>Total Pelanggaran</th>
                            <th>Total Prestasi</th>
                            <th>Status</th>
                            <th>Last Update</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $no = 1; @endphp
                        @forelse($monitoring as $m)
                        <tr data-status="{{ $m->status }}" data-kelas="{{ $m->siswa->kelas->id ?? '' }}">
                            <td>{{ $no++ }}</td>
                            <td>{{ $m->siswa->nama_siswa }}</td>
                            <td>{{ $m->siswa->kelas->nama_kelas ?? '-' }}</td>
                            <td>
                                <span class="badge bg-danger">{{ $m->total_poin }} Poin</span>
                            </td>
                            <td>
                                <span class="badge bg-success">{{ $m->total_poin_prestasi }} Poin</span>
                            </td>
                            <td>
                                <span class="badge 
                                    @if($m->status == 'normal') bg-success
                                    @elseif($m->status == 'warning') bg-warning
                                    @else bg-danger
                                    @endif">
                                    {{ ucfirst($m->status) }}
                                </span>
                            </td>
                            <td>{{ $m->updated_at->format('d/m/Y') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">Tidak ada data siswa</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Statistik -->
    <div class="row mt-4">
        <div class="col-md-3">
            <div class="card text-center" style="border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                <div class="card-body">
                    <i class="fas fa-users fs-2 text-primary mb-2"></i>
                    <h5>Total Siswa</h5>
                    <h3 class="text-primary">{{ $monitoring->count() }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center" style="border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                <div class="card-body">
                    <i class="fas fa-check-circle fs-2 text-success mb-2"></i>
                    <h5>Normal</h5>
                    <h3 class="text-success">{{ $monitoring->where('status', 'normal')->count() }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center" style="border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                <div class="card-body">
                    <i class="fas fa-exclamation-triangle fs-2 text-warning mb-2"></i>
                    <h5>Warning</h5>
                    <h3 class="text-warning">{{ $monitoring->where('status', 'warning')->count() }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center" style="border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                <div class="card-body">
                    <i class="fas fa-exclamation-circle fs-2 text-danger mb-2"></i>
                    <h5>Critical</h5>
                    <h3 class="text-danger">{{ $monitoring->where('status', 'critical')->count() }}</h3>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    function applyFilter() {
        const statusFilter = document.getElementById('filterStatus').value;
        const kelasFilter = document.getElementById('filterKelas').value;
        const rows = document.querySelectorAll('#monitoringTable tbody tr[data-status]');
        
        rows.forEach(row => {
            let showRow = true;
            
            if (statusFilter && row.getAttribute('data-status') !== statusFilter) {
                showRow = false;
            }
            
            if (kelasFilter && row.getAttribute('data-kelas') !== kelasFilter) {
                showRow = false;
            }
            
            row.style.display = showRow ? '' : 'none';
        });
    }
</script>
@endsection