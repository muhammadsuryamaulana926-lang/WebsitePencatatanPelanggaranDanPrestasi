<?php

namespace App\Filament\Pages\Siswa;

use Filament\Pages\Page;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\Action;
use Filament\Forms\Components\Textarea;
use App\Models\BimbinganKonseling;
use Filament\Notifications\Notification;

class AjukanBimbingan extends Page implements HasTable
{
    use InteractsWithTable;

    protected string $view = 'filament.pages.siswa.ajukan-bimbingan';
    protected static ?string $navigationLabel = 'Ajukan Bimbingan';
    protected static ?string $title = 'Ajukan Bimbingan Konseling';
    protected static ?int $navigationSort = 3;

    public static function getNavigationIcon(): string
    {
        return 'heroicon-o-hand-raised';
    }

    public static function canAccess(): bool
    {
        $user = auth()->user();
        return $user && $user->level === 'siswa' && $user->siswa;
    }

    public function table(Table $table): Table
    {
        $siswaId = auth()->user()->siswa?->id;

        return $table
            ->query(
                BimbinganKonseling::query()
                    ->where('siswa_id', $siswaId)
                    ->with(['konselor'])
            )
            ->columns([
                TextColumn::make('topik')->label('Topik')->limit(30),
                TextColumn::make('konselor.nama_guru')->label('Konselor'),
                TextColumn::make('status_pengajuan')
                    ->label('Status Pengajuan')
                    ->badge()
                    ->color(fn ($state) => match($state) {
                        'diajukan' => 'warning',
                        'disetujui' => 'success',
                        'ditolak' => 'danger',
                        default => 'gray'
                    }),
                TextColumn::make('status')
                    ->label('Status Bimbingan')
                    ->badge()
                    ->color(fn ($state) => match($state) {
                        'terjadwal' => 'info',
                        'berlangsung' => 'warning',
                        'selesai' => 'success',
                        default => 'gray'
                    }),
                TextColumn::make('created_at')->label('Tanggal Ajukan')->date('d/m/Y'),
            ])
            ->headerActions([
                Action::make('ajukan')
                    ->label('Ajukan Bimbingan Baru')
                    ->icon('heroicon-o-plus')
                    ->form([
                        Textarea::make('topik')
                            ->label('Topik/Masalah yang Ingin Dikonsultasikan')
                            ->required()
                            ->rows(4)
                            ->placeholder('Jelaskan masalah atau topik yang ingin Anda konsultasikan...'),
                    ])
                    ->action(function (array $data) {
                        BimbinganKonseling::create([
                            'siswa_id' => auth()->user()->siswa->id,
                            'topik' => $data['topik'],
                            'status' => 'terjadwal',
                            'status_pengajuan' => 'diajukan',
                        ]);

                        Notification::make()
                            ->title('Pengajuan bimbingan berhasil dikirim')
                            ->body('Menunggu persetujuan dari konselor BK')
                            ->success()
                            ->send();
                    }),
            ])
            ->filters([])
            ->actions([])
            ->bulkActions([]);
    }
}
