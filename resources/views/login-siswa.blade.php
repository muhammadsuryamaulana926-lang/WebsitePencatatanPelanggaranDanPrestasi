<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Siswa - Sistem Kesiswaan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-success text-white text-center">
                        <h4><i class="fas fa-graduation-cap me-2"></i>Login Siswa</h4>
                        <p class="mb-0">Pilih nama Anda untuk login</p>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <input type="text" class="form-control mb-3" id="searchSiswa" placeholder="Cari nama siswa..." onkeyup="searchSiswa()">
                            </div>
                            <div class="col-md-6">
                                <select class="form-control mb-3" id="filterKelas" onchange="filterByKelas()">
                                    <option value="">Semua Kelas</option>
                                    <option value="12 PPLG 1">12 PPLG 1</option>
                                    <option value="12 PPLG 2">12 PPLG 2</option>
                                    <option value="12 PPLG 3">12 PPLG 3</option>
                                    <option value="12 Pemasaran">12 Pemasaran</option>
                                    <option value="12 DKV">12 DKV</option>
                                    <option value="12 Akuntansi 1">12 Akuntansi 1</option>
                                    <option value="12 Akuntansi 2">12 Akuntansi 2</option>
                                    <option value="12 Animasi">12 Animasi</option>
                                </select>
                            </div>
                        </div>

                        <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                            <table class="table table-hover" id="siswaTable">
                                <thead class="table-success sticky-top">
                                    <tr>
                                        <th>Nama Siswa</th>
                                        <th>NIS</th>
                                        <th>Kelas</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($siswa as $s)
                                    <tr data-nama="{{ strtolower($s->nama_siswa) }}" data-kelas="{{ $s->kelas->nama_kelas ?? '' }}">
                                        <td>{{ $s->nama_siswa }}</td>
                                        <td>{{ $s->nis }}</td>
                                        <td>{{ $s->kelas->nama_kelas ?? '-' }}</td>
                                        <td>
                                            <button class="btn btn-success btn-sm" onclick="loginSiswa('{{ $s->nama_siswa }}', '{{ $s->nis }}')">
                                                <i class="fas fa-sign-in-alt me-1"></i>Login
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="text-center mt-3">
                            <a href="/login" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-1"></i>Kembali ke Login Utama
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Login -->
    <div class="modal fade" id="loginModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title">Login sebagai <span id="namaSiswa"></span></h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form action="/login-siswa-submit" method="POST">
                    @csrf
                    <div class="modal-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    {{ $error }}<br>
                                @endforeach
                            </div>
                        @endif
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            Password Anda adalah <strong>NIS</strong> Anda: <span id="nisInfo"></span>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Username (Nama Siswa)</label>
                            <input type="text" class="form-control" name="username" id="namaInput" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password (NIS)</label>
                            <input type="password" class="form-control" name="password" id="passwordInput" placeholder="Masukkan NIS Anda" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-sign-in-alt me-1"></i>Login
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function searchSiswa() {
            const searchTerm = document.getElementById('searchSiswa').value.toLowerCase();
            const rows = document.querySelectorAll('#siswaTable tbody tr');
            
            rows.forEach(row => {
                const nama = row.getAttribute('data-nama');
                if (nama.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }
        
        function filterByKelas() {
            const kelasFilter = document.getElementById('filterKelas').value;
            const rows = document.querySelectorAll('#siswaTable tbody tr');
            
            rows.forEach(row => {
                const kelas = row.getAttribute('data-kelas');
                if (!kelasFilter || kelas === kelasFilter) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }
        
        function loginSiswa(nama, nis) {
            document.getElementById('namaSiswa').textContent = nama;
            document.getElementById('namaInput').value = nama;
            document.getElementById('nisInfo').textContent = nis;
            document.getElementById('passwordInput').placeholder = 'Masukkan NIS: ' + nis;
            new bootstrap.Modal(document.getElementById('loginModal')).show();
        }
    </script>
</body>
</html>