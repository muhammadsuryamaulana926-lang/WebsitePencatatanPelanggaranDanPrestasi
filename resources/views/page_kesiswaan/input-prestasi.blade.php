@extends('layouts.kesiswaan')

@section('title', 'Input Prestasi')
@section('page-title', 'Input Prestasi')

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
            <h5 class="mb-0"><i class="fas fa-trophy me-2"></i>Input Prestasi</h5>
        </div>
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="mb-0">Data Prestasi</h6>
                <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambahPrestasi">
                    <i class="fas fa-plus me-1"></i>Tambah Prestasi
                </button>
            </div>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Nama Siswa</th>
                            <th>Kelas</th>
                            <th>Jenis Prestasi</th>
                            <th>Guru Pencatat</th>
                            <th>Poin</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($prestasi as $index => $p)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $p->siswa->nama_siswa ?? '-' }}</td>
                            <td>{{ $p->siswa->kelas->nama_kelas ?? '-' }}</td>
                            <td>{{ $p->jenisPrestasi->nama_prestasi ?? '-' }}</td>
                            <td>{{ $p->guru->nama_guru ?? '-' }}</td>
                            <td><span class="badge bg-success">{{ $p->poin }} Poin</span></td>
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
                    <form id="formPrestasi" action="/kesiswaan/store-prestasi" method="POST">
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
                            <select name="guru_pencatat" class="form-control">
                                <option value="">Pilih Guru</option>
                                @foreach($guru as $g)
                                <option value="{{ $g->id }}">{{ $g->nama_guru }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Jenis Prestasi</label>
                            <select name="jenis_prestasi_id" class="form-control" required>
                                <option value="">Pilih Jenis Prestasi</option>
                                @foreach($jenisPrestasi as $jp)
                                <option value="{{ $jp->id }}" data-poin="{{ $jp->poin }}">{{ $jp->nama_prestasi }} ({{ $jp->poin }} Poin)</option>
                                @endforeach
                            </select>
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
                            <label class="form-label">Poin</label>
                            <input type="number" name="poin" id="poin" class="form-control" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Keterangan</label>
                            <textarea name="keterangan" class="form-control" rows="3"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" form="formPrestasi" class="btn btn-success">Simpan</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    document.querySelector('select[name="jenis_prestasi_id"]').addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const poin = selectedOption.getAttribute('data-poin');
        document.getElementById('poin').value = poin || '';
    });
</script>
@endsection