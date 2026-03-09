<?php

namespace App\Filament\Resources\PelaksanaanSanksis;

use App\Filament\Resources\PelaksanaanSanksis\Pages\CreatePelaksanaanSanksi;
use App\Filament\Resources\PelaksanaanSanksis\Pages\EditPelaksanaanSanksi;
use App\Filament\Resources\PelaksanaanSanksis\Pages\ListPelaksanaanSanksis;
use App\Filament\Resources\PelaksanaanSanksis\Schemas\PelaksanaanSanksiForm;
use App\Filament\Resources\PelaksanaanSanksis\Tables\PelaksanaanSanksisTable;
use App\Models\PelaksanaanSanksi;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class PelaksanaanSanksiResource extends Resource
{
    protected static ?string $model = PelaksanaanSanksi::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentCheck;

    protected static string|UnitEnum|null $navigationGroup = 'Pelanggaran & Sanksi';

    protected static ?int $navigationSort = 12;

    protected static ?string $recordTitleAttribute = 'keterangan';

    public static function shouldRegisterNavigation(): bool
    {
        $user = auth()->user();
        return $user && in_array($user->level, ['admin', 'kesiswaan', 'siswa']);
    }

    public static function canViewAny(): bool
    {
        $user = auth()->user();
        return $user && in_array($user->level, ['admin', 'kesiswaan', 'siswa', 'kepalasekolah']);
    }

    public static function canCreate(): bool
    {
        $user = auth()->user();
        return $user && in_array($user->level, ['admin', 'kesiswaan', 'siswa']);
    }

    public static function canEdit($record): bool
    {
        $user = auth()->user();
        if ($user->level === 'admin' || $user->level === 'kesiswaan') {
            return true;
        }
        if ($user->level === 'siswa' && $record->siswa_id === $user->siswa->id) {
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
        return PelaksanaanSanksiForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PelaksanaanSanksisTable::configure($table);
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
            'index' => ListPelaksanaanSanksis::route('/'),
            'create' => CreatePelaksanaanSanksi::route('/create'),
            'edit' => EditPelaksanaanSanksi::route('/{record}/edit'),
        ];
    }
}
