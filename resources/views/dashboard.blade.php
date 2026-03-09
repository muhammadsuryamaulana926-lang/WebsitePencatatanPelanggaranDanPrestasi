<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Sistem Informasi Kesiswaan</title>
    <link rel="icon" href="{{ asset('img/logo smk.jpeg') }}" type="image/jpeg">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
</head>
<body style="background-color: #f8f9fa;">
    <!-- Main Content -->
    <div class="container-fluid p-0">
        <!-- Header -->
        <header class="py-4 mb-4" style="background: linear-gradient(135deg, #87ceeb 0%, #4682b4 100%); color: white;">
            <div class="container">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <img src="{{ asset('img/logo smk.jpeg') }}" alt="Logo SMK" class="me-3" style="width: 60px; height: 60px; border-radius: 50%;">
                        <div>
                            <h4 class="mb-0">Sistem Informasi Kesiswaan</h4>
                            <small class="opacity-75">SMK BAKTI NUSANTARA 666</small>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <div class="dropdown">
                            <button class="btn btn-link text-white p-0" type="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user-circle fs-4"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item text-primary" href="/login"><i class="fas fa-sign-in-alt"></i> Login</a></li>
                                <!-- <li><a class="dropdown-item text-danger" href="/login"><i class="fas fa-sign-out-alt"></i> Logout</a></li> -->
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Dashboard Content -->
        <div class="container">
            <!-- Welcome Section - Carousel -->
            <div id="welcomeCarousel" class="carousel slide mb-5" data-bs-ride="carousel" style="border-radius: 15px; overflow: hidden; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="position-relative" style="height: 400px; background: linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.4)), url('{{ asset('img/sajuta.jpeg') }}') center/cover;">
                            <div class="position-absolute top-50 start-50 translate-middle text-center text-white">
                                <h2 class="mb-3"><strong>SAJUTA</strong></h2>
                                 <p class="fs-5">Satu Jiwa Untuk Taat Aturan.<br>Komitmen bersama dalam menegakkan kedisiplinan.</p>
                               
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="position-relative" style="height: 400px; background: linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.4)), url('{{ asset('img/santun.jpeg') }}') center/cover;">
                            <div class="position-absolute top-50 start-50 translate-middle text-center text-white">
                                <h2 class="mb-3"><strong>SANTUN</strong></h2>
                                <p class="fs-5">Berperilaku sopan dan menghormati orang lain.<br>Menjunjung tinggi nilai-nilai kesopanan dalam berinteraksi.</p>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="position-relative" style="height: 400px; background: linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.4)), url('{{ asset('img/jujur.jpeg') }}') center/cover;">
                            <div class="position-absolute top-50 start-50 translate-middle text-center text-white">
                                <h2 class="mb-3"><strong>JUJUR</strong></h2>
                                <p class="fs-5">Berbudi pekerti luhur dalam bermasyarakat. Memiliki rasa<br>Handarbeni pada diri, sekolah, keluarga, dan almamaternya.</p>
                               
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="position-relative" style="height: 400px; background: linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.4)), url('{{ asset('img/taat.jpeg') }}') center/cover;">
                            <div class="position-absolute top-50 start-50 translate-middle text-center text-white">
                               
                                 <h2 class="mb-3"><strong>TAAT</strong></h2>
                                  <p class="fs-5">Patuh terhadap aturan dan norma yang berlaku.<br>Menjalankan kewajiban dengan penuh tanggung jawab.</p>
                                 
                            </div>
                        </div>
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#welcomeCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#welcomeCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#welcomeCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#welcomeCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#welcomeCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
                    <button type="button" data-bs-target="#welcomeCarousel" data-bs-slide-to="3" aria-label="Slide 4"></button>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="row g-4 mb-5">
                <div class="col-md-6 col-lg-4">
                    <div class="card text-center h-100" style="border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                        <div class="card-body">
                            <h3 class="text-dark">{{ number_format($totalSiswa) }}</h3>
                            <p class="text-muted mb-0">Jumlah Siswa</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="card text-center h-100" style="border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                        <div class="card-body">
                            <h3 class="text-dark">{{ $totalPelanggaran }}</h3>
                            <p class="text-muted mb-0">Jumlah Pelanggaran</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="card text-center h-100" style="border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                        <div class="card-body">
                            <h3 class="text-dark">{{ $totalPrestasi }}</h3>
                            <p class="text-muted mb-0">Jumlah Prestasi</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="card text-center h-100" style="border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                        <div class="card-body">
                            <h3 class="text-dark">{{ $totalKonseling }}</h3>
                            <p class="text-muted mb-0">Siswa Konseling</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="card text-center h-100" style="border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                        <div class="card-body">
                            <h3 class="text-dark">2024/2025</h3>
                            <p class="text-muted mb-0">Tahun Ajaran Aktif</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts Section -->
            <div class="row g-4 mb-5">
                <div class="col-md-6">
                    <div class="card" style="border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                        <div class="card-body">
                            <h6 class="card-title">Pelanggaran per Kelas</h6>
                            <div style="height: 300px;">
                                <canvas id="pelanggaranChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card" style="border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                        <div class="card-body">
                            <h6 class="card-title">Prestasi per Kelas</h6>
                            <div style="height: 300px;">
                                <canvas id="prestasiChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Trend Chart -->
            <div class="card mb-5" style="border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                <div class="card-body">
                    <h6 class="card-title">Tren Bulanan (12 Bulan Terakhir)</h6>
                    <div style="height: 400px;">
                        <canvas id="trendChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Tables Section -->
            <div class="row g-4 mb-5">
                <div class="col-lg-6">
                    <div class="card" style="border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                        <div class="card-body">
                            <h6 class="card-title">Top 5 Siswa - Poin Pelanggaran Tertinggi</h6>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Nama</th>
                                            <th>Kelas</th>
                                            <th>Poin</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($topPelanggaran as $siswa)
                                        <tr>
                                            <td>{{ $siswa->nama_siswa }}</td>
                                            <td>{{ $siswa->kelas->nama_kelas ?? '-' }}</td>
                                            <td><span class="badge bg-danger">{{ $siswa->pelanggaran_sum_poin ?? 0 }}</span></td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="3" class="text-center text-muted">Tidak ada data</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="card" style="border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                        <div class="card-body">
                            <h6 class="card-title">Top 5 Siswa - Poin Prestasi Tertinggi</h6>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Nama</th>
                                            <th>Kelas</th>
                                            <th>Poin</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($topPrestasi as $siswa)
                                        <tr>
                                            <td>{{ $siswa->nama_siswa }}</td>
                                            <td>{{ $siswa->kelas->nama_kelas ?? '-' }}</td>
                                            <td><span class="badge bg-success">{{ $siswa->prestasi_sum_poin ?? 0 }}</span></td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="3" class="text-center text-muted">Tidak ada data</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Schedule Table -->
            <div class="card mb-5" style="border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                <div class="card-body">
                    <h6 class="card-title">Jadwal Konseling Hari Ini</h6>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Waktu</th>
                                    <th>Siswa</th>
                                    <th>Kelas</th>
                                    <th>Konselor</th>
                                    <th>Topik</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>08:00 - 08:30</td>
                                    <td>Andi Wijaya</td>
                                    <td>XI RPL 1</td>
                                    <td>Ibu Sari, S.Pd</td>
                                    <td>Konseling Akademik</td>
                                </tr>
                                <tr>
                                    <td>10:00 - 10:30</td>
                                    <td>Putri Sari</td>
                                    <td>XII TKJ 2</td>
                                    <td>Pak Budi, M.Pd</td>
                                    <td>Konseling Karir</td>
                                </tr>
                                <tr>
                                    <td>13:00 - 13:30</td>
                                    <td>Bayu Prasetyo</td>
                                    <td>X MM 1</td>
                                    <td>Ibu Sari, S.Pd</td>
                                    <td>Konseling Pribadi</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <script>
        // Data dari controller
        const pelanggaranData = @json($pelanggaranPerKelas);
        const prestasiData = @json($prestasiPerKelas);
        const trendData = @json($trendData);
        
        document.addEventListener('DOMContentLoaded', function() {
            // Chart.js default configuration
            Chart.defaults.font.family = 'Inter, system-ui, sans-serif';
            Chart.defaults.color = '#6b7280';
            
            // Pelanggaran per Kelas Chart
            const pelanggaranCtx = document.getElementById('pelanggaranChart');
            if (pelanggaranCtx) {
                new Chart(pelanggaranCtx, {
                    type: 'bar',
                    data: {
                        labels: pelanggaranData.map(item => item.nama_kelas),
                        datasets: [{
                            label: 'Jumlah Pelanggaran',
                            data: pelanggaranData.map(item => item.total_pelanggaran),
                            backgroundColor: '#ef4444',
                            borderColor: '#dc2626',
                            borderWidth: 1,
                            borderRadius: 4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: {
                                    color: '#f3f4f6'
                                }
                            },
                            x: {
                                grid: {
                                    display: false
                                }
                            }
                        }
                    }
                });
            }

            // Prestasi per Kelas Chart
            const prestasiCtx = document.getElementById('prestasiChart');
            if (prestasiCtx) {
                new Chart(prestasiCtx, {
                    type: 'doughnut',
                    data: {
                        labels: prestasiData.map(item => item.nama_kelas),
                        datasets: [{
                            label: 'Jumlah Prestasi',
                            data: prestasiData.map(item => item.total_prestasi),
                            backgroundColor: [
                                '#22c55e', '#16a34a', '#15803d', '#166534',
                                '#14532d', '#052e16', '#84cc16', '#65a30d'
                            ],
                            borderWidth: 2,
                            borderColor: '#ffffff'
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    padding: 20,
                                    usePointStyle: true
                                }
                            }
                        }
                    }
                });
            }

            // Trend Chart
            const trendCtx = document.getElementById('trendChart');
            if (trendCtx) {
                new Chart(trendCtx, {
                    type: 'line',
                    data: {
                        labels: trendData.map(item => item.month),
                        datasets: [
                            {
                                label: 'Pelanggaran',
                                data: trendData.map(item => item.pelanggaran),
                                borderColor: '#ef4444',
                                backgroundColor: 'rgba(239, 68, 68, 0.1)',
                                tension: 0.4,
                                fill: true
                            },
                            {
                                label: 'Prestasi',
                                data: trendData.map(item => item.prestasi),
                                borderColor: '#22c55e',
                                backgroundColor: 'rgba(34, 197, 94, 0.1)',
                                tension: 0.4,
                                fill: true
                            },
                            {
                                label: 'Konseling',
                                data: trendData.map(item => item.konseling),
                                borderColor: '#3b82f6',
                                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                                tension: 0.4,
                                fill: true
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'top',
                                labels: {
                                    usePointStyle: true,
                                    padding: 20
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: {
                                    color: '#f3f4f6'
                                }
                            },
                            x: {
                                grid: {
                                    display: false
                                }
                            }
                        },
                        interaction: {
                            intersect: false,
                            mode: 'index'
                        }
                    }
                });
            }
        });
    </script>

</body>
</html>