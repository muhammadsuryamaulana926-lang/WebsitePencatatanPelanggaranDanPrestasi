@extends('layouts.kesiswaan')

@section('title', 'Riwayat Pelanggaran')
@section('page-title', 'Riwayat Pelanggaran Siswa')

@section('content')
    <!-- Filter Section -->
    <div class="card mb-4" style="border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
        <div class="card-header bg-warning text-dark">
            <h5 class="mb-0"><i class="fas fa-filter me-2"></i>Filter Riwayat Pelanggaran</h5>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ url()->current() }}">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">Kelas</label>
                        <select name="kelas" class="form-control">
                            <option value="">Semua Kelas</option>
                            @foreach($kelas as $k)
                            <option value="{{ $k->id }}" {{ request('kelas') == $k->id ? 'selected' : '' }}>
                                {{ $k->nama_kelas }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Tanggal Dari</label>
                        <input type="date" name="dari" class="form-control" value="{{ request('dari') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Tanggal Sampai</label>
                        <input type="date" name="sampai" class="form-control" value="{{ request('sampai') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Cari Siswa</label>
                        <input type="text" name="siswa" class="form-control" placeholder="Nama siswa..." value="{{ request('siswa') }}">
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search me-1"></i>Filter
                        </button>
                        <a href="{{ url()->current() }}" class="btn btn-secondary">
                            <i class="fas fa-refresh me-1"></i>Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Riwayat Pelanggaran -->
    <div class="card" style="border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
        <div class="card-header bg-danger text-white">
            <h5 class="mb-0"><i class="fas fa-history me-2"></i>Riwayat Pelanggaran Siswa</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Siswa</th>
                            <th>Kelas</th>
                            <th>Jenis Pelanggaran</th>
                            <th>Poin</th>
                            <th>Guru Pencatat</th>
                            <th>Sanksi</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $no = ($pelanggaran->currentPage() - 1) * $pelanggaran->perPage() + 1; @endphp
                        @forelse($pelanggaran as $p)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $p->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                <strong>{{ $p->siswa->nama_siswa ?? '-' }}</strong><br>
                                <small class="text-muted">{{ $p->siswa->nis ?? '-' }}</small>
                            </td>
                            <td>{{ $p->siswa->kelas->nama_kelas ?? '-' }}</td>
                            <td>
                                <span class="badge bg-warning text-dark">{{ $p->jenisPelanggaran->kategori ?? '-' }}</span><br>
                                <small>{{ $p->jenisPelanggaran->nama_pelanggaran ?? '-' }}</small>
                            </td>
                            <td>
                                <span class="badge bg-danger">{{ $p->poin }} Poin</span>
                            </td>
                            <td>{{ $p->guruPencatat->nama_guru ?? '-' }}</td>
                            <td>
                                @if($p->sanksi->count() > 0)
                                    @foreach($p->sanksi as $sanksi)
                                        <span class="badge bg-info mb-1">{{ $sanksi->jenis_sanksi }}</span><br>
                                    @endforeach
                                @else
                                    <span class="text-muted">Belum ada sanksi</span>
                                @endif
                            </td>
                            <td>{{ $p->keterangan ?? '-' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted py-4">
                                <i class="fas fa-inbox fa-3x mb-3 opacity-50"></i><br>
                                Tidak ada data riwayat pelanggaran
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            @if($pelanggaran->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $pelanggaran->appends(request()->query())->links() }}
            </div>
            @endif
        </div>
    </div>
@endsection