@extends('layouts.admin')

@section('title', 'Data Jenis Pelanggaran')
@section('page-title', 'Data Jenis Pelanggaran')

@section('content')
    <div class="card" style="border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
        <div class="card-header bg-warning text-dark">
            <h5 class="mb-0"><i class="fas fa-exclamation-triangle me-2"></i>Data Jenis Pelanggaran</h5>
        </div>
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="mb-0">Daftar Jenis Pelanggaran</h6>
            </div>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Kategori Utama</th>
                            <th>Nama Pelanggaran</th>
                            <th>Kategori</th>
                            <th>Poin</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $no = 1; @endphp
                        @foreach($jenisPelanggaran->groupBy('kategori_utama') as $kategoriUtama => $items)
                            @foreach($items as $jp)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td><span class="badge bg-primary">{{ $kategoriUtama }}</span></td>
                                <td>{{ $jp->nama_pelanggaran }}</td>
                                <td>
                                    <span class="badge 
                                        @if($jp->kategori == 'ringan') bg-success
                                        @elseif($jp->kategori == 'sedang') bg-warning
                                        @elseif($jp->kategori == 'berat') bg-danger
                                        @else bg-dark
                                        @endif">
                                        {{ ucfirst($jp->kategori) }}
                                    </span>
                                </td>
                                <td><span class="badge bg-info">{{ $jp->poin }} Poin</span></td>
                            </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection