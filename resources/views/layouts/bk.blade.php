<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Sistem Informasi Kesiswaan</title>
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
            background: linear-gradient(135deg, #17a2b8 0%, #138496 100%);
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
        .sidebar-menu a:hover, .sidebar-menu a.active {
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
        <div class="sidebar-header">
            <h5 class="mb-0">Panel Konselor BK</h5>
            <small>Sistem Kesiswaan</small>
        </div>
        <ul class="sidebar-menu">
            <li><a href="/bk" class="{{ request()->is('bk') ? 'active' : '' }}"><i class="fas fa-tachometer-alt me-2"></i>Dashboard</a></li>
            <li><a href="/bk/input-bk" class="{{ request()->is('bk/input-bk') ? 'active' : '' }}"><i class="fas fa-plus-circle me-2"></i>Input BK</a></li>
            <li><a href="/bk/view-data-sendiri" class="{{ request()->is('bk/view-data-sendiri') ? 'active' : '' }}"><i class="fas fa-eye me-2"></i>View Data Sendiri</a></li>
            <li><a href="/bk/export-laporan" class="{{ request()->is('bk/export-laporan') ? 'active' : '' }}"><i class="fas fa-file-export me-2"></i>Export Laporan</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Header -->
        <div class="top-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0">@yield('page-title')</h4>
            <div class="d-flex align-items-center gap-3">
                <span class="badge bg-info">BK</span>
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