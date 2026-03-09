# ROLE-BASED ACCESS CONTROL - SISTEM KESISWAAN

## ANALISIS SISTEM LAMA

### 8 Role dengan Akses Berbeda:

#### 1. ADMIN (level: 'admin')
**Menu/Fitur:**
- Dashboard dengan statistik lengkap
- Data Siswa (CRUD)
- Data Guru (CRUD)
- Data Orang Tua (CRUD)
- Data Kelas (CRUD)
- Jenis Pelanggaran (CRUD)
- Data Pelanggaran (CRUD)
- Riwayat Pelanggaran (View)
- Data Sanksi (CRUD)
- Jenis Sanksi (CRUD)
- Data Verifikasi (CRUD)
- Monitoring Pelanggaran (CRUD)
- Bimbingan Konseling (CRUD)
- Pelaksanaan Sanksi (CRUD)
- Jenis Prestasi (CRUD)
- Data Prestasi (CRUD)
- Tahun Ajaran (CRUD)
- Manajemen User (CRUD)
- Backup & Restore

**Karakteristik:** Akses penuh ke semua fitur sistem

---

#### 2. KESISWAAN (level: 'kesiswaan')
**Menu/Fitur:**
- Dashboard
- Input Pelanggaran (Create, Edit, Delete)
- Riwayat Pelanggaran Semua (View)
- Input Prestasi (Create, Edit, Delete)
- Data Sanksi (CRUD)
- Verifikasi Data (CRUD) - Verifikasi pelanggaran & prestasi
- Monitoring All (View semua siswa)
- View Data Sendiri
- View Data Anak (Semua siswa)
- Export Laporan

**Karakteristik:** Fokus pada pengelolaan pelanggaran, prestasi, sanksi, dan verifikasi

---

#### 3. GURU (level: 'guru')
**Menu/Fitur:**
- Dashboard (Statistik pribadi)
- Input Pelanggaran (Create untuk siswa yang diajar)
- View Data Sendiri (Hanya pelanggaran yang dicatat sendiri)
- Riwayat Pelanggaran (View)
- Export Laporan (Data sendiri)

**Karakteristik:** Hanya bisa input dan lihat pelanggaran yang dicatat sendiri

---

#### 4. WALI KELAS (level: 'walikelas')
**Menu/Fitur:**
- Dashboard (Statistik kelas wali)
- Input Pelanggaran (Create untuk siswa kelas wali)
- View Data Sendiri (Pelanggaran siswa kelas wali)
- Export Laporan (Data kelas wali)

**Karakteristik:** Akses terbatas pada siswa di kelas yang diwali

---

#### 5. BK / BIMBINGAN KONSELING (level: 'bk')
**Menu/Fitur:**
- Dashboard (Statistik bimbingan)
- Input BK (Create, Edit bimbingan konseling)
- Verifikasi Pengajuan (Approve/Reject pengajuan dari siswa)
- View Data Sendiri (Bimbingan yang ditangani)
- Export Laporan (Data bimbingan)

**Karakteristik:** Fokus pada bimbingan konseling dan penanganan siswa

---

#### 6. KEPALA SEKOLAH (level: 'kepalasekolah')
**Menu/Fitur:**
- Dashboard (Statistik keseluruhan)
- Monitoring All (View semua data siswa)
- View Data Sendiri (Semua pelanggaran, prestasi, bimbingan)
- View Data Anak (Semua siswa)
- Riwayat Pelanggaran (View)
- Export Laporan (Semua data)
- Profile

**Karakteristik:** Read-only access untuk monitoring dan laporan

---

#### 7. SISWA (level: 'siswa')
**Menu/Fitur:**
- Dashboard (Data pribadi)
- View Data Sendiri (Pelanggaran & prestasi pribadi)
- Ajukan Bimbingan (Create pengajuan BK)
- Bimbingan Konseling (View status bimbingan)
- Pelaksanaan Sanksi (View & Update status sanksi pribadi)
- Export Laporan (Data pribadi)

