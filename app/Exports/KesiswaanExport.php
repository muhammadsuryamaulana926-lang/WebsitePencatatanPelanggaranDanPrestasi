<?php

namespace App\Exports;

use App\Models\Pelanggaran;
use App\Models\Prestasi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class KesiswaanExport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            'Pelanggaran' => new PelanggaranSheet(),
            'Prestasi' => new PrestasiSheet(),
        ];
    }
}

class PelanggaranSheet implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Pelanggaran::with(['siswa.kelas', 'jenisPelanggaran', 'guru'])
            ->get()
            ->map(function($p) {
                return [
                    'nama_siswa' => $p->siswa->nama_siswa ?? '-',
                    'kelas' => $p->siswa->kelas->nama_kelas ?? '-',
                    'jenis_pelanggaran' => $p->jenisPelanggaran->nama_pelanggaran ?? '-',
                    'poin' => $p->poin,
                    'guru_pencatat' => $p->guru->nama_guru ?? '-',
                    'tanggal' => $p->created_at->format('d/m/Y'),
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Nama Siswa',
            'Kelas',
            'Jenis Pelanggaran',
            'Poin',
            'Guru Pencatat',
            'Tanggal',
        ];
    }
}

class PrestasiSheet implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Prestasi::with(['siswa.kelas', 'jenisPrestasi', 'guru'])
            ->get()
            ->map(function($p) {
                return [
                    'nama_siswa' => $p->siswa->nama_siswa ?? '-',
                    'kelas' => $p->siswa->kelas->nama_kelas ?? '-',
                    'jenis_prestasi' => $p->jenisPrestasi->nama_prestasi ?? '-',
                    'poin' => $p->poin,
                    'guru_pencatat' => $p->guru->nama_guru ?? '-',
                    'tanggal' => $p->created_at->format('d/m/Y'),
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Nama Siswa',
            'Kelas',
            'Jenis Prestasi',
            'Poin',
            'Guru Pencatat',
            'Tanggal',
        ];
    }
}