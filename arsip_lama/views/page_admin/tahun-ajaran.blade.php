@extends('layouts.admin')

@section('title', 'Tahun Ajaran')
@section('page-title', 'Tahun Ajaran')

@section('content')
<div class="card" style="border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0"><i class="fas fa-calendar-alt me-2"></i>Tahun Ajaran</h5>
    </div>
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h6 class="mb-0">Daftar Tahun Ajaran</h6>
            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambahTahunAjaran">
                <i class="fas fa-plus me-1"></i>Tambah Tahun Ajaran
            </button>
        </div>
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Tahun Ajaran</th>
                        <th>Semester</th>
                        <th>Status</th>
                        <th>Tanggal Dibuat</th>
                        <th>Aksi</th>
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
                        <td>
                            <button class="btn btn-warning btn-sm me-1" onclick="editTahunAjaran({{ $item->id }}, '{{ $item->tahun_ajaran }}', '{{ $item->semester }}', {{ $item->status_aktif }})"
                                    data-bs-toggle="modal" data-bs-target="#modalEditTahunAjaran">
                                <i class="fas fa-edit"></i>
                            </button>
                            <form action="/admin/delete-tahun-ajaran/{{ $item->id }}" method="POST" style="display: inline;" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
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

<!-- Modal Tambah Tahun Ajaran -->
<div class="modal fade" id="modalTambahTahunAjaran" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Tahun Ajaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formTahunAjaran" action="/admin/store-tahun-ajaran" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Tahun Ajaran</label>
                        <input type="text" name="tahun_ajaran" class="form-control" placeholder="2024/2025" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Semester</label>
                        <select name="semester" class="form-control" required>
                            <option value="">Pilih Semester</option>
                            <option value="Ganjil">Ganjil</option>
                            <option value="Genap">Genap</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status_aktif" class="form-control" required>
                            <option value="0">Tidak Aktif</option>
                            <option value="1">Aktif</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" form="formTahunAjaran" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Tahun Ajaran -->
<div class="modal fade" id="modalEditTahunAjaran" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Tahun Ajaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formEditTahunAjaran" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label">Tahun Ajaran</label>
                        <input type="text" name="tahun_ajaran" id="edit_tahun_ajaran" class="form-control" placeholder="2024/2025" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Semester</label>
                        <select name="semester" id="edit_semester" class="form-control" required>
                            <option value="">Pilih Semester</option>
                            <option value="Ganjil">Ganjil</option>
                            <option value="Genap">Genap</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status_aktif" id="edit_status_aktif" class="form-control" required>
                            <option value="0">Tidak Aktif</option>
                            <option value="1">Aktif</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" form="formEditTahunAjaran" class="btn btn-warning">Update</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function editTahunAjaran(id, tahunAjaran, semester, statusAktif) {
        document.getElementById('formEditTahunAjaran').action = '/admin/update-tahun-ajaran/' + id;
        document.getElementById('edit_tahun_ajaran').value = tahunAjaran;
        document.getElementById('edit_semester').value = semester;
        document.getElementById('edit_status_aktif').value = statusAktif;
    }
</script>
@endsection