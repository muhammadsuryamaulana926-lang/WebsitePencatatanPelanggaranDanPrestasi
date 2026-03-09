@extends('layouts.kepala_sekolah')

@section('title', 'View Data Anak')
@section('page-title', 'View Data Siswa')

@section('content')
    <!-- Filter Kelas -->
    <div class="card mb-4" style="border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="fas fa-filter me-2"></i>Filter Data Siswa</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <select class="form-control" id="filterKelas" onchange="filterByKelas()">
                        <option value="">Semua Kelas</option>
                        @foreach($kelas as $k)
                        <option value="{{ $k->id }}">{{ $k->nama_kelas }} ({{ $k->siswa->count() }} siswa)</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <input type="text" class="form-control" id="searchSiswa" placeholder="Cari nama siswa..." onkeyup="searchSiswa()">
                </div>
            </div>
        </div>
    </div>

    <!-- Data Siswa -->
    <div class="card" style="border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
        <div class="card-header bg-info text-white">
            <h5 class="mb-0"><i class="fas fa-users me-2"></i>Data Semua Siswa</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped" id="siswaTable">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>NIS</th>
                            <th>Nama Siswa</th>
                            <th>Kelas</th>
                            <th>Total Pelanggaran</th>
                            <th>Total Prestasi</th>
                            <th>Status</th>
                            <th>Detail</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $no = 1; @endphp
                        @forelse($siswa as $s)
                        @php
                            $totalPoinPelanggaran = $s->pelanggaran->sum('poin');
                            $totalPoinPrestasi = $s->prestasi->sum('poin');
                            $status = 'normal';
                            if ($totalPoinPelanggaran >= 100) $status = 'critical';
                            elseif ($totalPoinPelanggaran >= 50) $status = 'warning';
                        @endphp
                        <tr data-kelas="{{ $s->kelas->id ?? '' }}" data-nama="{{ strtolower($s->nama_siswa) }}">
                            <td>{{ $no++ }}</td>
                            <td>{{ $s->nis }}</td>
                            <td>{{ $s->nama_siswa }}</td>
                            <td>{{ $s->kelas->nama_kelas ?? '-' }}</td>
                            <td>
                                <span class="badge bg-danger">{{ $s->pelanggaran->count() }} ({{ $totalPoinPelanggaran }} poin)</span>
                            </td>
                            <td>
                                <span class="badge bg-success">{{ $s->prestasi->count() }} ({{ $totalPoinPrestasi }} poin)</span>
                            </td>
                            <td>
                                <span class="badge 
                                    @if($status == 'normal') bg-success
                                    @elseif($status == 'warning') bg-warning
                                    @else bg-danger
                                    @endif">
                                    {{ ucfirst($status) }}
                                </span>
                            </td>
                            <td>
                                <button class="btn btn-info btn-sm" onclick="showDetail({{ $s->id }}, '{{ $s->nama_siswa }}')" data-bs-toggle="modal" data-bs-target="#modalDetail">
                                    <i class="fas fa-eye"></i> Detail
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted">Tidak ada data siswa</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Detail -->
    <div class="modal fade" id="modalDetail" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Detail Siswa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="modalBody">
                    <!-- Detail akan dimuat di sini -->
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    function filterByKelas() {
        const kelasFilter = document.getElementById('filterKelas').value;
        const rows = document.querySelectorAll('#siswaTable tbody tr[data-kelas]');
        
        rows.forEach(row => {
            if (!kelasFilter || row.getAttribute('data-kelas') === kelasFilter) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }
    
    function searchSiswa() {
        const searchTerm = document.getElementById('searchSiswa').value.toLowerCase();
        const rows = document.querySelectorAll('#siswaTable tbody tr[data-nama]');
        
        rows.forEach(row => {
            const nama = row.getAttribute('data-nama');
            if (nama.includes(searchTerm)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }
    
    function showDetail(siswaId, namaSiswa) {
        document.getElementById('modalTitle').textContent = 'Detail ' + namaSiswa;
        document.getElementById('modalBody').innerHTML = '<div class="text-center"><i class="fas fa-spinner fa-spin"></i> Loading...</div>';
        
        fetch(`/test-detail-siswa/${siswaId}`)
            .then(response => {
                console.log('Response status:', response.status);
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                console.log('Data received:', data);
                
                if (data.error) {
                    document.getElementById('modalBody').innerHTML = `
                        <div class="alert alert-danger">
                            <strong>Error:</strong> ${data.error}
                        </div>
                    `;
                    return;
                }
                
                const siswa = data.siswa;
                const bimbinganKonseling = data.bimbingan_konseling;
                
                let html = `
                    <div class="row">
                        <div class="col-md-6">
                            <h6><strong>Informasi Siswa</strong></h6>
                            <table class="table table-sm">
                                <tr><td><strong>NIS:</strong></td><td>${siswa.nis}</td></tr>
                                <tr><td><strong>Nama:</strong></td><td>${siswa.nama_siswa}</td></tr>
                                <tr><td><strong>Kelas:</strong></td><td>${siswa.kelas ? siswa.kelas.nama_kelas : '-'}</td></tr>
                                <tr><td><strong>Jenis Kelamin:</strong></td><td>${siswa.jenis_kelamin}</td></tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h6><strong>Ringkasan</strong></h6>
                            <table class="table table-sm">
                                <tr><td><strong>Total Pelanggaran:</strong></td><td><span class="badge bg-danger">${siswa.pelanggaran.length} (${siswa.pelanggaran.reduce((sum, p) => sum + p.poin, 0)} poin)</span></td></tr>
                                <tr><td><strong>Total Prestasi:</strong></td><td><span class="badge bg-success">${siswa.prestasi.length} (${siswa.prestasi.reduce((sum, p) => sum + p.poin, 0)} poin)</span></td></tr>
                                <tr><td><strong>Bimbingan Konseling:</strong></td><td><span class="badge bg-info">${bimbinganKonseling.length} kali</span></td></tr>
                            </table>
                        </div>
                    </div>
                    
                    <hr>
                    
                    <div class="alert alert-success">
                        <strong>Data berhasil dimuat!</strong> Siswa memiliki ${siswa.pelanggaran.length} pelanggaran dan ${siswa.prestasi.length} prestasi.
                    </div>
                `;
                
                document.getElementById('modalBody').innerHTML = html;
            })
            .catch(error => {
                console.error('Fetch error:', error);
                document.getElementById('modalBody').innerHTML = `
                    <div class="alert alert-danger">
                        <strong>Error:</strong> ${error.message}<br>
                        <small>Periksa console browser untuk detail error.</small>
                    </div>
                `;
            });
    }
</script>
@endsection