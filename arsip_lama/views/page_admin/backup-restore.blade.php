@extends('layouts.admin')

@section('title', 'Backup & Restore Database')
@section('page-title', 'Backup & Restore Database')

@section('content')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <!-- Backup Section -->
        <div class="col-md-6">
            <div class="card" style="border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="fas fa-download me-2"></i>Backup Database</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted">Buat backup database untuk keamanan data</p>
                    
                    <div class="alert alert-info">
                        <h6><i class="fas fa-clock me-2"></i>Jadwal Backup Otomatis:</h6>
                        <ul class="mb-0">
                            <li>Daily incremental backup (00:00)</li>
                            <li>Weekly full backup (Minggu 02:00)</li>
                            <li>Monthly archive backup (Akhir bulan)</li>
                        </ul>
                    </div>

                    <form action="/admin/backup" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-success btn-lg w-100">
                            <i class="fas fa-download me-2"></i>Buat Backup Sekarang
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Restore Section -->
        <div class="col-md-6">
            <div class="card" style="border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                <div class="card-header bg-warning text-white">
                    <h5 class="mb-0"><i class="fas fa-upload me-2"></i>Restore Database</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted">Restore database dari file backup</p>
                    
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Peringatan:</strong> Proses restore akan mengganti semua data yang ada!
                    </div>

                    <form action="/admin/restore" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Pilih File Backup (.sql atau .gz)</label>
                            <input type="file" name="backup_file" class="form-control" accept=".sql,.gz" required>
                        </div>
                        <button type="submit" class="btn btn-warning btn-lg w-100" onclick="return confirm('Yakin ingin restore database? Semua data akan diganti!')">
                            <i class="fas fa-upload me-2"></i>Restore Database
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Backup Files List -->
    <div class="card mt-4" style="border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="fas fa-archive me-2"></i>File Backup Tersedia</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Nama File</th>
                            <th>Ukuran</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($backups as $index => $backup)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $backup['name'] }}</td>
                            <td>{{ $backup['size'] }}</td>
                            <td>{{ $backup['date'] }}</td>
                            <td>
                                <a href="/admin/backup/download/{{ $backup['name'] }}" class="btn btn-info btn-sm me-1">
                                    <i class="fas fa-download"></i>
                                </a>
                                <form action="/admin/backup/delete/{{ $backup['name'] }}" method="POST" style="display: inline;" onsubmit="return confirm('Yakin ingin menghapus backup ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">Belum ada file backup</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

  
    </div>
@endsection