@extends('layouts.admin')

@section('title', 'Bimbingan Konseling')
@section('page-title', 'Bimbingan Konseling')

@section('content')
<div class="card" style="border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
    <div class="card-header bg-success text-white">
        <h5 class="mb-0"><i class="fas fa-comments me-2"></i>Bimbingan Konseling</h5>
    </div>
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h6 class="mb-0">Daftar Bimbingan Konseling</h6>
            <div>
                <button class="btn btn-info btn-sm me-2" data-bs-toggle="modal" data-bs-target="#modalExportPDF">
                    <i class="fas fa-file-pdf me-1"></i>Export PDF
                </button>
                <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambahBimbingan">
                    <i class="fas fa-plus me-1"></i>Tambah Bimbingan
                </button>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Siswa</th>
                        <th>Guru Konselor</th>
                        <th>Topik</th>
                        <th>Status</th>
                        <th>Tindakan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bimbinganKonseling as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->siswa->nama_siswa ?? 'Tidak ditemukan' }}</td>
                        <td>{{ $item->guruKonselor->nama_guru ?? 'Belum ditentukan' }}</td>
                        <td>{{ $item->topik }}</td>
                        <td>
                            @if($item->status == 'terjadwal')
                                <span class="badge bg-warning">Terjadwal</span>
                            @elseif($item->status == 'berlangsung')
                                <span class="badge bg-info">Berlangsung</span>
                            @else
                                <span class="badge bg-success">Selesai</span>
                            @endif
                        </td>
                        <td>{{ $item->tindakan ?? '-' }}</td>
                        <td>
                            <button class="btn btn-warning btn-sm me-1" onclick="editBimbingan({{ $item->id }}, {{ $item->siswa_id }}, {{ $item->guru_konselor_id ?? 'null' }}, '{{ $item->topik }}', '{{ $item->status }}', '{{ $item->tindakan }}')"
                                    data-bs-toggle="modal" data-bs-target="#modalEditBimbingan">
                                <i class="fas fa-edit"></i>
                            </button>
                            <form action="/admin/delete-bimbingan-konseling/{{ $item->id }}" method="POST" style="display: inline;" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
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

<!-- Modal Tambah Bimbingan -->
<div class="modal fade" id="modalTambahBimbingan" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Bimbingan Konseling</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formBimbingan" action="/admin/bimbingan-konseling" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Siswa</label>
                        <select name="siswa_id" class="form-control" required>
                            <option value="">Pilih Siswa</option>
                            @foreach($siswa as $s)
                            <option value="{{ $s->id }}">{{ $s->nama_siswa }} - {{ $s->kelas->nama_kelas ?? '' }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Guru Konselor</label>
                        <select name="guru_konselor_id" class="form-control" required>
                            <option value="">Pilih Guru Konselor</option>
                            @foreach($guru as $g)
                            <option value="{{ $g->id }}">{{ $g->nama_guru }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Topik</label>
                        <input type="text" name="topik" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-control" required>
                            <option value="terjadwal">Terjadwal</option>
                            <option value="berlangsung">Berlangsung</option>
                            <option value="selesai">Selesai</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tindakan</label>
                        <textarea name="tindakan" class="form-control" rows="3"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" form="formBimbingan" class="btn btn-success">Simpan</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Export PDF -->
<div class="modal fade" id="modalExportPDF" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Export Laporan Bimbingan Konseling</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form action="/admin/export-bimbingan-konseling" method="GET">
                    <div class="mb-3">
                        <label class="form-label">Status Kasus</label>
                        <select name="status" class="form-control">
                            <option value="semua">Semua Status</option>
                            <option value="terjadwal">Terjadwal</option>
                            <option value="berlangsung">Berlangsung</option>
                            <option value="selesai">Selesai</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Periode</label>
                        <select name="periode" class="form-control">
                            <option value="semua">Semua Periode</option>
                            <option value="1">Januari</option>
                            <option value="2">Februari</option>
                            <option value="3">Maret</option>
                            <option value="4">April</option>
                            <option value="5">Mei</option>
                            <option value="6">Juni</option>
                            <option value="7">Juli</option>
                            <option value="8">Agustus</option>
                            <option value="9">September</option>
                            <option value="10">Oktober</option>
                            <option value="11">November</option>
                            <option value="12">Desember</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-info">
                            <i class="fas fa-download me-1"></i>Download PDF
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Bimbingan -->
<div class="modal fade" id="modalEditBimbingan" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Bimbingan Konseling</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formEditBimbingan" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label">Siswa</label>
                        <select name="siswa_id" id="edit_siswa_id" class="form-control" required>
                            <option value="">Pilih Siswa</option>
                            @foreach($siswa as $s)
                            <option value="{{ $s->id }}">{{ $s->nama_siswa }} - {{ $s->kelas->nama_kelas ?? '' }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Guru Konselor</label>
                        <select name="guru_konselor_id" id="edit_guru_konselor_id" class="form-control" required>
                            <option value="">Pilih Guru Konselor</option>
                            @foreach($guru as $g)
                            <option value="{{ $g->id }}">{{ $g->nama_guru }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Topik</label>
                        <input type="text" name="topik" id="edit_topik" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" id="edit_status" class="form-control" required>
                            <option value="terjadwal">Terjadwal</option>
                            <option value="berlangsung">Berlangsung</option>
                            <option value="selesai">Selesai</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tindakan</label>
                        <textarea name="tindakan" id="edit_tindakan" class="form-control" rows="3"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" form="formEditBimbingan" class="btn btn-warning">Update</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function editBimbingan(id, siswaId, guruKonselorId, topik, status, tindakan) {
    document.getElementById('formEditBimbingan').action = '/admin/update-bimbingan-konseling/' + id;
    document.getElementById('edit_siswa_id').value = siswaId;
    document.getElementById('edit_guru_konselor_id').value = guruKonselorId || '';
    document.getElementById('edit_topik').value = topik;
    document.getElementById('edit_status').value = status;
    document.getElementById('edit_tindakan').value = tindakan || '';
}
</script>
@endsection