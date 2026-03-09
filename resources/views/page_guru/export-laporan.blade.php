@extends('layouts.guru')

@section('title', 'Export Laporan')
@section('page-title', 'Export Laporan')

@section('content')
    <div class="card" style="border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
        <div class="card-header bg-info text-white">
            <h5 class="mb-0"><i class="fas fa-download me-2"></i>Export Laporan - Berdasarkan Guru Pencatat</h5>
        </div>
        <div class="card-body">
            @foreach($dataByGuru as $guru)
            <div class="mb-5">
                <h4 class="text-primary border-bottom pb-2">{{ $guru->nama_guru }}</h4>
                
                <!-- Ringkasan untuk guru ini -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="card bg-light">
                            <div class="card-body">
                                <h6>Pelanggaran</h6>
                                <p class="mb-1">Total: <strong>{{ $guru->pelanggaranPencatat->count() }}</strong></p>
                                <p class="mb-0">Total Poin: <strong>{{ $guru->pelanggaranPencatat->sum('poin') }}</strong></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card bg-light">
                            <div class="card-body">
                                <h6>Prestasi</h6>
                                <p class="mb-1">Total: <strong>{{ $guru->prestasiPencatat->count() }}</strong></p>
                                <p class="mb-0">Total Poin: <strong>{{ $guru->prestasiPencatat->sum('poin') }}</strong></p>
                            </div>
                        </div>
                    </div>
                </div>
                
                @if($guru->pelanggaranPencatat->count() > 0)
                <!-- Data Pelanggaran -->
                <h6 class="mb-3">Data Pelanggaran</h6>
                <div class="table-responsive mb-4">
                    <table class="table table-striped table-sm">
                        <thead class="table-dark">
                            <tr>
                                <th>No</th>
                                <th>Nama Siswa</th>
                                <th>Kelas</th>
                                <th>Jenis Pelanggaran</th>
                                <th>Poin</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $no = 1; @endphp
                            @foreach($guru->pelanggaranPencatat as $p)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $p->siswa->nama_siswa ?? '-' }}</td>
                                <td>{{ $p->siswa->kelas->nama_kelas ?? '-' }}</td>
                                <td>{{ $p->jenisPelanggaran->nama_pelanggaran ?? '-' }}</td>
                                <td>{{ $p->poin }}</td>
                                <td>{{ $p->created_at->format('d/m/Y') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
                
                @if($guru->prestasiPencatat->count() > 0)
                <!-- Data Prestasi -->
                <h6 class="mb-3">Data Prestasi</h6>
                <div class="table-responsive mb-4">
                    <table class="table table-striped table-sm">
                        <thead class="table-dark">
                            <tr>
                                <th>No</th>
                                <th>Nama Siswa</th>
                                <th>Kelas</th>
                                <th>Jenis Prestasi</th>
                                <th>Poin</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $no = 1; @endphp
                            @foreach($guru->prestasiPencatat as $p)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $p->siswa->nama_siswa ?? '-' }}</td>
                                <td>{{ $p->siswa->kelas->nama_kelas ?? '-' }}</td>
                                <td>{{ $p->jenisPrestasi->nama_prestasi ?? '-' }}</td>
                                <td>{{ $p->poin }}</td>
                                <td>{{ $p->created_at->format('d/m/Y') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
                
                <div class="text-end mb-3">
                    <a href="/guru/export-laporan/{{ $guru->id }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-download me-1"></i>Export Data {{ $guru->nama_guru }}
                    </a>
                </div>
                
                <hr>
            </div>
            @endforeach
            
            <div class="mt-3">
                <button class="btn btn-success" onclick="exportToPDF()">
                    <i class="fas fa-file-pdf me-1"></i>Export Semua ke PDF
                </button>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
function exportToPDF() {
    window.print();
}
</script>
@endsection