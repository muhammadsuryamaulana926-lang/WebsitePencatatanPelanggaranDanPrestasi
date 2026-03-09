<?php

namespace App\Filament\Resources\Pelanggarans;

use App\Filament\Resources\Pelanggarans\Pages\CreatePelanggaran;
use App\Filament\Resources\Pelanggarans\Pages\EditPelanggaran;
use App\Filament\Resources\Pelanggarans\Pages\ListPelanggarans;
use App\Filament\Resources\Pelanggarans\Schemas\PelanggaranForm;
use App\Filament\Resources\Pelanggarans\Tables\PelanggaransTable;
use App\Models\Pelanggaran;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class PelanggaranResource extends Resource
{
    protected static ?string $model = Pelanggaran::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedExclamationTriangle;

    protected static string|UnitEnum|null $navigationGroup = 'Pelanggaran & Sanksi';

    protected static ?int $navigationSort = 10;

    protected static ?string $recordTitleAttribute = 'catatan';

    public static function shouldRegisterNavigation(): bool
    {
        $user = auth()->user();
        return $user && in_array($user->level, ['admin', 'kesiswaan', 'guru', 'walikelas']);
    }

    public static function canViewAny(): bool
    {
        $user = auth()->user();
        return $user && in_array($user->level, ['admin', 'kesiswaan', 'guru', 'walikelas', 'kepalasekolah']);
    }

    public static function canCreate(): bool
    {
        $user = auth()->user();
        return $user && in_array($user->level, ['admin', 'kesiswaan', 'guru', 'walikelas']);
    }

    public static function canEdit($record): bool
    {
        $user = auth()->user();
        if ($user->level === 'admin' || $user->level === 'kesiswaan') {
            return true;
        }
        if (($user->level === 'guru' || $user->level === 'walikelas') && $record->guru_pencatat === $user->guru_id) {
            return true;
        }
        return false;
    }

    public static function canDelete($record): bool
    {
        $user = auth()->user();
        return $user && in_array($user->level, ['admin', 'kesiswaan']);
    }

    public static function form(Schema $schema): Schema
    {
        return PelanggaranForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PelanggaransTable::configure($table);
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
            'index' => ListPelanggarans::route('/'),
            'create' => CreatePelanggaran::route('/create'),
            'edit' => EditPelanggaran::route('/{record}/edit'),
        ];
    }
}
