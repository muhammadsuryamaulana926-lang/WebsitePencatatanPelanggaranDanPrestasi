@extends('layouts.admin')

@section('title', 'Manajemen User')
@section('page-title', 'Manajemen User')

@section('content')
<div class="card" style="border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
    <div class="card-header bg-dark text-white">
        <h5 class="mb-0"><i class="fas fa-users-cog me-2"></i>Manajemen User</h5>
    </div>
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h6 class="mb-0">Daftar User Sistem</h6>
            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambahUser">
                <i class="fas fa-plus me-1"></i>Tambah User
            </button>
        </div>
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Username</th>
                        <th>Level</th>
                        <th>Can Verify</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $index => $user)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td><strong>{{ $user->username }}</strong></td>
                        <td>
                            <span class="badge 
                                @if($user->level == 'admin') bg-danger
                                @elseif($user->level == 'guru') bg-warning
                                @elseif($user->level == 'bk') bg-info
                                @elseif($user->level == 'kepalasekolah') bg-dark
                                @elseif($user->level == 'kesiswaan') bg-primary
                                @elseif($user->level == 'walikelas') bg-secondary
                                @elseif($user->level == 'siswa') bg-success
                                @else bg-light text-dark
                                @endif">
                                {{ strtoupper($user->level) }}
                            </span>
                        </td>

                        <td>
                            @if($user->can_verify)
                                <span class="badge bg-success">Ya</span>
                            @else
                                <span class="badge bg-secondary">Tidak</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge bg-success">Aktif</span>
                        </td>
                        <td>
                            <button class="btn btn-warning btn-sm me-1" onclick="editUser({{ $user->id }}, '{{ $user->username }}', '{{ $user->level }}', {{ $user->guru_id ?? 'null' }}, {{ $user->can_verify ? 'true' : 'false' }})"
                                    data-bs-toggle="modal" data-bs-target="#modalEditUser">
                                <i class="fas fa-edit"></i>
                            </button>
                            <form action="/admin/delete-user/{{ $user->id }}" method="POST" style="display: inline;" onsubmit="return confirm('Yakin ingin menghapus user ini?')">
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

<!-- Modal Tambah User -->
<div class="modal fade" id="modalTambahUser" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah User Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formUser" action="/admin/manajemen-user" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" name="username" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Level</label>
                        <select name="level" id="add_level" class="form-control" required onchange="toggleGuruSelect('add')">
                            <option value="">Pilih Level</option>
                            <option value="admin">Admin</option>
                            <option value="guru">Guru</option>
                            <option value="bk">BK (Bimbingan Konseling)</option>
                            <option value="kepalasekolah">Kepala Sekolah</option>
                            <option value="kesiswaan">Kesiswaan</option>
                            <option value="walikelas">Wali Kelas</option>
                            <option value="siswa">Siswa</option>
                            <option value="ortu">Orang Tua</option>
                        </select>
                    </div>
                    <div class="mb-3" id="add_guru_select" style="display: none;">
                        <label class="form-label">Pilih Guru</label>
                        <select name="guru_id" class="form-control">
                            <option value="">Pilih Guru</option>
                            @foreach($guru as $g)
                            <option value="{{ $g->id }}">{{ $g->nama_guru }} ({{ $g->bidang_studi }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Hak Verifikasi</label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="can_verify" id="add_can_verify">
                            <label class="form-check-label" for="add_can_verify">
                                Dapat melakukan verifikasi data
                            </label>
                        </div>
                        <small class="text-muted"> untuk Admin, BK, Kepala Sekolah, Kesiswaan</small>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" form="formUser" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit User -->
<div class="modal fade" id="modalEditUser" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formEditUser" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" name="username" id="edit_username" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Password (kosongkan jika tidak ingin mengubah)</label>
                        <input type="password" name="password" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Level</label>
                        <select name="level" id="edit_level" class="form-control" required onchange="toggleGuruSelect('edit')">
                            <option value="">Pilih Level</option>
                            <option value="admin">Admin</option>
                            <option value="guru">Guru</option>
                            <option value="bk">BK (Bimbingan Konseling)</option>
                            <option value="kepalasekolah">Kepala Sekolah</option>
                            <option value="kesiswaan">Kesiswaan</option>
                            <option value="walikelas">Wali Kelas</option>
                            <option value="siswa">Siswa</option>
                            <option value="ortu">Orang Tua</option>
                        </select>
                    </div>
                    <div class="mb-3" id="edit_guru_select" style="display: none;">
                        <label class="form-label">Pilih Guru</label>
                        <select name="guru_id" id="edit_guru_id" class="form-control">
                            <option value="">Pilih Guru</option>
                            @foreach($guru as $g)
                            <option value="{{ $g->id }}">{{ $g->nama_guru }} ({{ $g->bidang_studi }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Hak Verifikasi</label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="can_verify" id="edit_can_verify">
                            <label class="form-check-label" for="edit_can_verify">
                                Dapat melakukan verifikasi data
                            </label>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" form="formEditUser" class="btn btn-warning">Update</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function editUser(id, username, level, guruId, canVerify) {
        document.getElementById('formEditUser').action = '/admin/update-user/' + id;
        document.getElementById('edit_username').value = username;
        document.getElementById('edit_level').value = level;
        document.getElementById('edit_guru_id').value = guruId || '';
        document.getElementById('edit_can_verify').checked = canVerify;
        toggleGuruSelect('edit');
    }

    function toggleGuruSelect(type) {
        const levelSelect = document.getElementById(type + '_level');
        const guruDiv = document.getElementById(type + '_guru_select');
        const needsGuru = ['guru', 'bk', 'kepalasekolah', 'kesiswaan', 'walikelas'];
        
        if (needsGuru.includes(levelSelect.value)) {
            guruDiv.style.display = 'block';
        } else {
            guruDiv.style.display = 'none';
        }
    }
</script>
@endsection