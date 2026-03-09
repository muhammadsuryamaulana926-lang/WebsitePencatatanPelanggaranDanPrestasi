@extends('layouts.admin')

@section('title', 'Monitoring Pelanggaran')
@section('page-title', 'Monitoring Pelanggaran')

@section('content')
<!-- Pelanggaran Baru yang Perlu Dimonitor -->
@if($pelanggaranBelumDimonitor->count() > 0)
<div class="card mb-4" style="border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
    <div class="card-header bg-danger text-white">
        <h5 class="mb-0"><i class="fas fa-exclamation-triangle me-2"></i>Pelanggaran Baru yang Perlu Dimonitor ({{ $pelanggaranBelumDimonitor->count() }})</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>Tanggal</th>
                        <th>Siswa</th>
                        <th>Jenis Pelanggaran</th>
                        <th>Poin</th>
                        <th>Guru Pencatat</th>
                        <th>Keterangan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pelanggaranBelumDimonitor as $p)
                    <tr>
                        <td>{{ date('d/m/Y', strtotime($p->created_at)) }}</td>
                        <td>
                            <strong>{{ $p->siswa->nama_siswa ?? 'Tidak ditemukan' }}</strong>
                            <br><small class="text-muted">{{ $p->siswa->nis ?? '' }} - {{ $p->siswa->kelas->nama_kelas ?? '' }}</small>
                        </td>
                        <td><span class="badge bg-warning">{{ $p->jenisPelanggaran->nama ?? 'Tidak ditemukan' }}</span></td>
                        <td><span class="badge bg-danger">{{ $p->poin }}</span></td>
                        <td>{{ $p->guruPencatat->nama_guru ?? 'Tidak ditemukan' }}</td>
                        <td>{{ $p->keterangan ?? '-' }}</td>
                        <td>
                            <form action="/admin/add-to-monitoring" method="POST" class="d-inline">
                                @csrf
                                <input type="hidden" name="pelanggaran_id" value="{{ $p->id }}">
                                <div class="input-group input-group-sm mb-2">
                                    <select name="guru_kepsek" class="form-select" required>
                                        <option value="">Pilih Guru</option>
                                        @foreach($guru as $g)
                                        <option value="{{ $g->id }}">{{ $g->nama_guru }}</option>
                                        @endforeach
                                    </select>
                                    <button type="submit" class="btn btn-primary btn-sm">Monitor</button>
                                </div>
                                <textarea name="catatan" class="form-control form-control-sm" rows="1" placeholder="Catatan..."></textarea>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@else
<div class="alert alert-success">
    <i class="fas fa-check-circle me-2"></i>Semua pelanggaran sudah dimonitor!
</div>
@endif

<div class="card" style="border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
    <div class="card-header bg-info text-white">
        <h5 class="mb-0"><i class="fas fa-search me-2"></i>Data Monitoring Pelanggaran ({{ $monitoringPelanggaran->count() }})</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Siswa</th>
                        <th>Jenis Pelanggaran</th>
                        <th>Poin</th>
                        <th>Guru Kepsek</th>
                        <th>Status</th>
                        <th>Catatan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($monitoringPelanggaran as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            {{ $item->pelanggaran->siswa->nama_siswa ?? 'Siswa tidak ditemukan' }}
                            <br><small class="text-muted">{{ $item->pelanggaran->siswa->nis ?? '' }}</small>
                        </td>
                        <td>
                            <strong>{{ $item->pelanggaran->jenisPelanggaran->nama ?? 'Jenis tidak ditemukan' }}</strong>
                            <br><small class="text-muted">{{ $item->pelanggaran->keterangan ?? '' }}</small>
                        </td>
                        <td><span class="badge bg-danger">{{ $item->pelanggaran->poin ?? 0 }}</span></td>
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
                        <td>
                            <button class="btn btn-warning btn-sm me-1" onclick="editMonitoring({{ $item->id }}, {{ $item->pelanggaran_id }}, {{ $item->guru_kepsek ?? 'null' }}, '{{ $item->status }}', '{{ $item->catatan }}')"
                                    data-bs-toggle="modal" data-bs-target="#modalEditMonitoring">
                                <i class="fas fa-edit"></i>
                            </button>
                            <form action="/admin/delete-monitoring-pelanggaran/{{ $item->id }}" method="POST" style="display: inline;" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
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
                        <td colspan="8" class="text-center text-muted">
                            <i class="fas fa-inbox fa-3x mb-3"></i>
                            <br>Belum ada data monitoring pelanggaran
                            <br><small>Silakan tambah monitoring pelanggaran baru</small>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection