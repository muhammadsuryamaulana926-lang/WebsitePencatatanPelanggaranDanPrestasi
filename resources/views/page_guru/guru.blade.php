<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Guru - Sistem Informasi Kesiswaan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 250px;
            background: linear-gradient(135deg, #4caf50 0%, #45a049 100%);
            color: white;
            z-index: 1000;
            overflow-y: auto;
        }
        .sidebar-header {
            padding: 20px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        .sidebar-menu {
            padding: 0;
            margin: 0;
            list-style: none;
        }
        .sidebar-menu li {
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        .sidebar-menu a {
            display: block;
            padding: 15px 20px;
            color: white;
            text-decoration: none;
            transition: all 0.3s;
        }
        .sidebar-menu a:hover {
            background: rgba(255,255,255,0.1);
            color: white;
        }
        .main-content {
            margin-left: 250px;
            min-height: 100vh;
            background: #f8f9fa;
        }
        .top-header {
            background: white;
            padding: 15px 30px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header text-center">
            <img src="{{ asset('img/logo smk.jpeg') }}" alt="Logo SMK" class="mb-3" style="width: 60px; height: 60px; border-radius: 50%;">
            <h5 class="mb-0">Panel Guru</h5>
            <small class="opacity-75">Sistem Kesiswaan</small>
        </div>
        <ul class="sidebar-menu">
            <li><a href="/guru"><i class="fas fa-tachometer-alt me-2"></i> Dashboard</a></li>
            <li><a href="/guru/input-pelanggaran"><i class="fas fa-plus me-2"></i> Input Pelanggaran</a></li>
            <li><a href="/guru/view-data-sendiri"><i class="fas fa-eye me-2"></i> View Data Sendiri</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Header -->
        <div class="top-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Dashboard Guru</h4>
            <div class="d-flex align-items-center gap-3">
                <span class="badge bg-success">Guru</span>
                <div class="dropdown">
                    <button class="btn btn-link p-0" type="button" data-bs-toggle="dropdown">
                        <i class="fas fa-user-circle fs-4 text-dark"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item text-danger" href="/logout"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="p-4">
            <div class="text-center mb-4 p-4" style="background: white; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                <i class="fas fa-chalkboard-teacher fs-1 text-success mb-3"></i>
                <h4 class="mb-2">Dashboard Guru</h4>
                <p class="text-muted">Tujuan: mencatat dan memantau pelanggaran siswa yang diajar</p>
            </div>
            
            <!-- 📊 Statistik Pribadi -->
            <div class="card mb-4" style="border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">📊 Statistik Pribadi</h5>
                </div>
                <div class="card-body">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="text-center">
                                <i class="fas fa-exclamation-triangle fs-2 text-warning mb-2"></i>
                                <h5>Pelanggaran Dicatat Bulan Ini</h5>
                                <h3 class="text-warning">{{ $pelanggaranBulanIni }}</h3>
                            </div>
                        </div>
                      
                        </div>
                    </div>
                </div>
            </div>

            <!-- 🔸 Tombol Cepat -->
            <div class="card mb-4" style="border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">🔸 Tombol Cepat</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <a href="/guru/input-pelanggaran" class="btn btn-outline-primary w-100 p-3">
                                <i class="fas fa-plus fs-3 mb-2"></i><br>
                                <strong>Input Pelanggaran Baru</strong>
                            </a>
                        </div>
                        <div class="col-md-6">
                            <a href="/guru/daftar-pelanggaran" class="btn btn-outline-success w-100 p-3">
                                <i class="fas fa-eye fs-3 mb-2"></i><br>
                                <strong>Lihat Status Pelanggaran</strong>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 🕓 Daftar Terakhir -->
            <div class="card mb-4" style="border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">🕓 Daftar Terakhir</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Siswa</th>
                                    <th>Pelanggaran</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pelanggaranTerakhir as $p)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar bg-primary text-white rounded-circle me-2 d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;">
                                                {{ substr($p->siswa->nama_siswa ?? 'N', 0, 1) }}
                                            </div>
                                            <strong>{{ $p->siswa->nama_siswa ?? '-' }}</strong>
                                        </div>
                                    </td>
                                    <td>{{ $p->jenisPelanggaran->nama_pelanggaran ?? '-' }}</td>
                                    <td>
                                        <span class="badge bg-warning">Menunggu</span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted">Belum ada data pelanggaran</td>
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
                    <div class="alert alert-warning d-flex align-items-center" role="alert">
                        <i class="fas fa-info-circle fs-4 me-3"></i>
                        <div>
                            <strong>Ada pelanggaran siswa yang menunggu verifikasi kesiswaan.</strong><br>
                            <small class="text-muted">Pelanggaran yang telah dicatat menunggu konfirmasi dari bagian kesiswaan</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>