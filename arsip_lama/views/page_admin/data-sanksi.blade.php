@extends('layouts.admin')

@section('title', 'Data Sanksi')
@section('page-title', 'Data Sanksi')

@section('content')
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        @foreach($errors->all() as $error)
            {{ $error }}<br>
        @endforeach
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="card" style="border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
    <div class="card-header bg-danger text-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="fas fa-gavel me-2"></i>Data Sanksi</h5>
        <button class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#tambahSanksiModal">
            <i class="fas fa-plus me-1"></i> Tambah Sanksi
        </button>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Siswa</th>
                        <th>Jenis Sanksi</th>
                        <th>Deskripsi</th>
                        <th>Tanggal Mulai</th>
                        <th>Tanggal Selesai</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sanksi as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->pelanggaran->siswa->nama_siswa ?? 'Tidak ditemukan' }}</td>
                        <td><strong>{{ $item->jenis_sanksi }}</strong></td>
                        <td>{{ $item->deskripsi ?? '-' }}</td>
                        <td>{{ $item->tanggal_mulai ? date('d/m/Y', strtotime($item->tanggal_mulai)) : '-' }}</td>
                        <td>{{ $item->tanggal_selesai ? date('d/m/Y', strtotime($item->tanggal_selesai)) : '-' }}</td>
                        <td>
                            @if($item->status == 'direncanakan')
                                <span class="badge bg-secondary">Direncanakan</span>
                            @elseif($item->status == 'berjalan')
                                <span class="badge bg-info">Berjalan</span>
                            @elseif($item->status == 'selesai')
                                <span class="badge bg-success">Selesai</span>
                            @elseif($item->status == 'ditunda')
                                <span class="badge bg-warning">Ditunda</span>
                            @else
                                <span class="badge bg-danger">Dibatalkan</span>
                            @endif
                        </td>
                        <td>
                            <button class="btn btn-sm btn-warning me-1" onclick="editSanksi({{ $item->id }}, {{ $item->pelanggaran_id }}, '{{ $item->jenis_sanksi }}', '{{ $item->deskripsi }}', '{{ $item->tanggal_mulai }}', '{{ $item->tanggal_selesai }}', '{{ $item->status }}')"
                                    data-bs-toggle="modal" data-bs-target="#editSanksiModal">
                                <i class="fas fa-edit"></i>
                            </button>
                            <form action="/admin/delete-sanksi/{{ $item->id }}" method="POST" style="display: inline;" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
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

<!-- Modal Tambah Sanksi -->
<div class="modal fade" id="tambahSanksiModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">Tambah Sanksi Baru</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="/admin/store-sanksi" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Pelanggaran</label>
                        <select name="pelanggaran_id" id="pelanggaran_id" class="form-select" required onchange="getSanksiOtomatis()">
                            <option value="">Pilih Pelanggaran</option>
                            @foreach($pelanggaran as $p)
                            <option value="{{ $p->id }}">{{ $p->siswa->nama_siswa ?? 'Siswa tidak ditemukan' }} - {{ $p->jenisPelanggaran->nama_pelanggaran ?? 'Jenis tidak ditemukan' }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="alert alert-info" id="info_poin" style="display: none;">
                        <small><i class="fas fa-info-circle"></i> <span id="poin_text"></span></small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jenis Sanksi <small class="text-muted">(Otomatis berdasarkan total poin)</small></label>
                        <input type="text" name="jenis_sanksi" id="jenis_sanksi" class="form-control" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="deskripsi" id="deskripsi" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label">Tanggal Mulai</label>
                            <input type="date" name="tanggal_mulai" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tanggal Selesai</label>
                            <input type="date" name="tanggal_selesai" class="form-control">
                        </div>
                    </div>
                    <div class="mb-3 mt-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
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
                    <button type="submit" class="btn btn-danger">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Sanksi -->
<div class="modal fade" id="editSanksiModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">Edit Sanksi</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="formEditSanksi" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Pelanggaran</label>
                        <select name="pelanggaran_id" id="edit_pelanggaran_id" class="form-select" required>
                            <option value="">Pilih Pelanggaran</option>
                            @foreach($pelanggaran as $p)
                            <option value="{{ $p->id }}">{{ $p->siswa->nama_siswa ?? 'Siswa tidak ditemukan' }} - {{ $p->jenisPelanggaran->nama_pelanggaran ?? 'Jenis tidak ditemukan' }}</option>
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
                            <label class="form-label">Tanggal Mulai</label>
                            <input type="date" name="tanggal_mulai" id="edit_tanggal_mulai" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tanggal Selesai</label>
                            <input type="date" name="tanggal_selesai" id="edit_tanggal_selesai" class="form-control">
                        </div>
                    </div>
                    <div class="mb-3 mt-3">
                        <label class="form-label">Status</label>
                        <select name="status" id="edit_status" class="form-select">
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
                    <button type="submit" class="btn btn-warning">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function editSanksi(id, pelanggaranId, jenisSanksi, deskripsi, tanggalMulai, tanggalSelesai, status) {
        document.getElementById('formEditSanksi').action = '/admin/update-sanksi/' + id;
        document.getElementById('edit_pelanggaran_id').value = pelanggaranId;
        document.getElementById('edit_jenis_sanksi').value = jenisSanksi;
        document.getElementById('edit_deskripsi').value = deskripsi || '';
        document.getElementById('edit_tanggal_mulai').value = tanggalMulai || '';
        document.getElementById('edit_tanggal_selesai').value = tanggalSelesai || '';
        document.getElementById('edit_status').value = status;
    }

    function getSanksiOtomatis() {
        const pelanggaranId = document.getElementById('pelanggaran_id').value;
        
        if (!pelanggaranId) {
            document.getElementById('jenis_sanksi').value = '';
            document.getElementById('deskripsi').value = '';
            document.getElementById('info_poin').style.display = 'none';
            return;
        }

        fetch(`/admin/get-sanksi-otomatis?pelanggaran_id=${pelanggaranId}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('jenis_sanksi').value = data.jenis_sanksi;
                document.getElementById('deskripsi').value = data.deskripsi;
                document.getElementById('poin_text').textContent = `Total poin pelanggaran siswa: ${data.total_poin} poin`;
                document.getElementById('info_poin').style.display = 'block';
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Gagal mengambil data sanksi otomatis');
            });
    }
</script>
@endsection