**Karakteristik:** Hanya bisa lihat dan kelola data pribadi

---

#### 8. ORANG TUA (level: 'ortu')
**Menu/Fitur:**
- Dashboard (Data anak)
- View Data Anak (Pelanggaran & prestasi anak)
- Export Laporan (Data anak)

**Karakteristik:** Read-only untuk data anak saja

---

## IMPLEMENTASI DI FILAMENT

### Metode yang Digunakan:

#### 1. shouldRegisterNavigation()
Mengontrol apakah menu muncul di sidebar atau tidak.

```php
public static function shouldRegisterNavigation(): bool
{
    $user = auth()->user();
    return $user && in_array($user->level, ['admin', 'kesiswaan']);
}
```

#### 2. canViewAny()
Mengontrol apakah user bisa melihat list data.

```php
public static function canViewAny(): bool
{
    $user = auth()->user();
    return $user && in_array($user->level, ['admin', 'kesiswaan', 'guru']);
}
```

#### 3. canCreate()
Mengontrol apakah user bisa membuat data baru.

```php
public static function canCreate(): bool
{
    $user = auth()->user();
    return $user && in_array($user->level, ['admin', 'kesiswaan']);
}
```

#### 4. canEdit($record)
Mengontrol apakah user bisa edit data tertentu.

```php
public static function canEdit($record): bool
{
    $user = auth()->user();
    if ($user->level === 'admin') return true;
    if ($user->level === 'guru' && $record->guru_pencatat === $user->guru_id) {
        return true;
    }
    return false;
}
```

#### 5. canDelete($record)
Mengontrol apakah user bisa hapus data.

```php
public static function canDelete($record): bool
{
    $user = auth()->user();
    return $user && $user->level === 'admin';
}
```

---

## MAPPING RESOURCE KE ROLE

### Master Data
| Resource | Admin | Kesiswaan | Guru | Wali Kelas | BK | Kepala Sekolah | Siswa | Ortu |
|----------|-------|-----------|------|------------|----|--------------|----|------|
| SiswaResource | CRUD | CRUD | View | View | - | View | - | - |
| GuruResource | CRUD | View | - | - | - | View | - | - |
| OrangtuaResource | CRUD | View | - | - | - | - | - | - |
| KelasResource | CRUD | - | - | - | - | - | - | - |

### Pelanggaran & Sanksi
| Resource | Admin | Kesiswaan | Guru | Wali Kelas | BK | Kepala Sekolah | Siswa | Ortu |
|----------|-------|-----------|------|------------|----|--------------|----|------|
| PelanggaranResource | CRUD | CRUD | Create/Edit Own | Create/Edit Own | - | View | - | - |
| SanksiResource | CRUD | CRUD | - | - | - | View | View | - |
| PelaksanaanSanksiResource | CRUD | CRUD | - | - | - | View | Edit Own | - |
| MonitoringPelanggaranResource | CRUD | CRUD | - | - | - | CRUD | - | - |

### Prestasi
| Resource | Admin | Kesiswaan | Guru | Wali Kelas | BK | Kepala Sekolah | Siswa | Ortu |
|----------|-------|-----------|------|------------|----|--------------|----|------|
| PrestasiResource | CRUD | CRUD | - | - | - | View | - | - |

### Bimbingan Konseling
| Resource | Admin | Kesiswaan | Guru | Wali Kelas | BK | Kepala Sekolah | Siswa | Ortu |
|----------|-------|-----------|------|------------|----|--------------|----|------|
| BimbinganKonselingResource | CRUD | CRUD | - | - | CRUD Own | View | Create | - |

### Verifikasi & Monitoring
| Resource | Admin | Kesiswaan | Guru | Wali Kelas | BK | Kepala Sekolah | Siswa | Ortu |
|----------|-------|-----------|------|------------|----|--------------|----|------|
| VerifikasiDataResource | CRUD | CRUD | View | View | - | - | - | - |

