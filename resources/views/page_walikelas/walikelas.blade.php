@extends('layouts.walikelas')

@section('title', 'Dashboard Wali Kelas')
@section('page-title', 'Dashboard Wali Kelas')

@section('content')
            <div class="text-center mb-4 p-4" style="background: white; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                <i class="fas fa-chalkboard-teacher fs-1 mb-3" style="color: #6f42c1;"></i>
                <h4 class="mb-2">Dashboard Wali Kelas</h4>
                <p class="text-muted">Tujuan: memantau kondisi siswa di kelas binaannya</p>
            </div>
            
            <!-- 🧮 Statistik Kelas -->
            <div class="card mb-4" style="border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                <div class="card-header text-white" style="background-color: #6f42c1;">
                    <h5 class="mb-0">🧮 Statistik Kelas</h5>
                </div>
                <div class="card-body">
                    <div class="row g-4">
                        <div class="col-md-4">
                            <div class="text-center">
                                <i class="fas fa-users fs-2 text-primary mb-2"></i>
                                <h5>Total Siswa</h5>
                                <h3 class="text-primary">{{ $totalSiswa }}</h3>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-center">
                                <i class="fas fa-exclamation-triangle fs-2 text-danger mb-2"></i>
                                <h5>Pelanggaran Aktif</h5>
                                <h3 class="text-danger">{{ $totalPelanggaran }}</h3>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-center">
                                <i class="fas fa-trophy fs-2 text-success mb-2"></i>
                                <h5>Prestasi Bulan Ini</h5>
                                <h3 class="text-success">{{ $totalPrestasi }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 📈 Grafik -->
            <div class="card mb-4" style="border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">📈 Grafik</h5>
                </div>
                <div class="card-body">
                    <div style="height: 300px; display: flex; align-items: center; justify-content: center; background: #f8f9fa; border-radius: 10px;">
                        <div class="text-center text-muted">
                            <i class="fas fa-chart-line fs-1 mb-3"></i>
                            <p>Tren pelanggaran kelasnya<br>(bulan ke bulan)</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 🧾 Daftar Kasus Kelas -->
            <div class="card mb-4" style="border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                <div class="card-header bg-warning text-white">
                    <h5 class="mb-0">🧾 Daftar Kasus Kelas</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Siswa</th>
                                    <th>Jenis Pelanggaran</th>
                                    <th>Status</th>
                                    <th>Sanksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($kelasWali as $kelas)
                                    @foreach($kelas->siswa as $siswa)
                                        @foreach($siswa->pelanggaran->take(5) as $p)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar bg-primary text-white rounded-circle me-2 d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;">
                                                        {{ substr($siswa->nama_siswa, 0, 1) }}
                                                    </div>
                                                    <strong>{{ $siswa->nama_siswa }}</strong>
                                                </div>
                                            </td>
                                            <td>{{ $p->jenisPelanggaran->nama_pelanggaran ?? '-' }}</td>
                                            <td>
                                                <span class="badge bg-danger">Aktif</span>
                                            </td>
                                            <td>{{ $p->keterangan ?? 'Teguran' }}</td>
                                        </tr>
                                        @endforeach
                                    @endforeach
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">Belum ada data pelanggaran</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- ⚠️ Alert -->
            <div class="card" style="border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0">⚠️ Alert</h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-warning d-flex align-items-center" role="alert">
                        <i class="fas fa-exclamation-triangle fs-4 me-3"></i>
                        <div>
                            <strong>Siswa Arif belum menyelesaikan sanksi kebersihan.</strong><br>
                            <small class="text-muted">Perlu tindak lanjut untuk memastikan sanksi diselesaikan</small>
                        </div>
                    </div>
                </div>
            </div>
@endsection