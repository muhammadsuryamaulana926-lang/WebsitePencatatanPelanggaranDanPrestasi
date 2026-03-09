@extends('layouts.siswa')

@section('title', 'Pelaksanaan Sanksi')
@section('page-title', 'Pelaksanaan Sanksi')

@section('content')
<!-- Info Sistem Poin -->
<div class="alert alert-info mb-4">
    <h6><i class="fas fa-info-circle me-2"></i>Informasi Sistem Poin & Sanksi</h6>
    <p class="mb-2">Sanksi ditentukan berdasarkan <strong>total poin aktif</strong> (pelanggaran yang sanksinya belum selesai):</p>
    <div class="row">
        <div class="col-md-6">
            <small>
                • 0-5 poin → Dicatat dan Konseling<br>
                • 6-10 poin → Peringatan Lisan<br>
                • 11-15 poin → Peringatan Tertulis<br>
                • 16-20 poin → Perjanjian Diatas Materai<br>
                • 21-25 poin → Diskors 3 Hari
            </small>
        </div>
        <div class="col-md-6">
            <small>
                • 26-35 poin → Diskors 7 Hari<br>
                • 36-40 poin → Diserahkan ke Ortu 2 Minggu<br>
                • 41-89 poin → Diserahkan ke Ortu 1 Bulan<br>
                • 90+ poin → Dikembalikan ke Ortu (Keluar)
            </small>
        </div>
    </div>
    <p class="mb-0 mt-2"><strong>Penting:</strong> Selesaikan sanksi dengan cepat agar poin tidak terakumulasi dengan pelanggaran baru!</p>
</div>

<div class="card" style="border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
    <div class="card-header bg-danger text-white">
        <h5 class="mb-0"><i class="fas fa-tasks me-2"></i>Pelaksanaan Sanksi Saya</h5>
    </div>
    <div class="card-body">
        @if($sanksiSaya->isEmpty())
            <div class="alert alert-success text-center">
                <i class="fas fa-check-circle fa-3x mb-3"></i>
                <h5>Tidak Ada Sanksi Aktif</h5>
                <p class="mb-0">Selamat! Kamu tidak memiliki sanksi yang perlu dilaksanakan.</p>
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Jenis Pelanggaran</th>
                            <th>Poin</th>
                            <th>Jenis Sanksi</th>
                            <th>Tanggal Pelaksanaan</th>
                            <th>Status</th>
                            <th>Bukti</th>
                            <th>Catatan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sanksiSaya as $index => $sanksi)
                        @php
                            $pelaksanaan = $sanksi->pelaksanaanSanksi->first();
                        @endphp
                        <tr>
                            @if($pelaksanaan)
                                <form action="/siswa/update-pelaksanaan-sanksi/{{ $pelaksanaan->id }}?t={{ time() }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="sanksi_id" value="{{ $sanksi->id }}">
                            @else
                                <form action="/siswa/store-pelaksanaan-sanksi?t={{ time() }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="sanksi_id" value="{{ $sanksi->id }}">
                            @endif
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $sanksi->pelanggaran->jenisPelanggaran->nama_pelanggaran ?? '-' }}</td>
                                <td>
                                    @php
                                        $totalPoinAktif = \App\Models\Pelanggaran::join('jenis_pelanggaran', 'pelanggaran.jenis_pelanggaran_id', '=', 'jenis_pelanggaran.id')
                                            ->leftJoin('sanksi', 'pelanggaran.id', '=', 'sanksi.pelanggaran_id')
                                            ->leftJoin('pelaksanaan_sanksi', 'sanksi.id', '=', 'pelaksanaan_sanksi.sanksi_id')
                                            ->where('pelanggaran.siswa_id', $sanksi->pelanggaran->siswa_id)
                                            ->where(function($query) {
                                                $query->whereNull('sanksi.id')
                                                      ->orWhere('pelaksanaan_sanksi.status', '!=', 'selesai')
                                                      ->orWhereNull('pelaksanaan_sanksi.status');
                                            })
                                            ->where('sanksi.status', '!=', 'dibatalkan')
                                            ->sum('jenis_pelanggaran.poin');
                                        
                                        $pelanggaranAktif = \App\Models\Pelanggaran::with('jenisPelanggaran')
                                            ->join('jenis_pelanggaran', 'pelanggaran.jenis_pelanggaran_id', '=', 'jenis_pelanggaran.id')
                                            ->leftJoin('sanksi', 'pelanggaran.id', '=', 'sanksi.pelanggaran_id')
                                            ->leftJoin('pelaksanaan_sanksi', 'sanksi.id', '=', 'pelaksanaan_sanksi.sanksi_id')
                                            ->where('pelanggaran.siswa_id', $sanksi->pelanggaran->siswa_id)
                                            ->where(function($query) {
                                                $query->whereNull('sanksi.id')
                                                      ->orWhere('pelaksanaan_sanksi.status', '!=', 'selesai')
                                                      ->orWhereNull('pelaksanaan_sanksi.status');
                                            })
                                            ->where('sanksi.status', '!=', 'dibatalkan')
                                            ->select('pelanggaran.*', 'jenis_pelanggaran.nama_pelanggaran', 'jenis_pelanggaran.poin')
                                            ->get();
                                    @endphp
                                    <span class="badge bg-danger" data-bs-toggle="tooltip" 
                                          title="Breakdown: {{ $pelanggaranAktif->map(function($p) { return $p->nama_pelanggaran . ' (' . $p->poin . ' poin)'; })->implode(', ') }}">
                                        {{ $totalPoinAktif }} Poin
                                    </span>
                                    <br><small class="text-muted">Total Aktif</small>
                                    @if($pelanggaranAktif->count() > 1)
                                        <br><small class="text-warning"><i class="fas fa-exclamation-triangle"></i> melakukan pelanggaran lagi sebelum sanksi pelanggaran pertama terpenuhi</small>
                                    @endif
                                </td>
                                <td>{{ $sanksi->jenis_sanksi }}</td>
                                <td>
                                    <input type="date" name="tanggal_pelaksanaan" 
                                           class="form-control form-control-sm" 
                                           value="{{ $pelaksanaan ? $pelaksanaan->tanggal_pelaksanaan : '' }}" required>
                                </td>
                                <td>
                                    <select name="status" class="form-control form-control-sm" required>
                                        <option value="dikerjakan" {{ $pelaksanaan && $pelaksanaan->status == 'dikerjakan' ? 'selected' : '' }}>Dikerjakan</option>
                                        <option value="tuntas" {{ $pelaksanaan && $pelaksanaan->status == 'tuntas' ? 'selected' : '' }}>Tuntas</option>
                                    </select>
                                </td>
                                <td>
                                    <input type="file" name="bukti" 
                                           class="form-control form-control-sm" 
                                           accept="image/*,.pdf,.doc,.docx">
                                    @if($pelaksanaan && $pelaksanaan->bukti)
                                        <small class="text-muted d-block">File saat ini: 
                                            <a href="{{ asset('storage/' . $pelaksanaan->bukti) }}" target="_blank">Lihat</a>
                                        </small>
                                    @else
                                        <small class="text-muted">Tidak ada file yang dipilih</small>
                                    @endif
                                </td>
                                <td>
                                    <textarea name="catatan" 
                                              class="form-control form-control-sm" 
                                              rows="2" placeholder="Jelaskan pelaksanaan...">{{ $pelaksanaan ? $pelaksanaan->catatan : '' }}</textarea>
                                </td>
                                <td>
                                    <button type="submit" class="btn btn-success btn-sm">
                                        <i class="fas fa-save"></i> Simpan
                                    </button>
                                </td>
                            </form>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>

