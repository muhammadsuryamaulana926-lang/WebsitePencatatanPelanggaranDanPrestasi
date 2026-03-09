<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Kesiswaan Dashboard') - Sistem Informasi Kesiswaan</title>
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
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
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
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header text-center">
            <img src="{{ asset('img/logo smk.jpeg') }}" alt="Logo SMK" class="mb-3" style="width: 60px; height: 60px; border-radius: 50%;">
            <h5 class="mb-0">Kesiswaan Panel</h5>
            <small class="opacity-75">Sistem Kesiswaan</small>
        </div>
        <ul class="sidebar-menu">
            <li><a href="/kesiswaan" class="{{ request()->is('kesiswaan') ? 'active' : '' }}"><i class="fas fa-tachometer-alt me-2"></i> Dashboard</a></li>
            <li><a href="/kesiswaan/input-pelanggaran" class="{{ request()->is('kesiswaan/input-pelanggaran') ? 'active' : '' }}"><i class="fas fa-exclamation-triangle me-2"></i> Input Pelanggaran</a></li>
            <li><a href="/kesiswaan/riwayat-pelanggaran-semua" class="{{ request()->is('kesiswaan/riwayat-pelanggaran-semua') ? 'active' : '' }}"><i class="fas fa-history me-2"></i> Riwayat Pelanggaran</a></li>
            <li><a href="/kesiswaan/input-prestasi" class="{{ request()->is('kesiswaan/input-prestasi') ? 'active' : '' }}"><i class="fas fa-trophy me-2"></i> Input Prestasi</a></li>
            <li><a href="/kesiswaan/sanksi" class="{{ request()->is('kesiswaan/sanksi') ? 'active' : '' }}"><i class="fas fa-gavel me-2"></i> Data Sanksi</a></li>
            <li><a href="/kesiswaan/verifikasi-data" class="{{ request()->is('kesiswaan/verifikasi-data') ? 'active' : '' }}"><i class="fas fa-clipboard-check me-2"></i> Verifikasi Data</a></li>
            <li><a href="/kesiswaan/monitoring-all" class="{{ request()->is('kesiswaan/monitoring-all') ? 'active' : '' }}"><i class="fas fa-search me-2"></i> Monitoring All</a></li>
            <li><a href="/kesiswaan/view-data-sendiri" class="{{ request()->is('kesiswaan/view-data-sendiri') ? 'active' : '' }}"><i class="fas fa-eye me-2"></i> View Data Sendiri</a></li>
            <li><a href="/kesiswaan/view-data-anak" class="{{ request()->is('kesiswaan/view-data-anak') ? 'active' : '' }}"><i class="fas fa-users me-2"></i> View Data Anak</a></li>
            <li><a href="/kesiswaan/export-laporan" class="{{ request()->is('kesiswaan/export-laporan') ? 'active' : '' }}"><i class="fas fa-file-export me-2"></i> Export Laporan</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Header -->
        <div class="top-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0">@yield('page-title', 'Dashboard')</h4>
            <div class="d-flex align-items-center gap-3">
                <span class="badge bg-success">Kesiswaan</span>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>