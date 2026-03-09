<?php

namespace App\Filament\Resources\MonitoringPelanggarans;

use App\Filament\Resources\MonitoringPelanggarans\Pages\CreateMonitoringPelanggaran;
use App\Filament\Resources\MonitoringPelanggarans\Pages\EditMonitoringPelanggaran;
use App\Filament\Resources\MonitoringPelanggarans\Pages\ListMonitoringPelanggarans;
use App\Filament\Resources\MonitoringPelanggarans\Schemas\MonitoringPelanggaranForm;
use App\Filament\Resources\MonitoringPelanggarans\Tables\MonitoringPelanggaransTable;
use App\Models\MonitoringPelanggaran;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class MonitoringPelanggaranResource extends Resource
{
    protected static ?string $model = MonitoringPelanggaran::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedEye;

    protected static string|UnitEnum|null $navigationGroup = 'Pelanggaran & Sanksi';

    protected static ?int $navigationSort = 13;

    protected static ?string $recordTitleAttribute = 'keterangan';

    public static function shouldRegisterNavigation(): bool
    {
        $user = auth()->user();
        return $user && in_array($user->level, ['admin', 'kesiswaan', 'kepalasekolah']);
    }

    public static function canViewAny(): bool
    {
        $user = auth()->user();
        return $user && in_array($user->level, ['admin', 'kesiswaan', 'kepalasekolah']);
    }

    public static function canCreate(): bool
    {
        $user = auth()->user();
        return $user && in_array($user->level, ['admin', 'kesiswaan', 'kepalasekolah']);
    }

    public static function canEdit($record): bool
    {
        $user = auth()->user();
        return $user && in_array($user->level, ['admin', 'kesiswaan', 'kepalasekolah']);
    }

    public static function canDelete($record): bool
    {
        $user = auth()->user();
        return $user && in_array($user->level, ['admin', 'kesiswaan']);
    }

    public static function form(Schema $schema): Schema
    {
        return MonitoringPelanggaranForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MonitoringPelanggaransTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListMonitoringPelanggarans::route('/'),
            'create' => CreateMonitoringPelanggaran::route('/create'),
            'edit' => EditMonitoringPelanggaran::route('/{record}/edit'),
        ];
    }
}
