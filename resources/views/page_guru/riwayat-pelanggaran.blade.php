@extends('layouts.guru')

@section('title', 'Riwayat Pelanggaran')
@section('page-title', 'Riwayat Pelanggaran')

@section('content')
    <div class="card" style="border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
        <div class="card-header bg-warning text-dark">
            <h5 class="mb-0"><i class="fas fa-history me-2"></i>Riwayat Pelanggaran yang Dihapus</h5>
        </div>
        <div class="card-body">
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
                            <th>Tanggal Pelanggaran</th>
                            <th>Tanggal Dihapus</th>
                            <th>Alasan Hapus</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($riwayat as $index => $r)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $r->siswa->nama_siswa ?? '-' }}</td>
                            <td>{{ $r->siswa->kelas->nama_kelas ?? '-' }}</td>
                            <td>{{ $r->jenisPelanggaran->nama_pelanggaran ?? '-' }}</td>
                            <td>{{ $r->guru->nama_guru ?? '-' }}</td>
                            <td><span class="badge bg-secondary">{{ $r->poin }} Poin</span></td>
                            <td>{{ $r->tanggal_pelanggaran ? \Carbon\Carbon::parse($r->tanggal_pelanggaran)->format('d/m/Y') : '-' }}</td>
                            <td>{{ $r->tanggal_dihapus ? \Carbon\Carbon::parse($r->tanggal_dihapus)->format('d/m/Y H:i') : '-' }}</td>
                            <td>{{ $r->alasan_hapus ?? '-' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection