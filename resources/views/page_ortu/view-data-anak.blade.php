@extends('layouts.ortu')

@section('title', 'View Data Anak')
@section('page-title', 'View Data Anak')

@section('content')
    <!-- Info Anak -->
    <div class="card mb-4" style="border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="fas fa-child me-2"></i>Informasi Anak</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>NIS:</strong> {{ $orangtua->siswa->nis }}</p>
                    <p><strong>Nama:</strong> {{ $orangtua->siswa->nama_siswa }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Kelas:</strong> {{ $orangtua->siswa->kelas->nama_kelas ?? '-' }}</p>
                    <p><strong>Jenis Kelamin:</strong> {{ $orangtua->siswa->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Pelanggaran -->
    <div class="card mb-4" style="border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
        <div class="card-header bg-danger text-white">
            <h5 class="mb-0"><i class="fas fa-exclamation-triangle me-2"></i>Data Pelanggaran Anak</h5>
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
                        <tfoot>
                            <tr class="table-warning">
                                <th colspan="3">Total Poin Pelanggaran</th>
                                <th><span class="badge bg-danger">{{ $pelanggaran->sum('poin') }}</span></th>
                                <th colspan="2"></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            @else
                <div class="alert alert-success">
                    <i class="fas fa-check-circle me-2"></i>Anak Anda tidak memiliki catatan pelanggaran
                </div>
            @endif
        </div>
    </div>

    <!-- Data Prestasi -->
    <div class="card" style="border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
        <div class="card-header bg-success text-white">
            <h5 class="mb-0"><i class="fas fa-trophy me-2"></i>Data Prestasi Anak</h5>
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
                        <tfoot>
                            <tr class="table-info">
                                <th colspan="3">Total Poin Prestasi</th>
                                <th><span class="badge bg-success">{{ $prestasi->sum('poin') }}</span></th>
                                <th colspan="2"></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            @else
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>Anak Anda belum memiliki catatan prestasi
                </div>
            @endif
        </div>
    </div>
@endsection