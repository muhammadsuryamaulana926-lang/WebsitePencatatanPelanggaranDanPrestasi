@extends('layouts.kesiswaan')

@section('title', 'Dashboard Kesiswaan')
@section('page-title', 'Dashboard Kesiswaan')

@section('content')
<div class="row">
    <div class="col-lg-3 col-md-6 mb-4">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4>Input Pelanggaran</h4>
                        <p class="mb-0">Kelola data pelanggaran siswa</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-exclamation-triangle fa-2x"></i>
                    </div>
                </div>
            </div>
            <a href="/kesiswaan/input-pelanggaran" class="card-footer text-white text-decoration-none">
                <span class="float-start">Lihat Detail</span>
                <span class="float-end"><i class="fas fa-arrow-circle-right"></i></span>
            </a>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6 mb-4">
        <div class="card bg-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4>Input Prestasi</h4>
                        <p class="mb-0">Kelola data prestasi siswa</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-trophy fa-2x"></i>
                    </div>
                </div>
            </div>
            <a href="/kesiswaan/input-prestasi" class="card-footer text-white text-decoration-none">
                <span class="float-start">Lihat Detail</span>
                <span class="float-end"><i class="fas fa-arrow-circle-right"></i></span>
            </a>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6 mb-4">
        <div class="card bg-info text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4>Verifikasi Data</h4>
                        <p class="mb-0">Verifikasi data siswa</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-clipboard-check fa-2x"></i>
                    </div>
                </div>
            </div>
            <a href="/kesiswaan/verifikasi-data" class="card-footer text-white text-decoration-none">
                <span class="float-start">Lihat Detail</span>
                <span class="float-end"><i class="fas fa-arrow-circle-right"></i></span>
            </a>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6 mb-4">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4>Monitoring All</h4>
                        <p class="mb-0">Monitor semua data</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-search fa-2x"></i>
                    </div>
                </div>
            </div>
            <a href="/kesiswaan/monitoring-all" class="card-footer text-white text-decoration-none">
                <span class="float-start">Lihat Detail</span>
                <span class="float-end"><i class="fas fa-arrow-circle-right"></i></span>
            </a>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6 mb-4">
        <div class="card bg-danger text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4>Data Sanksi</h4>
                        <p class="mb-0">Kelola sanksi pelanggaran</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-gavel fa-2x"></i>
                    </div>
                </div>
            </div>
            <a href="/kesiswaan/sanksi" class="card-footer text-white text-decoration-none">
                <span class="float-start">Lihat Detail</span>
                <span class="float-end"><i class="fas fa-arrow-circle-right"></i></span>
            </a>
        </div>
    </div>
</div>
@endsection