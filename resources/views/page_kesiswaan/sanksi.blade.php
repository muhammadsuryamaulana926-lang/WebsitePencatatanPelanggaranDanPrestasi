@extends('layouts.kesiswaan')

@section('title', 'Data Sanksi - Kesiswaan')
@section('page-title', 'Data Sanksi')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Data Sanksi</h5>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addSanksiModal">
                        <i class="fas fa-plus"></i> Tambah Sanksi
                    </button>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Siswa</th>
                                    <th>Pelanggaran</th>
                                    <th>Jenis Sanksi</th>
                                    <th>Status Sanksi</th>
                                    <th>Pelaksanaan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($sanksi as $index => $s)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        {{ $s->pelanggaran->siswa->nama_siswa }}<br>
                                        <small class="text-muted">{{ $s->pelanggaran->siswa->kelas->nama_kelas }}</small>
                                    </td>
                                    <td>{{ $s->pelanggaran->jenisPelanggaran->nama_pelanggaran }}</td>
                                    <td>
                                        <strong>{{ $s->jenis_sanksi }}</strong><br>
                                        @if($s->deskripsi)
                                            <small class="text-muted">{{ $s->deskripsi }}</small><br>
                                        @endif
                                        <small class="text-info">
                                            {{ $s->tanggal_mulai ? date('d/m/Y', strtotime($s->tanggal_mulai)) : '-' }} - 
                                            {{ $s->tanggal_selesai ? date('d/m/Y', strtotime($s->tanggal_selesai)) : '-' }}
                                        </small>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ 
                                            $s->status == 'selesai' ? 'success' : 
                                            ($s->status == 'berjalan' ? 'primary' : 
                                            ($s->status == 'ditunda' ? 'warning' : 
                                            ($s->status == 'dibatalkan' ? 'danger' : 'secondary'))) 
                                        }}">
                                            {{ ucfirst($s->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($s->pelaksanaanSanksi->count() > 0)
                                            @foreach($s->pelaksanaanSanksi as $pelaksanaan)
                                                <div class="mb-2 p-2 border rounded">
                                                    <small class="d-block">
                                                        <strong>{{ date('d/m/Y', strtotime($pelaksanaan->tanggal_pelaksanaan)) }}</strong>
                                                    </small>
                                                    <div class="d-flex align-items-center gap-2 mb-1">
                                                        <form action="/kesiswaan/update-status-pelaksanaan/{{ $pelaksanaan->id }}" method="POST" class="d-inline">
                                                            @csrf
                                                            @method('PUT')
                                                            <select name="status" class="form-select form-select-sm" onchange="this.form.submit()" style="width: auto;">
                                                                <option value="terjadwal" {{ $pelaksanaan->status == 'terjadwal' ? 'selected' : '' }}>Terjadwal</option>
                                                                <option value="dikerjakan" {{ $pelaksanaan->status == 'dikerjakan' ? 'selected' : '' }}>Dikerjakan</option>
                                                                <option value="tuntas" {{ $pelaksanaan->status == 'tuntas' ? 'selected' : '' }}>Tuntas</option>
                                                                <option value="terlambat" {{ $pelaksanaan->status == 'terlambat' ? 'selected' : '' }}>Terlambat</option>
                                                                <option value="perpanjangan" {{ $pelaksanaan->status == 'perpanjangan' ? 'selected' : '' }}>Perpanjangan</option>
                                                            </select>
                                                        </form>
                                                    </div>
                                                    @if($pelaksanaan->catatan)
                                                        <small class="text-muted d-block">{{ $pelaksanaan->catatan }}</small>
                                                    @endif
                                                    @if($pelaksanaan->bukti)
                                                        <small class="text-success d-block">
                                                            <a href="/kesiswaan/lihat-bukti/{{ $pelaksanaan->id }}" target="_blank" class="text-success text-decoration-none">
                                                                <i class="fas fa-paperclip"></i> Lihat Bukti
                                                            </a>
                                                        </small>
                                                    @endif
                                                </div>
                                            @endforeach
                                        @else
                                            <small class="text-muted">Belum ada laporan pelaksanaan</small>
                                        @endif
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-warning" onclick="editSanksi({{ $s->id }})">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <form action="/kesiswaan/delete-sanksi/{{ $s->id }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Sanksi -->
<div class="modal fade" id="addSanksiModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Sanksi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="/kesiswaan/store-sanksi" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Pelanggaran</label>
                        <select name="pelanggaran_id" class="form-control" required>
                            <option value="">Pilih Pelanggaran</option>
                            @foreach($pelanggaran as $p)
                            <option value="{{ $p->id }}">
                                {{ $p->siswa->nama_siswa }} - {{ $p->jenisPelanggaran->nama_pelanggaran }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jenis Sanksi</label>
                        <input type="text" name="jenis_sanksi" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Tanggal Mulai</label>
                                <input type="date" name="tanggal_mulai" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Tanggal Selesai</label>
                                <input type="date" name="tanggal_selesai" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-control" required>
                            <option value="direncanakan">Direncanakan</option>
                            <option value="berjalan">Berjalan</option>
                            <option value="selesai">Selesai</option>
                            <option value="ditunda">Ditunda</option>
                            <option value="dibatalkan">Dibatalkan</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Sanksi -->
<div class="modal fade" id="editSanksiModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Sanksi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editSanksiForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Pelanggaran</label>
                        <select name="pelanggaran_id" id="edit_pelanggaran_id" class="form-control" required>
                            @foreach($pelanggaran as $p)
                            <option value="{{ $p->id }}">
                                {{ $p->siswa->nama_siswa }} - {{ $p->jenisPelanggaran->nama_pelanggaran }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jenis Sanksi</label>
                        <input type="text" name="jenis_sanksi" id="edit_jenis_sanksi" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="deskripsi" id="edit_deskripsi" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Tanggal Mulai</label>
                                <input type="date" name="tanggal_mulai" id="edit_tanggal_mulai" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Tanggal Selesai</label>
                                <input type="date" name="tanggal_selesai" id="edit_tanggal_selesai" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" id="edit_status" class="form-control" required>
                            <option value="direncanakan">Direncanakan</option>
                            <option value="berjalan">Berjalan</option>
                            <option value="selesai">Selesai</option>
                            <option value="ditunda">Ditunda</option>
                            <option value="dibatalkan">Dibatalkan</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function editSanksi(id) {
    fetch(`/kesiswaan/sanksi/${id}`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('edit_pelanggaran_id').value = data.pelanggaran_id;
            document.getElementById('edit_jenis_sanksi').value = data.jenis_sanksi;
            document.getElementById('edit_deskripsi').value = data.deskripsi || '';
            document.getElementById('edit_tanggal_mulai').value = data.tanggal_mulai || '';
            document.getElementById('edit_tanggal_selesai').value = data.tanggal_selesai || '';
            document.getElementById('edit_status').value = data.status;
            
            document.getElementById('editSanksiForm').action = `/kesiswaan/update-sanksi/${id}`;
            new bootstrap.Modal(document.getElementById('editSanksiModal')).show();
        });
}
</script>
@endsection