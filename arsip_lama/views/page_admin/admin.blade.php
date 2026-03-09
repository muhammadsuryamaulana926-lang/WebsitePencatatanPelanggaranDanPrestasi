@extends('layouts.admin')

@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard Admin Sistem (Super User)')

@section('styles')
<style>
    .col-xl-2-4 {
        flex: 0 0 auto;
        width: 20%;
    }
    @media (max-width: 1200px) {
        .col-xl-2-4 {
            width: 50%;
        }
    }
    @media (max-width: 768px) {
        .col-xl-2-4 {
            width: 100%;
        }
    }
</style>
@endsection

@section('content')
            <div class="text-center mb-4 p-4" style="background: white; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                <i class="fas fa-crown fs-1 text-danger mb-3"></i>
                <h4 class="mb-2">Dashboard Admin Sistem (Super User)</h4>
                <p class="text-muted">Melihat seluruh aktivitas dan mengatur sistem</p>
            </div>
            
            <!-- 📊 Statistik Global -->
            <div class="card mb-4" style="border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">📊 Statistik Global</h5>
                </div>
                <div class="card-body">
                    <div class="row g-4">
                        <div class="col-md-6 col-xl-2-4">
                            <div class="text-center">
                                <i class="fas fa-user-graduate fs-2 text-primary mb-2"></i>
                                <h5>Total Siswa</h5>
                                <h3 class="text-primary">{{ number_format($totalSiswa) }}</h3>
                            </div>
                        </div>
                        <div class="col-md-6 col-xl-2-4">
                            <div class="text-center">
                                <i class="fas fa-chalkboard-teacher fs-2 text-success mb-2"></i>
                                <h5>Total Guru</h5>
                                <h3 class="text-success">{{ $totalGuru }}</h3>
                            </div>
                        </div>
                        <div class="col-md-6 col-xl-2-4">
                            <div class="text-center">
                                <i class="fas fa-exclamation-triangle fs-2 text-warning mb-2"></i>
                                <h5>Pelanggaran Bulan Ini</h5>
                                <h3 class="text-warning">{{ $pelanggaranBulanIni }}</h3>
                            </div>
                        </div>
                        <div class="col-md-6 col-xl-2-4">
                            <div class="text-center">
                                <i class="fas fa-gavel fs-2 text-danger mb-2"></i>
                                <h5>Sanksi Aktif</h5>
                                <h3 class="text-danger">{{ $sanksiAktif }}</h3>
                            </div>
                        </div>
                        <div class="col-md-6 col-xl-2-4">
                            <div class="text-center">
                                <i class="fas fa-trophy fs-2 text-info mb-2"></i>
                                <h5>Total Prestasi</h5>
                                <h3 class="text-info">{{ $totalPrestasi }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 📈 Grafik Tren -->
            <div class="row g-4 mb-4">
                <div class="col-md-6">
                    <div class="card" style="border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                        <div class="card-header bg-success text-white">
                            <h6 class="mb-0">📈 Grafik Pelanggaran per Bulan</h6>
                        </div>
                        <div class="card-body">
                            <div style="height: 300px;">
                                <canvas id="pelanggaranChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card" style="border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                        <div class="card-header bg-warning text-white">
                            <h6 class="mb-0">📈 Grafik Jenis Sanksi Terbanyak</h6>
                        </div>
                        <div class="card-body">
                            <div style="height: 300px;">
                                <canvas id="sanksiChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ⚙️ Menu Cepat -->
            <div class="card mb-4" style="border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">⚙️ Menu Cepat</h5>
                    <div>
                        <button class="btn btn-light btn-sm me-2" data-bs-toggle="modal" data-bs-target="#exportModal">
                            <i class="fas fa-file-pdf"></i> Export Laporan PDF
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <a href="/admin/manajemen-user" class="btn btn-outline-primary w-100 p-3 text-decoration-none">
                                <i class="fas fa-users-cog fs-3 mb-2"></i><br>
                                <strong>Kelola User</strong>
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="/admin/backup-restore" class="btn btn-outline-success w-100 p-3 text-decoration-none">
                                <i class="fas fa-database fs-3 mb-2"></i><br>
                                <strong>Backup Database</strong>
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="/admin/monitoring-pelanggaran" class="btn btn-outline-warning w-100 p-3 text-decoration-none">
                                <i class="fas fa-eye fs-3 mb-2"></i><br>
                                <strong>Monitoring</strong>
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="/admin/data-siswa" class="btn btn-outline-secondary w-100 p-3 text-decoration-none">
                                <i class="fas fa-cogs fs-3 mb-2"></i><br>
                                <strong>Master Data</strong>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 🔍 Monitoring Pelanggaran -->
            <div class="card mb-4" style="border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">🔍 Monitoring Pelanggaran</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>No</th>
                                    <th>Siswa</th>
                                    <th>Pelanggaran</th>
                                    <th>Guru Kepsek</th>
                                    <th>Status</th>
                                    <th>Catatan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($monitoringPelanggaran as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $item->pelanggaran->siswa->nama_siswa ?? 'Tidak ditemukan' }}</td>
                                    <td>{{ $item->pelanggaran->jenisPelanggaran->nama ?? 'Tidak ditemukan' }}</td>
                                    <td>{{ $item->guruKepsek->nama_guru ?? 'Belum ditentukan' }}</td>
                                    <td>
                                        @if($item->status == 'dipantau')
                                            <span class="badge bg-warning">Dipantau</span>
                                        @elseif($item->status == 'dalam_tindakan')
                                            <span class="badge bg-info">Dalam Tindakan</span>
                                        @else
                                            <span class="badge bg-success">Selesai</span>
                                        @endif
                                    </td>
                                    <td>{{ $item->catatan ?? '-' }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- 💬 Bimbingan Konseling -->
            <div class="card mb-4" style="border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">💬 Bimbingan Konseling</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>No</th>
                                    <th>Siswa</th>
                                    <th>Guru Konselor</th>
                                    <th>Topik</th>
                                    <th>Status</th>
                                    <th>Tindakan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($bimbinganKonseling as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $item->siswa->nama_siswa ?? 'Tidak ditemukan' }}</td>
                                    <td>{{ $item->konselor->nama_guru ?? 'Belum ditentukan' }}</td>
                                    <td>{{ $item->topik }}</td>
                                    <td>
                                        @if($item->status == 'terjadwal')
                                            <span class="badge bg-warning">Terjadwal</span>
                                        @elseif($item->status == 'berlangsung')
                                            <span class="badge bg-info">Berlangsung</span>
                                        @else
                                            <span class="badge bg-success">Selesai</span>
                                        @endif
                                    </td>
                                    <td>{{ $item->tindakan_solusi ?? '-' }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- 📋 Data Verifikasi -->
            <div class="card mb-4" style="border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                <div class="card-header bg-warning text-white">
                    <h5 class="mb-0">📋 Data Verifikasi</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>No</th>
                                    <th>Tabel Terkait</th>
                                    <th>ID Terkait</th>
                                    <th>Guru Verifikator</th>
                                    <th>Status</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($verifikasiData as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td><span class="badge bg-info">{{ $item->tabel_terkait }}</span></td>
                                    <td>{{ $item->id_terkait }}</td>
                                    <td>{{ $item->guru->nama_guru ?? 'Tidak ditemukan' }}</td>
                                    <td>
                                        @if($item->status == 'menunggu')
                                            <span class="badge bg-warning">Menunggu</span>
                                        @elseif($item->status == 'disetujui')
                                            <span class="badge bg-success">Disetujui</span>
                                        @else
                                            <span class="badge bg-danger">Ditolak</span>
                                        @endif
                                    </td>
                                    <td>{{ date('d/m/Y', strtotime($item->created_at)) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- 📅 Tahun Ajaran -->
            <div class="card mb-4" style="border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">📅 Tahun Ajaran</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>No</th>
                                    <th>Tahun Ajaran</th>
                                    <th>Semester</th>
                                    <th>Status</th>
                                    <th>Tanggal Dibuat</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($tahunAjaran as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td><strong>{{ $item->tahun_ajaran }}</strong></td>
                                    <td><span class="badge bg-info">{{ $item->semester }}</span></td>
                                    <td>
                                        @if($item->status_aktif)
                                            <span class="badge bg-success">Aktif</span>
                                        @else
                                            <span class="badge bg-secondary">Tidak Aktif</span>
                                        @endif
                                    </td>
                                    <td>{{ date('d/m/Y', strtotime($item->created_at)) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- 🔔 Notifikasi Sistem -->
            <div class="card" style="border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0">🔔 Notifikasi Sistem</h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-warning d-flex align-items-center" role="alert">
                        <i class="fas fa-user-clock fs-4 me-3"></i>
                        <div>
                            <strong>{{ $verifikasiData->where('status', 'menunggu')->count() }} data menunggu verifikasi</strong><br>
                            <small class="text-muted">Perlu persetujuan admin untuk verifikasi data</small>
                        </div>
                    </div>
                    <div class="alert alert-info d-flex align-items-center" role="alert">
                        <i class="fas fa-database fs-4 me-3"></i>
                        <div>
                            <strong>Database backup terakhir: 5 hari lalu</strong><br>
                            <small class="text-muted">Disarankan untuk melakukan backup secara berkala</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<!-- Modal Export PDF -->
<div class="modal fade" id="exportModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Export Laporan PDF</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="/admin/export-laporan-pdf" method="GET">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label">Bulan</label>
                            <select name="bulan" class="form-select">
                                <option value="">Semua Bulan</option>
                                <option value="1">Januari</option>
                                <option value="2">Februari</option>
                                <option value="3">Maret</option>
                                <option value="4">April</option>
                                <option value="5">Mei</option>
                                <option value="6">Juni</option>
                                <option value="7">Juli</option>
                                <option value="8">Agustus</option>
                                <option value="9">September</option>
                                <option value="10">Oktober</option>
                                <option value="11">November</option>
                                <option value="12">Desember</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tahun</label>
                            <select name="tahun" class="form-select">
                                <option value="">Semua Tahun</option>
                                @for($i = date('Y'); $i >= date('Y')-5; $i--)
                                <option value="{{ $i }}" {{ $i == date('Y') ? 'selected' : '' }}>{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                    <div class="mt-3">
                        <label class="form-label">Kelas</label>
                        <select name="kelas" class="form-select">
                            <option value="">Semua Kelas</option>
                            @foreach(\App\Models\Kelas::all() as $kelas)
                            <option value="{{ $kelas->id }}">{{ $kelas->nama_kelas }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-file-pdf"></i> Export PDF
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Data dari controller
        const pelanggaranData = @json($pelanggaranPerBulan);
        const sanksiData = @json($jenisSanksi);
        
        // Chart.js default configuration
        Chart.defaults.font.family = 'Inter, system-ui, sans-serif';
        Chart.defaults.color = '#6b7280';
        
        // Grafik Pelanggaran per Bulan
        const pelanggaranCtx = document.getElementById('pelanggaranChart');
        if (pelanggaranCtx) {
            new Chart(pelanggaranCtx, {
                type: 'bar',
                data: {
                    labels: pelanggaranData.map(item => item.bulan),
                    datasets: [{
                        label: 'Jumlah Pelanggaran',
                        data: pelanggaranData.map(item => item.jumlah),
                        backgroundColor: '#dc3545',
                        borderColor: '#c82333',
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
                        },
                        title: {
                            display: true,
                            text: 'Pelanggaran per Bulan (12 Bulan Terakhir)'
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

        // Grafik Jenis Sanksi Terbanyak
        const sanksiCtx = document.getElementById('sanksiChart');
        if (sanksiCtx) {
            new Chart(sanksiCtx, {
                type: 'doughnut',
                data: {
                    labels: sanksiData.map(item => item.jenis_sanksi),
                    datasets: [{
                        label: 'Jumlah Sanksi',
                        data: sanksiData.map(item => item.total),
                        backgroundColor: [
                            '#dc3545',
                            '#fd7e14',
                            '#ffc107',
                            '#28a745',
                            '#17a2b8'
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
                        },
                        title: {
                            display: true,
                            text: 'Jenis Sanksi Terbanyak'
                        }
                    }
                }
            });
        }
    });
</script>
@endsection