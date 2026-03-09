@extends('layouts.ortu')

@section('title', 'View Data Sendiri')
@section('page-title', 'Profil Keluarga')

@section('content')
<div class="row">
    <!-- Info Orang Tua -->
    <div class="col-lg-6 mb-4">
        <div class="card h-100" style="border: none; box-shadow: 0 8px 25px rgba(0,0,0,0.08); border-radius: 12px;">
            <div class="card-header text-white" style="background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%); border-radius: 12px 12px 0 0;">
                <div class="d-flex align-items-center">
                    <div class="bg-white rounded-circle p-2 me-3">
                        <i class="fas fa-user" style="color: #2c3e50; font-size: 1.2rem;"></i>
                    </div>
                    <h5 class="mb-0 fw-bold">Informasi Orang Tua</h5>
                </div>
            </div>
            <div class="card-body p-4">
                <div class="row g-3">
                    <div class="col-12">
                        <div class="info-item p-3 rounded" style="background: #2c3e50; color: white;">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-id-card me-3" style="font-size: 1.1rem;"></i>
                                <div>
                                    <small class="opacity-75">Nama Lengkap</small>
                                    <div class="fw-bold">{{ $orangtua->nama_orangtua }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-item p-3 rounded" style="background: #34495e; color: white;">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-heart me-3"></i>
                                <div>
                                    <small class="opacity-75">Hubungan</small>
                                    <div class="fw-bold">{{ ucfirst($orangtua->hubungan) }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-item p-3 rounded" style="background: #5d6d7e; color: white;">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-briefcase me-3"></i>
                                <div>
                                    <small class="opacity-75">Pekerjaan</small>
                                    <div class="fw-bold">{{ $orangtua->pekerjaan }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-item p-3 rounded" style="background: #85929e; color: white;">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-graduation-cap me-3"></i>
                                <div>
                                    <small class="opacity-75">Pendidikan</small>
                                    <div class="fw-bold">{{ $orangtua->pendidikan }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-item p-3 rounded" style="background: #f8f9fa; color: #2c3e50; border: 1px solid #e9ecef;">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-phone me-3" style="color: #2c3e50;"></i>
                                <div>
                                    <small class="text-muted">No. Telepon</small>
                                    <div class="fw-bold">{{ $orangtua->no_telp }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="info-item p-3 rounded" style="background: #f8f9fa; color: #2c3e50; border: 1px solid #e9ecef;">
                            <div class="d-flex align-items-start">
                                <i class="fas fa-map-marker-alt me-3 mt-1" style="color: #2c3e50;"></i>
                                <div>
                                    <small class="text-muted">Alamat</small>
                                    <div class="fw-bold">{{ $orangtua->alamat }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Info Anak -->
    <div class="col-lg-6 mb-4">
        <div class="card h-100" style="border: none; box-shadow: 0 8px 25px rgba(0,0,0,0.08); border-radius: 12px;">
            <div class="card-header text-white" style="background: linear-gradient(135deg, #2980b9 0%, #3498db 100%); border-radius: 12px 12px 0 0;">
                <div class="d-flex align-items-center">
                    <div class="bg-white rounded-circle p-2 me-3">
                        <i class="fas fa-user-graduate" style="color: #2980b9; font-size: 1.2rem;"></i>
                    </div>
                    <h5 class="mb-0 fw-bold">Informasi Anak</h5>
                </div>
            </div>
            <div class="card-body p-4">
                <div class="text-center mb-4">
                    <div class="avatar-circle mx-auto mb-3" style="width: 80px; height: 80px; background: linear-gradient(135deg, #2980b9 0%, #3498db 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-user text-white" style="font-size: 2rem;"></i>
                    </div>
                    <h4 class="fw-bold mb-1" style="color: #2c3e50;">{{ $orangtua->siswa->nama_siswa }}</h4>
                    <span class="badge px-3 py-2 rounded-pill" style="background: #2980b9; color: white;">{{ $orangtua->siswa->nis }}</span>
                </div>
                
                <div class="row g-3">
                    <div class="col-12">
                        <div class="info-item p-3 rounded" style="background: #2980b9; color: white;">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-school me-3" style="font-size: 1.1rem;"></i>
                                <div>
                                    <small class="opacity-75">Kelas</small>
                                    <div class="fw-bold">{{ $orangtua->siswa->kelas->nama_kelas ?? '-' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="info-item p-3 rounded" style="background: #3498db; color: white;">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-chalkboard-teacher me-3" style="font-size: 1.1rem;"></i>
                                <div>
                                    <small class="opacity-75">Wali Kelas</small>
                                    <div class="fw-bold">{{ $orangtua->siswa->kelas->waliKelas->nama_guru ?? '-' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="info-item p-3 rounded" style="background: #f8f9fa; color: #2c3e50; border: 1px solid #e9ecef;">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-{{ $orangtua->siswa->jenis_kelamin == 'L' ? 'mars' : 'venus' }} me-3" style="color: {{ $orangtua->siswa->jenis_kelamin == 'L' ? '#2980b9' : '#e74c3c' }};"></i>
                                <div>
                                    <small class="text-muted">Jenis Kelamin</small>
                                    <div class="fw-bold">{{ $orangtua->siswa->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="mt-4 p-3 rounded text-center" style="background: #f8f9fa; border: 1px solid #e9ecef;">
                    <i class="fas fa-heart mb-2" style="color: #e74c3c; font-size: 1.5rem;"></i>
                    <p class="mb-0 fw-bold" style="color: #2c3e50;">Anak Tercinta</p>
                    <small class="text-muted">Semoga selalu menjadi kebanggaan keluarga</small>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.info-item {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.info-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

.avatar-circle {
    transition: transform 0.3s ease;
}

.avatar-circle:hover {
    transform: scale(1.05);
}

.card {
    transition: transform 0.2s ease;
}

.card:hover {
    transform: translateY(-3px);
}
</style>
@endsection