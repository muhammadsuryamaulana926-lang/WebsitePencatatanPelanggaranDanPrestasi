@extends('layouts.siswa')

@section('title', 'View Data Sendiri')
@section('page-title', 'View Data Sendiri')

@section('content')
    <!-- Info Siswa -->
    <div class="card mb-4" style="border: none; box-shadow: 0 8px 25px rgba(0,0,0,0.15); border-radius: 15px;">
        <div class="card-header text-white" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 15px 15px 0 0;">
            <h5 class="mb-0"><i class="fas fa-user-graduate me-2"></i>Profil Siswa</h5>
        </div>
        <div class="card-body" style="padding: 2rem;">
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="d-flex align-items-center mb-3">
                        <div class="icon-box me-3" style="width: 50px; height: 50px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-id-card text-white"></i>
                        </div>
                        <div>
                            <small class="text-muted d-block">Nomor Induk Siswa</small>
                            <h6 class="mb-0 fw-bold">{{ $siswa->nis }}</h6>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mb-3">
                        <div class="icon-box me-3" style="width: 50px; height: 50px; background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-user text-white"></i>
                        </div>
                        <div>
                            <small class="text-muted d-block">Nama Lengkap</small>
                            <h6 class="mb-0 fw-bold">{{ $siswa->nama_siswa }}</h6>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="d-flex align-items-center mb-3">
                        <div class="icon-box me-3" style="width: 50px; height: 50px; background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-school text-white"></i>
                        </div>
                        <div>
                            <small class="text-muted d-block">Kelas</small>
                            <h6 class="mb-0 fw-bold">{{ $siswa->kelas->nama_kelas ?? '-' }}</h6>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mb-3">
                        <div class="icon-box me-3" style="width: 50px; height: 50px; background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-{{ $siswa->jenis_kelamin == 'L' ? 'mars' : 'venus' }} text-white"></i>
                        </div>
                        <div>
                            <small class="text-muted d-block">Jenis Kelamin</small>
                            <h6 class="mb-0 fw-bold">{{ $siswa->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</h6>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Data Orang Tua -->
            @if($siswa->orangtua && $siswa->orangtua->count() > 0)
            <div class="row mt-4">
                <div class="col-12">
                    <h6 class="text-muted mb-3"><i class="fas fa-users me-2"></i>Data Orang Tua</h6>
                    <div class="row">
                        @foreach($siswa->orangtua as $ortu)
                        <div class="col-md-6 mb-3">
                            <div class="d-flex align-items-center">
                                <div class="icon-box me-3" style="width: 40px; height: 40px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-{{ $ortu->hubungan == 'ayah' ? 'male' : ($ortu->hubungan == 'ibu' ? 'female' : 'user') }} text-white"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">{{ ucfirst($ortu->hubungan) }}</small>
                                    <h6 class="mb-0 fw-bold">{{ $ortu->nama_orangtua }}</h6>
                                    @if($ortu->no_telp)
                                        <small class="text-muted">{{ $ortu->no_telp }}</small>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Data Pelanggaran -->
    <div class="card mb-4" style="border: none; box-shadow: 0 8px 25px rgba(0,0,0,0.15); border-radius: 15px;">
        <div class="card-header text-white" style="background: linear-gradient(135deg, #ff6b6b 0%, #ee5a24 100%); border-radius: 15px 15px 0 0;">
            <h5 class="mb-0"><i class="fas fa-exclamation-triangle me-2"></i>Riwayat Pelanggaran</h5>
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
                <div class="text-center py-5">
                    <div class="mb-3">
                        <i class="fas fa-check-circle" style="font-size: 4rem; color: #26de81;"></i>
                    </div>
                    <h5 class="text-muted">Selamat! Tidak ada catatan pelanggaran</h5>
                    <p class="text-muted">Pertahankan perilaku baik Anda</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Data Prestasi -->
    <div class="card" style="border: none; box-shadow: 0 8px 25px rgba(0,0,0,0.15); border-radius: 15px;">
        <div class="card-header text-white" style="background: linear-gradient(135deg, #26de81 0%, #20bf6b 100%); border-radius: 15px 15px 0 0;">
            <h5 class="mb-0"><i class="fas fa-trophy me-2"></i>Prestasi & Penghargaan</h5>
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
                <div class="text-center py-5">
                    <div class="mb-3">
                        <i class="fas fa-star" style="font-size: 4rem; color: #feca57;"></i>
                    </div>
                    <h5 class="text-muted">Belum ada prestasi tercatat</h5>
                    <p class="text-muted">Terus berprestasi dan raih pencapaian terbaik!</p>
                </div>
            @endif
        </div>
    </div>
@endsection