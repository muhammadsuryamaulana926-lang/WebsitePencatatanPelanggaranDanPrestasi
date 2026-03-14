<?php

namespace App\Filament\Pages\Guru;

use Filament\Pages\Page;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use App\Models\Pelanggaran;
use App\Models\Siswa;
use App\Models\JenisPelanggaran;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class InputPelanggaran extends Page implements HasTable
{
    use InteractsWithTable;

    protected string $view = 'filament.pages.guru.input-pelanggaran';
    protected static ?string $navigationLabel = 'Input Pelanggaran';
    protected static ?string $title = 'Input Pelanggaran';
    protected static ?int $navigationSort = 1;

    public static function getNavigationIcon(): string
    {
        return 'heroicon-o-exclamation-triangle';
    }

    public static function canAccess(): bool
    {
        $user = Auth::user();
        return $user && in_array($user->level, ['guru', 'walikelas']);
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Pelanggaran::query()
                    ->where('guru_pencatat', Auth::user()->guru_id)
                    ->with(['siswa.kelas', 'jenisPelanggaran'])
            )
            ->columns([
                TextColumn::make('siswa.nama_siswa')->label('Nama Siswa')->searchable(),
                TextColumn::make('siswa.kelas.nama_kelas')->label('Kelas'),
                TextColumn::make('jenisPelanggaran.nama_pelanggaran')->label('Jenis Pelanggaran'),
                TextColumn::make('poin')->label('Poin')->badge()->color('danger'),
                TextColumn::make('created_at')->label('Tanggal')->dateTime('d/m/Y'),
            ])
            ->headerActions([
                Action::make('create')
                    ->label('Tambah Pelanggaran')
                    ->icon('heroicon-o-plus')
                    ->form([
                        Select::make('siswa_id')
                            ->label('Siswa')
                            ->options(Siswa::with('kelas')->get()->pluck('nama_siswa', 'id'))
                            ->searchable()
                            ->required(),
                        Select::make('jenis_pelanggaran_id')
                            ->label('Jenis Pelanggaran')
                            ->options(JenisPelanggaran::pluck('nama_pelanggaran', 'id'))
                            ->searchable()
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set) {
                                $jenis = JenisPelanggaran::find($state);
                                if ($jenis) {
                                    $set('poin', $jenis->poin);
                                }
                            })
                            ->required(),
                        TextInput::make('poin')
                            ->label('Poin')
                            ->numeric()
                            ->required()
                            ->disabled(),
                        Textarea::make('keterangan')
                            ->label('Keterangan')
                            ->rows(3),
                    ])
                    ->action(function (array $data) {
                        $tahunAjaran = \App\Models\TahunAjaran::where('status_aktif', true)->first();
                        
                        $pelanggaran = Pelanggaran::create([
                            'siswa_id' => $data['siswa_id'],
                            'jenis_pelanggaran_id' => $data['jenis_pelanggaran_id'],
                            'poin' => $data['poin'],
                            'guru_pencatat' => Auth::user()->guru_id,
                            'tahun_ajaran_id' => $tahunAjaran?->id,
                            'keterangan' => $data['keterangan'] ?? null,
                        ]);

                        // Auto create verifikasi
                        \App\Models\VerifikasiData::create([
                            'tabel_terkait' => 'pelanggaran',
                            'id_terkait' => $pelanggaran->id,
                            'guru_verifikator' => Auth::user()->guru_id,
                            'status' => 'menunggu'
                        ]);

                        // Auto create sanksi berdasarkan total poin
                        $this->createAutoSanksi($pelanggaran);

                        Notification::make()
                            ->title('Pelanggaran berhasil ditambahkan')
                            ->body('Sanksi otomatis dibuat dan masuk antrian verifikasi')
                            ->success()
                            ->send();
                    }),
            ])
            ->filters([])
            ->actions([])
            ->bulkActions([]);
    }

    private function createAutoSanksi($pelanggaran)
    {
        $totalPoin = \Illuminate\Support\Facades\DB::table('pelanggaran')
            ->join('jenis_pelanggaran', 'pelanggaran.jenis_pelanggaran_id', '=', 'jenis_pelanggaran.id')
            ->where('pelanggaran.siswa_id', $pelanggaran->siswa_id)
            ->sum('jenis_pelanggaran.poin');

        $jenisSanksi = $this->getJenisSanksiByPoin($totalPoin);
        
        \App\Models\Sanksi::create([
            'pelanggaran_id' => $pelanggaran->id,
            'jenis_sanksi' => $jenisSanksi,
            'deskripsi' => $this->getDeskripsiSanksi($jenisSanksi),
            'tanggal_mulai' => now(),
            'tanggal_selesai' => $this->getTanggalSelesai($jenisSanksi),
            'status' => 'direncanakan'
        ]);
    }

    private function getJenisSanksiByPoin($totalPoin)
    {
        if ($totalPoin >= 90) return 'Dikembalikan Kepada Orang Tua (Keluar)';
        if ($totalPoin >= 41) return 'Diserahkan Kepada Orang Tua 1 Bulan';
        if ($totalPoin >= 36) return 'Diserahkan Kepada Orang Tua 2 Minggu';
        if ($totalPoin >= 26) return 'Diskors Selama 7 Hari';
        if ($totalPoin >= 21) return 'Diskors Selama 3 Hari';
        if ($totalPoin >= 16) return 'Perjanjian Siswa Diatas Materai';
        if ($totalPoin >= 11) return 'Peringatan Tertulis';
        if ($totalPoin >= 6) return 'Peringatan Lisan';
        return 'Dicatat dan Konseling';
    }

    private function getDeskripsiSanksi($jenisSanksi)
    {
        $deskripsi = [
            'Dicatat dan Konseling' => 'Pelanggaran ringan dicatat dan diberikan konseling',
            'Peringatan Lisan' => 'Diberikan peringatan lisan oleh guru/wali kelas',
            'Peringatan Tertulis' => 'Surat peringatan tertulis dengan perjanjian',
            'Perjanjian Siswa Diatas Materai' => 'Siswa membuat perjanjian tertulis diatas materai',
            'Diskors Selama 3 Hari' => 'Siswa tidak diperbolehkan masuk sekolah selama 3 hari',
            'Diskors Selama 7 Hari' => 'Siswa tidak diperbolehkan masuk sekolah selama 7 hari',
            'Diserahkan Kepada Orang Tua 2 Minggu' => 'Siswa diserahkan kepada orang tua untuk pembinaan 2 minggu',
            'Diserahkan Kepada Orang Tua 1 Bulan' => 'Siswa diserahkan kepada orang tua untuk pembinaan 1 bulan',
            'Dikembalikan Kepada Orang Tua (Keluar)' => 'Siswa dikeluarkan dari sekolah'
        ];
        return $deskripsi[$jenisSanksi] ?? 'Sanksi sesuai pelanggaran';
    }

    private function getTanggalSelesai($jenisSanksi)
    {
        $hari = [
            'Diskors Selama 3 Hari' => 3,
            'Diskors Selama 7 Hari' => 7,
            'Diserahkan Kepada Orang Tua 2 Minggu' => 14,
            'Diserahkan Kepada Orang Tua 1 Bulan' => 30
        ];
        return now()->addDays($hari[$jenisSanksi] ?? 7);
    }
}
