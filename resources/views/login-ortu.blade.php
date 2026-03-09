<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Orang Tua - Sistem Kesiswaan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-success text-white text-center">
                        <h4><i class="fas fa-users me-2"></i>Login Orang Tua</h4>
                        <p class="mb-0">Pilih nama Anda untuk login</p>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <input type="text" class="form-control mb-3" id="searchOrtu" placeholder="Cari nama orang tua..." onkeyup="searchOrtu()">
                            </div>
                            <div class="col-md-6">
                                <select class="form-control mb-3" id="filterHubungan" onchange="filterByHubungan()">
                                    <option value="">Semua</option>
                                    <option value="ayah">Ayah</option>
                                    <option value="ibu">Ibu</option>
                                    <option value="wali">Wali</option>
                                </select>
                            </div>
                        </div>

                        <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                            <table class="table table-hover" id="ortuTable">
                                <thead class="table-success sticky-top">
                                    <tr>
                                        <th>Nama Orang Tua</th>
                                        <th>Hubungan</th>
                                        <th>Nama Anak</th>
                                        <th>NIS Anak</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orangtua as $o)
                                    <tr data-nama="{{ strtolower($o->nama_orangtua) }}" data-hubungan="{{ $o->hubungan }}">
                                        <td>{{ $o->nama_orangtua }}</td>
                                        <td><span class="badge bg-info">{{ ucfirst($o->hubungan) }}</span></td>
                                        <td>{{ $o->siswa->nama_siswa }}</td>
                                        <td>{{ $o->siswa->nis }}</td>
                                        <td>
                                            <button class="btn btn-success btn-sm" onclick="loginOrtu('{{ $o->nama_orangtua }}', '{{ $o->siswa->nis }}', '{{ $o->siswa->nama_siswa }}')">
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
                    <h5 class="modal-title">Login sebagai <span id="namaOrtu"></span></h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form action="/login-ortu-submit" method="POST">
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
                            Password Anda adalah <strong>NIS anak</strong> Anda: <span id="nisAnak"></span><br>
                            <small>Anak: <span id="namaAnak"></span></small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Username (Nama Orang Tua)</label>
                            <input type="text" class="form-control" name="username" id="namaInput" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password (NIS Anak)</label>
                            <input type="password" class="form-control" name="password" id="passwordInput" placeholder="Masukkan NIS anak Anda" required>
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
        function searchOrtu() {
            const searchTerm = document.getElementById('searchOrtu').value.toLowerCase();
            const rows = document.querySelectorAll('#ortuTable tbody tr');
            
            rows.forEach(row => {
                const nama = row.getAttribute('data-nama');
                if (nama.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }
        
        function filterByHubungan() {
            const hubunganFilter = document.getElementById('filterHubungan').value;
            const rows = document.querySelectorAll('#ortuTable tbody tr');
            
            rows.forEach(row => {
                const hubungan = row.getAttribute('data-hubungan');
                if (!hubunganFilter || hubungan === hubunganFilter) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }
        
        function loginOrtu(namaOrtu, nisAnak, namaAnak) {
            document.getElementById('namaOrtu').textContent = namaOrtu;
            document.getElementById('namaInput').value = namaOrtu;
            document.getElementById('nisAnak').textContent = nisAnak;
            document.getElementById('namaAnak').textContent = namaAnak;
            document.getElementById('passwordInput').placeholder = 'Masukkan NIS: ' + nisAnak;
            new bootstrap.Modal(document.getElementById('loginModal')).show();
        }
    </script>
</body>
</html>