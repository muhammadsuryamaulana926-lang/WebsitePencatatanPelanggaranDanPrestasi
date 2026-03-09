@extends('layouts.bk')

@section('title', 'View Data Sendiri')
@section('page-title', 'View Data Sendiri')

@section('content')
    <!-- Data Bimbingan Konseling -->
    <div class="card mb-4" style="border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
        <div class="card-header bg-info text-white">
            <h5 class="mb-0"><i class="fas fa-user-friends me-2"></i>Data Bimbingan Konseling Saya</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Nama Siswa</th>
                            <th>Kelas</th>
                            <th>Topik Bimbingan</th>
                            <th>Status Kasus</th>
                            <th>Tindakan</th>
                            <th>Konselor</th>
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
                            <td>{{ $bk->tindakan_solusi ?? '-' }}</td>
                            <td>{{ $bk->konselor->nama_guru ?? '-' }}</td>
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

    <!-- Statistik -->
    <div class="row">
        <div class="col-md-4">
            <div class="card text-center" style="border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                <div class="card-body">
                    <i class="fas fa-users fs-2 text-primary mb-2"></i>
                    <h5>Total Siswa Binaan</h5>
                    <h3 class="text-primary">{{ $bimbinganKonseling->count() }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center" style="border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                <div class="card-body">
                    <i class="fas fa-clock fs-2 text-warning mb-2"></i>
                    <h5>Berlangsung</h5>
                    <h3 class="text-warning">{{ $bimbinganKonseling->where('status', 'berlangsung')->count() }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center" style="border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                <div class="card-body">
                    <i class="fas fa-check-circle fs-2 text-success mb-2"></i>
                    <h5>Selesai</h5>
                    <h3 class="text-success">{{ $bimbinganKonseling->where('status', 'selesai')->count() }}</h3>
                </div>
            </div>
        </div>
    </div>
@endsection