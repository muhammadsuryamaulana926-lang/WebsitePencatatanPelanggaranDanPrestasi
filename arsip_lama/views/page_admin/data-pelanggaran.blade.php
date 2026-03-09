@extends('layouts.admin')

@section('title', 'Data Pelanggaran')
@section('page-title', 'Data Pelanggaran')

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
    <div class="card-header bg-danger text-white">
        <h5 class="mb-0"><i class="fas fa-ban me-2"></i>Data Pelanggaran</h5>
    </div>
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h6 class="mb-0">Daftar Pelanggaran</h6>
            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambahPelanggaran">
                <i class="fas fa-plus me-1"></i>Tambah Pelanggaran
            </button>
        </div>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Siswa</th>
                        <th>Jenis Pelanggaran</th>
                        <th>Poin</th>
                        <th>Guru Pencatat</th>
                        <th>Keterangan</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pelanggaran as $index => $p)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $p->siswa->nama_siswa ?? '-' }}</td>
                        <td>{{ $p->jenisPelanggaran->nama_pelanggaran ?? '-' }}</td>
                        <td><span class="badge bg-danger">{{ $p->poin }}</span></td>
                        <td>{{ $p->guruPencatat->nama_guru ?? '-' }}</td>
                        <td>{{ $p->keterangan ?? '-' }}</td>
                        <td>{{ $p->created_at->format('d/m/Y') }}</td>
                        <td>
                            <button class="btn btn-warning btn-sm me-1" onclick="editPelanggaran({{ $p->id }}, {{ $p->siswa_id }}, {{ $p->guru_pencatat ?? 'null' }}, {{ $p->jenis_pelanggaran_id }}, {{ $p->tahun_ajaran_id }}, {{ $p->poin }}, '{{ $p->keterangan }}')"
                                    data-bs-toggle="modal" data-bs-target="#modalEditPelanggaran">
                                <i class="fas fa-edit"></i>
                            </button>
                            <form action="/admin/delete-pelanggaran/{{ $p->id }}" method="POST" style="display: inline;" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
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

<!-- Modal Tambah Pelanggaran -->
<div class="modal fade" id="modalTambahPelanggaran" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Pelanggaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formPelanggaran" action="/admin/store-pelanggaran" method="POST">
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
                        <label class="form-label">Jenis Pelanggaran</label>
                        <select name="jenis_pelanggaran_id" class="form-control" required onchange="setPoin(this)">
                            <option value="">Pilih Jenis Pelanggaran</option>
                            @foreach($jenisPelanggaran->groupBy('kategori_utama') as $kategori => $items)
                            <optgroup label="{{ $kategori }}">
                                @foreach($items as $jp)
                                <option value="{{ $jp->id }}" data-poin="{{ $jp->poin }}">{{ $jp->nama_pelanggaran }} ({{ $jp->poin }} poin)</option>
                                @endforeach
                            </optgroup>
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
                        <label class="form-label">Guru Pencatat</label>
                        <select name="guru_pencatat" class="form-control">
                            <option value="">Pilih Guru</option>
                            @foreach($guru as $g)
                            <option value="{{ $g->id }}">{{ $g->nama_guru }}</option>
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
                <button type="submit" form="formPelanggaran" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Pelanggaran -->
<div class="modal fade" id="modalEditPelanggaran" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Pelanggaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formEditPelanggaran" method="POST">
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
                        <label class="form-label">Jenis Pelanggaran</label>
                        <select name="jenis_pelanggaran_id" id="edit_jenis_pelanggaran_id" class="form-control" required onchange="setEditPoin(this)">
                            <option value="">Pilih Jenis Pelanggaran</option>
                            @foreach($jenisPelanggaran->groupBy('kategori_utama') as $kategori => $items)
                            <optgroup label="{{ $kategori }}">
                                @foreach($items as $jp)
                                <option value="{{ $jp->id }}" data-poin="{{ $jp->poin }}">{{ $jp->nama_pelanggaran }} ({{ $jp->poin }} poin)</option>
                                @endforeach
                            </optgroup>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Poin</label>
                        <input type="number" name="poin" id="edit_poin" class="form-control" readonly>
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
                        <label class="form-label">Guru Pencatat</label>
                        <select name="guru_pencatat" id="edit_guru_pencatat" class="form-control">
                            <option value="">Pilih Guru</option>
                            @foreach($guru as $g)
                            <option value="{{ $g->id }}">{{ $g->nama_guru }}</option>
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
                <button type="submit" form="formEditPelanggaran" class="btn btn-warning">Update</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function setPoin(select) {
        const poin = select.options[select.selectedIndex].getAttribute('data-poin');
        document.querySelector('input[name="poin"]').value = poin || '';
    }
    
    function setEditPoin(select) {
        const poin = select.options[select.selectedIndex].getAttribute('data-poin');
        document.getElementById('edit_poin').value = poin || '';
    }
    
    function editPelanggaran(id, siswaId, guruId, jenisId, tahunAjaranId, poin, keterangan) {
        document.getElementById('formEditPelanggaran').action = '/admin/update-pelanggaran/' + id;
        document.getElementById('edit_siswa_id').value = siswaId;
        document.getElementById('edit_jenis_pelanggaran_id').value = jenisId;
        document.getElementById('edit_tahun_ajaran_id').value = tahunAjaranId;
        document.getElementById('edit_poin').value = poin;
        document.getElementById('edit_guru_pencatat').value = guruId || '';
        document.getElementById('edit_keterangan').value = keterangan || '';
    }
</script>
@endsection