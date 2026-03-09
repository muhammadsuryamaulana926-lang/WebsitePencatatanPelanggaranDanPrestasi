<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\JenisPelanggaran;

class JenisPelanggaranSeeder extends Seeder
{
    public function run(): void
    {
        $pelanggaranData = [
            'KETERTIBAN' => [
                ['nama_pelanggaran' => 'Membuat keribulan / kegaduhan dalam kelas pada saat berlangsungnya pelajaran', 'kategori' => 'ringan', 'poin' => 10],
                ['nama_pelanggaran' => 'Masuk dan atau keluar lingkungan sekolah tidak melalui gerbang sekolah', 'kategori' => 'sedang', 'poin' => 20],
                ['nama_pelanggaran' => 'Berkata tidak jujur, tidak sopan/kasar', 'kategori' => 'ringan', 'poin' => 10],
                ['nama_pelanggaran' => 'Mengotori (mencorat-coret) barang milik sekolah, guru, karyawan atau teman', 'kategori' => 'ringan', 'poin' => 10],
                ['nama_pelanggaran' => 'Merusak atau menghilangkan barang milik sekolah, guru, karyawan atau teman', 'kategori' => 'ringan', 'poin' => 10],
                ['nama_pelanggaran' => 'Mengambil (mencuri) barang milik sekolah, guru, karyawan atau teman', 'kategori' => 'sedang', 'poin' => 25],
                ['nama_pelanggaran' => 'Makan dan minum di dalam kelas saat berlangsungnya pelajaran', 'kategori' => 'berat', 'poin' => 50],
                ['nama_pelanggaran' => 'Mengaktifkan alat komunikasi didalam kelas pada saat pelajaran berlangsung', 'kategori' => 'ringan', 'poin' => 5],
                ['nama_pelanggaran' => 'Membuang sampah tidak pada tempatnya', 'kategori' => 'ringan', 'poin' => 5],
                ['nama_pelanggaran' => 'Membawa teman selain siswa SMK BN maupun dengan siswa sekolah lain atau pihak lain', 'kategori' => 'ringan', 'poin' => 5],
                ['nama_pelanggaran' => 'Membawa benda yang tidak ada kaitannya dengan proses belajar mengajar', 'kategori' => 'ringan', 'poin' => 5],
                ['nama_pelanggaran' => 'Bertengkar / bertentangan dengan teman di lingkungan sekolah', 'kategori' => 'ringan', 'poin' => 10],
                ['nama_pelanggaran' => 'Memalsu tandatangan guru, walikelas, kepala sekolah', 'kategori' => 'sedang', 'poin' => 15],
                ['nama_pelanggaran' => 'Menggunakan/menggelapkan SPP dan orang tua', 'kategori' => 'berat', 'poin' => 40],
                ['nama_pelanggaran' => 'Membentuk organisasi lain, OSIS maupun kegiatan lainnya tanpa seijin Kepala Sekolah', 'kategori' => 'berat', 'poin' => 40],
                ['nama_pelanggaran' => 'Menyalahgunakan Uang SPP', 'kategori' => 'sedang', 'poin' => 15],
                ['nama_pelanggaran' => 'Berbuat asusila', 'kategori' => 'berat', 'poin' => 40],
            ],
            
            'ROKOK' => [
                ['nama_pelanggaran' => 'Membawa rokok', 'kategori' => 'sedang', 'poin' => 25],
                ['nama_pelanggaran' => 'Merokok / menghisap rokok di sekolah', 'kategori' => 'berat', 'poin' => 40],
                ['nama_pelanggaran' => 'Merokok menghisap rokok di luar sekolah memakai seragam sekolah', 'kategori' => 'berat', 'poin' => 40],
            ],
            
            'MEDIA_TERLARANG' => [
                ['nama_pelanggaran' => 'Membawa buku, majalah, kaset terlarang atau HP berisi gambar dan film porno', 'kategori' => 'sedang', 'poin' => 25],
                ['nama_pelanggaran' => 'Memperjual belikan buku, majalah atau kaset terlarang', 'kategori' => 'berat', 'poin' => 75],
            ],
            
            'SENJATA' => [
                ['nama_pelanggaran' => 'Membawa senjata tajam tanpa ijin', 'kategori' => 'berat', 'poin' => 40],
                ['nama_pelanggaran' => 'Memperjual belikan senjata tajam di sekolah', 'kategori' => 'berat', 'poin' => 40],
                ['nama_pelanggaran' => 'Menggunakan senjata tajam untuk mengancam', 'kategori' => 'berat', 'poin' => 75],
                ['nama_pelanggaran' => 'Menggunakan senjata tajam untuk melukai', 'kategori' => 'berat', 'poin' => 75],
            ],
            
            'NARKOBA' => [
                ['nama_pelanggaran' => 'Membawa obat terlarang / minuman terlarang', 'kategori' => 'berat', 'poin' => 75],
                ['nama_pelanggaran' => 'Menggunakan obat / minuman terlarang di dalam lingkungan sekolah', 'kategori' => 'sangat_berat', 'poin' => 100],
                ['nama_pelanggaran' => 'Memperjual belikan obat / minuman terlarang di dalam / di luar sekolah', 'kategori' => 'sangat_berat', 'poin' => 100],
            ],
            
            'PERKELAHIAN' => [
                ['nama_pelanggaran' => 'Disebutkan oleh siswa di dalam sekolah (intern)', 'kategori' => 'berat', 'poin' => 75],
                ['nama_pelanggaran' => 'Disebutkan oleh sekolah lain', 'kategori' => 'berat', 'poin' => 75],
                ['nama_pelanggaran' => 'Antar siswa SMK BN 666', 'kategori' => 'berat', 'poin' => 75],
            ],
            
            'PELANGGARAN_TERHADAP_GURU' => [
                ['nama_pelanggaran' => 'Diserta ancaman', 'kategori' => 'berat', 'poin' => 75],
                ['nama_pelanggaran' => 'Diserta pemukulan', 'kategori' => 'sangat_berat', 'poin' => 100],
            ],
            
            'KETERLAMBATAN' => [
                ['nama_pelanggaran' => 'Terlambat masuk sekolah lebih dari 15 menit - Satu kali', 'kategori' => 'ringan', 'poin' => 2],
                ['nama_pelanggaran' => 'Terlambat masuk sekolah lebih dari 15 menit - Dua kali', 'kategori' => 'ringan', 'poin' => 3],
                ['nama_pelanggaran' => 'Terlambat masuk sekolah lebih dari 15 menit - Tiga kali dan seterusnya', 'kategori' => 'ringan', 'poin' => 5],
                ['nama_pelanggaran' => 'Terlambat masuk karena ijin', 'kategori' => 'ringan', 'poin' => 1],
                ['nama_pelanggaran' => 'Terlambat masuk karena dinas tugas guru', 'kategori' => 'ringan', 'poin' => 2],
                ['nama_pelanggaran' => 'Terlambat masuk karena alasan yang dibenarkan ijin keluar saat proses belajar berlangsung dan tidak kembali', 'kategori' => 'ringan', 'poin' => 5],
                ['nama_pelanggaran' => 'Pulang tanpa ijin', 'kategori' => 'ringan', 'poin' => 10],
            ],
            
            'KEHADIRAN' => [
                ['nama_pelanggaran' => 'Siswa tidak masuk karena - Ijin tanpa keterangan (surat)', 'kategori' => 'ringan', 'poin' => 2],
                ['nama_pelanggaran' => 'Siswa tidak masuk karena - Alfa', 'kategori' => 'ringan', 'poin' => 5],
                ['nama_pelanggaran' => 'Tidak mengikuti kegiatan belajar (membolos)', 'kategori' => 'ringan', 'poin' => 10],
                ['nama_pelanggaran' => 'Siswa tidak masuk dengan membuat keterangan (surat) palsu', 'kategori' => 'ringan', 'poin' => 10],
            ],
            
            'SERAGAM' => [
                ['nama_pelanggaran' => 'Memakai seragam tidak rapi / tidak dimasukkan', 'kategori' => 'ringan', 'poin' => 5],
                ['nama_pelanggaran' => 'Siswa putri memakai seragam yang ketat / rok pendek', 'kategori' => 'ringan', 'poin' => 5],
                ['nama_pelanggaran' => 'Tidak memakai perlengkapan upacara bendera (topi)', 'kategori' => 'ringan', 'poin' => 5],
                ['nama_pelanggaran' => 'Salah memakai baju, rok atau celana', 'kategori' => 'ringan', 'poin' => 5],
                ['nama_pelanggaran' => 'Salah atau tidak memakai ikat pinggang', 'kategori' => 'ringan', 'poin' => 5],
                ['nama_pelanggaran' => 'Salah memakai sepatu (tidak sesuai ketentuan)', 'kategori' => 'ringan', 'poin' => 5],
                ['nama_pelanggaran' => 'Tidak memakai kaos kaki', 'kategori' => 'ringan', 'poin' => 5],
                ['nama_pelanggaran' => 'Salah / tidak memakai kaos dalam', 'kategori' => 'ringan', 'poin' => 5],
                ['nama_pelanggaran' => 'Memakai topi yang bukan topi sekolah di lingkungan sekolah', 'kategori' => 'ringan', 'poin' => 5],
                ['nama_pelanggaran' => 'Siswa putri memakai perhiasan berlebihan', 'kategori' => 'ringan', 'poin' => 5],
                ['nama_pelanggaran' => 'Siswa putra memakai perhiasan atau aksesoris (kalung, gelang, dll)', 'kategori' => 'ringan', 'poin' => 5],
            ],
            
            'PENAMPILAN' => [
                ['nama_pelanggaran' => 'Potongan rambut putra tidak sesuai dengan ketentuan sekolah', 'kategori' => 'sedang', 'poin' => 15],
                ['nama_pelanggaran' => 'Dicat / diwarna-warnai (putra-putri)', 'kategori' => 'sedang', 'poin' => 15],
                ['nama_pelanggaran' => 'Bertato', 'kategori' => 'sangat_berat', 'poin' => 100],
                ['nama_pelanggaran' => 'Kuku di cat', 'kategori' => 'sedang', 'poin' => 20],
            ],
        ];

        foreach ($pelanggaranData as $kategoriUtama => $pelanggaran) {
            foreach ($pelanggaran as $jenis) {
                JenisPelanggaran::create(array_merge($jenis, ['kategori_utama' => $kategoriUtama]));
            }
        }
    }
}