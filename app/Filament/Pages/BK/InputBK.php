<?php

namespace App\Filament\Pages\BK;

use Filament\Pages\Page;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\DatePicker;
use App\Models\BimbinganKonseling;
use App\Models\Siswa;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class InputBK extends Page implements HasTable
{
    use InteractsWithTable;

    protected string $view = 'filament.pages.bk.input-bk';
    protected static ?string $navigationLabel = 'Input BK';
    protected static ?string $title = 'Input Bimbingan Konseling';
    protected static ?int $navigationSort = 1;

    public static function getNavigationIcon(): string
    {
        return 'heroicon-o-heart';
    }

    public static function canAccess(): bool
    {
        $user = Auth::user();
        return $user && $user->level === 'bk';
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                BimbinganKonseling::query()
                    ->where('guru_konselor', Auth::user()->guru_id)
                    ->with(['siswa.kelas'])
            )
            ->columns([
                TextColumn::make('siswa.nama_siswa')->label('Nama Siswa')->searchable(),
                TextColumn::make('siswa.kelas.nama_kelas')->label('Kelas'),
                TextColumn::make('topik')->label('Topik')->limit(30),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn ($state) => match($state) {
                        'terjadwal' => 'warning',
                        'berlangsung' => 'info',
                        'selesai' => 'success',
                        default => 'gray'
                    }),
                TextColumn::make('tanggal_konseling')->label('Tanggal')->date('d/m/Y'),
            ])
            ->headerActions([
                Action::make('create')
                    ->label('Tambah Bimbingan')
                    ->icon('heroicon-o-plus')
                    ->form([
                        Select::make('siswa_id')
                            ->label('Siswa')
                            ->options(Siswa::with('kelas')->get()->pluck('nama_siswa', 'id'))
                            ->searchable()
                            ->required(),
                        Textarea::make('topik')
                            ->label('Topik Bimbingan')
                            ->required()
                            ->rows(3),
                        Textarea::make('tindakan_solusi')
                            ->label('Tindakan/Solusi')
                            ->rows(3),
                        DatePicker::make('tanggal_konseling')
                            ->label('Tanggal Konseling')
                            ->default(now())
                            ->required(),
                        Select::make('status')
                            ->label('Status')
                            ->options([
                                'terjadwal' => 'Terjadwal',
                                'berlangsung' => 'Berlangsung',
                                'selesai' => 'Selesai',
                            ])
                            ->default('terjadwal')
                            ->required(),
                    ])
                    ->action(function (array $data) {
                        BimbinganKonseling::create([
                            'siswa_id' => $data['siswa_id'],
                            'guru_konselor' => Auth::user()->guru_id,
                            'topik' => $data['topik'],
                            'tindakan_solusi' => $data['tindakan_solusi'] ?? null,
                            'tanggal_konseling' => $data['tanggal_konseling'],
                            'status' => $data['status'],
                            'status_pengajuan' => 'disetujui',
                        ]);

                        Notification::make()
                            ->title('Bimbingan konseling berhasil ditambahkan')
                            ->success()
                            ->send();
                    }),
            ])
            ->filters([])
            ->actions([])
            ->bulkActions([]);
    }
}
