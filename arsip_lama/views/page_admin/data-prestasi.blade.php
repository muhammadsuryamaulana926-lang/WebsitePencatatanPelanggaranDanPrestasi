@extends('layouts.admin')

@section('title', 'Data Prestasi')
@section('page-title', 'Data Prestasi')

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
        <h5 class="mb-0"><i class="fas fa-trophy me-2"></i>Data Prestasi</h5>
    </div>
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h6 class="mb-0">Daftar Prestasi Siswa</h6>
            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambahPrestasi">
                <i class="fas fa-plus me-1"></i>Tambah Prestasi
            </button>
        </div>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Siswa</th>
                        <th>Jenis Prestasi</th>
                        <th>Poin</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($prestasi as $index => $p)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $p->siswa->nama_siswa ?? '-' }}</td>
                        <td>{{ $p->jenisPrestasi->nama_prestasi ?? '-' }}</td>
                        <td><span class="badge bg-success">{{ $p->poin }}</span></td>
                        <td>
                            <span class="badge 
                                @if($p->status_verifikasi == 'menunggu') bg-warning
                                @elseif($p->status_verifikasi == 'disetujui') bg-success
                                @else bg-danger
                                @endif">
                                {{ ucfirst($p->status_verifikasi) }}
                            </span>
                        </td>
                        <td>
                            <button class="btn btn-warning btn-sm me-1" onclick="editPrestasi({{ $p->id }}, {{ $p->siswa_id }}, {{ $p->jenis_prestasi_id }}, {{ $p->tahun_ajaran_id }}, '{{ $p->keterangan }}')"
                                    data-bs-toggle="modal" data-bs-target="#modalEditPrestasi">
                                <i class="fas fa-edit"></i>
                            </button>
                            <form action="/admin/delete-prestasi/{{ $p->id }}" method="POST" style="display: inline;" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
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

<!-- Modal Tambah Prestasi -->
<div class="modal fade" id="modalTambahPrestasi" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Prestasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formPrestasi" action="/admin/store-prestasi" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Siswa</label>
                        <select name="siswa_id" class="form-control" required>
                            <option value="">Pilih Siswa</option>
                            @foreach($siswa as $s)
                            <option value="{{ $s->id }}">{{ $s->nama_siswa }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jenis Prestasi</label>
                        <select name="jenis_prestasi_id" class="form-control" required onchange="setPoinPrestasi(this)">
                            <option value="">Pilih Jenis Prestasi</option>
                            @foreach($jenisPrestasi as $jp)
                            <option value="{{ $jp->id }}" data-poin="{{ $jp->poin }}">{{ $jp->nama_prestasi }} ({{ $jp->poin }} poin)</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Poin</label>
                        <input type="number" name="poin" class="form-control" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tahun Ajaran</label>
                        <select name="tahun_ajaran_id" class="form-control" required>
                            <option value="">Pilih Tahun Ajaran</option>
                            @foreach($tahunAjaran as $ta)
                            <option value="{{ $ta->id }}" {{ $ta->status_aktif ? 'selected' : '' }}>{{ $ta->tahun_ajaran }} - {{ $ta->semester }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Keterangan</label>
                        <textarea name="keterangan" class="form-control" rows="3"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" form="formPrestasi" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Prestasi -->
<div class="modal fade" id="modalEditPrestasi" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Prestasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formEditPrestasi" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label">Siswa</label>
                        <select name="siswa_id" id="edit_siswa_id" class="form-control" required>
                            <option value="">Pilih Siswa</option>
                            @foreach($siswa as $s)
                            <option value="{{ $s->id }}">{{ $s->nama_siswa }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jenis Prestasi</label>
                        <select name="jenis_prestasi_id" id="edit_jenis_prestasi_id" class="form-control" required onchange="setEditPoinPrestasi(this)">
                            <option value="">Pilih Jenis Prestasi</option>
                            @foreach($jenisPrestasi as $jp)
                            <option value="{{ $jp->id }}" data-poin="{{ $jp->poin }}">{{ $jp->nama_prestasi }} ({{ $jp->poin }} poin)</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Poin</label>
                        <input type="number" name="poin" id="edit_poin_prestasi" class="form-control" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tahun Ajaran</label>
                        <select name="tahun_ajaran_id" id="edit_tahun_ajaran_id" class="form-control" required>
                            <option value="">Pilih Tahun Ajaran</option>
                            @foreach($tahunAjaran as $ta)
                            <option value="{{ $ta->id }}">{{ $ta->tahun_ajaran }} - {{ $ta->semester }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Keterangan</label>
                        <textarea name="keterangan" id="edit_keterangan" class="form-control" rows="3"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" form="formEditPrestasi" class="btn btn-warning">Update</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function setPoinPrestasi(select) {
        const poin = select.options[select.selectedIndex].getAttribute('data-poin');
        document.querySelector('input[name="poin"]').value = poin || '';
    }
    
    function setEditPoinPrestasi(select) {
        const poin = select.options[select.selectedIndex].getAttribute('data-poin');
        document.getElementById('edit_poin_prestasi').value = poin || '';
    }
    
    function editPrestasi(id, siswaId, jenisPrestasiId, tahunAjaranId, keterangan) {
        document.getElementById('formEditPrestasi').action = '/admin/update-prestasi/' + id;
        document.getElementById('edit_siswa_id').value = siswaId;
        document.getElementById('edit_jenis_prestasi_id').value = jenisPrestasiId;
        document.getElementById('edit_tahun_ajaran_id').value = tahunAjaranId;
        document.getElementById('edit_keterangan').value = keterangan || '';
        
        // Set poin berdasarkan jenis prestasi yang dipilih
        const select = document.getElementById('edit_jenis_prestasi_id');
        const poin = select.options[select.selectedIndex].getAttribute('data-poin');
        document.getElementById('edit_poin_prestasi').value = poin || '';
    }
</script>
@endsection