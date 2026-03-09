@extends('layouts.kesiswaan')

@section('title', 'Monitoring All')
@section('page-title', 'Monitoring All')

@section('content')
    <div class="card" style="border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
        <div class="card-header bg-warning text-dark">
            <h5 class="mb-0"><i class="fas fa-search me-2"></i>Monitoring All</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Nama Siswa</th>
                            <th>Kelas</th>
                            <th>Total Poin Pelanggaran</th>
                            <th>Status Monitoring</th>
                            <th>Tanggal Update</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($monitoring as $index => $m)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $m->siswa->nama_siswa ?? '-' }}</td>
                            <td>{{ $m->siswa->kelas->nama_kelas ?? '-' }}</td>
                            <td><span class="badge bg-danger">{{ $m->total_poin ?? 0 }} Poin</span></td>
                            <td>
                                <span class="badge 
                                    @if($m->status == 'normal') bg-success
                                    @elseif($m->status == 'warning') bg-warning
                                    @else bg-danger
                                    @endif">
                                    {{ ucfirst($m->status) }}
                                </span>
                            </td>
                            <td>{{ $m->updated_at->format('d/m/Y H:i') }}</td>
                            <td>
                                <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#modalDetail{{ $m->siswa->id }}">
                                    <i class="fas fa-eye"></i> Detail
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">Belum ada data monitoring</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Detail untuk setiap siswa -->
    @foreach($monitoring as $m)
    <div class="modal fade" id="modalDetail{{ $m->siswa->id }}" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Pelanggaran - {{ $m->siswa->nama_siswa }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Nama:</strong> {{ $m->siswa->nama_siswa }}<br>
                            <strong>Kelas:</strong> {{ $m->siswa->kelas->nama_kelas ?? '-' }}<br>
                            <strong>Total Poin:</strong> <span class="badge bg-danger">{{ $m->total_poin }} Poin</span>
                        </div>
                    </div>
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" id="myTab{{ $m->siswa->id }}" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="pelanggaran-tab{{ $m->siswa->id }}" data-bs-toggle="tab" data-bs-target="#pelanggaran{{ $m->siswa->id }}" type="button" role="tab">Riwayat Pelanggaran</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="sanksi-tab{{ $m->siswa->id }}" data-bs-toggle="tab" data-bs-target="#sanksi{{ $m->siswa->id }}" type="button" role="tab">Pelaksanaan Sanksi</button>
                        </li>
                    </ul>
                    
                    <!-- Tab panes -->
                    <div class="tab-content" id="myTabContent{{ $m->siswa->id }}">
                        <div class="tab-pane fade show active" id="pelanggaran{{ $m->siswa->id }}" role="tabpanel">
                            <div class="table-responsive mt-3">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Jenis Pelanggaran</th>
                                            <th>Poin</th>
                                            <th>Tanggal</th>
                                            <th>Keterangan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($m->siswa->pelanggaran as $index => $p)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $p->jenisPelanggaran->nama_pelanggaran ?? '-' }}</td>
                                            <td><span class="badge bg-danger">{{ $p->poin }}</span></td>
                                            <td>{{ $p->created_at->format('d/m/Y') }}</td>
                                            <td>{{ $p->keterangan ?? '-' }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="sanksi{{ $m->siswa->id }}" role="tabpanel">
                            <div class="table-responsive mt-3">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Jenis Sanksi</th>
                                            <th>Tanggal Pelaksanaan</th>
                                            <th>Status</th>
                                            <th>Bukti</th>
                                            <th>Catatan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $pelaksanaanSanksi = collect();
                                            foreach($m->siswa->pelanggaran as $pelanggaran) {
                                                foreach($pelanggaran->sanksi as $sanksi) {
                                                    foreach($sanksi->pelaksanaanSanksi as $ps) {
                                                        $pelaksanaanSanksi->push((object)[
                                                            'sanksi' => $sanksi,
                                                            'pelaksanaan' => $ps
                                                        ]);
                                                    }
                                                }
                                            }
                                        @endphp
                                        @forelse($pelaksanaanSanksi as $index => $ps)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $ps->sanksi->jenis_sanksi }}</td>
                                            <td>{{ date('d/m/Y', strtotime($ps->pelaksanaan->tanggal_pelaksanaan)) }}</td>
                                            <td>
                                                <span class="badge 
                                                    @if($ps->pelaksanaan->status == 'terjadwal') bg-secondary
                                                    @elseif($ps->pelaksanaan->status == 'dikerjakan') bg-info
                                                    @elseif($ps->pelaksanaan->status == 'tuntas') bg-success
                                                    @elseif($ps->pelaksanaan->status == 'terlambat') bg-danger
                                                    @else bg-warning
                                                    @endif">
                                                    {{ ucfirst($ps->pelaksanaan->status) }}
                                                </span>
                                            </td>
                                            <td>
                                                @if($ps->pelaksanaan->bukti)
                                                    <a href="{{ asset('storage/' . $ps->pelaksanaan->bukti) }}" target="_blank" class="btn btn-xs btn-outline-primary">Lihat</a>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>{{ $ps->pelaksanaan->catatan ?? '-' }}</td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="6" class="text-center text-muted">Belum ada pelaksanaan sanksi</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    @endforeach
@endsection