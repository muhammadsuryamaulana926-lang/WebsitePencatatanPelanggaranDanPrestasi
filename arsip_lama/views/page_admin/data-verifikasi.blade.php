@extends('layouts.admin')

@section('title', 'Data Verifikasi')
@section('page-title', 'Data Verifikasi')

@section('content')
<div class="card" style="border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
    <div class="card-header bg-warning text-white">
        <h5 class="mb-0"><i class="fas fa-clipboard-check me-2"></i>Antrian Verifikasi ({{ $verifikasiData->count() }})</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Tabel Terkait</th>
                        <th>ID Terkait</th>
                        <th>Guru Verifikator</th>
                        <th>Status</th>
                        <th>Catatan</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($verifikasiData as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td><span class="badge bg-info">{{ $item->tabel_terkait }}</span></td>
                        <td>{{ $item->id_terkait }}</td>
                        <td>{{ $item->guru->nama_guru ?? 'Tidak ditemukan' }}</td>
                        <td>
                            @if($item->status == 'menunggu')
                                <span class="badge bg-warning">Menunggu</span>
                            @elseif($item->status == 'diverifikasi')
                                <span class="badge bg-success">Diverifikasi</span>
                            @elseif($item->status == 'ditolak')
                                <span class="badge bg-danger">Ditolak</span>
                            @else
                                <span class="badge bg-info">Revisi</span>
                            @endif
                        </td>
                        <td>{{ $item->catatan ?? '-' }}</td>
                        <td>{{ date('d/m/Y', strtotime($item->created_at)) }}</td>
                        <td>
                            <span class="text-muted">Hanya Lihat Data</span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection