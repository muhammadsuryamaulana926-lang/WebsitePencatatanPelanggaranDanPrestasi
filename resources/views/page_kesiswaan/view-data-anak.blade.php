@extends('layouts.kesiswaan')

@section('title', 'View Data Anak')
@section('page-title', 'View Data Anak')

@section('content')
    <div class="card" style="border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="fas fa-users me-2"></i>Data Siswa dan Rekam Jejak</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>NIS</th>
                            <th>Nama Siswa</th>
                            <th>Kelas</th>
                            <th>Total Pelanggaran</th>
                            <th>Total Prestasi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($siswa as $index => $s)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $s->nis }}</td>
                            <td>{{ $s->nama_siswa }}</td>
                            <td>{{ $s->kelas->nama_kelas ?? '-' }}</td>
                            <td>
                                <span class="badge bg-danger">
                                    {{ $s->pelanggaran->count() }} Pelanggaran
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-success">
                                    {{ $s->prestasi->count() }} Prestasi
                                </span>
                            </td>
                            <td>
                                <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#modalDetail{{ $s->id }}">
                                    <i class="fas fa-eye"></i> Detail
                                </button>
                            </td>
                        </tr>
                        
                        <!-- Modal Detail -->
                        <div class="modal fade" id="modalDetail{{ $s->id }}" tabindex="-1">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Detail {{ $s->nama_siswa }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h6>Pelanggaran:</h6>
                                                @forelse($s->pelanggaran as $p)
                                                <div class="alert alert-danger">
                                                    <strong>{{ $p->jenisPelanggaran->nama_pelanggaran ?? '-' }}</strong><br>
                                                    <small>{{ $p->tanggal_pelanggaran }} - {{ $p->jenisPelanggaran->poin ?? 0 }} Poin</small>
                                                </div>
                                                @empty
                                                <p class="text-muted">Tidak ada pelanggaran</p>
                                                @endforelse
                                            </div>
                                            <div class="col-md-6">
                                                <h6>Prestasi:</h6>
                                                @forelse($s->prestasi as $p)
                                                <div class="alert alert-success">
                                                    <strong>{{ $p->jenisPrestasi->nama_prestasi ?? '-' }}</strong><br>
                                                    <small>{{ $p->tanggal_prestasi }} - {{ $p->jenisPrestasi->poin ?? 0 }} Poin</small>
                                                </div>
                                                @empty
                                                <p class="text-muted">Tidak ada prestasi</p>
                                                @endforelse
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection