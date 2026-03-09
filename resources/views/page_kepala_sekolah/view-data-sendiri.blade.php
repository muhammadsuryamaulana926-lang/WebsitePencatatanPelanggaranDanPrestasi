@extends('layouts.kepala_sekolah')

@section('title', 'View Data Sendiri')
@section('page-title', 'View Data Sendiri')

@section('content')
    <!-- Profil Kepala Sekolah -->
    @if($guru)
    <div class="card mb-4" style="border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="fas fa-user-tie me-2"></i>Profil Kepala Sekolah</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-2 text-center">
                    <i class="fas fa-user-circle fa-5x text-primary"></i>
                </div>
                <div class="col-md-10">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td width="120"><strong>NIP</strong></td>
                                    <td>: {{ $guru->nip }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Nama</strong></td>
                                    <td>: {{ $guru->nama_guru }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Jabatan</strong></td>
                                    <td>: Kepala Sekolah</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td width="120"><strong>Bidang Studi</strong></td>
                                    <td>: {{ $guru->bidang_studi }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Status</strong></td>
                                    <td>: <span class="badge bg-success">{{ ucfirst($guru->status) }}</span></td>
                                </tr>
                                <tr>
                                    <td><strong>Bergabung</strong></td>
                                    <td>: {{ $guru->created_at->format('d F Y') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Data Pelanggaran -->
    <div class="card mb-4" style="border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
        <div class="card-header bg-danger text-white">
            <h5 class="mb-0"><i class="fas fa-exclamation-triangle me-2"></i>Data Pelanggaran Sekolah</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
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
                        @php $no = 1; @endphp
                        @forelse($pelanggaran as $p)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $p->siswa->nama_siswa ?? '-' }}</td>
                            <td>{{ $p->siswa->kelas->nama_kelas ?? '-' }}</td>
                            <td>{{ $p->jenisPelanggaran->nama_pelanggaran ?? '-' }}</td>
                            <td>{{ $p->guruPencatat->nama_guru ?? '-' }}</td>
                            <td><span class="badge bg-danger">{{ $p->poin }} Poin</span></td>
                            <td>{{ $p->keterangan ?? '-' }}</td>
                            <td>{{ $p->created_at->format('d/m/Y H:i') }}</td>
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

    <!-- Data Prestasi -->
    <div class="card mb-4" style="border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
        <div class="card-header bg-success text-white">
            <h5 class="mb-0"><i class="fas fa-trophy me-2"></i>Data Prestasi Sekolah</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Nama Siswa</th>
                            <th>Kelas</th>
                            <th>Jenis Prestasi</th>
                            <th>Guru Pencatat</th>
                            <th>Poin</th>
                            <th>Keterangan</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $no = 1; @endphp
                        @forelse($prestasi as $p)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $p->siswa->nama_siswa ?? '-' }}</td>
                            <td>{{ $p->siswa->kelas->nama_kelas ?? '-' }}</td>
                            <td>{{ $p->jenisPrestasi->nama_prestasi ?? '-' }}</td>
                            <td>{{ $p->guruPencatat->nama_guru ?? '-' }}</td>
                            <td><span class="badge bg-success">{{ $p->poin }} Poin</span></td>
                            <td>{{ $p->keterangan ?? '-' }}</td>
                            <td>{{ $p->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted">Belum ada data prestasi</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Data Bimbingan Konseling -->
    <div class="card mb-4" style="border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
        <div class="card-header bg-info text-white">
            <h5 class="mb-0"><i class="fas fa-user-friends me-2"></i>Data Bimbingan Konseling</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Nama Siswa</th>
                            <th>Kelas</th>
                            <th>Topik</th>
                            <th>Status</th>
                            <th>Konselor</th>
                            <th>Tindakan</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $no = 1; @endphp
                        @forelse($bimbinganKonseling as $bk)
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
                            <td>{{ $bk->konselor->nama_guru ?? '-' }}</td>
                            <td>{{ $bk->tindakan_solusi ?? '-' }}</td>
                            <td>{{ $bk->created_at->format('d/m/Y H:i') }}</td>
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