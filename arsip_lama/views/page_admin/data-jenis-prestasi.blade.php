@extends('layouts.admin')

@section('title', 'Data Jenis Prestasi')
@section('page-title', 'Data Jenis Prestasi')

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
    <div class="card-header bg-success text-white">
        <h5 class="mb-0"><i class="fas fa-medal me-2"></i>Data Jenis Prestasi</h5>
    </div>
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h6 class="mb-0">Daftar Jenis Prestasi</h6>
            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambahJenisPrestasi">
                <i class="fas fa-plus me-1"></i>Tambah Jenis Prestasi
            </button>
        </div>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Nama Prestasi</th>
                        <th>Kategori</th>
                        <th>Poin</th>
                        <th>Deskripsi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($jenisPrestasi as $index => $jp)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $jp->nama_prestasi }}</td>
                        <td>
                            <span class="badge 
                                @if($jp->kategori == 'akademik') bg-primary
                                @elseif($jp->kategori == 'non_akademik') bg-success
                                @else bg-info
                                @endif">
                                {{ ucfirst(str_replace('_', ' ', $jp->kategori)) }}
                            </span>
                        </td>
                        <td><span class="badge bg-success">{{ $jp->poin }}</span></td>
                        <td>{{ $jp->deskripsi ?? '-' }}</td>
                        <td>
                            <button class="btn btn-warning btn-sm me-1" onclick="editJenisPrestasi({{ $jp->id }}, '{{ $jp->nama_prestasi }}', '{{ $jp->kategori }}', {{ $jp->poin }}, '{{ $jp->deskripsi }}')"
                                    data-bs-toggle="modal" data-bs-target="#modalEditJenisPrestasi">
                                <i class="fas fa-edit"></i>
                            </button>
                            <form action="/admin/delete-jenis-prestasi/{{ $jp->id }}" method="POST" style="display: inline;" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
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

<!-- Modal Tambah Jenis Prestasi -->
<div class="modal fade" id="modalTambahJenisPrestasi" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Jenis Prestasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formJenisPrestasi" action="/admin/store-jenis-prestasi" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Nama Prestasi</label>
                        <input type="text" name="nama_prestasi" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kategori</label>
                        <select name="kategori" class="form-control" required>
                            <option value="">Pilih Kategori</option>
                            <option value="akademik">Akademik</option>
                            <option value="non_akademik">Non Akademik</option>
                            <option value="olahraga">Olahraga</option>
                            <option value="seni">Seni</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Poin</label>
                        <input type="number" name="poin" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control" rows="3"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" form="formJenisPrestasi" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Jenis Prestasi -->
<div class="modal fade" id="modalEditJenisPrestasi" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Jenis Prestasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formEditJenisPrestasi" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label">Nama Prestasi</label>
                        <input type="text" name="nama_prestasi" id="edit_nama_prestasi" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kategori</label>
                        <select name="kategori" id="edit_kategori" class="form-control" required>
                            <option value="">Pilih Kategori</option>
                            <option value="akademik">Akademik</option>
                            <option value="non_akademik">Non Akademik</option>
                            <option value="olahraga">Olahraga</option>
                            <option value="seni">Seni</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Poin</label>
                        <input type="number" name="poin" id="edit_poin" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="deskripsi" id="edit_deskripsi" class="form-control" rows="3"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" form="formEditJenisPrestasi" class="btn btn-warning">Update</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function editJenisPrestasi(id, nama, kategori, poin, deskripsi) {
        document.getElementById('formEditJenisPrestasi').action = '/admin/update-jenis-prestasi/' + id;
        document.getElementById('edit_nama_prestasi').value = nama;
        document.getElementById('edit_kategori').value = kategori;
        document.getElementById('edit_poin').value = poin;
        document.getElementById('edit_deskripsi').value = deskripsi || '';
    }
</script>
@endsection