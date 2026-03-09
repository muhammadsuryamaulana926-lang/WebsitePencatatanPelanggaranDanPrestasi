@extends('layouts.bk')

@section('title', 'Dashboard BK')
@section('page-title', 'Dashboard Konselor BK')

@section('content')
            <div class="text-center mb-4 p-4" style="background: white; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                <i class="fas fa-user-friends fs-1 text-info mb-3"></i>
                <h4 class="mb-2">Dashboard Konselor BK</h4>
                <p class="text-muted">Tujuan: melakukan bimbingan dan memantau siswa bermasalah</p>
            </div>
            
            <!-- 📊 Ringkasan -->
            <div class="card mb-4" style="border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">📊 Ringkasan</h5>
                </div>
                <div class="card-body">
                    <div class="row g-4">
                        <div class="col-md-4">
                            <div class="text-center">
                                <i class="fas fa-users fs-2 text-primary mb-2"></i>
                                <h5>Total Siswa Binaan</h5>
                                <h3 class="text-primary">{{ $totalSiswaBinaan ?? 0 }}</h3>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-center">
                                <i class="fas fa-calendar-check fs-2 text-success mb-2"></i>
                                <h5>Sesi Konseling Minggu Ini</h5>
                                <h3 class="text-success">{{ $sesiMingguIni ?? 0 }}</h3>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-center">
                                <i class="fas fa-exclamation-circle fs-2 text-danger mb-2"></i>
                                <h5>Kasus Berat Aktif</h5>
                                <h3 class="text-danger">{{ $kasusBerat ?? 0 }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 📅 Agenda Konseling -->
            <div class="card mb-4" style="border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                <div class="card-header bg-warning text-white">
                    <h5 class="mb-0">📅 Agenda Konseling</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Nama Siswa</th>
                                    <th>Jenis Kasus</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>12/11</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar bg-primary text-white rounded-circle me-2 d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;">
                                                R
                                            </div>
                                            <strong>Rina</strong>
                                        </div>
                                    </td>
                                    <td>Kasus berat</td>
                                    <td>
                                        <span class="badge bg-warning">Jadwal</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- 🧾 Evaluasi Perilaku -->
            <div class="card mb-4" style="border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">🧾 Evaluasi Perilaku</h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-success d-flex align-items-center" role="alert">
                        <i class="fas fa-chart-line fs-4 me-3"></i>
                        <div>
                            <strong>5 siswa menunjukkan perbaikan positif.</strong><br>
                            <small class="text-muted">Hasil evaluasi perilaku siswa binaan menunjukkan tren positif</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 🔔 Notifikasi -->
            <div class="card" style="border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0">🔔 Notifikasi</h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-warning d-flex align-items-center" role="alert">
                        <i class="fas fa-bell fs-4 me-3"></i>
                        <div>
                            <strong>Follow-up sanksi untuk siswa X belum diupdate.</strong><br>
                            <small class="text-muted">Perlu tindak lanjut untuk memperbarui status sanksi siswa</small>
                        </div>
                    </div>
                </div>
            </div>
@endsection