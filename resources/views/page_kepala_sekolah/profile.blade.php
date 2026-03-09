@extends('layouts.kepala_sekolah')

@section('title', 'Profil Kepala Sekolah')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h3 class="card-title mb-0">
                        <i class="fas fa-user-tie"></i> Profil Kepala Sekolah
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 text-center">
                            <div class="profile-img mb-3">
                                <i class="fas fa-user-circle fa-8x text-primary"></i>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <table class="table table-borderless">
                                <tr>
                                    <td width="200"><strong>NIP</strong></td>
                                    <td>: {{ $guru->nip }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Nama Lengkap</strong></td>
                                    <td>: {{ $guru->nama_guru }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Jabatan</strong></td>
                                    <td>: Kepala Sekolah</td>
                                </tr>
                                <tr>
                                    <td><strong>Bidang Studi</strong></td>
                                    <td>: {{ $guru->bidang_studi }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Status</strong></td>
                                    <td>: 
                                        <span class="badge {{ $guru->status == 'aktif' ? 'bg-success' : 'bg-secondary' }}">
                                            {{ ucfirst($guru->status) }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Bergabung Sejak</strong></td>
                                    <td>: {{ $guru->created_at->format('d F Y') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    
                    <hr>
                    
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <h5><i class="fas fa-chart-bar"></i> Statistik Sekolah</h5>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="card bg-info text-white">
                                        <div class="card-body text-center">
                                            <h4>{{ \App\Models\Siswa::count() }}</h4>
                                            <p class="mb-0">Total Siswa</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card bg-success text-white">
                                        <div class="card-body text-center">
                                            <h4>{{ \App\Models\Guru::count() }}</h4>
                                            <p class="mb-0">Total Guru</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card bg-warning text-white">
                                        <div class="card-body text-center">
                                            <h4>{{ \App\Models\Pelanggaran::count() }}</h4>
                                            <p class="mb-0">Total Pelanggaran</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card bg-primary text-white">
                                        <div class="card-body text-center">
                                            <h4>{{ \App\Models\Prestasi::count() }}</h4>
                                            <p class="mb-0">Total Prestasi</p>
                                        </div>
                                    </div>
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