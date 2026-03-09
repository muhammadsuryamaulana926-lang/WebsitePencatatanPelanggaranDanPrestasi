@extends('layouts.walikelas')

@section('title', 'Input Pelanggaran')
@section('page-title', 'Input Pelanggaran')

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
        <h5 class="mb-0"><i class="fas fa-exclamation-triangle me-2"></i>Input Pelanggaran Siswa</h5>
    </div>
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h6 class="mb-0">Form Input Pelanggaran</h6>
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
                        <th>Kelas</th>
                        <th>Jenis Pelanggaran</th>
                        <th>Poin</th>
                        <th>Guru Pencatat</th>
                        <th>Status</th>
                        <th>Keterangan</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @php $no = 1; @endphp
                    @php 
                        $allPelanggaran = collect();
                        foreach($pelanggaranKelas as $s) {
                            foreach($s->pelanggaran as $p) {
                                $allPelanggaran->push((object)[
                                    'siswa_nama' => $s->nama_siswa,
                                    'kelas_nama' => $s->kelas->nama_kelas ?? '-',
                                    'jenis_pelanggaran' => $p->jenisPelanggaran->nama_pelanggaran ?? '-',
                                    'poin' => $p->poin,
                                    'guru_pencatat' => $p->guruPencatat->nama_guru ?? '-',
                                    'status' => $p->verifikasi?->status ?? 'menunggu',
                                    'keterangan' => $p->keterangan ?? '-',
                                    'tanggal' => $p->created_at->format('d/m/Y')
                                ]);
                            }
                        }
                    @endphp
                    @forelse($allPelanggaran as $p)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $p->siswa_nama }}</td>
                        <td>{{ $p->kelas_nama }}</td>
                        <td>{{ $p->jenis_pelanggaran }}</td>
                        <td><span class="badge bg-danger">{{ $p->poin }}</span></td>
                        <td>{{ $p->guru_pencatat }}</td>
                        <td>
                            <span class="badge 
                                @if($p->status == 'diverifikasi') bg-success
                                @elseif($p->status == 'ditolak') bg-danger
                                @elseif($p->status == 'revisi') bg-warning
                                @else bg-secondary
                                @endif">
                                {{ ucfirst($p->status) }}
                            </span>
                        </td>
                        <td>{{ $p->keterangan }}</td>
                        <td>{{ $p->tanggal }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center text-muted">Belum ada data pelanggaran</td>
                    </tr>
                    @endforelse
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
                <form id="formPelanggaran" action="/walikelas/store-pelanggaran" method="POST">
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
                        <label class="form-label">Guru Pencatat</label>
                        <select name="guru_pencatat" class="form-control">
                            <option value="">Pilih Guru</option>
                            @foreach($allGuru as $g)
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
@endsection

@section('scripts')
<script>
    function setPoin(select) {
        const poin = select.options[select.selectedIndex].getAttribute('data-poin');
        document.querySelector('input[name="poin"]').value = poin || '';
    }
</script>
@endsection