### Pengaturan
| Resource | Admin | Kesiswaan | Guru | Wali Kelas | BK | Kepala Sekolah | Siswa | Ortu |
|----------|-------|-----------|------|------------|----|--------------|----|------|
| JenisPelanggaranResource | CRUD | CRUD | View | View | View | View | - | - |
| JenisPrestasiResource | CRUD | CRUD | View | View | View | View | - | - |
| TahunAjaranResource | CRUD | View | View | View | View | View | - | - |

---

## PERBEDAAN SISTEM LAMA VS FILAMENT

### Sistem Lama (Blade + Controller):
- Setiap role punya layout berbeda (admin.blade.php, guru.blade.php, dll)
- Menu sidebar berbeda untuk setiap role
- Controller terpisah per role (AdminController, GuruController, dll)
- Route terpisah per role (/admin/*, /guru/*, /walikelas/*)

### Sistem Filament (Sekarang):
- Satu panel untuk semua role
- Menu sidebar dinamis berdasarkan shouldRegisterNavigation()
- Resource yang sama digunakan semua role dengan permission berbeda
- Dashboard widget berbeda per role
- Akses data dibatasi di level Resource (canViewAny, canEdit, dll)

---

## CARA KERJA SISTEM

1. **User Login** → Sistem cek level user dari tabel users
2. **Load Dashboard** → Dashboard menampilkan widget sesuai role
3. **Load Navigation** → Hanya menu yang shouldRegisterNavigation() = true yang muncul
4. **Akses Resource** → Sistem cek canViewAny(), canCreate(), canEdit(), canDelete()
5. **Filter Data** → Query builder di table bisa filter data sesuai role (contoh: guru hanya lihat data yang dicatat sendiri)

---

## TESTING CHECKLIST

### Admin
- [ ] Bisa akses semua menu
- [ ] Bisa CRUD semua data
- [ ] Dashboard menampilkan semua statistik

### Kesiswaan
- [ ] Menu: Pelanggaran, Prestasi, Sanksi, Verifikasi, Monitoring
- [ ] Bisa CRUD pelanggaran dan prestasi
- [ ] Bisa verifikasi data

### Guru
- [ ] Menu: Input Pelanggaran, View Data Sendiri
- [ ] Hanya bisa input pelanggaran
- [ ] Hanya lihat data yang dicatat sendiri

### Wali Kelas
- [ ] Menu: Input Pelanggaran, View Data Sendiri
- [ ] Hanya bisa input pelanggaran siswa kelas wali
- [ ] Hanya lihat data siswa kelas wali

### BK
- [ ] Menu: Bimbingan Konseling
- [ ] Bisa CRUD bimbingan konseling
- [ ] Bisa verifikasi pengajuan dari siswa

### Kepala Sekolah
- [ ] Menu: Monitoring, View Data
- [ ] Read-only access
- [ ] Bisa lihat semua data

### Siswa
- [ ] Menu: View Data Sendiri, Ajukan Bimbingan, Pelaksanaan Sanksi
- [ ] Hanya lihat data pribadi
- [ ] Bisa ajukan bimbingan dan update status sanksi

### Orang Tua
- [ ] Menu: View Data Anak
- [ ] Read-only access
- [ ] Hanya lihat data anak

---

## CATATAN PENTING

1. **Navigation Groups** sudah diatur di AdminPanelProvider
2. **Setiap Resource** sudah ditambahkan role-based access control
3. **Dashboard** menampilkan widget berbeda per role
4. **Query Scoping** perlu ditambahkan di table untuk filter data per role (contoh: guru hanya lihat data sendiri)
5. **Middleware** sudah ada di panel untuk autentikasi

## NEXT STEPS

1. Tambahkan query scoping di setiap table untuk filter data sesuai role
2. Buat custom pages untuk fitur khusus (monitoring all, export laporan, dll)
3. Tambahkan notification untuk verifikasi data
4. Implementasi export PDF/Excel per role
5. Testing menyeluruh untuk setiap role
