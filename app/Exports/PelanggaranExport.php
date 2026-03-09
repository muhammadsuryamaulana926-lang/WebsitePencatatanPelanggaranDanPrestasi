<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use App\Models\Pelanggaran;

class PelanggaranExport implements FromCollection, WithHeadings, WithMapping
{
    protected $guruId;

    public function __construct($guruId = null)
    {
        $this->guruId = $guruId;
    }

    public function collection()
    {
        if ($this->guruId) {
            return Pelanggaran::with(['siswa.kelas', 'jenisPelanggaran', 'guru'])
                ->where('guru_pencatat', $this->guruId)
                ->get();
        }
        
        return Pelanggaran::with(['siswa.kelas', 'jenisPelanggaran', 'guru'])->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Siswa',
            'Kelas',
            'Jenis Pelanggaran',
            'Guru Pencatat',
            'Poin',
            'Keterangan',
            'Tanggal'
        ];
    }

    public function map($pelanggaran): array
    {
        static $no = 1;
        return [
            $no++,
            $pelanggaran->siswa->nama_siswa ?? '-',
            $pelanggaran->siswa->kelas->nama_kelas ?? '-',
            $pelanggaran->jenisPelanggaran->nama_pelanggaran ?? '-',
            $pelanggaran->guru->nama_guru ?? '-',
            $pelanggaran->poin,
            $pelanggaran->keterangan ?? '-',
            $pelanggaran->created_at->format('d/m/Y')
        ];
    }
}
