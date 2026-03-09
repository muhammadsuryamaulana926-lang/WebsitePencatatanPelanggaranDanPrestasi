@extends('layouts.bk')

@section('title', 'Input BK')
@section('page-title', 'Input Bimbingan Konseling')

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
    <div class="card-header bg-info text-white">
        <h5 class="mb-0"><i class="fas fa-plus-circle me-2"></i>Input Bimbingan Konseling</h5>
    </div>
    <div class="card-body">
        <!-- Pengajuan Baru -->
        @if($pengajuanBaru->count() > 0)
        <div class="alert alert-info">
            <h6><i class="fas fa-bell"></i> Pengajuan Bimbingan Baru ({{ $pengajuanBaru->count() }})</h6>
            <div class="row">
                @foreach($pengajuanBaru as $pengajuan)
                <div class="col-md-6 mb-2">
                    <div class="card border-warning">
                        <div class="card-body p-2">
                            <h6 class="card-title mb-1">{{ $pengajuan->siswa->nama_siswa ?? '-' }} - {{ $pengajuan->siswa->kelas->nama_kelas ?? '-' }}</h6>
                            <p class="card-text mb-1"><strong>{{ $pengajuan->topik }}</strong></p>
                            <p class="card-text mb-2"><small>{{ $pengajuan->keluhan_masalah }}</small></p>
                            <button class="btn btn-success btn-sm me-1" onclick="verifikasiPengajuan({{ $pengajuan->bk_id }}, 'setujui')">
                                <i class="fas fa-check"></i> Setujui
                            </button>
                            <button class="btn btn-danger btn-sm" onclick="verifikasiPengajuan({{ $pengajuan->bk_id }}, 'tolak')">
                                <i class="fas fa-times"></i> Tolak
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
        
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h6 class="mb-0">Data Bimbingan Konseling</h6>
        </div>
        
        <div class="table-responsive">
            <table class="table table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Siswa</th>
                        <th>Kelas</th>
                        <th>Topik</th>
                        <th>Status</th>
                        <th>Tindakan</th>
                        <th>Konselor</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @php $no = 1; @endphp
                    @forelse($bimbinganKonseling as $bk)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $bk->siswa->nama_siswa ?? '-' }}</td>
                        <td>{{ $bk->siswa->kelas->nama_kelas ?? '-' }}</td>
                        <td>{{ $bk->topik }}</td>
                        <td>
                            <span class="badge 
                                @if($bk->status == 'selesai') bg-success
                                @elseif($bk->status == 'berlangsung') bg-warning
                                @else bg-info
                                @endif">
                                {{ ucfirst($bk->status) }}
                            </span>
                        </td>
                        <td>{{ $bk->tindakan_solusi ?? '-' }}</td>
                        <td>{{ $bk->konselor->nama_guru ?? '-' }}</td>
                        <td>{{ $bk->tanggal_konseling ? $bk->tanggal_konseling->format('d/m/Y') : $bk->created_at->format('d/m/Y') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted">Belum ada data bimbingan konseling</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Tambah BK -->
<!-- <div class="modal fade" id="modalTambahBK" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Bimbingan Konseling</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formBK" action="/bk/store-bk" method="POST">
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
                        <label class="form-label">Topik Bimbingan</label>
                        <input type="text" name="topik" class="form-control" required placeholder="Masukkan topik bimbingan">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status Bimbingan</label>
                        <select name="status" class="form-control" required>
                            <option value="">Pilih Status</option>
                            <option value="terjadwal">Terjadwal</option>
                            <option value="berlangsung">Berlangsung</option>
                            <option value="selesai">Selesai</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Konselor</label>
                        <select name="guru_konselor" class="form-control">
                            <option value="">Pilih Konselor</option>
                            @foreach($guru as $g)
                            <option value="{{ $g->id }}">{{ $g->nama_guru }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tindakan</label>
                        <textarea name="tindakan" class="form-control" rows="3" placeholder="Tindakan yang dilakukan"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" form="formBK" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</div> -->

<!-- Modal Edit BK -->
<div class="modal fade" id="modalEditBK" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Status Bimbingan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formEditBK" action="/bk/update-bk/1" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="edit_bk_id" name="bk_id">
                    <div class="mb-3">
                        <label class="form-label">Topik</label>
                        <input type="text" id="edit_topik" class="form-control" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tanggal Konseling</label>
                        <input type="date" name="tanggal_konseling" id="edit_tanggal" class="form-control">
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
                        <label class="form-label">Tindakan/Hasil</label>
                        <textarea name="tindakan" id="edit_tindakan" class="form-control" rows="4" required placeholder="Jelaskan tindakan yang dilakukan atau hasil bimbingan"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" form="formEditBK" class="btn btn-success">Update Status</button>
            </div>
        </div>
    </div>
</div>

<script>
function editBK(id, topik, status, tindakan, tanggal) {
    console.log('Setting action to: /bk/update-bk/' + id);
    const form = document.getElementById('formEditBK');
    form.action = '/bk/update-bk/' + id;
    
    document.getElementById('edit_bk_id').value = id;
    document.getElementById('edit_topik').value = topik;
    document.getElementById('edit_status').value = status;
    document.getElementById('edit_tindakan').value = tindakan || '';
    document.getElementById('edit_tanggal').value = tanggal;
    
    console.log('Form action is now: ' + form.action);
}

function verifikasiPengajuan(id, action) {
    let alasan = '';
    if (action === 'tolak') {
        alasan = prompt('Alasan penolakan:');
        if (!alasan) return;
    }
    
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '/bk/verifikasi-pengajuan/' + id;
    
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';
    form.innerHTML = `
        <input type="hidden" name="_token" value="${csrfToken}">
        <input type="hidden" name="action" value="${action}">
        <input type="hidden" name="alasan_penolakan" value="${alasan}">
    `;
    
    document.body.appendChild(form);
    form.submit();
}
</script>
@endsection