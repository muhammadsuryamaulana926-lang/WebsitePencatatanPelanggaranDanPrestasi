<?php

namespace App\Filament\Pages\Siswa;

use Filament\Pages\Page;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use App\Models\PelaksanaanSanksi as PelaksanaanSanksiModel;
use Filament\Notifications\Notification;

class PelaksanaanSanksi extends Page implements HasTable
{
    use InteractsWithTable;

    protected string $view = 'filament.pages.siswa.pelaksanaan-sanksi';
    protected static ?string $navigationLabel = 'Pelaksanaan Sanksi';
    protected static ?string $title = 'Pelaksanaan Sanksi Saya';
    protected static ?int $navigationSort = 2;

    public static function getNavigationIcon(): string
    {
        return 'heroicon-o-clipboard-document-check';
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
                \App\Models\PelaksanaanSanksi::query()
                    ->where('siswa_id', $siswaId)
                    ->with(['sanksi.pelanggaran.jenisPelanggaran'])
            )
            ->columns([
                TextColumn::make('sanksi.jenis_sanksi')->label('Jenis Sanksi'),
                TextColumn::make('sanksi.deskripsi')->label('Deskripsi')->limit(30),
                TextColumn::make('tanggal_pelaksanaan')->label('Tanggal')->date('d/m/Y'),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn ($state) => match($state) {
                        'terjadwal' => 'warning',
                        'dikerjakan' => 'info',
                        'tuntas' => 'success',
                        'terlambat' => 'danger',
                        default => 'gray'
                    }),
            ])
            ->actions([
                Action::make('upload')
                    ->label('Upload Bukti')
                    ->icon('heroicon-o-arrow-up-tray')
                    ->visible(fn ($record) => in_array($record->status, ['terjadwal', 'dikerjakan']))
                    ->form([
                        FileUpload::make('bukti')
                            ->label('Upload Bukti Pelaksanaan')
                            ->image()
                            ->maxSize(2048)
                            ->required(),
                        Textarea::make('catatan')
                            ->label('Catatan')
                            ->rows(3),
                    ])
                    ->action(function ($record, array $data) {
                        $record->update([
                            'bukti' => $data['bukti'],
                            'catatan' => $data['catatan'] ?? null,
                            'status' => 'tuntas',
                        ]);

                        Notification::make()
                            ->title('Bukti pelaksanaan berhasil diupload')
                            ->success()
                            ->send();
                    }),
            ])
            ->bulkActions([]);
    }
}
