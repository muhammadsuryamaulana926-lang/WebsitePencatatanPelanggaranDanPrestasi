@extends('layouts.guru')

@section('title', 'View Data Sendiri')
@section('page-title', 'View Data Sendiri')

@section('content')
    <!-- Data Pelanggaran -->
    <div class="card" style="border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
        <div class="card-header bg-danger text-white">
            <div class="row align-items-center">
                <div class="col-md-4">
                    <h5 class="mb-0"><i class="fas fa-exclamation-triangle me-2"></i>Data Pelanggaran Saya</h5>
                </div>
                <div class="col-md-3">
                    <select id="filterGuru" class="form-select form-select-sm">
                        <option value="">Semua Guru</option>
                        @foreach($guru as $g)
                        <option value="{{ $g->nama_guru }}">{{ $g->nama_guru }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="text" id="searchSiswa" class="form-control form-control-sm" placeholder="Cari nama siswa...">
                </div>
                <div class="col-md-2">
                    <button id="resetFilter" class="btn btn-light btn-sm">
                        <i class="fas fa-undo"></i>
                    </button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="pelanggaranTable" class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Nama Siswa</th>
                            <th>Kelas</th>
                            <th>Jenis Pelanggaran</th>
                            <th>Guru Pencatat</th>
                            <th>Poin</th>
                            <th>Keterangan</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pelanggaran as $index => $p)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <strong>{{ $p->siswa->nama_siswa ?? '-' }}</strong>
                                <br><small class="text-muted">{{ $p->siswa->nis ?? '' }}</small>
                            </td>
                            <td><span class="badge bg-info">{{ $p->siswa->kelas->nama_kelas ?? '-' }}</span></td>
                            <td>{{ $p->jenisPelanggaran->nama_pelanggaran ?? '-' }}</td>
                            <td><span class="badge bg-success">{{ $p->guruPencatat->nama_guru ?? '-' }}</span></td>
                            <td><span class="badge bg-danger">{{ $p->poin }} Poin</span></td>
                            <td>{{ $p->keterangan ?? '-' }}</td>
                            <td>{{ $p->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted">
                                <i class="fas fa-inbox fa-2x mb-2"></i><br>
                                Belum ada data pelanggaran
                            </td>
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
document.addEventListener('DOMContentLoaded', function() {
    const table = document.getElementById('pelanggaranTable');
    const filterGuru = document.getElementById('filterGuru');
    const searchSiswa = document.getElementById('searchSiswa');
    const resetFilter = document.getElementById('resetFilter');
    const tbody = table.querySelector('tbody');
    const rows = Array.from(tbody.querySelectorAll('tr'));
    
    function updateRowNumbers() {
        const visibleRows = tbody.querySelectorAll('tr:not([style*="display: none"])');
        visibleRows.forEach((row, index) => {
            const firstCell = row.querySelector('td:first-child');
            if (firstCell && !firstCell.querySelector('.fa-inbox')) {
                firstCell.textContent = index + 1;
            }
        });
    }
    
    function filterTable() {
        const guruFilter = filterGuru.value.toLowerCase();
        const siswaSearch = searchSiswa.value.toLowerCase();
        
        let visibleCount = 0;
        
        rows.forEach(row => {
            if (row.querySelector('.fa-inbox')) return; // Skip empty row
            
            const cells = row.querySelectorAll('td');
            const siswa = cells[1]?.textContent.toLowerCase() || '';
            const guru = cells[4]?.textContent.toLowerCase() || '';
            
            const matchGuru = !guruFilter || guru.includes(guruFilter);
            const matchSiswa = !siswaSearch || siswa.includes(siswaSearch);
            
            if (matchGuru && matchSiswa) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });
        
        updateRowNumbers();
    }
    
    // Event listeners
    filterGuru.addEventListener('change', filterTable);
    searchSiswa.addEventListener('input', filterTable);
    
    resetFilter.addEventListener('click', function() {
        filterGuru.value = '';
        searchSiswa.value = '';
        filterTable();
    });
    
    // Initial count
    filterTable();
});
</script>
@endsection