<!-- Modal Tambah Pelaksanaan -->
<div class="modal fade" id="modalTambahPelaksanaan" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Pelaksanaan Sanksi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formTambahPelaksanaan" action="/siswa/store-pelaksanaan-sanksi" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="sanksi_id" id="tambah_sanksi_id">
                    <div class="mb-3">
                        <label class="form-label">Tanggal Pelaksanaan</label>
                        <input type="date" name="tanggal_pelaksanaan" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Bukti Pelaksanaan (Foto/File)</label>
                        <input type="file" name="bukti" class="form-control" accept="image/*,.pdf,.doc,.docx">
                        <small class="text-muted">Format: JPG, PNG, PDF, DOC, DOCX (Max: 5MB)</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-control" required>
                            <option value="dikerjakan">Dikerjakan</option>
                            <option value="tuntas">Tuntas</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Catatan</label>
                        <textarea name="catatan" class="form-control" rows="3" placeholder="Jelaskan bagaimana sanksi dilaksanakan..."></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" form="formTambahPelaksanaan" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Pelaksanaan -->
<div class="modal fade" id="modalEditPelaksanaan" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Pelaksanaan Sanksi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formEditPelaksanaan" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label">Tanggal Pelaksanaan</label>
                        <input type="date" name="tanggal_pelaksanaan" id="edit_tanggal" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Bukti Pelaksanaan (Foto/File)</label>
                        <input type="file" name="bukti" class="form-control" accept="image/*,.pdf,.doc,.docx">
                        <small class="text-muted">Format: JPG, PNG, PDF, DOC, DOCX (Max: 5MB)</small>
                        <div id="current_bukti" class="mt-2"></div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" id="edit_status" class="form-control" required>
                            <option value="dikerjakan">Dikerjakan</option>
                            <option value="tuntas">Tuntas</option>
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
                <button type="submit" form="formEditPelaksanaan" class="btn btn-warning">Update</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
// Aktifkan tooltip Bootstrap
document.addEventListener('DOMContentLoaded', function() {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});

function tambahPelaksanaan(sanksiId) {
    document.getElementById('tambah_sanksi_id').value = sanksiId;
}

function editPelaksanaan(id, tanggal, status, catatan) {
    document.getElementById('formEditPelaksanaan').action = '/siswa/update-pelaksanaan-sanksi/' + id;
    document.getElementById('edit_tanggal').value = tanggal;
    document.getElementById('edit_status').value = status;
    document.getElementById('edit_catatan').value = catatan || '';
}
</script>
@endsection