<?php

namespace App\Filament\Resources\BimbinganKonselings\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class BimbinganKonselingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('siswa_id')
                    ->required()
                    ->numeric(),
                TextInput::make('guru_konselor')
                    ->required()
                    ->numeric(),
                TextInput::make('tahun_ajaran_id')
                    ->numeric(),
                Select::make('jenis_layanan')
                    ->options([
            'konseling_individual' => 'Konseling individual',
            'konseling_kelompok' => 'Konseling kelompok',
            'bimbingan_klasikal' => 'Bimbingan klasikal',
            'konsultasi' => 'Konsultasi',
        ])
                    ->required(),
                TextInput::make('topik')
                    ->required(),
                Textarea::make('keluhan_masalah')
                    ->required()
                    ->columnSpanFull(),
                Textarea::make('tindakan_solusi')
                    ->required()
                    ->columnSpanFull(),
                Select::make('status')
                    ->options(['terjadwal' => 'Terjadwal', 'berlangsung' => 'Berlangsung', 'selesai' => 'Selesai'])
                    ->required(),
                Select::make('status_pengajuan')
                    ->options(['diajukan' => 'Diajukan', 'disetujui' => 'Disetujui', 'ditolak' => 'Ditolak'])
                    ->default('diajukan')
                    ->required(),
                Textarea::make('alasan_penolakan')
                    ->columnSpanFull(),
                DatePicker::make('tanggal_konseling')
                    ->required(),
                DatePicker::make('tanggal_tindak_lanjut'),
                Textarea::make('hasil_evaluasi')
                    ->columnSpanFull(),
            ]);
    }
}
