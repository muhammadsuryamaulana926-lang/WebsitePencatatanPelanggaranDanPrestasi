<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') - Sistem Informasi Kesiswaan</title>
     <link rel="icon" href="{{ asset('img/logo smk.jpeg') }}" type="image/jpeg">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 250px;
            background: linear-gradient(135deg, #dc3545 0%, #a71e2a 100%);
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
        .sidebar-menu a.active {
            background: rgba(255,255,255,0.1);
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
        @yield('styles')
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header text-center">
            <img src="{{ asset('img/logo smk.jpeg') }}" alt="Logo SMK" class="mb-3" style="width: 60px; height: 60px; border-radius: 50%;">
            <h5 class="mb-0">Admin Panel</h5>
            <small class="opacity-75">Sistem Kesiswaan</small>
        </div>
        <ul class="sidebar-menu">
            <li><a href="/admin" class="{{ request()->is('admin') ? 'active' : '' }}"><i class="fas fa-tachometer-alt me-2"></i> Dashboard</a></li>
            <li><a href="/admin/data-siswa" class="{{ request()->is('admin/data-siswa') ? 'active' : '' }}"><i class="fas fa-user-graduate me-2"></i> Data Siswa</a></li>
            <li><a href="/admin/data-guru" class="{{ request()->is('admin/data-guru') ? 'active' : '' }}"><i class="fas fa-chalkboard-teacher me-2"></i> Data Guru</a></li>
            <li><a href="/admin/data-orangtua" class="{{ request()->is('admin/data-orangtua') ? 'active' : '' }}"><i class="fas fa-users me-2"></i> Data Orang Tua</a></li>
            <li><a href="/admin/data-kelas" class="{{ request()->is('admin/data-kelas') ? 'active' : '' }}"><i class="fas fa-school me-2"></i> Data Kelas</a></li>
            <li><a href="/admin/data-jenis-pelanggaran" class="{{ request()->is('admin/data-jenis-pelanggaran') ? 'active' : '' }}"><i class="fas fa-exclamation-triangle me-2"></i> Jenis Pelanggaran</a></li>
            <li><a href="/admin/data-pelanggaran" class="{{ request()->is('admin/data-pelanggaran') ? 'active' : '' }}"><i class="fas fa-ban me-2"></i> Data Pelanggaran</a></li>
            <li><a href="/admin/riwayat-pelanggaran" class="{{ request()->is('admin/riwayat-pelanggaran') ? 'active' : '' }}"><i class="fas fa-history me-2"></i> Riwayat Pelanggaran</a></li>
            <li><a href="/admin/data-sanksi" class="{{ request()->is('admin/data-sanksi') ? 'active' : '' }}"><i class="fas fa-gavel me-2"></i> Data Sanksi</a></li>
            <li><a href="/admin/jenis-sanksi" class="{{ request()->is('admin/jenis-sanksi') ? 'active' : '' }}"><i class="fas fa-balance-scale me-2"></i> Jenis Sanksi</a></li>
            <li><a href="/admin/data-verifikasi" class="{{ request()->is('admin/data-verifikasi') ? 'active' : '' }}"><i class="fas fa-clipboard-check me-2"></i> Data Verifikasi</a></li>
            <li><a href="/admin/monitoring-pelanggaran" class="{{ request()->is('admin/monitoring-pelanggaran') ? 'active' : '' }}"><i class="fas fa-search me-2"></i> Monitoring Pelanggaran</a></li>
            <li><a href="/admin/bimbingan-konseling" class="{{ request()->is('admin/bimbingan-konseling') ? 'active' : '' }}"><i class="fas fa-comments me-2"></i> Bimbingan Konseling</a></li>
            <li><a href="/admin/data-pelaksanaan-sanksi" class="{{ request()->is('admin/data-pelaksanaan-sanksi') ? 'active' : '' }}"><i class="fas fa-tasks me-2"></i> Pelaksanaan Sanksi</a></li>
            <li><a href="/admin/data-jenis-prestasi" class="{{ request()->is('admin/data-jenis-prestasi') ? 'active' : '' }}"><i class="fas fa-medal me-2"></i> Jenis Prestasi</a></li>
            <li><a href="/admin/data-prestasi" class="{{ request()->is('admin/data-prestasi') ? 'active' : '' }}"><i class="fas fa-trophy me-2"></i> Data Prestasi</a></li>
            <li><a href="/admin/tahun-ajaran" class="{{ request()->is('admin/tahun-ajaran') ? 'active' : '' }}"><i class="fas fa-calendar-alt me-2"></i> Tahun Ajaran</a></li>
            <li><a href="/admin/manajemen-user" class="{{ request()->is('admin/manajemen-user') ? 'active' : '' }}"><i class="fas fa-users-cog me-2"></i> Manajemen User</a></li>
            <li><a href="/admin/backup-restore" class="{{ request()->is('admin/backup-restore') ? 'active' : '' }}"><i class="fas fa-database me-2"></i> Backup & Restore</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Header -->
        <div class="top-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0">@yield('page-title', 'Dashboard')</h4>
            <div class="d-flex align-items-center gap-3">
                <span class="badge bg-danger">Admin</span>
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
            @yield('content')
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-3 mt-4">
        <div class="container">
            <p class="mb-0">&copy; 2024 Sistem Informasi Kesiswaan SMK. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>