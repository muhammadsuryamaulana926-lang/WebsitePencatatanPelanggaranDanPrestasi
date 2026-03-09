@extends('layouts.ortu')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard Orang Tua')

@section('content')
            <div class="text-center mb-4 p-4" style="background: white; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                <i class="fas fa-heart fs-1 text-warning mb-3"></i>
                <h4 class="mb-2">Dashboard Orang Tua</h4>
                <p class="text-muted">Tujuan: memantau perkembangan anak dan status sanksi/prestasi</p>
            </div>
            
            <!-- 🧒 Profil Anak -->
            <div class="card mb-4" style="border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                <div class="card-header bg-warning text-white">
                    <h5 class="mb-0">🧒 Profil Anak</h5>
                </div>
                <div class="card-body">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="d-flex align-items-center">
                                <div class="avatar bg-primary text-white rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; font-size: 24px;">
                                    {{ substr($orangtua->siswa->nama_siswa, 0, 1) }}
                                </div>
                                <div>
                                    <h5 class="mb-1">Nama: {{ $orangtua->siswa->nama_siswa }}</h5>
                                    <p class="mb-0 text-muted">Kelas: {{ $orangtua->siswa->kelas->nama_kelas ?? '-' }}</p>
                                    <p class="mb-0 text-muted">NIS: {{ $orangtua->siswa->nis }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 📈 Ringkasan Anak -->
            <div class="card mb-4" style="border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">📈 Ringkasan Anak</h5>
                </div>
                <div class="card-body">
                    <div class="row g-4">
                        <div class="col-md-4">
                            <div class="text-center">
                                <i class="fas fa-exclamation-triangle fs-2 text-danger mb-2"></i>
                                <h5>Total Pelanggaran</h5>
                                <h3 class="text-danger">{{ $pelanggaran->count() }}</h3>
                                <p class="text-muted">{{ $pelanggaran->sum('poin') }} Poin</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-center">
                                <i class="fas fa-trophy fs-2 text-success mb-2"></i>
                                <h5>Total Prestasi</h5>
                                <h3 class="text-success">{{ $prestasi->count() }}</h3>
                                <p class="text-muted">{{ $prestasi->sum('poin') }} Poin</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-center">
                                @php
                                    $totalPoinPelanggaran = $pelanggaran->sum('poin');
                                    $status = 'Normal';
                                    $statusClass = 'text-success';
                                    if ($totalPoinPelanggaran >= 100) {
                                        $status = 'Critical';
                                        $statusClass = 'text-danger';
                                    } elseif ($totalPoinPelanggaran >= 50) {
                                        $status = 'Warning';
                                        $statusClass = 'text-warning';
                                    }
                                @endphp
                                <i class="fas fa-heart-pulse fs-2 {{ str_replace('text-', '', $statusClass) }} mb-2"></i>
                                <h5>Status Anak</h5>
                                <h3 class="{{ $statusClass }}">{{ $status }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 📊 Grafik -->
            <div class="card mb-4" style="border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">📊 Grafik</h5>
                </div>
                <div class="card-body">
                    <div style="height: 300px; display: flex; align-items: center; justify-content: center; background: #f8f9fa; border-radius: 10px;">
                        <div class="text-center text-muted">
                            <i class="fas fa-chart-bar fs-1 mb-3"></i>
                            <p>Perbandingan poin<br>pelanggaran vs prestasi</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 🔔 Notifikasi -->
            <div class="card" style="border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">🔔 Notifikasi</h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-success d-flex align-items-center mb-3" role="alert">
                        <i class="fas fa-check-circle fs-4 me-3"></i>
                        <div>
                            <strong>Sanksi anak Anda sudah diselesaikan.</strong><br>
                            <small class="text-muted">Sanksi kebersihan telah diselesaikan dengan baik</small>
                        </div>
                    </div>
                    <div class="alert alert-info d-flex align-items-center" role="alert">
                        <i class="fas fa-medal fs-4 me-3"></i>
                        <div>
                            <strong>Prestasi anak Anda telah diverifikasi.</strong><br>
                            <small class="text-muted">Prestasi lomba puisi telah diverifikasi dan dicatat</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection