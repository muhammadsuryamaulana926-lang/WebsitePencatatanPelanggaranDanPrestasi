@extends('layouts.siswa')

@section('title', 'Ajukan Bimbingan Konseling')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-hand-paper"></i> Ajukan Bimbingan Konseling
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header bg-primary text-white">
                                    <h5 class="mb-0">Form Pengajuan Bimbingan</h5>
                                </div>
                                <div class="card-body">
                                    <form action="/siswa/store-pengajuan-bimbingan" method="POST">
                                        @csrf
                                        <div class="mb-3">
                                            <label class="form-label">Topik Bimbingan</label>
                                            <select name="topik" class="form-control" required>
                                                <option value="">Pilih Topik</option>
                                                <option value="Masalah Akademik">Masalah Akademik</option>
                                                <option value="Masalah Pribadi">Masalah Pribadi</option>
                                                <option value="Masalah Sosial">Masalah Sosial</option>
                                                <option value="Karir dan Masa Depan">Karir dan Masa Depan</option>
                                                <option value="Lainnya">Lainnya</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Keluhan/Masalah</label>
                                            <textarea name="keluhan" class="form-control" rows="4" required 
                                                placeholder="Jelaskan masalah atau keluhan yang ingin Anda konsultasikan..."></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-paper-plane"></i> Ajukan Bimbingan
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header bg-info text-white">
                                    <h5 class="mb-0">Status Pengajuan</h5>
                                </div>
                                <div class="card-body">
                                    @if($pengajuan->count() > 0)
                                        @foreach($pengajuan as $item)
                                        <div class="alert 
                                            @if($item->status_pengajuan == 'diajukan') alert-warning
                                            @elseif($item->status_pengajuan == 'disetujui') alert-success
                                            @else alert-danger
                                            @endif">
                                            <h6>
                                                @if($item->status_pengajuan == 'diajukan')
                                                    <i class="fas fa-clock"></i>
                                                @elseif($item->status_pengajuan == 'disetujui')
                                                    <i class="fas fa-check-circle"></i>
                                                @else
                                                    <i class="fas fa-times-circle"></i>
                                                @endif
                                                {{ $item->topik }}
                                            </h6>
                                            <p class="mb-1">{{ $item->keluhan_masalah }}</p>
                                            <small class="text-muted">Diajukan: {{ $item->created_at->format('d/m/Y H:i') }}</small>
                                            <br>
                                            @if($item->status_pengajuan == 'diajukan')
                                                <span class="badge bg-warning">Menunggu Persetujuan BK</span>
                                            @elseif($item->status_pengajuan == 'disetujui')
                                                <span class="badge bg-success">Disetujui - {{ ucfirst($item->status) }}</span>
                                                @if($item->konselor)
                                                    <br><small class="text-muted">Konselor: {{ $item->konselor->nama_guru }}</small>
                                                @endif
                                            @else
                                                <span class="badge bg-danger">Ditolak</span>
                                                @if($item->alasan_penolakan)
                                                    <br><small class="text-muted">Alasan: {{ $item->alasan_penolakan }}</small>
                                                @endif
                                            @endif
                                        </div>
                                        @endforeach
                                    @else
                                        <div class="text-center py-4">
                                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                            <h5 class="text-muted">Belum Ada Pengajuan</h5>
                                            <p class="text-muted">Silakan ajukan bimbingan jika membutuhkan konseling.</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection