@extends('layouts.admin')

@section('title', 'Data Orang Tua')
@section('page-title', 'Data Orang Tua')

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
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-users me-2"></i>Data Orang Tua</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="mb-0">Daftar Orang Tua</h6>
                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambahOrangtua">
                            <i class="fas fa-plus me-1"></i>Tambah Orang Tua
                        </button>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead class="table-dark">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Orang Tua</th>
                                    <th>Hubungan</th>
                                    <th>Nama Siswa</th>
                                    <th>Pekerjaan</th>
                                    <th>No. Telp</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($orangtua as $index => $o)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $o->nama_orangtua }}</td>
                                    <td><span class="badge bg-info">{{ ucfirst($o->hubungan) }}</span></td>
                                    <td>{{ $o->siswa->nama_siswa ?? '-' }}</td>
                                    <td>{{ $o->pekerjaan ?? '-' }}</td>
                                    <td>{{ $o->no_telp ?? '-' }}</td>
                                    <td>

                                        <form action="/admin/delete-orangtua/{{ $o->orangtua_id }}" method="POST" style="display: inline;" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
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
                                    <td colspan="7" class="text-center text-muted">Belum ada data orang tua</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Orang Tua -->
    <div class="modal fade" id="modalTambahOrangtua" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Orang Tua</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="formOrangtua" action="/admin/store-orangtua" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">User Account</label>
                            <select name="user_id" class="form-control" required>
                                <option value="">Pilih User</option>
                                @foreach($users as $u)
                                <option value="{{ $u->id }}">{{ $u->username }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Siswa</label>
                            <select name="siswa_id" class="form-control" required>
                                <option value="">Pilih Siswa</option>
                                @foreach($siswa as $s)
                                <option value="{{ $s->id }}">{{ $s->nama_siswa }} ({{ $s->nis }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Hubungan</label>
                            <select name="hubungan" class="form-control" required>
                                <option value="">Pilih Hubungan</option>
                                <option value="ayah">Ayah</option>
                                <option value="ibu">Ibu</option>
                                <option value="wali">Wali</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nama Orang Tua</label>
                            <input type="text" name="nama_orangtua" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Pekerjaan</label>
                            <input type="text" name="pekerjaan" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Pendidikan</label>
                            <input type="text" name="pendidikan" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">No. Telp</label>
                            <input type="text" name="no_telp" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Alamat</label>
                            <textarea name="alamat" class="form-control" rows="3"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" form="formOrangtua" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </div>
    </div>

<!-- Modal Edit Orang Tua -->
<div class="modal fade" id="modalEditOrangtua" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Orang Tua</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formEditOrangtua" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label">User Account</label>
                        <select name="user_id" id="edit_user_id" class="form-control" required>
                            <option value="">Pilih User</option>
                            @foreach($users as $u)
                            <option value="{{ $u->id }}">{{ $u->username }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Siswa</label>
                        <select name="siswa_id" id="edit_siswa_id" class="form-control" required>
                            <option value="">Pilih Siswa</option>
                            @foreach($siswa as $s)
                            <option value="{{ $s->id }}">{{ $s->nama_siswa }} ({{ $s->nis }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Hubungan</label>
                        <select name="hubungan" id="edit_hubungan" class="form-control" required>
                            <option value="">Pilih Hubungan</option>
                            <option value="ayah">Ayah</option>
                            <option value="ibu">Ibu</option>
                            <option value="wali">Wali</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama Orang Tua</label>
                        <input type="text" name="nama_orangtua" id="edit_nama_orangtua" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Pekerjaan</label>
                        <input type="text" name="pekerjaan" id="edit_pekerjaan" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Pendidikan</label>
                        <input type="text" name="pendidikan" id="edit_pendidikan" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">No. Telp</label>
                        <input type="text" name="no_telp" id="edit_no_telp" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Alamat</label>
                        <textarea name="alamat" id="edit_alamat" class="form-control" rows="3"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" form="formEditOrangtua" class="btn btn-warning">Update</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function editOrangtua(id, userId, siswaId, hubungan, nama, pekerjaan, pendidikan, noTelp, alamat) {
        document.getElementById('formEditOrangtua').action = '/admin/update-orangtua/' + id;
        document.getElementById('edit_user_id').value = userId;
        document.getElementById('edit_siswa_id').value = siswaId;
        document.getElementById('edit_hubungan').value = hubungan;
        document.getElementById('edit_nama_orangtua').value = nama;
        document.getElementById('edit_pekerjaan').value = pekerjaan || '';
        document.getElementById('edit_pendidikan').value = pendidikan || '';
        document.getElementById('edit_no_telp').value = noTelp || '';
        document.getElementById('edit_alamat').value = alamat || '';
    }
</script>
@endsection