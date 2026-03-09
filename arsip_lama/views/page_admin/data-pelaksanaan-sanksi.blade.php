@extends('layouts.admin')

@section('title', 'Data Pelaksanaan Sanksi')
@section('page-title', 'Data Pelaksanaan Sanksi')

@section('content')
<div class="card" style="border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
    <div class="card-header bg-dark text-white">
        <h5 class="mb-0"><i class="fas fa-tasks me-2"></i>Data Pelaksanaan Sanksi</h5>
    </div>
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h6 class="mb-0">Daftar Pelaksanaan Sanksi</h6>
            <button class="btn btn-primary btn-sm" onclick="showTambahPelaksanaanSanksi()">
                <i class="fas fa-plus me-1"></i>Tambah Pelaksanaan Sanksi
            </button>
        </div>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Siswa</th>
                        <th>Jenis Sanksi</th>
                        <th>Tanggal Pelaksanaan</th>
                        <th>Bukti</th>
                        <th>Status</th>
                        <th>Catatan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pelaksanaanSanksi as $index => $ps)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $ps->sanksi->pelanggaran->siswa->nama_siswa ?? '-' }}</td>
                        <td>{{ $ps->sanksi->jenis_sanksi ?? '-' }}</td>
                        <td>{{ date('d/m/Y', strtotime($ps->tanggal_pelaksanaan)) }}</td>
                        <td>
                            @if($ps->bukti)
                                @php
                                    $fileExtension = pathinfo($ps->bukti, PATHINFO_EXTENSION);
                                    $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
                                @endphp
                                @if(in_array(strtolower($fileExtension), $imageExtensions))
                                    <img src="{{ asset('storage/' . $ps->bukti) }}" alt="Bukti" class="img-thumbnail" style="max-width: 100px; max-height: 80px; cursor: pointer;" onclick="showImageModal('{{ asset('storage/' . $ps->bukti) }}')">
                                @else
                                    <div class="text-center">
                                        <i class="fas fa-file-{{ $fileExtension == 'pdf' ? 'pdf' : 'alt' }} fa-2x text-primary"></i>
                                        <br><small>{{ strtoupper($fileExtension) }}</small>
                                        <br><a href="{{ asset('storage/' . $ps->bukti) }}" target="_blank" class="btn btn-xs btn-outline-primary">Buka</a>
                                    </div>
                                @endif
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            <span class="badge 
                                @if($ps->status == 'terjadwal') bg-secondary
                                @elseif($ps->status == 'dikerjakan') bg-info
                                @elseif($ps->status == 'tuntas') bg-success
                                @elseif($ps->status == 'terlambat') bg-danger
                                @else bg-warning
                                @endif">
                                {{ ucfirst($ps->status) }}
                            </span>
                        </td>
                        <td>{{ $ps->catatan ?? '-' }}</td>
                        <td>
                            <button class="btn btn-warning btn-sm me-1" onclick="editPelaksanaanSanksi({{ $ps->id }}, {{ $ps->sanksi_id }}, '{{ $ps->tanggal_pelaksanaan }}', '{{ $ps->bukti }}', '{{ $ps->status }}', '{{ $ps->catatan }}')"
                                    data-bs-toggle="modal" data-bs-target="#modalEditPelaksanaanSanksi">
                                <i class="fas fa-edit"></i>
                            </button>
                            <form action="/admin/delete-pelaksanaan-sanksi/{{ $ps->id }}" method="POST" style="display: inline;" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
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

