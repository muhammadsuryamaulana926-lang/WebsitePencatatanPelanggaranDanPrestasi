@extends('layouts.kesiswaan')

@section('title', 'View Data Sendiri')
@section('page-title', 'View Data Sendiri')

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="card" style="border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0"><i class="fas fa-exclamation-triangle me-2"></i>Data Pelanggaran</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead class="table-dark">
                                <tr>
                                    <th>No</th>
                                    <th>Siswa</th>
                                    <th>Jenis Pelanggaran</th>
                                    <th>Tanggal</th>
                                    <th>Poin</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pelanggaran as $index => $p)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $p->siswa->nama_siswa ?? '-' }}</td>
                                    <td>{{ $p->jenisPelanggaran->nama_pelanggaran ?? '-' }}</td>
                                    <td>{{ $p->tanggal_pelanggaran }}</td>
                                    <td><span class="badge bg-danger">{{ $p->jenisPelanggaran->poin ?? 0 }}</span></td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">Belum ada data pelanggaran</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card" style="border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="fas fa-trophy me-2"></i>Data Prestasi</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead class="table-dark">
                                <tr>
                                    <th>No</th>
                                    <th>Siswa</th>
                                    <th>Jenis Prestasi</th>
                                    <th>Tanggal</th>
                                    <th>Poin</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($prestasi as $index => $p)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $p->siswa->nama_siswa ?? '-' }}</td>
                                    <td>{{ $p->jenisPrestasi->nama_prestasi ?? '-' }}</td>
                                    <td>{{ $p->tanggal_prestasi }}</td>
                                    <td><span class="badge bg-success">{{ $p->jenisPrestasi->poin ?? 0 }}</span></td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">Belum ada data prestasi</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection