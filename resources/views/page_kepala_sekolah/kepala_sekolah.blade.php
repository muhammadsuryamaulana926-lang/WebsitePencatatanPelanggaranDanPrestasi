@extends('layouts.kepala_sekolah')

@section('title', 'Dashboard Kepala Sekolah')
@section('page-title', 'Dashboard Kepala Sekolah')

@section('content')
            <div class="text-center mb-4 p-4" style="background: white; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                <i class="fas fa-school fs-1 mb-3" style="color: #6f42c1;"></i>
                <h4 class="mb-2">Dashboard Kepala Sekolah</h4>
                <p class="text-muted">Tujuan: memantau disiplin dan prestasi sekolah secara keseluruhan</p>
            </div>
            
            <!-- 📈 Statistik Sekolah -->
            <div class="card mb-4" style="border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                <div class="card-header text-white" style="background-color: #6f42c1;">
                    <h5 class="mb-0">📈 Statistik Sekolah</h5>
                </div>
                <div class="card-body">
                    <div class="row g-4">
                        <div class="col-md-4">
                            <div class="text-center">
                                <i class="fas fa-exclamation-triangle fs-2 text-warning mb-2"></i>
                                <h5>Total Pelanggaran</h5>
                                <h3 class="text-warning">{{ $totalPelanggaran ?? 0 }}</h3>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-center">
                                <i class="fas fa-user-friends fs-2 text-info mb-2"></i>
                                <h5>Bimbingan Konseling</h5>
                                <h3 class="text-info">{{ $totalBimbingan ?? 0 }}</h3>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-center">
                                <i class="fas fa-trophy fs-2 text-success mb-2"></i>
                                <h5>Total Prestasi</h5>
                                <h3 class="text-success">{{ $totalPrestasi ?? 0 }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 🧩 Grafik & Analitik -->
            <div class="card mb-4" style="border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">🧩 Grafik & Analitik</h5>
                </div>
                <div class="card-body">
                    <div class="row g-4">
                        <div class="col-md-4">
                            <div style="height: 200px; display: flex; align-items: center; justify-content: center; background: #f8f9fa; border-radius: 10px;">
                                <div class="text-center text-muted">
                                    <i class="fas fa-chart-bar fs-1 mb-3"></i>
                                    <p>Tren Pelanggaran<br>per Kelas</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div style="height: 200px; display: flex; align-items: center; justify-content: center; background: #f8f9fa; border-radius: 10px;">
                                <div class="text-center text-muted">
                                    <i class="fas fa-chart-pie fs-1 mb-3"></i>
                                    <p>Efektivitas Sanksi<br>per Jenis</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div style="height: 200px; display: flex; align-items: center; justify-content: center; background: #f8f9fa; border-radius: 10px;">
                                <div class="text-center text-muted">
                                    <i class="fas fa-chart-line fs-1 mb-3"></i>
                                    <p>Distribusi Prestasi<br>Akademik vs Non-Akademik</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 📄 Laporan Cepat -->
            <div class="card mb-4" style="border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">📄 Laporan Cepat</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <button class="btn btn-outline-danger w-100 p-3">
                                <i class="fas fa-file-pdf fs-3 mb-2"></i><br>
                                <strong>Laporan Sanksi PDF</strong>
                            </button>
                        </div>
                        <div class="col-md-6">
                            <button class="btn btn-outline-success w-100 p-3">
                                <i class="fas fa-file-excel fs-3 mb-2"></i><br>
                                <strong>Analisis Tren Excel</strong>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ⚠️ Notifikasi -->
            <div class="card" style="border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                <div class="card-header bg-warning text-white">
                    <h5 class="mb-0">⚠️ Notifikasi</h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-danger d-flex align-items-center" role="alert">
                        <i class="fas fa-exclamation-triangle fs-4 me-3"></i>
                        <div>
                            <strong>Kasus berat kelas XI-IPA-1 butuh persetujuan kepala sekolah.</strong><br>
                            <small class="text-muted">Kasus pelanggaran berat memerlukan persetujuan dan tindak lanjut dari kepala sekolah</small>
                        </div>
                    </div>
                </div>
            </div>
@endsection