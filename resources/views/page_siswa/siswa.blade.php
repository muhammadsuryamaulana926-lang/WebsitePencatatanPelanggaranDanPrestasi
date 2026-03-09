@extends('layouts.siswa')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard Siswa')

@section('content')
         
            
            <!-- 📋 Ringkasan Pribadi -->
            <div class="card mb-4" style="border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">📋 Ringkasan Pribadi</h5>
                </div>
                <div class="card-body">
                    <div class="row g-4">
                        <div class="col-md-4">
                            <div class="text-center">
                                <i class="fas fa-exclamation-triangle fs-2 text-danger mb-2"></i>
                                <h5>Total Poin Pelanggaran</h5>
                                <h3 class="text-danger">{{ $totalPoinPelanggaran ?? 0 }}</h3>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-center">
                                <i class="fas fa-trophy fs-2 text-warning mb-2"></i>
                                <h5>Total Poin Prestasi</h5>
                                <h3 class="text-warning">{{ $totalPoinPrestasi ?? 0 }}</h3>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-center">
                                <i class="fas fa-tasks fs-2 text-info mb-2"></i>
                                <h5>Status Sanksi Aktif</h5>
                                <h3 class="text-info">{{ $sanksiAktif ?? 0 }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 🕓 Riwayat Singkat -->
            <div class="card mb-4" style="border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">🕓 Riwayat Singkat</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Jenis</th>
                                    <th>Deskripsi</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($riwayatTerbaru ?? [] as $riwayat)
                                <tr>
                                    <td>{{ $riwayat['tanggal'] }}</td>
                                    <td>
                                        <span class="badge {{ $riwayat['badge_class'] }}">{{ $riwayat['jenis'] }}</span>
                                    </td>
                                    <td>{{ $riwayat['deskripsi'] }}</td>
                                    <td>
                                        <span class="badge bg-success">{{ $riwayat['status'] }}</span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">Belum ada riwayat</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- 🔔 Notifikasi -->
            <div class="card" style="border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                <div class="card-header bg-warning text-white">
                    <h5 class="mb-0">🔔 Notifikasi</h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-danger d-flex align-items-center" role="alert">
                        <i class="fas fa-exclamation-triangle fs-4 me-3"></i>
                        <div>
                            <strong>Kamu punya sanksi kebersihan yang belum diselesaikan.</strong><br>
                            <small class="text-muted">Segera selesaikan sanksi untuk menghindari penambahan poin pelanggaran</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection