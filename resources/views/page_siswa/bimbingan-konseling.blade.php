@extends('layouts.siswa')

@section('title', 'Riwayat Bimbingan Konseling')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-comments"></i>  Bimbingan Konseling
                    </h3>
                </div>
                <div class="card-body">
                    @if($bimbingan->count() > 0)
                        <div class="alert alert-info mb-3">
                            <i class="fas fa-info-circle"></i> 
                            <strong>Informasi:</strong> Status bimbingan akan diupdate oleh konselor BK sesuai progress konseling Anda.
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>Konselor</th>
                                        <th>Topik</th>
                                        <th>Status</th>
                                        <th>Tindakan/Hasil</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($bimbingan as $index => $item)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $item->tanggal_konseling->format('d/m/Y') }}</td>
                                        <td>{{ $item->konselor->nama_guru ?? '-' }}</td>
                                        <td>{{ $item->topik }}</td>
                                        <td>
                                            @switch($item->status)
                                                @case('terdaftar')
                                                    <span class="badge bg-secondary">Terdaftar</span>
                                                    @break
                                                @case('diproses')
                                                    <span class="badge bg-warning">Diproses</span>
                                                    @break
                                                @case('selesai')
                                                    <span class="badge bg-success">Selesai</span>
                                                    @break
                                                @case('tindak_lanjut')
                                                    <span class="badge bg-info">Tindak Lanjut</span>
                                                    @break
                                            @endswitch
                                        </td>
                                        <td>
                                            @if($item->tindakan_solusi)
                                                {{ $item->tindakan_solusi }}
                                            @else
                                                @if($item->status == 'terjadwal')
                                                    <span class="text-warning"><i class="fas fa-clock"></i> Menunggu jadwal konseling</span>
                                                @elseif($item->status == 'berlangsung')
                                                    <span class="text-info"><i class="fas fa-spinner"></i> Sedang dalam proses bimbingan</span>
                                                @else
                                                    <span class="text-muted">Belum ada catatan tindakan</span>
                                                @endif
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-comments fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">Belum Ada Riwayat Bimbingan Konseling</h5>
                            <p class="text-muted">Anda belum pernah mendapat bimbingan konseling dari guru BK.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection