@extends('layouts.guru')

@section('title', 'Input Pelanggaran')
@section('page-title', 'Input Pelanggaran')

@section('content')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    
    <div class="card" style="border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="fas fa-exclamation-triangle me-2"></i>Input Pelanggaran</h5>
        </div>
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="mb-0">Data Pelanggaran Saya</h6>
                <div>
                    <a href="/guru/riwayat-pelanggaran" class="btn btn-warning btn-sm me-2">
                        <i class="fas fa-history me-1"></i>Riwayat Pelanggaran
                    </a>
                    <a href="/guru/export-laporan" class="btn btn-success btn-sm me-2">
                        <i class="fas fa-download me-1"></i>Export Data
                    </a>
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambahPelanggaran">
                        <i class="fas fa-plus me-1"></i>Tambah Pelanggaran
                    </button>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Nama Siswa</th>
                            <th>Kelas</th>
                            <th>Jenis Pelanggaran</th>
                            <th>Guru Pencatat</th>
                            <th>Poin</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pelanggaran as $index => $p)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $p->siswa->nama_siswa ?? '-' }}</td>
                            <td>{{ $p->siswa->kelas->nama_kelas ?? '-' }}</td>
                            <td>{{ $p->jenisPelanggaran->nama_pelanggaran ?? '-' }}</td>
                            <td>{{ $p->guruPencatat->nama_guru ?? '-' }}</td>
                            <td><span class="badge bg-danger">{{ $p->poin }} Poin</span></td>
                            <td>
                                <span class="badge 
                                    @if($p->verifikasi?->status == 'diverifikasi') bg-success
                                    @elseif($p->verifikasi?->status == 'ditolak') bg-danger
                                    @elseif($p->verifikasi?->status == 'revisi') bg-warning
                                    @else bg-secondary
                                    @endif">
                                    {{ ucfirst($p->verifikasi?->status ?? 'menunggu') }}
                                </span>
                            </td>
                            <td>{{ $p->created_at->format('d/m/Y') }}</td>
                            <td>
                                <form action="/guru/delete-pelanggaran/{{ $p->id }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus? Data akan disimpan ke riwayat pelanggaran.')">
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
                    <form id="formPelanggaran" action="/guru/store-pelanggaran" method="POST">
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
                            <label class="form-label">Guru Pencatat</label>
                            <select name="guru_pencatat" class="form-control" required>
                                <option value="">Pilih Guru</option>
                                @foreach($guru as $g)
                                <option value="{{ $g->id }}" {{ $g->id == Auth::user()->guru_id ? 'selected' : '' }}>{{ $g->nama_guru }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Jenis Pelanggaran</label>
                            <select name="jenis_pelanggaran_id" class="form-control" required>
                                <option value="">Pilih Jenis Pelanggaran</option>
                                @foreach($jenisPelanggaran->groupBy('kategori_utama') as $kategori => $items)
                                <optgroup label="{{ $kategori }}">
                                    @foreach($items as $jp)
                                    <option value="{{ $jp->id }}" data-poin="{{ $jp->poin }}">{{ $jp->nama_pelanggaran }} ({{ $jp->poin }} Poin)</option>
                                    @endforeach
                                </optgroup>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Poin</label>
                            <input type="number" name="poin" id="poin_pelanggaran" class="form-control" readonly>
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
@endsection

@section('scripts')
<script>
    document.querySelector('select[name="jenis_pelanggaran_id"]').addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const poin = selectedOption.getAttribute('data-poin');
        document.getElementById('poin_pelanggaran').value = poin || '';
    });
</script>
@endsection