<!-- Modal Tambah Pelaksanaan Sanksi -->
<div class="modal fade" id="modalTambahPelaksanaanSanksi" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Pelaksanaan Sanksi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formPelaksanaanSanksi" action="/admin/store-pelaksanaan-sanksi" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Sanksi</label>
                        <select name="sanksi_id" class="form-control" required>
                            <option value="">Pilih Sanksi</option>
                            @foreach($sanksi as $s)
                            <option value="{{ $s->id }}">{{ $s->pelanggaran->siswa->nama_siswa ?? '-' }} - {{ $s->jenis_sanksi }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tanggal Pelaksanaan</label>
                        <input type="date" name="tanggal_pelaksanaan" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Bukti (Foto/File)</label>
                        <input type="file" name="bukti" class="form-control" accept="image/*,.pdf,.doc,.docx">
                        <small class="text-muted">Format: JPG, PNG, PDF, DOC, DOCX (Max: 5MB)</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-control" required>
                            <option value="terjadwal">Terjadwal</option>
                            <option value="dikerjakan">Dikerjakan</option>
                            <option value="tuntas">Tuntas</option>
                            <option value="terlambat">Terlambat</option>
                            <option value="perpanjangan">Perpanjangan</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Catatan</label>
                        <textarea name="catatan" class="form-control" rows="3"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" form="formPelaksanaanSanksi" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Pelaksanaan Sanksi -->
<div class="modal fade" id="modalEditPelaksanaanSanksi" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Pelaksanaan Sanksi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formEditPelaksanaanSanksi" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label">Sanksi</label>
                        <select name="sanksi_id" id="edit_sanksi_id" class="form-control" required>
                            <option value="">Pilih Sanksi</option>
                            @foreach($sanksi as $s)
                            <option value="{{ $s->id }}">{{ $s->pelanggaran->siswa->nama_siswa ?? '-' }} - {{ $s->jenis_sanksi }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tanggal Pelaksanaan</label>
                        <input type="date" name="tanggal_pelaksanaan" id="edit_tanggal_pelaksanaan" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Bukti (Foto/File)</label>
                        <input type="file" name="bukti" class="form-control" accept="image/*,.pdf,.doc,.docx">
                        <small class="text-muted">Format: JPG, PNG, PDF, DOC, DOCX (Max: 5MB)</small>
                        <div id="current_bukti" class="mt-2"></div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" id="edit_status" class="form-control" required>
                            <option value="terjadwal">Terjadwal</option>
                            <option value="dikerjakan">Dikerjakan</option>
                            <option value="tuntas">Tuntas</option>
                            <option value="terlambat">Terlambat</option>
                            <option value="perpanjangan">Perpanjangan</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Catatan</label>
                        <textarea name="catatan" id="edit_catatan" class="form-control" rows="3"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" form="formEditPelaksanaanSanksi" class="btn btn-warning">Update</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Preview Gambar -->
<div class="modal fade" id="imagePreviewModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Preview Bukti</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <img id="previewImage" src="" alt="Preview" class="img-fluid" style="max-height: 500px;">
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function showTambahPelaksanaanSanksi() {
    const modal = new bootstrap.Modal(document.getElementById('modalTambahPelaksanaanSanksi'));
    modal.show();
}

function editPelaksanaanSanksi(id, sanksiId, tanggal, bukti, status, catatan) {
    document.getElementById('formEditPelaksanaanSanksi').action = '/admin/update-pelaksanaan-sanksi/' + id;
    document.getElementById('edit_sanksi_id').value = sanksiId;
    document.getElementById('edit_tanggal_pelaksanaan').value = tanggal;
    document.getElementById('edit_status').value = status;
    document.getElementById('edit_catatan').value = catatan || '';
    
    // Tampilkan file bukti yang sudah ada
    const currentBuktiDiv = document.getElementById('current_bukti');
    if (bukti) {
        currentBuktiDiv.innerHTML = `
            <div class="alert alert-info p-2">
                <small><strong>File saat ini:</strong> ${bukti}</small>
                <br><small class="text-muted">Upload file baru untuk mengganti</small>
            </div>
        `;
    } else {
        currentBuktiDiv.innerHTML = '';
    }
}

function showImageModal(imageSrc) {
    document.getElementById('previewImage').src = imageSrc;
    const modal = new bootstrap.Modal(document.getElementById('imagePreviewModal'));
    modal.show();
}
</script>
@endsection