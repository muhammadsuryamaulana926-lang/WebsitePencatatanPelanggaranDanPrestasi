@extends('layouts.kesiswaan')

@section('title', 'Export Laporan')
@section('page-title', 'Export Laporan')

@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="card" style="border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-file-export me-2"></i>Export Options</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="/kesiswaan/export-pdf" class="btn btn-danger">
                            <i class="fas fa-file-pdf me-2"></i>Export Laporan PDF
                        </a>
                        <a href="/kesiswaan/export-excel" class="btn btn-success">
                            <i class="fas fa-file-excel me-2"></i>Export Laporan Excel
                        </a>
                        <button onclick="window.print()" class="btn btn-primary">
                            <i class="fas fa-print me-2"></i>Cetak Laporan
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-8">
            <div class="card" style="border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="fas fa-chart-bar me-2"></i>Ringkasan Data</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Statistik Pelanggaran</h6>
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>Kategori</th>
                                            <th>Jumlah</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Ringan</td>
                                            <td><span class="badge bg-warning">{{ $pelanggaran->where('jenisPelanggaran.kategori', 'ringan')->count() }}</span></td>
                                        </tr>
                                        <tr>
                                            <td>Sedang</td>
                                            <td><span class="badge bg-warning">{{ $pelanggaran->where('jenisPelanggaran.kategori', 'sedang')->count() }}</span></td>
                                        </tr>
                                        <tr>
                                            <td>Berat</td>
                                            <td><span class="badge bg-danger">{{ $pelanggaran->where('jenisPelanggaran.kategori', 'berat')->count() }}</span></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <h6>Statistik Prestasi</h6>
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>Tingkat</th>
                                            <th>Jumlah</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Sekolah</td>
                                            <td><span class="badge bg-success">{{ $prestasi->where('jenisPrestasi.tingkat', 'sekolah')->count() }}</span></td>
                                        </tr>
                                        <tr>
                                            <td>Kota</td>
                                            <td><span class="badge bg-success">{{ $prestasi->where('jenisPrestasi.tingkat', 'kota')->count() }}</span></td>
                                        </tr>
                                        <tr>
                                            <td>Nasional</td>
                                            <td><span class="badge bg-success">{{ $prestasi->where('jenisPrestasi.tingkat', 'nasional')->count() }}</span></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    
                    <hr>
                    
                    <div class="row text-center">
                        <div class="col-md-4">
                            <h3 class="text-danger">{{ $pelanggaran->count() }}</h3>
                            <p class="mb-0">Total Pelanggaran</p>
                        </div>
                        <div class="col-md-4">
                            <h3 class="text-success">{{ $prestasi->count() }}</h3>
                            <p class="mb-0">Total Prestasi</p>
                        </div>
                        <div class="col-md-4">
                            <h3 class="text-info">{{ $pelanggaran->sum('jenisPelanggaran.poin') }}</h3>
                            <p class="mb-0">Total Poin Pelanggaran</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection