<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Artisan;
use Filament\Support\Icons\Heroicon;
use BackedEnum;
use UnitEnum;
use Illuminate\Support\Facades\Auth;

class BackupRestore extends Page
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCpuChip;
    protected static ?string $navigationLabel = 'Backup & Restore';
    protected static ?string $title = 'Backup & Restore Database';
    protected static string|UnitEnum|null $navigationGroup = 'Konfigurasi Sistem';
    protected static ?int $navigationSort = 34;

    protected string $view = 'filament.pages.backup-restore';

    public static function canAccess(): bool
    {
        return Auth::user() && Auth::user()->level === 'admin';
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('backup')
                ->label('Buat Backup Baru')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('success')
                ->action(function () {
                    try {
                        Notification::make()
                            ->title('Backup berhasil dibuat (Simulasi)')
                            ->success()
                            ->send();
                    } catch (\Exception $e) {
                        Notification::make()
                            ->title('Gagal membuat backup')
                            ->danger()
                            ->body($e->getMessage())
                            ->send();
                    }
                }),
        ];
    }

    public function getBackups(): array
    {
        return [
            ['name' => 'backup_2024_03_14.sql', 'size' => '2.5 MB', 'date' => '2024-03-14 10:00'],
            ['name' => 'backup_2024_03_13.sql', 'size' => '2.4 MB', 'date' => '2024-03-13 10:00'],
        ];
    }
}
