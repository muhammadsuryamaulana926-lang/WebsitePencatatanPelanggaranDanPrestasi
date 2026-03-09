@extends('layouts.walikelas')

@section('title', 'View Data Sendiri')
@section('page-title', 'Profil Wali Kelas')

@section('content')
    <!-- Profil Wali Kelas -->
    <div class="card mb-4" style="border: none; box-shadow: 0 8px 25px rgba(0,0,0,0.08); border-radius: 12px;">
        <div class="card-header text-white" style="background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%); border-radius: 12px 12px 0 0;">
            <div class="d-flex align-items-center">
                <div class="bg-white rounded-circle p-2 me-3">
                    <i class="fas fa-chalkboard-teacher" style="color: #2c3e50; font-size: 1.2rem;"></i>
                </div>
                <h5 class="mb-0 fw-bold">Profil Wali Kelas</h5>
            </div>
        </div>
        <div class="card-body p-4">
            @if($guru)
            <div class="row">
                <div class="col-lg-4 text-center mb-4">
                    <div class="avatar-circle mx-auto mb-3" style="width: 100px; height: 100px; background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-user text-white" style="font-size: 2.5rem;"></i>
                    </div>
                    <h4 class="fw-bold mb-1" style="color: #2c3e50;">{{ $guru->nama_guru }}</h4>
                    <span class="badge px-3 py-2 rounded-pill" style="background: #2c3e50; color: white;">{{ $guru->nip }}</span>
                </div>
                <div class="col-lg-8">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="info-item p-3 rounded" style="background: #2c3e50; color: white;">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-book me-3" style="font-size: 1.1rem;"></i>
                                    <div>
                                        <small class="opacity-75">Bidang Studi</small>
                                        <div class="fw-bold">{{ $guru->bidang_studi }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-item p-3 rounded" style="background: #34495e; color: white;">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-user-check me-3" style="font-size: 1.1rem;"></i>
                                    <div>
                                        <small class="opacity-75">Status</small>
                                        <div class="fw-bold">{{ ucfirst($guru->status) }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="info-item p-3 rounded" style="background: #f8f9fa; color: #2c3e50; border: 1px solid #e9ecef;">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-school me-3" style="color: #2c3e50;"></i>
                                    <div>
                                        <small class="text-muted">Kelas yang Diwali</small>
                                        <div class="fw-bold">
                                            @if($kelasWali->count() > 0)
                                                @foreach($kelasWali as $kelas)
                                                    <span class="badge bg-primary me-1">{{ $kelas->nama_kelas }}</span>
                                                @endforeach
                                            @else
                                                <span class="text-muted">Belum ada kelas yang diwali</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @else
            <div class="text-center text-muted">
                <i class="fas fa-user-times" style="font-size: 3rem; opacity: 0.3;"></i>
                <p class="mt-3">Data guru tidak ditemukan</p>
            </div>
            @endif
        </div>
    </div>

    <!-- Data Kelas Wali -->
    <div class="card mb-4" style="border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
        <div class="card-header bg-info text-white">
            <h5 class="mb-0"><i class="fas fa-school me-2"></i>Kelas yang Saya Wali</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Nama Kelas</th>
                            <th>Jurusan</th>
                            <th>Jumlah Siswa</th>
                            <th>Total Pelanggaran</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $no = 1; @endphp
                        @forelse($kelasWali as $kelas)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $kelas->nama_kelas }}</td>
                            <td>{{ $kelas->jurusan }}</td>
                            <td><span class="badge bg-primary">{{ $kelas->siswa->count() }} Siswa</span></td>
                            <td><span class="badge bg-danger">{{ $kelas->siswa->sum(function($s) { return $s->pelanggaran->count(); }) }} Pelanggaran</span></td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">Anda belum menjadi wali kelas</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Data Pelanggaran -->
    <div class="card mb-4" style="border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
        <div class="card-header bg-danger text-white">
            <h5 class="mb-0"><i class="fas fa-exclamation-triangle me-2"></i>Data Pelanggaran Kelas Wali</h5>
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

<style>
.info-item {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.info-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

.avatar-circle {
    transition: transform 0.3s ease;
}

.avatar-circle:hover {
    transform: scale(1.05);
}

.card {
    transition: transform 0.2s ease;
}

.card:hover {
    transform: translateY(-3px);
}
</style>
@endsection