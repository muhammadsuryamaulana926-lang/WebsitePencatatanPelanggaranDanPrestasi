# ANALISIS MENU SISTEM LAMA VS FILAMENT

## MASALAH UTAMA:
Sistem lama punya menu CUSTOM yang tidak bisa langsung di-map ke Filament Resource!

## MENU SISTEM LAMA YANG TIDAK ADA RESOURCE-NYA:

### ADMIN:
- ❌ Riwayat Pelanggaran (custom page, bukan CRUD)
- ❌ Jenis Sanksi (belum ada resource)
- ❌ Manajemen User (belum ada resource)
- ❌ Backup & Restore (custom page)

### KESISWAAN:
- ❌ Input Pelanggaran (custom page dengan form khusus)
- ❌ Riwayat Pelanggaran (custom page)
- ❌ Input Prestasi (custom page dengan form khusus)
- ❌ Monitoring All (custom page dengan view khusus)
- ❌ View Data Sendiri (custom page)
- ❌ View Data Anak (custom page)
- ❌ Export Laporan (custom page)

### GURU:
- ❌ Input Pelanggaran (custom page)
- ❌ View Data Sendiri (custom page)
- ❌ Riwayat Pelanggaran (custom page)
- ❌ Export Laporan (custom page)

### WALI KELAS:
- ❌ Input Pelanggaran (custom page)
- ❌ View Data Sendiri (custom page)
- ❌ Export Laporan (custom page)

### BK:
- ❌ Input BK (custom page)
- ❌ View Data Sendiri (custom page)
- ❌ Export Laporan (custom page)

### KEPALA SEKOLAH:
- ❌ Monitoring All (custom page)
- ❌ View Data Sendiri (custom page)
- ❌ View Data Anak (custom page)
- ❌ Riwayat Pelanggaran (custom page)
- ❌ Export Laporan (custom page)
- ❌ Profile (custom page)

### SISWA:
- ❌ View Data Sendiri (custom page)
- ❌ Pelaksanaan Sanksi (custom page)
- ❌ Ajukan Bimbingan (custom page)
- ❌ Riwayat Bimbingan (custom page)
- ❌ Export Laporan (custom page)

### ORANG TUA:
- ❌ View Data Anak (custom page)
- ❌ Export Laporan (custom page)

## SOLUSI:

### OPSI 1: BUAT CUSTOM PAGES DI FILAMENT
Buat Filament Pages untuk setiap menu custom:
- `app/Filament/Pages/InputPelanggaran.php`
- `app/Filament/Pages/RiwayatPelanggaran.php`
- `app/Filament/Pages/ViewDataSendiri.php`
- dll...

**Kelebihan:**
- Tetap menggunakan Filament UI
- Konsisten dengan design system

**Kekurangan:**
- Banyak custom pages yang harus dibuat (30+ pages)
- Perlu coding manual untuk setiap page

### OPSI 2: GUNAKAN RESOURCE DENGAN CUSTOM ACTIONS
Modifikasi Resource yang ada dengan custom actions dan filters:
- PelanggaranResource dengan action "Input Pelanggaran"
- PelanggaranResource dengan filter "Data Sendiri"
- dll...

**Kelebihan:**
- Lebih sedikit code
- Menggunakan table dan form Filament

**Kekurangan:**
- Tidak persis sama dengan sistem lama
- Menu tidak se-spesifik sistem lama

### OPSI 3: HYBRID (RECOMMENDED)
Kombinasi Resource + Custom Pages:
- Gunakan Resource untuk CRUD standard (Admin)
- Buat Custom Pages untuk menu khusus (Guru, Siswa, dll)

## REKOMENDASI IMPLEMENTASI:

### UNTUK ADMIN:
✅ Gunakan semua Resource yang ada (14 resources)
➕ Tambah Custom Pages:
- ManajemenUserPage
- BackupRestorePage
- RiwayatPelanggaranPage

### UNTUK KESISWAAN:
✅ Gunakan Resource: Pelanggaran, Prestasi, Sanksi, VerifikasiData
➕ Tambah Custom Pages:
- MonitoringAllPage
- ViewDataSendiriPage
- ViewDataAnakPage
- ExportLaporanPage

### UNTUK GURU/WALI KELAS:
✅ Gunakan Resource: Pelanggaran (dengan scope)
➕ Tambah Custom Pages:
- ViewDataSendiriPage
- ExportLaporanPage

### UNTUK BK:
✅ Gunakan Resource: BimbinganKonseling (dengan scope)
➕ Tambah Custom Pages:
- ViewDataSendiriPage
- ExportLaporanPage

### UNTUK KEPALA SEKOLAH:
➕ Semua Custom Pages (read-only):
- MonitoringAllPage
- ViewDataSendiriPage
- ViewDataAnakPage
- RiwayatPelanggaranPage
- ExportLaporanPage
- ProfilePage

### UNTUK SISWA:
➕ Semua Custom Pages:
- ViewDataSendiriPage
- PelaksanaanSanksiPage
- AjukanBimbinganPage
- RiwayatBimbinganPage
- ExportLaporanPage

### UNTUK ORANG TUA:
➕ Semua Custom Pages:
- ViewDataAnakPage
- ExportLaporanPage

## KESIMPULAN:
Sistem lama menggunakan **CUSTOM PAGES** untuk setiap role, bukan CRUD Resource!
Filament Resource hanya cocok untuk Admin yang butuh CRUD lengkap.
Role lain butuh **Custom Filament Pages** yang disesuaikan dengan kebutuhan mereka.
